from typing import List, Optional
from fastapi import APIRouter, Depends, HTTPException, Query, status
from sqlalchemy.orm import Session

from app.dependencies import get_db, get_current_user, require_roles
from app.models.autoparte import Autoparte
from app.models.categoria import Categoria
from app.models.inventario import Inventario
from app.models.usuario import Usuario, Rol
from app.schemas.autoparte import (
    AutoparteCreate, AutoparteUpdate, AutoparteOut, CategoriaOut,
)

router = APIRouter(prefix='/autopartes', tags=['Autopartes'])

_interno = Depends(require_roles(Rol.admin, Rol.ventas, Rol.almacen, Rol.logistica))
_ventas  = Depends(require_roles(Rol.admin, Rol.ventas))
_admin   = Depends(require_roles(Rol.admin))


# ── Categorías ───────────────────────────────────────────────────────────────

@router.get('/categorias', response_model=List[CategoriaOut])
def listar_categorias(db: Session = Depends(get_db)):
    return db.query(Categoria).order_by(Categoria.nombre).all()


# ── Catálogo ─────────────────────────────────────────────────────────────────

@router.get('', response_model=List[AutoparteOut])
def listar_autopartes(
    categoria_id: Optional[int]  = Query(None),
    activo:       Optional[bool] = Query(True),
    buscar:       Optional[str]  = Query(None),
    db:           Session        = Depends(get_db),
):
    q = db.query(Autoparte)
    if activo is not None:
        q = q.filter(Autoparte.activo == activo)
    if categoria_id:
        q = q.filter(Autoparte.categoria_id == categoria_id)
    if buscar:
        q = q.filter(Autoparte.nombre.ilike(f'%{buscar}%'))
    return q.order_by(Autoparte.nombre).all()


@router.get('/{id}', response_model=AutoparteOut)
def obtener_autoparte(
    id: int,
    db: Session = Depends(get_db),
):
    autoparte = db.query(Autoparte).filter(Autoparte.id == id).first()
    if not autoparte:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Autoparte no encontrada')
    return autoparte


# ── CRUD interno ─────────────────────────────────────────────────────────────

@router.post('', response_model=AutoparteOut, status_code=status.HTTP_201_CREATED)
def crear_autoparte(
    datos: AutoparteCreate,
    db:    Session = Depends(get_db),
    _:     Usuario = _ventas,
):
    if not db.query(Categoria).filter(Categoria.id == datos.categoria_id).first():
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail='Categoría no encontrada',
        )

    nueva = Autoparte(**datos.model_dump())
    db.add(nueva)
    db.flush()

    # Crear registro de inventario en cero al dar de alta la autoparte
    db.add(Inventario(autoparte_id=nueva.id, stock_actual=0, stock_minimo=10))
    db.commit()
    db.refresh(nueva)
    return nueva


@router.put('/{id}', response_model=AutoparteOut)
def actualizar_autoparte(
    id:    int,
    datos: AutoparteUpdate,
    db:    Session = Depends(get_db),
    _:     Usuario = _ventas,
):
    autoparte = db.query(Autoparte).filter(Autoparte.id == id).first()
    if not autoparte:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Autoparte no encontrada')

    for campo, valor in datos.model_dump(exclude_unset=True).items():
        setattr(autoparte, campo, valor)

    db.commit()
    db.refresh(autoparte)
    return autoparte


@router.delete('/{id}', status_code=status.HTTP_204_NO_CONTENT)
def eliminar_autoparte(
    id: int,
    db: Session = Depends(get_db),
    _:  Usuario = _admin,
):
    autoparte = db.query(Autoparte).filter(Autoparte.id == id).first()
    if not autoparte:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Autoparte no encontrada')
    db.delete(autoparte)
    db.commit()
