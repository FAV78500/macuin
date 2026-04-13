from flask import Blueprint, render_template, request, redirect, url_for, flash
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required

autopartes_bp = Blueprint('autopartes', __name__, url_prefix='/autopartes')

def _get_categorias():
    cats = api_client.get('/autopartes/categorias')
    return cats if isinstance(cats, list) else []


@autopartes_bp.route('/')
@login_required
@role_required('admin', 'ventas')
def index():
    partes = api_client.get('/autopartes')
    if isinstance(partes, dict) and 'error' in partes:
        flash('Error al obtener autopartes', 'danger')
        partes = []
    return render_template('autopartes/index.html', partes=partes)

@autopartes_bp.route('/nuevo', methods=['GET', 'POST'])
@login_required
@role_required('admin', 'ventas')
def nuevo():
    if request.method == 'POST':
        data = {
            'nombre':       request.form.get('nombre'),
            'descripcion':  request.form.get('descripcion') or None,
            'numero_parte': request.form.get('numero_parte') or None,
            'marca':        request.form.get('marca') or None,
            'precio':       float(request.form.get('precio', 0)),
            'categoria_id': int(request.form.get('categoria_id', 0)),
            'activo':       bool(request.form.get('activo')),
            'imagen':       request.form.get('imagen_base64') or None,
        }
        api_client.post('/autopartes', data=data)
        flash('Autoparte creada', 'success')
        return redirect(url_for('autopartes.index'))
    return render_template('autopartes/form.html', parte={}, categorias=_get_categorias())

@autopartes_bp.route('/editar/<int:id>', methods=['GET', 'POST'])
@login_required
@role_required('admin', 'ventas')
def editar(id):
    if request.method == 'POST':
        data = {
            'nombre':       request.form.get('nombre'),
            'descripcion':  request.form.get('descripcion') or None,
            'numero_parte': request.form.get('numero_parte') or None,
            'marca':        request.form.get('marca') or None,
            'precio':       float(request.form.get('precio', 0)),
            'categoria_id': int(request.form.get('categoria_id', 0)),
            'activo':       bool(request.form.get('activo')),
            'imagen':       request.form.get('imagen_base64') or None,
        }
        api_client.put(f'/autopartes/{id}', data=data)
        flash('Autoparte actualizada', 'success')
        return redirect(url_for('autopartes.index'))
    parte = api_client.get(f'/autopartes/{id}')
    if isinstance(parte, dict) and 'error' in parte:
        flash('No se pudo obtener la autoparte', 'danger')
        return redirect(url_for('autopartes.index'))
    return render_template('autopartes/form.html', parte=parte, categorias=_get_categorias())

@autopartes_bp.route('/eliminar/<int:id>', methods=['POST'])
@login_required
@role_required('admin')
def eliminar(id):
    api_client.delete(f'/autopartes/{id}')
    flash('Autoparte eliminada', 'success')
    return redirect(url_for('autopartes.index'))
