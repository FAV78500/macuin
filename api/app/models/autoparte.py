from datetime import datetime
from typing import Optional, List
from sqlalchemy import String, Text, Numeric, Boolean, DateTime, ForeignKey
from sqlalchemy.orm import Mapped, mapped_column, relationship
from app.database import Base


class Autoparte(Base):
    __tablename__ = 'autopartes'

    id:           Mapped[int]           = mapped_column(primary_key=True, index=True)
    nombre:       Mapped[str]           = mapped_column(String(150))
    descripcion:  Mapped[Optional[str]] = mapped_column(Text,        nullable=True)
    numero_parte: Mapped[Optional[str]] = mapped_column(String(50),  nullable=True, unique=True)
    marca:        Mapped[Optional[str]] = mapped_column(String(100), nullable=True)
    imagen:       Mapped[Optional[str]] = mapped_column(Text,        nullable=True)
    precio:       Mapped[float]         = mapped_column(Numeric(10, 2))
    categoria_id: Mapped[int]           = mapped_column(ForeignKey('categorias.id'))
    activo:       Mapped[bool]          = mapped_column(Boolean,     default=True)
    created_at:   Mapped[datetime]      = mapped_column(DateTime,    default=datetime.utcnow)
    updated_at:   Mapped[datetime]      = mapped_column(
                                            DateTime,
                                            default=datetime.utcnow,
                                            onupdate=datetime.utcnow
                                          )

    categoria:       Mapped['Categoria']          = relationship('Categoria',       back_populates='autopartes')
    inventario:      Mapped[Optional['Inventario']] = relationship('Inventario',    back_populates='autoparte', uselist=False, cascade='all, delete-orphan')
    detalles_pedido: Mapped[List['DetallePedido']]  = relationship('DetallePedido', back_populates='autoparte', cascade='all, delete-orphan')
