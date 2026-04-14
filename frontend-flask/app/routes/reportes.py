from flask import Blueprint, render_template, Response, request, session
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required

reportes_bp = Blueprint('reportes', __name__, url_prefix='/reportes')


@reportes_bp.route('/')
@login_required
@role_required('admin', 'ventas', 'almacen', 'externo')
def index():
    ventas_data   = api_client.get('/reportes/ventas') or {}
    pedidos_data  = api_client.get('/reportes/pedidos') or {}
    clientes_data = api_client.get('/reportes/clientes') or {}
    inventarios   = api_client.get('/inventarios') or []

    ventas_preview   = list(zip(ventas_data.get('labels', []), ventas_data.get('data', [])))
    ventas_total     = ventas_data.get('total', 0)

    pedidos_preview  = pedidos_data.get('pedidos', [])[:8]
    total_pedidos    = pedidos_data.get('total_pedidos', 0)

    clientes_all     = clientes_data.get('clientes', [])
    clientes_preview = clientes_all[:8]
    total_clientes   = len(clientes_all)

    inventario_preview = inventarios[:8]
    total_items        = len(inventarios)
    alertas            = sum(
        1 for i in inventarios
        if i.get('stock_actual', 0) <= i.get('stock_minimo', 0)
    )

    return render_template('reportes/index.html',
        ventas_preview=ventas_preview,
        ventas_total=ventas_total,
        pedidos_preview=pedidos_preview,
        total_pedidos=total_pedidos,
        clientes_preview=clientes_preview,
        total_clientes=total_clientes,
        inventario_preview=inventario_preview,
        total_items=total_items,
        alertas=alertas,
        rol=session.get('role', ''),
    )


def _proxy_download(api_base, filename_base, formato):
    params = {k: v for k, v in request.args.items() if v}
    response = api_client.get_raw(f'{api_base}/{formato}', params=params or None)
    if response.status_code == 200:
        ct = response.headers.get('Content-Type', 'application/octet-stream')
        cd = response.headers.get('Content-Disposition',
                                  f'attachment; filename={filename_base}.{formato}')
        return Response(response.content, mimetype=ct, headers={'Content-Disposition': cd})
    return {'error': 'Error al generar el reporte'}, 400


@reportes_bp.route('/descargar-ventas/<formato>')
@login_required
@role_required('admin', 'ventas')
def descargar_ventas(formato):
    return _proxy_download('/reportes/ventas/descargar', 'ventas', formato)


@reportes_bp.route('/descargar-pedidos/<formato>')
@login_required
@role_required('admin', 'ventas', 'almacen')
def descargar_pedidos(formato):
    return _proxy_download('/reportes/pedidos/descargar', 'pedidos', formato)


@reportes_bp.route('/descargar-inventario/<formato>')
@login_required
@role_required('admin', 'ventas', 'almacen')
def descargar_inventario(formato):
    return _proxy_download('/reportes/inventario/descargar', 'inventario', formato)


@reportes_bp.route('/descargar-clientes/<formato>')
@login_required
@role_required('admin', 'ventas')
def descargar_clientes(formato):
    return _proxy_download('/reportes/clientes/descargar', 'clientes', formato)
