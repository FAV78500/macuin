from flask import Blueprint, render_template, request, redirect, url_for, flash
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required

usuarios_bp = Blueprint('usuarios', __name__, url_prefix='/usuarios')

@usuarios_bp.route('/')
@login_required
@role_required('Admin') 
def index():
    usuarios = api_client.get('/usuarios')
    if isinstance(usuarios, dict) and 'error' in usuarios:
        flash('Error al obtener los usuarios', 'danger')
        usuarios = []
    return render_template('usuarios/index.html', usuarios=usuarios)

@usuarios_bp.route('/nuevo', methods=['GET', 'POST'])
@login_required
@role_required('Admin')
def nuevo():
    if request.method == 'POST':
        data = {
            'nombre': request.form.get('nombre'),
            'email': request.form.get('email'),
            'rol': request.form.get('rol', 'Ventas'),
            'password': request.form.get('password') # Passwords usually required on creation
        }
        response = api_client.post('/usuarios', data=data)
        if isinstance(response, dict) and 'error' in response:
            flash(f"Error al crear usuario: {response.get('error')}", 'danger')
        else:
            flash('Usuario creado exitosamente', 'success')
            return redirect(url_for('usuarios.index'))
    return render_template('usuarios/form.html', usuario={})

@usuarios_bp.route('/editar/<int:id>', methods=['GET', 'POST'])
@login_required
@role_required('Admin')
def editar(id):
    if request.method == 'POST':
        data = {
            'nombre': request.form.get('nombre'),
            'email': request.form.get('email'),
            'rol': request.form.get('rol')
        }
        
        # Only send password if the user typed a new one
        password = request.form.get('password')
        if password:
            data['password'] = password
            
        response = api_client.put(f'/usuarios/{id}', data=data)
        if isinstance(response, dict) and 'error' in response:
            flash(f"Error al actualizar usuario: {response.get('error')}", 'danger')
        else:
            flash('Usuario actualizado exitosamente', 'success')
            return redirect(url_for('usuarios.index'))
            
    # As the API might not have a GET /usuarios/{id}, we can fetch all and filter or assume it exists.
    # For simplicity, if we rely on a GET by ID:
    usuario = api_client.get(f'/usuarios/{id}')
    if isinstance(usuario, dict) and 'error' in usuario:
        flash('No se pudo obtener la información del usuario', 'danger')
        return redirect(url_for('usuarios.index'))
        
    return render_template('usuarios/form.html', usuario=usuario)
    
@usuarios_bp.route('/eliminar/<int:id>', methods=['POST'])
@login_required
@role_required('Admin')
def eliminar(id):
    response = api_client.delete(f'/usuarios/{id}')
    if isinstance(response, dict) and 'error' in response:
        flash(f"Error al eliminar usuario: {response.get('error')}", 'danger')
    else:
        flash('Usuario eliminado exitosamente', 'success')
    return redirect(url_for('usuarios.index'))
