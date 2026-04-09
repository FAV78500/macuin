# Importar todos los modelos para que SQLAlchemy registre sus metadatos
# al momento de llamar Base.metadata.create_all(engine)
from app.models.usuario import Usuario, Rol
from app.models.categoria import Categoria
from app.models.autoparte import Autoparte
from app.models.inventario import Inventario
from app.models.pedido import Pedido, EstadoPedido
from app.models.detalle_pedido import DetallePedido
