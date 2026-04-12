from flask import Blueprint, render_template, request, flash, redirect, url_for
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required

pedidos_bp = Blueprint('pedidos', __name__, url_prefix='/pedidos')

_ESTADO_MAP = {
    '1': 'RECIBIDO',
    '2': 'SURTIDO',
    '3': 'ENVIADO',
}

@pedidos_bp.route('/')
@login_required
@role_required('admin', 'ventas', 'almacen', 'externo')
def index():
    pedidos = api_client.get('/pedidos')
    if isinstance(pedidos, dict) and 'error' in pedidos:
        flash('Error al obtener pedidos', 'danger')
        pedidos = []
    return render_template('pedidos/index.html', pedidos=pedidos)

@pedidos_bp.route('/estatus/<int:id>', methods=['POST'])
@login_required
@role_required('admin', 'almacen')
def estatus(id):
    nuevo_estado = request.form.get('estado_id')
    if nuevo_estado and nuevo_estado in _ESTADO_MAP:
        api_client.patch(f'/pedidos/{id}/estado', data={'estado': _ESTADO_MAP[nuevo_estado]})
        flash('Estatus del pedido actualizado', 'success')
    return redirect(url_for('pedidos.index'))
