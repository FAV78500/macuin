"""
seed.py — Datos de prueba para MACUIN
Ejecutar dentro del contenedor api:
    docker compose exec api python seed.py
"""
import os
import sys
from datetime import datetime, timedelta

import bcrypt as _bcrypt
from sqlalchemy import create_engine, text
from sqlalchemy.orm import sessionmaker

# ── Conexión ──────────────────────────────────────────────────────────────────
DATABASE_URL = os.getenv('DATABASE_URL', 'postgresql://macuin:macuin2026@db:5432/macuin_db')
engine  = create_engine(DATABASE_URL)
Session = sessionmaker(bind=engine)
db      = Session()


def h(pw): return _bcrypt.hashpw(pw.encode(), _bcrypt.gensalt()).decode()


# ── Imports de modelos (después de inicializar el engine) ─────────────────────
from app.models.usuario      import Usuario, Rol
from app.models.categoria    import Categoria
from app.models.autoparte    import Autoparte
from app.models.inventario   import Inventario
from app.models.pedido       import Pedido, EstadoPedido
from app.models.detalle_pedido import DetallePedido
from app.database import Base

# ── Crear tablas si no existen ────────────────────────────────────────────────
Base.metadata.create_all(bind=engine)

# ── Limpiar en orden inverso a las FK ─────────────────────────────────────────
print("Limpiando tablas previas...")
db.query(DetallePedido).delete()
db.query(Pedido).delete()
db.query(Inventario).delete()
db.query(Autoparte).delete()
db.query(Usuario).delete()
db.query(Categoria).delete()
db.commit()
print("  OK\n")

# ─────────────────────────────────────────────────────────────────────────────
# 1. CATEGORÍAS
# ─────────────────────────────────────────────────────────────────────────────
print("Insertando categorías...")
cats = {}
for nombre in ['Frenos', 'Suspensión', 'Motor', 'Eléctrico']:
    c = Categoria(nombre=nombre)
    db.add(c)
    db.flush()
    cats[nombre] = c
    print(f"  [{c.id}] {c.nombre}")
db.commit()

# ─────────────────────────────────────────────────────────────────────────────
# 2. USUARIOS
# ─────────────────────────────────────────────────────────────────────────────
print("\nInsertando usuarios...")
usuarios = {}
datos_usuarios = [
    dict(nombre='Admin MACUIN',        email='admin@macuin.com',     password='admin2026',    rol=Rol.admin,     telefono=None),
    dict(nombre='Carlos Ventas',       email='ventas@macuin.com',    password='ventas2026',   rol=Rol.ventas,    telefono='5551234567'),
    dict(nombre='Lupita Almacén',      email='almacen@macuin.com',   password='almacen2026',  rol=Rol.almacen,   telefono='5559876543'),
    dict(nombre='Taller El Pistón',    email='piston@taller.com',    password='taller2026',   rol=Rol.externo,   telefono='5552223344'),
    dict(nombre='Refaccionaria Rueda', email='rueda@refac.com',      password='refac2026',    rol=Rol.externo,   telefono='5556667788'),
]
for d in datos_usuarios:
    u = Usuario(
        nombre=d['nombre'],
        email=d['email'],
        password_hash=h(d['password']),
        rol=d['rol'],
        telefono=d['telefono'],
    )
    db.add(u)
    db.flush()
    usuarios[d['email']] = u
    print(f"  [{u.id}] {u.nombre} ({u.rol.value})  pw={d['password']}")
db.commit()

# ─────────────────────────────────────────────────────────────────────────────
# 3. AUTOPARTES (2 por categoría = 8 total)
# ─────────────────────────────────────────────────────────────────────────────
print("\nInsertando autopartes...")
partes_datos = [
    # Frenos
    dict(nombre='Pastillas de freno delanteras', numero_parte='FRE-001', marca='Bendix',   precio=850.00,  categoria='Frenos',    stock=45, s_min=10),
    dict(nombre='Disco de freno ventilado',      numero_parte='FRE-002', marca='Brembo',   precio=1450.00, categoria='Frenos',    stock=20, s_min=5),
    # Suspensión
    dict(nombre='Amortiguador delantero',        numero_parte='SUS-001', marca='Monroe',   precio=1200.00, categoria='Suspensión', stock=15, s_min=5),
    dict(nombre='Resorte helicoidal',            numero_parte='SUS-002', marca='Moog',     precio=680.00,  categoria='Suspensión', stock=30, s_min=8),
    # Motor
    dict(nombre='Filtro de aceite',              numero_parte='MOT-001', marca='Purolator',precio=180.00,  categoria='Motor',     stock=80, s_min=20),
    dict(nombre='Bujía de encendido (pack x4)',  numero_parte='MOT-002', marca='NGK',      precio=420.00,  categoria='Motor',     stock=60, s_min=15),
    # Eléctrico
    dict(nombre='Batería 12V 60Ah',              numero_parte='ELE-001', marca='Bosch',    precio=2100.00, categoria='Eléctrico', stock=12, s_min=4),
    dict(nombre='Alternador remanufacturado',    numero_parte='ELE-002', marca='Denso',    precio=3200.00, categoria='Eléctrico', stock=6,  s_min=3),
]

partes = {}
for d in partes_datos:
    ap = Autoparte(
        nombre=d['nombre'],
        numero_parte=d['numero_parte'],
        marca=d['marca'],
        precio=d['precio'],
        categoria_id=cats[d['categoria']].id,
        activo=True,
    )
    db.add(ap)
    db.flush()

    inv = Inventario(autoparte_id=ap.id, stock_actual=d['stock'], stock_minimo=d['s_min'])
    db.add(inv)

    partes[d['numero_parte']] = ap
    print(f"  [{ap.id}] {ap.nombre}  ${ap.precio}  stock={d['stock']}")

db.commit()

# ─────────────────────────────────────────────────────────────────────────────
# 4. PEDIDOS + DETALLES
# ─────────────────────────────────────────────────────────────────────────────
print("\nInsertando pedidos y detalles...")

pedidos_datos = [
    dict(
        cliente='piston@taller.com',
        estado=EstadoPedido.enviado,
        fecha=datetime.utcnow() - timedelta(days=10),
        direccion='Av. Industria 45, Col. Centro, CDMX',
        items=[
            ('FRE-001', 2),   # 2 × 850.00 = 1700
            ('MOT-001', 4),   # 4 × 180.00 = 720
        ],
    ),
    dict(
        cliente='piston@taller.com',
        estado=EstadoPedido.surtido,
        fecha=datetime.utcnow() - timedelta(days=3),
        direccion='Av. Industria 45, Col. Centro, CDMX',
        items=[
            ('SUS-001', 1),   # 1 × 1200.00 = 1200
            ('MOT-002', 2),   # 2 ×  420.00 =  840
        ],
    ),
    dict(
        cliente='rueda@refac.com',
        estado=EstadoPedido.recibido,
        fecha=datetime.utcnow() - timedelta(days=1),
        direccion='Calle Talleres 12, Ecatepec, Edo. Méx.',
        items=[
            ('ELE-001', 1),   # 1 × 2100.00 = 2100
            ('FRE-002', 2),   # 2 × 1450.00 = 2900
            ('SUS-002', 3),   # 3 ×  680.00 = 2040
        ],
    ),
]

for pd_data in pedidos_datos:
    subtotal = sum(
        float(partes[num_parte].precio) * cant
        for num_parte, cant in pd_data['items']
    )
    pedido = Pedido(
        usuario_id=usuarios[pd_data['cliente']].id,
        estado=pd_data['estado'],
        subtotal=subtotal,
        total=subtotal,
        direccion_entrega=pd_data['direccion'],
        fecha_pedido=pd_data['fecha'],
    )
    db.add(pedido)
    db.flush()

    for num_parte, cantidad in pd_data['items']:
        ap = partes[num_parte]
        db.add(DetallePedido(
            pedido_id=pedido.id,
            autoparte_id=ap.id,
            cantidad=cantidad,
            precio_unitario=ap.precio,
        ))

    print(f"  [{pedido.id}] {pd_data['cliente']}  estado={pd_data['estado'].value}  total=${subtotal:,.2f}")

db.commit()

# ─────────────────────────────────────────────────────────────────────────────
# 5. VERIFICACIÓN — SELECT de cada tabla
# ─────────────────────────────────────────────────────────────────────────────
print("\n" + "="*60)
print("VERIFICACIÓN")
print("="*60)

tablas = [
    ('categorias',     'SELECT id, nombre FROM categorias ORDER BY id'),
    ('usuarios',       'SELECT id, nombre, email, rol, activo FROM usuarios ORDER BY id'),
    ('autopartes',     'SELECT id, nombre, precio, categoria_id, activo FROM autopartes ORDER BY id'),
    ('inventarios',    'SELECT id, autoparte_id, stock_actual, stock_minimo FROM inventarios ORDER BY id'),
    ('pedidos',        'SELECT id, usuario_id, estado, subtotal, total FROM pedidos ORDER BY id'),
    ('detalles_pedido','SELECT id, pedido_id, autoparte_id, cantidad, precio_unitario FROM detalles_pedido ORDER BY id'),
]

for tabla, query in tablas:
    result = db.execute(text(query)).fetchall()
    print(f"\n── {tabla} ({len(result)} registros) ──")
    for row in result:
        print("  ", dict(row._mapping))

db.close()
print("\n✓ Seed completado exitosamente")
