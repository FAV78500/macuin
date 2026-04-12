from fastapi import APIRouter, Depends
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
    generar_pdf_ventas, generar_xlsx_ventas, generar_docx_ventas,
    generar_pdf_pedidos, generar_xlsx_pedidos, generar_docx_pedidos,
    generar_pdf_inventario, generar_xlsx_inventario, generar_docx_inventario,
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


# ── Endpoints de descarga de archivos ────────────────────────────────────────────────

@router.get('/ventas/descargar/{formato}')
def descargar_ventas(
    formato: str,
    db: Session = Depends(get_db),
    _: Usuario = _ventas,
):
    """Descarga reporte de ventas en PDF, XLSX o DOCX."""
    # Obtener datos
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
    data = [float(r.total or 0) for r in rows]
    total = sum(data)

    if formato == 'pdf':
        buffer = generar_pdf_ventas(labels, data, total)
        return Response(
            content=buffer.getvalue(),
            media_type='application/pdf',
            headers={'Content-Disposition': 'attachment; filename=ventas_periodo.pdf'}
        )
    elif formato == 'xlsx':
        buffer = generar_xlsx_ventas(labels, data, total)
        return Response(
            content=buffer.getvalue(),
            media_type='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            headers={'Content-Disposition': 'attachment; filename=ventas_periodo.xlsx'}
        )
    elif formato == 'docx':
        buffer = generar_docx_ventas(labels, data, total)
        return Response(
            content=buffer.getvalue(),
            media_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            headers={'Content-Disposition': 'attachment; filename=ventas_periodo.docx'}
        )
    else:
        return Response(status_code=400, content='Formato no soportado. Use: pdf, xlsx, docx')


@router.get('/pedidos/descargar/{formato}')
def descargar_pedidos(
    formato: str,
    db: Session = Depends(get_db),
    _: Usuario = _logistica,
):
    """Descarga reporte de pedidos en PDF, XLSX o DOCX."""
    pedidos = db.query(Pedido).order_by(Pedido.fecha_pedido.desc()).all()

    resumen = [
        {
            'id': p.id,
            'estado': p.estado.value,
            'total': float(p.total),
            'fecha': p.fecha_pedido.strftime('%Y-%m-%d'),
        }
        for p in pedidos
    ]

    if formato == 'pdf':
        buffer = generar_pdf_pedidos(resumen)
        return Response(
            content=buffer.getvalue(),
            media_type='application/pdf',
            headers={'Content-Disposition': 'attachment; filename=pedidos.pdf'}
        )
    elif formato == 'xlsx':
        buffer = generar_xlsx_pedidos(resumen)
        return Response(
            content=buffer.getvalue(),
            media_type='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            headers={'Content-Disposition': 'attachment; filename=pedidos.xlsx'}
        )
    elif formato == 'docx':
        buffer = generar_docx_pedidos(resumen)
        return Response(
            content=buffer.getvalue(),
            media_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            headers={'Content-Disposition': 'attachment; filename=pedidos.docx'}
        )
    else:
        return Response(status_code=400, content='Formato no soportado. Use: pdf, xlsx, docx')


@router.get('/inventario/descargar/{formato}')
def descargar_inventario(
    formato: str,
    db: Session = Depends(get_db),
    _: Usuario = Depends(require_roles(Rol.admin, Rol.ventas, Rol.almacen)),
):
    """Descarga reporte de inventario en PDF, XLSX o DOCX."""
    inventario = (
        db.query(Inventario, Autoparte)
        .join(Autoparte, Inventario.autoparte_id == Autoparte.id)
        .all()
    )

    resumen = [
        {
            'autoparte_id': inv.autoparte_id,
            'nombre': auto.nombre,
            'stock_actual': inv.stock_actual,
            'stock_minimo': inv.stock_minimo,
        }
        for inv, auto in inventario
    ]

    if formato == 'pdf':
        buffer = generar_pdf_inventario(resumen)
        return Response(
            content=buffer.getvalue(),
            media_type='application/pdf',
            headers={'Content-Disposition': 'attachment; filename=inventario.pdf'}
        )
    elif formato == 'xlsx':
        buffer = generar_xlsx_inventario(resumen)
        return Response(
            content=buffer.getvalue(),
            media_type='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            headers={'Content-Disposition': 'attachment; filename=inventario.xlsx'}
        )
    elif formato == 'docx':
        buffer = generar_docx_inventario(resumen)
        return Response(
            content=buffer.getvalue(),
            media_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            headers={'Content-Disposition': 'attachment; filename=inventario.docx'}
        )
    else:
        return Response(status_code=400, content='Formato no soportado. Use: pdf, xlsx, docx')
