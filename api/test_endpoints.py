"""
test_endpoints.py — Prueba de endpoints principales de la API MACUIN
Ejecutar dentro del contenedor: docker compose exec api python test_endpoints.py
"""
import json
import urllib.request
import urllib.error

BASE = 'http://localhost:8000/api/v1'
LINEA = '-' * 60


def call(method, path, body=None, token=None):
    url  = f'{BASE}{path}'
    data = json.dumps(body).encode() if body else None
    req  = urllib.request.Request(url, data=data, method=method)
    req.add_header('Content-Type', 'application/json')
    if token:
        req.add_header('Authorization', f'Bearer {token}')
    try:
        with urllib.request.urlopen(req) as r:
            raw = r.read().decode()
            return r.status, json.loads(raw) if raw else {}
    except urllib.error.HTTPError as e:
        raw = e.read().decode()
        return e.code, json.loads(raw) if raw else {}


def mostrar(status, body, etiqueta=''):
    ok = status < 400
    marca = 'OK' if ok else 'FALLO'
    print(f'  [{marca}] HTTP {status}  {etiqueta}')
    print(json.dumps(body, indent=2, ensure_ascii=False, default=str)[:500])


# -----------------------------------------------------------------------
# 1. Registro de nuevo cliente externo
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('1. POST /auth/registro — nuevo cliente externo')
print(LINEA)
status, body = call('POST', '/auth/registro', {
    'nombre': 'Taller Nuevo Test', 'email': 'nuevo@test.com',
    'password': 'nuevo2026', 'telefono': '5550001111',
})
mostrar(status, body)

# -----------------------------------------------------------------------
# 2. Login cliente externo
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('2. POST /auth/login — cliente externo (piston@taller.com)')
print(LINEA)
status, body = call('POST', '/auth/login', {
    'email': 'piston@taller.com', 'password': 'taller2026',
})
mostrar(status, body)
TOKEN_EXTERNO = body.get('token') if status < 400 else None
print(f'  >> Token externo capturado: {"SI" if TOKEN_EXTERNO else "NO"}')

# -----------------------------------------------------------------------
# 3. Login admin
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('3. POST /auth/login — admin')
print(LINEA)
status, body = call('POST', '/auth/login', {
    'email': 'admin@macuin.com', 'password': 'admin2026',
})
mostrar(status, body)
TOKEN_ADMIN = body.get('token') if status < 400 else None
print(f'  >> Token admin capturado: {"SI" if TOKEN_ADMIN else "NO"}')

# -----------------------------------------------------------------------
# 4. GET /autopartes sin token (401 esperado)
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('4. GET /autopartes — SIN token (401 esperado)')
print(LINEA)
status, body = call('GET', '/autopartes')
mostrar(status, body, '401 esperado')

# -----------------------------------------------------------------------
# 5. GET /autopartes con token externo
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('5. GET /autopartes — CON token externo')
print(LINEA)
status, body = call('GET', '/autopartes', token=TOKEN_EXTERNO)
mostrar(status, body)
if isinstance(body, list):
    print(f'  >> Total autopartes: {len(body)}')
    for ap in body:
        print(f'     [{ap["id"]}] {ap["nombre"]}  ${ap["precio"]}')

# -----------------------------------------------------------------------
# 6. GET /pedidos — cliente externo (solo los suyos)
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('6. GET /pedidos — cliente externo (solo sus pedidos)')
print(LINEA)
status, body = call('GET', '/pedidos', token=TOKEN_EXTERNO)
mostrar(status, body)
if isinstance(body, list):
    print(f'  >> Pedidos del cliente: {len(body)}')
    for p in body:
        print(f'     pedido #{p["id"]}  estado={p["estado"]}  total=${p["total"]}')

# -----------------------------------------------------------------------
# 7. POST /pedidos — crear nuevo pedido
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('7. POST /pedidos — crear nuevo pedido')
print(LINEA)
status, body = call('POST', '/pedidos', {
    'detalles': [
        {'autoparte_id': 5, 'cantidad': 2},
        {'autoparte_id': 6, 'cantidad': 1},
    ],
    'direccion_entrega': 'Calle Prueba 99, CDMX',
}, token=TOKEN_EXTERNO)
mostrar(status, body)
PEDIDO_NUEVO_ID = body.get('id') if status < 400 else None
if PEDIDO_NUEVO_ID:
    print(f'  >> Pedido creado ID: {PEDIDO_NUEVO_ID}  estado={body["estado"]}  total=${body["total"]}')

# -----------------------------------------------------------------------
# 8. PATCH /pedidos/{id}/estado — cambiar a SURTIDO (admin)
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print(f'8. PATCH /pedidos/{PEDIDO_NUEVO_ID}/estado — cambiar a SURTIDO')
print(LINEA)
status, body = call('PATCH', f'/pedidos/{PEDIDO_NUEVO_ID}/estado',
                    {'estado': 'SURTIDO'}, token=TOKEN_ADMIN)
mostrar(status, body)
if status < 400:
    print(f'  >> Nuevo estado: {body["estado"]}')

# -----------------------------------------------------------------------
# 9. GET /pedidos — admin ve TODOS
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('9. GET /pedidos — admin (todos los pedidos)')
print(LINEA)
status, body = call('GET', '/pedidos', token=TOKEN_ADMIN)
mostrar(status, body)
if isinstance(body, list):
    print(f'  >> Total pedidos en sistema: {len(body)}')
    for p in body:
        print(f'     #{p["id"]}  usuario_id={p["usuario_id"]}  estado={p["estado"]}  total=${p["total"]}')

# -----------------------------------------------------------------------
# 10. GET /reportes/ventas
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('10. GET /reportes/ventas — admin')
print(LINEA)
status, body = call('GET', '/reportes/ventas', token=TOKEN_ADMIN)
mostrar(status, body)

# -----------------------------------------------------------------------
# 11. GET /reportes/clientes
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('11. GET /reportes/clientes — admin')
print(LINEA)
status, body = call('GET', '/reportes/clientes', token=TOKEN_ADMIN)
mostrar(status, body)

# -----------------------------------------------------------------------
# 12. Acceso cruzado — externo intenta ver pedido ajeno (403 esperado)
# -----------------------------------------------------------------------
print(f'\n{LINEA}')
print('12. GET /pedidos/3 — externo intenta ver pedido ajeno (403 esperado)')
print(LINEA)
status, body = call('GET', '/pedidos/3', token=TOKEN_EXTERNO)
mostrar(status, body, '403 esperado')

print(f'\n{LINEA}')
print('  Pruebas finalizadas')
print(LINEA)
