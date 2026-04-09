from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware

from app.database import engine
from app.models import *  # registra todos los modelos en Base.metadata
from app.database import Base
from app.routers import (
    auth_router,
    users_router,
    autopartes_router,
    inventario_router,
    pedidos_router,
    reportes_router,
)

Base.metadata.create_all(bind=engine)

app = FastAPI(
    title='MACUIN API',
    description='API central para la plataforma de autopartes MACUIN',
    version='1.0.0',
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=['*'],
    allow_credentials=True,
    allow_methods=['*'],
    allow_headers=['*'],
)

app.include_router(auth_router,       prefix='/api/v1')
app.include_router(users_router,      prefix='/api/v1')
app.include_router(autopartes_router, prefix='/api/v1')
app.include_router(inventario_router, prefix='/api/v1')
app.include_router(pedidos_router,    prefix='/api/v1')
app.include_router(reportes_router,   prefix='/api/v1')


@app.get('/')
def root():
    return {'message': 'MACUIN API v1.0 — /docs para documentación'}
