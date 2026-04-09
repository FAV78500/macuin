from typing import List
from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session

from app.dependencies import get_db, hash_password, require_roles
from app.models.usuario import Usuario, Rol
from app.schemas.user import UsuarioCreate, UsuarioUpdate, UsuarioOut

router = APIRouter(prefix='/usuarios', tags=['Usuarios'])

_solo_admin = Depends(require_roles(Rol.admin))


@router.get('/', response_model=List[UsuarioOut])
def listar_usuarios(
    db: Session = Depends(get_db),
    _: Usuario = _solo_admin,
):
    return db.query(Usuario).order_by(Usuario.nombre).all()


@router.get('/{id}', response_model=UsuarioOut)
def obtener_usuario(
    id: int,
    db: Session = Depends(get_db),
    _: Usuario = _solo_admin,
):
    usuario = db.query(Usuario).filter(Usuario.id == id).first()
    if not usuario:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Usuario no encontrado')
    return usuario


@router.post('/', response_model=UsuarioOut, status_code=status.HTTP_201_CREATED)
def crear_usuario(
    datos: UsuarioCreate,
    db: Session = Depends(get_db),
    _: Usuario = _solo_admin,
):
    if db.query(Usuario).filter(Usuario.email == datos.email).first():
        raise HTTPException(
            status_code=status.HTTP_409_CONFLICT,
            detail='Ya existe un usuario con ese correo electrónico',
        )
    nuevo = Usuario(
        nombre=datos.nombre,
        email=datos.email,
        password_hash=hash_password(datos.password),
        rol=datos.rol,
    )
    db.add(nuevo)
    db.commit()
    db.refresh(nuevo)
    return nuevo


@router.put('/{id}', response_model=UsuarioOut)
def actualizar_usuario(
    id: int,
    datos: UsuarioUpdate,
    db: Session = Depends(get_db),
    _: Usuario = _solo_admin,
):
    usuario = db.query(Usuario).filter(Usuario.id == id).first()
    if not usuario:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Usuario no encontrado')

    cambios = datos.model_dump(exclude_unset=True)

    if 'password' in cambios:
        usuario.password_hash = hash_password(cambios.pop('password'))

    for campo, valor in cambios.items():
        setattr(usuario, campo, valor)

    db.commit()
    db.refresh(usuario)
    return usuario


@router.delete('/{id}', status_code=status.HTTP_204_NO_CONTENT)
def eliminar_usuario(
    id: int,
    db: Session = Depends(get_db),
    _: Usuario = _solo_admin,
):
    usuario = db.query(Usuario).filter(Usuario.id == id).first()
    if not usuario:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail='Usuario no encontrado')
    db.delete(usuario)
    db.commit()
