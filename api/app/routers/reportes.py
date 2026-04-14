from datetime import datetime
from typing import Optional
from fastapi import APIRouter, Depends, Query
from fastapi.responses import Response
from sqlalchemy import func
from sqlalchemy.orm import Session

from app.dependencies import get_db, require_roles
from app.models.pedido import Pedido, EstadoPedido
from app.models.usuario import Usuario, Rol
from app.models.autoparte import Autoparte
from app.models.inventario import Inventario
from app.schemas.reporte import (
    ReporteVentas, ReportePedidos, ReporteClientes,
    ResumenPedido, ResumenCliente,
)
from app.services.reporte_service import (
    generar_pdf_ventas, generar_xlsx_ventas, generar_docx_ventas, generar_csv_ventas,
    generar_pdf_pedidos, generar_xlsx_pedidos, generar_docx_pedidos, generar_csv_pedidos,
    generar_pdf_inventario, generar_xlsx_inventario, generar_docx_inventario, generar_csv_inventario,
    generar_pdf_clientes, generar_xlsx_clientes, generar_docx_clientes, generar_csv_clientes,
)

router = APIRouter(prefix='/reportes', tags=['Reportes'])

_ventas    = Depends(require_roles(Rol.admin, Rol.ventas))
_logistica = Depends(require_roles(Rol.admin, Rol.ventas, Rol.logistica))


@router.get('/ventas', response_model=ReporteVentas)
def reporte_ventas(db: Session = Depends(get_db), _: Usuario = _ventas):
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
    return ReporteVentas(labels=labels, data=data, total=sum(data))


@router.get('/pedidos', response_model=ReportePedidos)
def reporte_pedidos(db: Session = Depends(get_db), _: Usuario = _logistica):
    pedidos = db.query(Pedido).order_by(Pedido.fecha_pedido.desc()).all()
    resumen = [
        ResumenPedido(id=p.id, estado=p.estado.value, total=float(p.total),
                      fecha=p.fecha_pedido.strftime('%Y-%m-%d'))
        for p in pedidos
    ]
    return ReportePedidos(pedidos=resumen, total_pedidos=len(resumen))


@router.get('/clientes', response_model=ReporteClientes)
def reporte_clientes(db: Session = Depends(get_db), _: Usuario = _ventas):
    rows = (
        db.query(
            Usuario.nombre,
            func.count(Pedido.id).label('total_pedidos'),
            func.sum(Pedido.total).label('total_gastado'),
        )
        .join(Pedido, Pedido.usuario_id == Usuario.id)
        .filter(Usuario.rol == Rol.externo, Pedido.estado != EstadoPedido.cancelado)
        .group_by(Usuario.nombre)
        .order_by(func.sum(Pedido.total).desc())
        .all()
    )
    clientes = [
        ResumenCliente(nombre=r.nombre, total_pedidos=r.total_pedidos,
                       total_gastado=float(r.total_gastado or 0))
        for r in rows
    ]
    return ReporteClientes(clientes=clientes)


# ── Helpers ───────────────────────────────────────────────────────────────────

def _resp(buffer, media_type: str, filename: str) -> Response:
    return Response(
        content=buffer.getvalue(),
        media_type=media_type,
        headers={'Content-Disposition': f'attachment; filename={filename}'},
    )

_MEDIA = {
    'pdf':  'application/pdf',
    'xlsx': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'docx': 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'csv':  'text/csv; charset=utf-8',
}


# ── Descarga: Ventas ──────────────────────────────────────────────────────────

@router.get('/ventas/descargar/{formato}')
def descargar_ventas(
    formato:      str,
    fecha_desde:  Optional[str] = Query(None),
    fecha_hasta:  Optional[str] = Query(None),
    db:           Session       = Depends(get_db),
    current_user: Usuario       = _ventas,
):
    q = db.query(Pedido).filter(Pedido.estado != EstadoPedido.cancelado)
    if fecha_desde:
        q = q.filter(Pedido.fecha_pedido >= datetime.strptime(fecha_desde, '%Y-%m-%d'))
    if fecha_hasta:
        q = q.filter(Pedido.fecha_pedido <= datetime.strptime(fecha_hasta, '%Y-%m-%d').replace(hour=23, minute=59))
    pedidos = q.order_by(Pedido.fecha_pedido.desc()).all()

    ventas = []
    for p in pedidos:
        cats = {d.autoparte.categoria.nombre for d in p.detalles if d.autoparte and d.autoparte.categoria}
        ventas.append({
            'fecha':    p.fecha_pedido.strftime('%Y-%m-%d'),
            'id_venta': p.id,
            'cliente':  p.usuario.nombre if p.usuario else 'Desconocido',
            'categoria': ', '.join(cats) or 'General',
            'subtotal': float(p.subtotal or 0),
            'iva':       float(p.total or 0) - float(p.subtotal or 0),
            'total':    float(p.total or 0),
        })

    usuario = current_user.nombre if current_user else 'Administrador'
    if formato == 'pdf':
        return _resp(generar_pdf_ventas(ventas, usuario), _MEDIA['pdf'], 'ventas.pdf')
    if formato == 'xlsx':
        return _resp(generar_xlsx_ventas(ventas, usuario), _MEDIA['xlsx'], 'ventas.xlsx')
    if formato == 'docx':
        return _resp(generar_docx_ventas(ventas, usuario), _MEDIA['docx'], 'ventas.docx')
    if formato == 'csv':
        return _resp(generar_csv_ventas(ventas), _MEDIA['csv'], 'ventas.csv')
    return Response(status_code=400, content='Formato no soportado')


# ── Descarga: Pedidos ─────────────────────────────────────────────────────────

@router.get('/pedidos/descargar/{formato}')
def descargar_pedidos(
    formato:     str,
    estado:      Optional[str] = Query(None),
    fecha_desde: Optional[str] = Query(None),
    fecha_hasta: Optional[str] = Query(None),
    db:          Session       = Depends(get_db),
    _:           Usuario       = _logistica,
):
    q = db.query(Pedido)
    if estado:
        try:
            q = q.filter(Pedido.estado == EstadoPedido(estado.upper()))
        except ValueError:
            pass
    if fecha_desde:
        q = q.filter(Pedido.fecha_pedido >= datetime.strptime(fecha_desde, '%Y-%m-%d'))
    if fecha_hasta:
        q = q.filter(Pedido.fecha_pedido <= datetime.strptime(fecha_hasta, '%Y-%m-%d').replace(hour=23, minute=59))
    pedidos = q.order_by(Pedido.fecha_pedido.desc()).all()

    resumen = []
    for p in pedidos:
        piezas = [f"{d.cantidad}x {d.autoparte.nombre}" for d in p.detalles if d.autoparte]
        resumen.append({
            'id':      p.id,
            'cliente': p.usuario.nombre if p.usuario else 'Desconocido',
            'fecha':   p.fecha_pedido.strftime('%Y-%m-%d'),
            'estado':  p.estado.value,
            'total':   float(p.total or 0),
            'piezas':  ', '.join(piezas),
        })

    if formato == 'pdf':
        return _resp(generar_pdf_pedidos(resumen), _MEDIA['pdf'], 'pedidos.pdf')
    if formato == 'xlsx':
        return _resp(generar_xlsx_pedidos(resumen), _MEDIA['xlsx'], 'pedidos.xlsx')
    if formato == 'docx':
        return _resp(generar_docx_pedidos(resumen), _MEDIA['docx'], 'pedidos.docx')
    if formato == 'csv':
        return _resp(generar_csv_pedidos(resumen), _MEDIA['csv'], 'pedidos.csv')
    return Response(status_code=400, content='Formato no soportado')


# ── Descarga: Inventario ──────────────────────────────────────────────────────

@router.get('/inventario/descargar/{formato}')
def descargar_inventario(
    formato:       str,
    stock_filtro:  Optional[str] = Query(None),  # 'bajo', 'agotado', o None=todos
    db:            Session       = Depends(get_db),
    _:             Usuario       = Depends(require_roles(Rol.admin, Rol.ventas, Rol.almacen)),
):
    q = db.query(Inventario, Autoparte).join(Autoparte, Inventario.autoparte_id == Autoparte.id)
    rows = q.all()

    resumen = []
    for inv, auto in rows:
        if stock_filtro == 'agotado' and inv.stock_actual > 0:
            continue
        if stock_filtro == 'bajo' and not (0 < inv.stock_actual <= inv.stock_minimo):
            continue
        resumen.append({
            'codigo_parte': auto.numero_parte or str(auto.id),
            'familia':      auto.categoria.nombre if auto.categoria else 'General',
            'descripcion':  auto.nombre,
            'marca':        auto.marca or 'Genérica',
            'stock_actual': inv.stock_actual,
            'punto_reorden': inv.stock_minimo,
            'valorizado':   float(auto.precio * inv.stock_actual),
        })

    if formato == 'pdf':
        return _resp(generar_pdf_inventario(resumen), _MEDIA['pdf'], 'inventario.pdf')
    if formato == 'xlsx':
        return _resp(generar_xlsx_inventario(resumen), _MEDIA['xlsx'], 'inventario.xlsx')
    if formato == 'docx':
        return _resp(generar_docx_inventario(resumen), _MEDIA['docx'], 'inventario.docx')
    if formato == 'csv':
        return _resp(generar_csv_inventario(resumen), _MEDIA['csv'], 'inventario.csv')
    return Response(status_code=400, content='Formato no soportado')


# ── Descarga: Clientes ────────────────────────────────────────────────────────

@router.get('/clientes/descargar/{formato}')
def descargar_clientes(
    formato:      str,
    db:           Session = Depends(get_db),
    current_user: Usuario = _ventas,
):
    rows = (
        db.query(
            Usuario.nombre,
            func.count(Pedido.id).label('total_pedidos'),
            func.sum(Pedido.total).label('total_gastado'),
        )
        .join(Pedido, Pedido.usuario_id == Usuario.id)
        .filter(Usuario.rol == Rol.externo, Pedido.estado != EstadoPedido.cancelado)
        .group_by(Usuario.nombre)
        .order_by(func.sum(Pedido.total).desc())
        .all()
    )
    clientes = [
        {'nombre': r.nombre, 'total_pedidos': r.total_pedidos,
         'total_gastado': float(r.total_gastado or 0)}
        for r in rows
    ]
    usuario = current_user.nombre if current_user else 'Administrador'

    if formato == 'pdf':
        return _resp(generar_pdf_clientes(clientes, usuario), _MEDIA['pdf'], 'clientes.pdf')
    if formato == 'xlsx':
        return _resp(generar_xlsx_clientes(clientes, usuario), _MEDIA['xlsx'], 'clientes.xlsx')
    if formato == 'docx':
        return _resp(generar_docx_clientes(clientes, usuario), _MEDIA['docx'], 'clientes.docx')
    if formato == 'csv':
        return _resp(generar_csv_clientes(clientes), _MEDIA['csv'], 'clientes.csv')
    return Response(status_code=400, content='Formato no soportado')
