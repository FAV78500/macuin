from flask import Blueprint, render_template, send_file
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required
import io
import csv

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
    # Endpoint para descargar reporte de ventas por periodo
    data = api_client.get('/reportes/ventas')
    if formato == 'pdf':
        # Simular PDF
        output = io.BytesIO(b'MOCK PDF: Ventas por Periodo')
        output.seek(0)
        return send_file(output, mimetype='application/pdf', as_attachment=True, download_name='ventas_periodo.pdf')
    elif formato == 'xlsx':
        # Simular Excel
        output = io.BytesIO(b'MOCK XLSX: Ventas por Periodo')
        output.seek(0)
        return send_file(output, mimetype='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', as_attachment=True, download_name='ventas_periodo.xlsx')
    elif formato == 'docx':
        # Simular Word
        output = io.BytesIO(b'MOCK DOCX: Ventas por Periodo')
        output.seek(0)
        return send_file(output, mimetype='application/vnd.openxmlformats-officedocument.wordprocessingml.document', as_attachment=True, download_name='ventas_periodo.docx')
    return {'error': 'Formato no soportado'}, 400

@reportes_bp.route('/descargar-top-productos/<formato>')
@login_required
@role_required('admin', 'ventas', 'almacen', 'externo')
def descargar_top_productos(formato):
    # Endpoint para descargar reporte de productos más vendidos
    data = api_client.get('/autopartes')
    if formato == 'pdf':
        output = io.BytesIO(b'MOCK PDF: Top Productos')
        output.seek(0)
        return send_file(output, mimetype='application/pdf', as_attachment=True, download_name='top_productos.pdf')
    elif formato == 'xlsx':
        output = io.BytesIO(b'MOCK XLSX: Top Productos')
        output.seek(0)
        return send_file(output, mimetype='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', as_attachment=True, download_name='top_productos.xlsx')
    elif formato == 'docx':
        output = io.BytesIO(b'MOCK DOCX: Top Productos')
        output.seek(0)
        return send_file(output, mimetype='application/vnd.openxmlformats-officedocument.wordprocessingml.document', as_attachment=True, download_name='top_productos.docx')
    return {'error': 'Formato no soportado'}, 400

@reportes_bp.route('/descargar-inventario/<formato>')
@login_required
@role_required('admin', 'ventas', 'almacen', 'externo')
def descargar_inventario(formato):
    # Endpoint para descargar reporte de inventario
    data = api_client.get('/inventarios')
    if formato == 'pdf':
        output = io.BytesIO(b'MOCK PDF: Inventario')
        output.seek(0)
        return send_file(output, mimetype='application/pdf', as_attachment=True, download_name='inventario.pdf')
    elif formato == 'xlsx':
        output = io.BytesIO(b'MOCK XLSX: Inventario')
        output.seek(0)
        return send_file(output, mimetype='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', as_attachment=True, download_name='inventario.xlsx')
    elif formato == 'docx':
        output = io.BytesIO(b'MOCK DOCX: Inventario')
        output.seek(0)
        return send_file(output, mimetype='application/vnd.openxmlformats-officedocument.wordprocessingml.document', as_attachment=True, download_name='inventario.docx')
    return {'error': 'Formato no soportado'}, 400

@reportes_bp.route('/descargar-pedidos-estatus/<formato>')
@login_required
@role_required('admin', 'ventas', 'almacen', 'externo')
def descargar_pedidos_estatus(formato):
    # Endpoint para descargar reporte de pedidos por estatus
    data = api_client.get('/pedidos')
    if formato == 'pdf':
        output = io.BytesIO(b'MOCK PDF: Pedidos por Estatus')
        output.seek(0)
        return send_file(output, mimetype='application/pdf', as_attachment=True, download_name='pedidos_estatus.pdf')
    elif formato == 'xlsx':
        output = io.BytesIO(b'MOCK XLSX: Pedidos por Estatus')
        output.seek(0)
        return send_file(output, mimetype='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', as_attachment=True, download_name='pedidos_estatus.xlsx')
    elif formato == 'docx':
        output = io.BytesIO(b'MOCK DOCX: Pedidos por Estatus')
        output.seek(0)
        return send_file(output, mimetype='application/vnd.openxmlformats-officedocument.wordprocessingml.document', as_attachment=True, download_name='pedidos_estatus.docx')
    return {'error': 'Formato no soportado'}, 400
