from app.schemas.user import (
    LoginRequest, TokenResponse, RegistroExterno,
    UsuarioCreate, UsuarioUpdate, UsuarioOut, UsuarioInfo,
)
from app.schemas.autoparte import (
    AutoparteCreate, AutoparteUpdate, AutoparteOut,
    CategoriaOut, InventarioOut, InventarioUpdate,
)
from app.schemas.pedido import (
    PedidoCreate, PedidoOut, EstadoUpdate,
    DetallePedidoCreate, DetallePedidoOut,
)
from app.schemas.reporte import (
    ReporteVentas, ReportePedidos, ReporteClientes,
)
