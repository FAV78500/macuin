import enum
from datetime import datetime
from typing import Optional, List
from sqlalchemy import Numeric, DateTime, ForeignKey, Enum as SAEnum, Text
from sqlalchemy.orm import Mapped, mapped_column, relationship
from app.database import Base


class EstadoPedido(str, enum.Enum):
    recibido  = 'RECIBIDO'
    surtido   = 'SURTIDO'
    enviado   = 'ENVIADO'
    cancelado = 'CANCELADO'


class Pedido(Base):
    __tablename__ = 'pedidos'

    id:                Mapped[int]           = mapped_column(primary_key=True, index=True)
    usuario_id:        Mapped[int]           = mapped_column(ForeignKey('usuarios.id'))
    estado:            Mapped[EstadoPedido]  = mapped_column(SAEnum(EstadoPedido), default=EstadoPedido.recibido)
    subtotal:          Mapped[float]         = mapped_column(Numeric(10, 2), default=0)
    total:             Mapped[float]         = mapped_column(Numeric(10, 2), default=0)
    direccion_entrega: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    fecha_pedido:      Mapped[datetime]      = mapped_column(DateTime, default=datetime.utcnow)
    updated_at:        Mapped[datetime]      = mapped_column(
                                                DateTime,
                                                default=datetime.utcnow,
                                                onupdate=datetime.utcnow
                                              )

    usuario:  Mapped['Usuario']           = relationship('Usuario',       back_populates='pedidos')
    detalles: Mapped[List['DetallePedido']] = relationship('DetallePedido', back_populates='pedido', cascade='all, delete-orphan')
