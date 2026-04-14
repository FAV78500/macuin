from typing import List
from fastapi import APIRouter, Depends, HTTPException, status
from fastapi.responses import Response
from sqlalchemy.orm import Session

from app.dependencies import get_db, get_current_user, require_roles
from app.models.autoparte import Autoparte
from app.models.detalle_pedido import DetallePedido
from app.models.inventario import Inventario
from app.models.pedido import Pedido, EstadoPedido
from app.models.usuario import Usuario, Rol
from app.schemas.pedido import PedidoCreate, PedidoOut, EstadoUpdate
from app.services.reporte_service import generar_pdf_factura

router = APIRouter(prefix='/pedidos', tags=['Pedidos'])

_interno  = Depends(require_roles(Rol.admin, Rol.ventas, Rol.logistica))
_logistica = Depends(require_roles(Rol.admin, Rol.logistica))


@router.get('', response_model=List[PedidoOut])
def listar_pedidos(
    db:           Session = Depends(get_db),
    current_user: Usuario = Depends(get_current_user),
):
    """
    - Personal interno (admin/ventas/logistica): ve todos los pedidos.
    - Cliente externo: ve solo sus propios pedidos.
    """
    if current_user.rol == Rol.externo:
        return db.query(Pedido).filter(Pedido.usuario_id == current_user.id).all()
    if current_user.rol in (Rol.admin, Rol.ventas, Rol.logistica):
        return db.query(Pedido).order_by(Pedido.fecha_pedido.desc()).all()
    raise HTTPException(status_code=status.HTTP_403_FORBIDDEN, detail='Sin acceso a pedidos')


@router.get('/{id}', response_model=PedidoOut)
def obtener_pedido(
    id:           int,
    db:           Session = Depends(get_db),
    current_user: Usuario = Depends(get_current_user),
):
    pedido = db.query(Pedido).filter(Pedido.id == id).first()
    if not pedido:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Pedido no encontrado')

    # Cliente externo solo puede ver sus propios pedidos
    if current_user.rol == Rol.externo and pedido.usuario_id != current_user.id:
        raise HTTPException(status_code=status.HTTP_403_FORBIDDEN, detail='Sin acceso a este pedido')

    return pedido


@router.post('', response_model=PedidoOut, status_code=status.HTTP_201_CREATED)
def crear_pedido(
    datos:        PedidoCreate,
    db:           Session = Depends(get_db),
    current_user: Usuario = Depends(get_current_user),
):
    """Solo clientes externos pueden crear pedidos."""
    if current_user.rol != Rol.externo:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail='Solo clientes externos pueden crear pedidos',
        )
    if not datos.detalles:
        raise HTTPException(
            status_code=status.HTTP_422_UNPROCESSABLE_ENTITY,
            detail='El pedido debe tener al menos una autoparte',
        )

    subtotal = 0.0
    detalles_obj = []

    for item in datos.detalles:
        autoparte = db.query(Autoparte).filter(
            Autoparte.id == item.autoparte_id,
            Autoparte.activo == True,
        ).first()
        if not autoparte:
            raise HTTPException(
                status_code=status.HTTP_404_NOT_FOUND,
                detail=f'Autoparte {item.autoparte_id} no encontrada o no disponible',
            )

        inv = db.query(Inventario).filter(Inventario.autoparte_id == autoparte.id).first()
        if not inv or inv.stock_actual < item.cantidad:
            raise HTTPException(
                status_code=status.HTTP_409_CONFLICT,
                detail=f'Stock insuficiente para "{autoparte.nombre}" (disponible: {inv.stock_actual if inv else 0})',
            )

        subtotal += float(autoparte.precio) * item.cantidad
        detalles_obj.append(DetallePedido(
            autoparte_id=autoparte.id,
            cantidad=item.cantidad,
            precio_unitario=autoparte.precio,
        ))

    envio = 0.0 if subtotal >= 1000 else round(subtotal * 0.15, 2)
    total = round((subtotal + envio) * 1.16, 2)

    pedido = Pedido(
        usuario_id=current_user.id,
        subtotal=subtotal,
        total=total,
        direccion_entrega=datos.direccion_entrega,
    )
    db.add(pedido)
    db.flush()

    for detalle in detalles_obj:
        detalle.pedido_id = pedido.id
        db.add(detalle)

        # Descontar inventario
        inv = db.query(Inventario).filter(Inventario.autoparte_id == detalle.autoparte_id).first()
        inv.stock_actual -= detalle.cantidad

    db.commit()
    db.refresh(pedido)
    return pedido


@router.patch('/{id}/estado', response_model=PedidoOut)
def actualizar_estado(
    id:    int,
    datos: EstadoUpdate,
    db:    Session = Depends(get_db),
    _:     Usuario = _logistica,
):
    pedido = db.query(Pedido).filter(Pedido.id == id).first()
    if not pedido:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Pedido no encontrado')
    if pedido.estado == EstadoPedido.cancelado:
        raise HTTPException(
            status_code=status.HTTP_409_CONFLICT,
            detail='No se puede modificar un pedido cancelado',
        )

    pedido.estado = datos.estado
    db.commit()
    db.refresh(pedido)
    return pedido


@router.get('/{id}/factura')
def descargar_factura(
    id:           int,
    db:           Session = Depends(get_db),
    current_user: Usuario = Depends(get_current_user),
):
    pedido = db.query(Pedido).filter(Pedido.id == id).first()
    if not pedido:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Pedido no encontrado')
    if current_user.rol == Rol.externo and pedido.usuario_id != current_user.id:
        raise HTTPException(status_code=status.HTTP_403_FORBIDDEN, detail='Sin acceso a este pedido')

    pedido_dict = {
        'id':                pedido.id,
        'fecha_pedido':      pedido.fecha_pedido.isoformat(),
        'estado':            pedido.estado.value,
        'subtotal':          float(pedido.subtotal),
        'total':             float(pedido.total),
        'direccion_entrega': pedido.direccion_entrega,
        'usuario':           {'nombre': pedido.usuario.nombre} if pedido.usuario else {},
        'detalles': [
            {
                'cantidad':        d.cantidad,
                'precio_unitario': float(d.precio_unitario),
                'autoparte': {
                    'nombre': d.autoparte.nombre if d.autoparte else '—',
                    'marca':  d.autoparte.marca  if d.autoparte else '—',
                } if d.autoparte else {},
            }
            for d in pedido.detalles
        ],
    }

    buffer = generar_pdf_factura(pedido_dict)
    return Response(
        content=buffer.getvalue(),
        media_type='application/pdf',
        headers={'Content-Disposition': f'attachment; filename=factura-{id:05d}.pdf'},
    )


@router.delete('/{id}', status_code=status.HTTP_204_NO_CONTENT)
def cancelar_pedido(
    id:           int,
    db:           Session = Depends(get_db),
    current_user: Usuario = Depends(get_current_user),
):
    """
    - Cliente externo: puede cancelar sus pedidos solo si están en RECIBIDO.
    - Admin: puede cancelar cualquier pedido.
    """
    pedido = db.query(Pedido).filter(Pedido.id == id).first()
    if not pedido:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Pedido no encontrado')

    if current_user.rol == Rol.externo:
        if pedido.usuario_id != current_user.id:
            raise HTTPException(status_code=status.HTTP_403_FORBIDDEN, detail='Sin acceso a este pedido')
        if pedido.estado != EstadoPedido.recibido:
            raise HTTPException(
                status_code=status.HTTP_409_CONFLICT,
                detail='Solo puedes cancelar pedidos en estado RECIBIDO',
            )
    elif current_user.rol != Rol.admin:
        raise HTTPException(status_code=status.HTTP_403_FORBIDDEN, detail='Sin permiso para cancelar pedidos')

    # Restaurar inventario si el pedido se cancela
    if pedido.estado != EstadoPedido.cancelado:
        for detalle in pedido.detalles:
            inv = db.query(Inventario).filter(Inventario.autoparte_id == detalle.autoparte_id).first()
            if inv:
                inv.stock_actual += detalle.cantidad

    pedido.estado = EstadoPedido.cancelado
    db.commit()
