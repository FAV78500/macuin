from fastapi import APIRouter, Depends
from sqlalchemy import func
from sqlalchemy.orm import Session

from app.dependencies import get_db, require_roles
from app.models.pedido import Pedido, EstadoPedido
from app.models.usuario import Usuario, Rol
from app.schemas.reporte import (
    ReporteVentas, ReportePedidos, ReporteClientes,
    ResumenPedido, ResumenCliente,
)

router = APIRouter(prefix='/reportes', tags=['Reportes'])

_ventas    = Depends(require_roles(Rol.admin, Rol.ventas))
_logistica = Depends(require_roles(Rol.admin, Rol.ventas, Rol.logistica))


@router.get('/ventas', response_model=ReporteVentas)
def reporte_ventas(
    db: Session = Depends(get_db),
    _:  Usuario = _ventas,
):
    """Totales de ventas agrupados por mes (últimos 12 meses)."""
    rows = (
        db.query(
            func.to_char(Pedido.fecha_pedido, 'Mon').label('mes'),
            func.sum(Pedido.total).label('total'),
        )
        .filter(Pedido.estado != EstadoPedido.cancelado)
        .group_by(func.to_char(Pedido.fecha_pedido, 'Mon'), func.date_trunc('month', Pedido.fecha_pedido))
        .order_by(func.date_trunc('month', Pedido.fecha_pedido))
        .limit(12)
        .all()
    )

    labels = [r.mes for r in rows]
    data   = [float(r.total or 0) for r in rows]
    total  = sum(data)

    return ReporteVentas(labels=labels, data=data, total=total)


@router.get('/pedidos', response_model=ReportePedidos)
def reporte_pedidos(
    db: Session = Depends(get_db),
    _:  Usuario = _logistica,
):
    """Lista resumida de todos los pedidos para el panel de reportes."""
    pedidos = db.query(Pedido).order_by(Pedido.fecha_pedido.desc()).all()

    resumen = [
        ResumenPedido(
            id=p.id,
            estado=p.estado.value,
            total=float(p.total),
            fecha=p.fecha_pedido.strftime('%Y-%m-%d'),
        )
        for p in pedidos
    ]

    return ReportePedidos(pedidos=resumen, total_pedidos=len(resumen))


@router.get('/clientes', response_model=ReporteClientes)
def reporte_clientes(
    db: Session = Depends(get_db),
    _:  Usuario = _ventas,
):
    """Ranking de clientes externos por volumen de compra."""
    rows = (
        db.query(
            Usuario.nombre,
            func.count(Pedido.id).label('total_pedidos'),
            func.sum(Pedido.total).label('total_gastado'),
        )
        .join(Pedido, Pedido.usuario_id == Usuario.id)
        .filter(
            Usuario.rol == Rol.externo,
            Pedido.estado != EstadoPedido.cancelado,
        )
        .group_by(Usuario.nombre)
        .order_by(func.sum(Pedido.total).desc())
        .all()
    )

    clientes = [
        ResumenCliente(
            nombre=r.nombre,
            total_pedidos=r.total_pedidos,
            total_gastado=float(r.total_gastado or 0),
        )
        for r in rows
    ]

    return ReporteClientes(clientes=clientes)
