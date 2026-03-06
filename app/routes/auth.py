from flask import Blueprint, render_template, request, session, redirect, url_for, flash
from app.utils.api_client import api_client
import re

auth_bp = Blueprint('auth', __name__, url_prefix='/auth')

def validar_formato_email(email):
    """Valida formato de correo electrónico usando expresión regular"""
    email_pattern = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
    return re.match(email_pattern, email) is not None

def validar_email_o_id(email):
    """Valida formato de email o ID de empleado"""
    if not email or len(email) == 0:
        return False, 'El ID de empleado o correo es obligatorio'
    
    if len(email) > 100:
        return False, 'El ID de empleado o correo no puede exceder los 100 caracteres'
    
    # Validar si es un correo electrónico
    if '@' in email:
        if not validar_formato_email(email):
            return False, 'El formato del correo es inválido'
        return True, 'email'
    
    # Validar si es un ID de empleado
    id_pattern = r'^[a-zA-Z0-9]{4,20}$'
    if re.match(id_pattern, email):
        return True, 'id'
    else:
        return False, 'Ingrese un correo electrónico válido o un ID de empleado (4-20 caracteres alfanuméricos)'

def validar_password(password):
    """Valida la contraseña"""
    if not password or len(password) == 0:
        return False, 'La contraseña es obligatoria'
    
    if len(password) > 128:
        return False, 'La contraseña no puede exceder los 128 caracteres'
    
    return True, ''

@auth_bp.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form.get('email', '').strip()
        password = request.form.get('password', '')
        
        # Validar email/ID
        email_valido, email_result = validar_email_o_id(email)
        if not email_valido:
            flash(email_result, 'danger')
            return render_template('auth/login.html')
        
        # Validar contraseña
        password_valido, password_error = validar_password(password)
        if not password_valido:
            flash(password_error, 'danger')
            return render_template('auth/login.html')
        
        # Bypass de desarrollo: permitir cualquier email válido con contraseña "12345678"
        if password == '12345678':
            # Simulación de sesión exitosa
            session['token'] = 'dev_token_' + email
            session['user'] = email.split('@')[0] if '@' in email else email
            session['role'] = 'Admin'
            flash('Inicio de sesión exitoso.', 'success')
            return redirect(url_for('dashboard.index'))
        else:
            # Mensaje específico según el tipo de entrada
            if email_result == 'email':
                flash('Contraseña incorrecta para el correo proporcionado.', 'danger')
            else:
                flash('Contraseña incorrecta para el ID de empleado proporcionado.', 'danger')
            flash('Para desarrollo, use: 12345678', 'info')
            
    return render_template('auth/login.html')

@auth_bp.route('/logout')
def logout():
    session.clear()
    flash('Sesión cerrada.', 'info')
    return redirect(url_for('auth.login'))
