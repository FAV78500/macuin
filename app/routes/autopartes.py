from flask import Blueprint, render_template, request, redirect, url_for, flash
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required

autopartes_bp = Blueprint('autopartes', __name__, url_prefix='/autopartes')

@autopartes_bp.route('/')
@login_required
@role_required('Admin', 'Ventas') 
def index():
    partes = api_client.get('/autopartes')
    if isinstance(partes, dict) and 'error' in partes:
        flash('Error al obtener autopartes', 'danger')
        partes = []
    return render_template('autopartes/index.html', partes=partes)

@autopartes_bp.route('/nuevo', methods=['GET', 'POST'])
@login_required
@role_required('Admin', 'Ventas')
def nuevo():
    if request.method == 'POST':
        data = {
            'nombre': request.form.get('nombre'),
            'descripcion': request.form.get('descripcion'),
            'precio': float(request.form.get('precio', 0)),
            'categoria_id': int(request.form.get('categoria_id', 1)),
            'marca_id': int(request.form.get('marca_id', 1)),
            'activo': True if request.form.get('activo') else False
        }
        api_client.post('/autopartes', data=data)
        flash('Autoparte creada', 'success')
        return redirect(url_for('autopartes.index'))
    return render_template('autopartes/form.html', parte={})

@autopartes_bp.route('/editar/<int:id>', methods=['GET', 'POST'])
@login_required
@role_required('Admin', 'Ventas')
def editar(id):
    if request.method == 'POST':
        data = {
            'nombre': request.form.get('nombre'),
            'descripcion': request.form.get('descripcion'),
            'precio': float(request.form.get('precio', 0)),
            'categoria_id': int(request.form.get('categoria_id', 1)),
            'marca_id': int(request.form.get('marca_id', 1)),
            'activo': True if request.form.get('activo') else False
        }
        api_client.put(f'/autopartes/{id}', data=data)
        flash('Autoparte actualizada', 'success')
        return redirect(url_for('autopartes.index'))
    return render_template('autopartes/form.html', parte={'id': id, 'nombre': 'Dummy Part', 'precio': 100})
    
@autopartes_bp.route('/eliminar/<int:id>', methods=['POST'])
@login_required
@role_required('Admin')
def eliminar(id):
    api_client.delete(f'/autopartes/{id}')
    flash('Autoparte eliminada', 'success')
    return redirect(url_for('autopartes.index'))
