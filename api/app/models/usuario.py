import enum
from datetime import datetime
from typing import Optional, List
from sqlalchemy import String, Boolean, DateTime, Enum as SAEnum
from sqlalchemy.orm import Mapped, mapped_column, relationship
from app.database import Base


class Rol(str, enum.Enum):
    externo   = 'externo'    # clientes: talleres, refaccionarias, compradores finales
    ventas    = 'ventas'     # personal interno de ventas
    almacen   = 'almacen'    # personal interno de almacén
    logistica = 'logistica'  # personal interno de logística
    admin     = 'admin'      # administrador del sistema


class Usuario(Base):
    __tablename__ = 'usuarios'

    id:            Mapped[int]           = mapped_column(primary_key=True, index=True)
    nombre:        Mapped[str]           = mapped_column(String(150))
    email:         Mapped[str]           = mapped_column(String(255), unique=True, index=True)
    password_hash: Mapped[str]           = mapped_column(String(255))
    rol:           Mapped[Rol]           = mapped_column(SAEnum(Rol), default=Rol.externo)
    telefono:      Mapped[Optional[str]] = mapped_column(String(20),  nullable=True)
    activo:        Mapped[bool]          = mapped_column(Boolean,     default=True)
    created_at:    Mapped[datetime]      = mapped_column(DateTime,    default=datetime.utcnow)
    updated_at:    Mapped[datetime]      = mapped_column(
                                            DateTime,
                                            default=datetime.utcnow,
                                            onupdate=datetime.utcnow
                                          )

    pedidos: Mapped[List['Pedido']] = relationship('Pedido', back_populates='usuario')
