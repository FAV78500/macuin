from flask import Blueprint, render_template, request, session, redirect, url_for, flash
from app.utils.api_client import api_client

auth_bp = Blueprint('auth', __name__, url_prefix='/auth')

@auth_bp.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form.get('email')
        password = request.form.get('password')
        
        response = api_client.post('/auth/login', data={'email': email, 'password': password})
        
        if 'error' not in response and 'token' in response:
            session['token'] = response['token']
            session['user'] = response['user']['name']
            session['role'] = response['user']['role']
            flash('Inicio de sesión exitoso.', 'success')
            return redirect(url_for('dashboard.index'))
        else:
            flash(response.get('error', 'Error de autenticación'), 'danger')
            
    return render_template('auth/login.html')

@auth_bp.route('/logout')
def logout():
    session.clear()
    flash('Sesión cerrada.', 'info')
    return redirect(url_for('auth.login'))
