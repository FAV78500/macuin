from flask import Blueprint, render_template
from app.utils.api_client import api_client
from app.utils.decorators import login_required, role_required

reportes_bp = Blueprint('reportes', __name__, url_prefix='/reportes')

@reportes_bp.route('/')
@login_required
@role_required('Admin', 'Ventas')
def index():
    ventas = api_client.get('/reportes/ventas')
    return render_template('reportes/index.html', ventas=ventas)
