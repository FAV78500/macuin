from datetime import datetime
from typing import Optional, List
from pydantic import BaseModel
from app.models.pedido import EstadoPedido


class UsuarioBrief(BaseModel):
    id:     int
    nombre: str

    model_config = {'from_attributes': True}


class AutoparteBrief(BaseModel):
    id:     int
    nombre: str
    marca:  Optional[str] = None

    model_config = {'from_attributes': True}


class DetallePedidoCreate(BaseModel):
    autoparte_id: int
    cantidad:     int


class PedidoCreate(BaseModel):
    detalles:          List[DetallePedidoCreate]
    direccion_entrega: Optional[str] = None


class EstadoUpdate(BaseModel):
    estado: EstadoPedido


class DetallePedidoOut(BaseModel):
    id:              int
    autoparte_id:    int
    autoparte:       Optional[AutoparteBrief] = None
    cantidad:        int
    precio_unitario: float

    model_config = {'from_attributes': True}


class PedidoOut(BaseModel):
    id:                int
    usuario_id:        int
    usuario:           Optional[UsuarioBrief] = None
    estado:            EstadoPedido
    subtotal:          float
    total:             float
    direccion_entrega: Optional[str]          = None
    fecha_pedido:      datetime
    detalles:          List[DetallePedidoOut] = []

    model_config = {'from_attributes': True}
