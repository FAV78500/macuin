from datetime import datetime
from sqlalchemy import Integer, DateTime, ForeignKey
from sqlalchemy.orm import Mapped, mapped_column, relationship
from app.database import Base


class Inventario(Base):
    __tablename__ = 'inventarios'

    id:            Mapped[int]      = mapped_column(primary_key=True, index=True)
    autoparte_id:  Mapped[int]      = mapped_column(ForeignKey('autopartes.id'), unique=True)
    stock_actual:  Mapped[int]      = mapped_column(Integer, default=0)
    stock_minimo:  Mapped[int]      = mapped_column(Integer, default=10)
    updated_at:    Mapped[datetime] = mapped_column(
                                        DateTime,
                                        default=datetime.utcnow,
                                        onupdate=datetime.utcnow
                                      )

    autoparte: Mapped['Autoparte'] = relationship('Autoparte', back_populates='inventario')
