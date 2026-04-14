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
        result = api_client.post('/autopartes', data=data)
        if isinstance(result, dict) and 'error' in result:
            flash(f'Error al crear autoparte: {result.get("error")}', 'danger')
            return render_template('autopartes/form.html', parte=request.form, categorias=_get_categorias())
        stock_inicial = request.form.get('stock_inicial', '').strip()
        if stock_inicial and int(stock_inicial) > 0 and isinstance(result, dict) and result.get('id'):
            inventarios = api_client.get('/inventarios')
            if isinstance(inventarios, list):
                inv = next((i for i in inventarios if i.get('autoparte_id') == result['id']), None)
                if inv:
                    api_client.patch(f'/inventarios/{inv["id"]}', data={'stock_actual': int(stock_inicial)})
        flash('Autoparte creada correctamente', 'success')
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
        result = api_client.put(f'/autopartes/{id}', data=data)
        if isinstance(result, dict) and 'error' in result:
            flash(f'Error al actualizar autoparte: {result.get("error")}', 'danger')
        else:
            stock_nuevo = request.form.get('stock_inicial', '').strip()
            if stock_nuevo != '':
                inventarios = api_client.get('/inventarios')
                if isinstance(inventarios, list):
                    inv = next((i for i in inventarios if i.get('autoparte_id') == id), None)
                    if inv:
                        api_client.patch(f'/inventarios/{inv["id"]}', data={'stock_actual': int(stock_nuevo)})
            flash('Autoparte actualizada correctamente', 'success')
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
    result = api_client.delete(f'/autopartes/{id}')
    if isinstance(result, dict) and 'error' in result:
        flash(f'No se pudo eliminar la autoparte: {result["error"]}', 'danger')
    else:
        flash('Autoparte eliminada correctamente', 'success')
    return redirect(url_for('autopartes.index'))
