from sqlalchemy import Integer, Numeric, ForeignKey
from sqlalchemy.orm import Mapped, mapped_column, relationship
from app.database import Base


class DetallePedido(Base):
    __tablename__ = 'detalles_pedido'

    id:               Mapped[int]   = mapped_column(primary_key=True, index=True)
    pedido_id:        Mapped[int]   = mapped_column(ForeignKey('pedidos.id'))
    autoparte_id:     Mapped[int]   = mapped_column(ForeignKey('autopartes.id'))
    cantidad:         Mapped[int]   = mapped_column(Integer)
    precio_unitario:  Mapped[float] = mapped_column(Numeric(10, 2))

    pedido:    Mapped['Pedido']     = relationship('Pedido',    back_populates='detalles')
    autoparte: Mapped['Autoparte']  = relationship('Autoparte', back_populates='detalles_pedido')
