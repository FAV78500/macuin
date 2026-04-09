from typing import List
from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session

from app.dependencies import get_db, require_roles
from app.models.inventario import Inventario
from app.models.usuario import Usuario, Rol
from app.schemas.autoparte import InventarioOut, InventarioUpdate

router = APIRouter(prefix='/inventarios', tags=['Inventario'])

_lectura    = Depends(require_roles(Rol.admin, Rol.ventas, Rol.almacen, Rol.logistica))
_escritura  = Depends(require_roles(Rol.admin, Rol.almacen))


@router.get('/', response_model=List[InventarioOut])
def listar_inventario(
    db: Session = Depends(get_db),
    _:  Usuario = _lectura,
):
    return db.query(Inventario).all()


@router.patch('/{id}', response_model=InventarioOut)
def actualizar_stock(
    id:    int,
    datos: InventarioUpdate,
    db:    Session = Depends(get_db),
    _:     Usuario = _escritura,
):
    inv = db.query(Inventario).filter(Inventario.id == id).first()
    if not inv:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Registro de inventario no encontrado')

    inv.stock_actual = datos.stock_actual
    db.commit()
    db.refresh(inv)
    return inv
