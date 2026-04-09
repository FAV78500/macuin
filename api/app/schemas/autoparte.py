from datetime import datetime
from typing import Optional
from pydantic import BaseModel


class CategoriaOut(BaseModel):
    id:     int
    nombre: str

    model_config = {'from_attributes': True}


class AutoparteCreate(BaseModel):
    nombre:       str
    descripcion:  Optional[str]   = None
    numero_parte: Optional[str]   = None
    marca:        Optional[str]   = None
    precio:       float
    categoria_id: int
    activo:       bool             = True


class AutoparteUpdate(BaseModel):
    nombre:       Optional[str]   = None
    descripcion:  Optional[str]   = None
    numero_parte: Optional[str]   = None
    marca:        Optional[str]   = None
    precio:       Optional[float] = None
    categoria_id: Optional[int]   = None
    activo:       Optional[bool]  = None


class AutoparteOut(BaseModel):
    id:           int
    nombre:       str
    descripcion:  Optional[str]          = None
    numero_parte: Optional[str]          = None
    marca:        Optional[str]          = None
    precio:       float
    categoria_id: int
    categoria:    Optional[CategoriaOut] = None
    activo:       bool
    created_at:   datetime

    model_config = {'from_attributes': True}


class InventarioOut(BaseModel):
    id:           int
    autoparte_id: int
    autoparte:    Optional[AutoparteOut] = None
    stock_actual: int
    stock_minimo: int

    model_config = {'from_attributes': True}


class InventarioUpdate(BaseModel):
    stock_actual: int
