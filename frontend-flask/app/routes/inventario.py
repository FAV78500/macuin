from flask import Blueprint, render_template, request, flash, redirect, url_for
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required

inventario_bp = Blueprint('inventario', __name__, url_prefix='/inventario')

@inventario_bp.route('/')
@login_required
@role_required('Admin', 'Almacen')
def index():
    inventarios = api_client.get('/inventarios')
    return render_template('inventario/index.html', inventarios=inventarios)

@inventario_bp.route('/actualizar/<int:id>', methods=['POST'])
@login_required
@role_required('Admin', 'Almacen')
def actualizar(id):
    stock_actual = request.form.get('stock_actual')
    if stock_actual:
        api_client.patch(f'/inventarios/{id}', data={'stock_actual': int(stock_actual)})
        flash('Inventario actualizado', 'success')
    return redirect(url_for('inventario.index'))
