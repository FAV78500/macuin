from flask import Blueprint, render_template, Response
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required
import io

reportes_bp = Blueprint('reportes', __name__, url_prefix='/reportes')

@reportes_bp.route('/')
@login_required
@role_required('admin', 'ventas', 'almacen', 'externo')
def index():
    ventas = api_client.get('/reportes/ventas')
    return render_template('reportes/index.html', ventas=ventas)

@reportes_bp.route('/descargar-ventas-periodo/<formato>')
@login_required
@role_required('admin', 'ventas', 'almacen', 'externo')
def descargar_ventas_periodo(formato):
    # Consumir endpoint de FastAPI para generar archivos reales
    response = api_client.get_raw(f'/reportes/ventas/descargar/{formato}')
    if response.status_code == 200:
        # Obtener Content-Type y Content-Disposition de la respuesta de FastAPI
        content_type = response.headers.get('Content-Type', 'application/octet-stream')
        content_disposition = response.headers.get('Content-Disposition', f'attachment; filename=ventas_periodo.{formato}')
        
        return Response(
            response.content,
            mimetype=content_type,
            headers={'Content-Disposition': content_disposition}
        )
    return {'error': 'Formato no soportado'}, 400

@reportes_bp.route('/descargar-pedidos-estatus/<formato>')
@login_required
@role_required('admin', 'ventas', 'almacen', 'externo')
def descargar_pedidos_estatus(formato):
    # Consumir endpoint de FastAPI para generar archivos reales
    response = api_client.get_raw(f'/reportes/pedidos/descargar/{formato}')
    if response.status_code == 200:
        content_type = response.headers.get('Content-Type', 'application/octet-stream')
        content_disposition = response.headers.get('Content-Disposition', f'attachment; filename=pedidos.{formato}')
        
        return Response(
            response.content,
            mimetype=content_type,
            headers={'Content-Disposition': content_disposition}
        )
    return {'error': 'Formato no soportado'}, 400

@reportes_bp.route('/descargar-inventario/<formato>')
@login_required
@role_required('admin', 'ventas', 'almacen', 'externo')
def descargar_inventario(formato):
    # Consumir endpoint de FastAPI para generar archivos reales
    response = api_client.get_raw(f'/reportes/inventario/descargar/{formato}')
    if response.status_code == 200:
        content_type = response.headers.get('Content-Type', 'application/octet-stream')
        content_disposition = response.headers.get('Content-Disposition', f'attachment; filename=inventario.{formato}')
        
        return Response(
            response.content,
            mimetype=content_type,
            headers={'Content-Disposition': content_disposition}
        )
    return {'error': 'Formato no soportado'}, 400
