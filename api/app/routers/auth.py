from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session

from app.dependencies import get_db, hash_password, verify_password, crear_token, get_current_user
from app.models.usuario import Usuario, Rol
from app.schemas.user import LoginRequest, TokenResponse, RegistroExterno, UsuarioOut, UsuarioUpdate
from typing import Annotated

router = APIRouter(prefix='/auth', tags=['Autenticación'])


@router.post('/login', response_model=TokenResponse)
def login(datos: LoginRequest, db: Session = Depends(get_db)):
    usuario = db.query(Usuario).filter(
        Usuario.email == datos.email,
        Usuario.activo == True,
    ).first()

    if not usuario or not verify_password(datos.password, usuario.password_hash):
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail='Credenciales inválidas',
        )

    # sub debe ser string según el estándar JWT (python-jose lo valida)
    token = crear_token({'sub': str(usuario.id), 'rol': usuario.rol.value})

    return TokenResponse(
        token=token,
        user={'name': usuario.nombre, 'role': usuario.rol.value},
    )


@router.post('/registro', response_model=UsuarioOut, status_code=status.HTTP_201_CREATED)
def registro_externo(datos: RegistroExterno, db: Session = Depends(get_db)):
    """Registro de clientes externos (talleres, refaccionarias, compradores finales)."""
    if db.query(Usuario).filter(Usuario.email == datos.email).first():
        raise HTTPException(
            status_code=status.HTTP_409_CONFLICT,
            detail='Ya existe una cuenta con ese correo electrónico',
        )

    nuevo = Usuario(
        nombre=datos.nombre,
        email=datos.email,
        password_hash=hash_password(datos.password),
        telefono=datos.telefono,
        rol=Rol.externo,
    )
    db.add(nuevo)
    db.commit()
    db.refresh(nuevo)
    return nuevo


@router.get('/me', response_model=UsuarioOut)
def obtener_perfil(
    current_user: Annotated[Usuario, Depends(get_current_user)],
):
    return current_user

@router.put('/me', response_model=UsuarioOut)
def actualizar_perfil(
    datos: UsuarioUpdate,
    db: Annotated[Session, Depends(get_db)],
    current_user: Annotated[Usuario, Depends(get_current_user)],
):
    cambios = datos.model_dump(exclude_unset=True)
    if 'password' in cambios:
        current_user.password_hash = hash_password(cambios.pop('password'))
    for campo, valor in cambios.items():
        setattr(current_user, campo, valor)
    db.commit()
    db.refresh(current_user)
    return current_user
