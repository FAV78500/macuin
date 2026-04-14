from flask import Blueprint, render_template
from app.utils.api_client import api_client
from app.utils.decorators import login_required
from datetime import datetime
import json

dashboard_bp = Blueprint('dashboard', __name__, url_prefix='/')

@dashboard_bp.route('/')
@login_required
def index():
    pedidos     = api_client.get('/pedidos')
    inventarios = api_client.get('/inventarios')

    if not isinstance(pedidos, list):
        pedidos = []
    if not isinstance(inventarios, list):
        inventarios = []

    ahora = datetime.now()

    # KPI 1: Ventas del mes actual (excluye cancelados)
    ventas_mes = 0.0
    for p in pedidos:
        if p.get('estado') == 'CANCELADO':
            continue
        try:
            fecha = datetime.fromisoformat(p['fecha_pedido'][:10])
            if fecha.month == ahora.month and fecha.year == ahora.year:
                ventas_mes += float(p.get('subtotal', 0))
        except (KeyError, ValueError):
            pass

    # KPI 2: Pedidos pendientes (en estado RECIBIDO)
    pedidos_pendientes = sum(1 for p in pedidos if p.get('estado') == 'RECIBIDO')

    # KPI 3: Ítems con stock en o bajo el mínimo
    alertas_stock = sum(
        1 for inv in inventarios
        if inv.get('stock_actual', 0) <= inv.get('stock_minimo', 0)
    )

    # Bar chart: Top 5 autopartes más vendidas por unidades (excluye cancelados)
    ventas_por_parte = {}
    for p in pedidos:
        if p.get('estado') == 'CANCELADO':
            continue
        for d in p.get('detalles', []):
            nombre = (d.get('autoparte') or {}).get('nombre') or f"ID {d.get('autoparte_id')}"
            ventas_por_parte[nombre] = ventas_por_parte.get(nombre, 0) + d.get('cantidad', 0)

    top5 = sorted(ventas_por_parte.items(), key=lambda x: x[1], reverse=True)[:5]
    bar_labels = json.dumps([x[0] for x in top5])
    bar_data   = json.dumps([x[1] for x in top5])

    # Doughnut: clasificación de inventario
    optimo  = sum(1 for inv in inventarios if inv.get('stock_actual', 0) > inv.get('stock_minimo', 0))
    bajo    = sum(1 for inv in inventarios if 0 < inv.get('stock_actual', 0) <= inv.get('stock_minimo', 0))
    agotado = sum(1 for inv in inventarios if inv.get('stock_actual', 0) == 0)
    doughnut_data = json.dumps([optimo, bajo, agotado])

    # Tabla: últimos 8 pedidos
    recientes = pedidos[:8]

    return render_template('dashboard/index.html',
        ventas_mes=ventas_mes,
        pedidos_pendientes=pedidos_pendientes,
        alertas_stock=alertas_stock,
        bar_labels=bar_labels,
        bar_data=bar_data,
        doughnut_data=doughnut_data,
        recientes=recientes,
    )
