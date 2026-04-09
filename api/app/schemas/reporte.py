from typing import List
from pydantic import BaseModel


class ReporteVentas(BaseModel):
    labels: List[str]
    data:   List[float]
    total:  float


class ResumenPedido(BaseModel):
    id:     int
    estado: str
    total:  float
    fecha:  str


class ReportePedidos(BaseModel):
    pedidos:       List[ResumenPedido]
    total_pedidos: int


class ResumenCliente(BaseModel):
    nombre:        str
    total_pedidos: int
    total_gastado: float


class ReporteClientes(BaseModel):
    clientes: List[ResumenCliente]
