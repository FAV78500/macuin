from flask import Blueprint, render_template, request, flash, redirect, url_for
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required

pedidos_bp = Blueprint('pedidos', __name__, url_prefix='/pedidos')

@pedidos_bp.route('/')
@login_required
@role_required('Admin', 'Ventas', 'Logistica')
def index():
    pedidos = api_client.get('/pedidos')
    return render_template('pedidos/index.html', pedidos=pedidos)

@pedidos_bp.route('/estatus/<int:id>', methods=['POST'])
@login_required
@role_required('Admin', 'Logistica')
def estatus(id):
    nuevo_estado = request.form.get('estado_id')
    if nuevo_estado:
        api_client.patch(f'/pedidos/{id}', data={'estado_id': int(nuevo_estado)})
        flash('Estatus del pedido actualizado', 'success')
    return redirect(url_for('pedidos.index'))
