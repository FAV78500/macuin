from datetime import datetime
from typing import Optional
from pydantic import BaseModel, EmailStr
from app.models.usuario import Rol


class LoginRequest(BaseModel):
    email: str
    password: str


class UsuarioInfo(BaseModel):
    name: str
    role: str


class TokenResponse(BaseModel):
    token: str
    user: UsuarioInfo


# Registro de cliente externo (talleres, refaccionarias, compradores finales)
class RegistroExterno(BaseModel):
    nombre:   str
    email:    EmailStr
    password: str
    telefono: Optional[str] = None


# Creación de usuario interno (solo Admin)
class UsuarioCreate(BaseModel):
    nombre:   str
    email:    EmailStr
    rol:      Rol
    password: str


class UsuarioUpdate(BaseModel):
    nombre:   Optional[str]       = None
    email:    Optional[EmailStr]  = None
    rol:      Optional[Rol]       = None
    activo:   Optional[bool]      = None
    password: Optional[str]       = None


class UsuarioOut(BaseModel):
    id:         int
    nombre:     str
    email:      str
    rol:        Rol
    telefono:   Optional[str] = None
    activo:     bool
    created_at: datetime

    model_config = {'from_attributes': True}
