from datetime import datetime, timedelta, timezone
from typing import Annotated

import bcrypt as _bcrypt

from fastapi import Depends, HTTPException, status
from fastapi.security import HTTPBearer, HTTPAuthorizationCredentials
from jose import JWTError, jwt
from sqlalchemy.orm import Session

from app import config
from app.database import SessionLocal
from app.models.usuario import Usuario, Rol


# ── Hashing de contraseñas ──────────────────────────────────────────────────

def hash_password(password: str) -> str:
    return _bcrypt.hashpw(password.encode(), _bcrypt.gensalt()).decode()

def verify_password(plain: str, hashed: str) -> bool:
    return _bcrypt.checkpw(plain.encode(), hashed.encode())


# ── JWT ─────────────────────────────────────────────────────────────────────

def crear_token(data: dict) -> str:
    payload = data.copy()
    expire = datetime.now(timezone.utc) + timedelta(minutes=config.ACCESS_TOKEN_EXPIRE_MINUTES)
    payload.update({'exp': expire})
    return jwt.encode(payload, config.SECRET_KEY, algorithm=config.ALGORITHM)


# ── Sesión de base de datos ──────────────────────────────────────────────────

def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()


# ── Autenticación ────────────────────────────────────────────────────────────

_security = HTTPBearer()

def get_current_user(
    credentials: Annotated[HTTPAuthorizationCredentials, Depends(_security)],
    db: Annotated[Session, Depends(get_db)],
) -> Usuario:
    exc = HTTPException(
        status_code=status.HTTP_401_UNAUTHORIZED,
        detail='Token inválido o expirado',
        headers={'WWW-Authenticate': 'Bearer'},
    )
    try:
        payload = jwt.decode(
            credentials.credentials,
            config.SECRET_KEY,
            algorithms=[config.ALGORITHM],
        )
        sub = payload.get('sub')
        if sub is None:
            raise exc
        user_id: int = int(sub)
    except JWTError:
        raise exc

    usuario = db.query(Usuario).filter(
        Usuario.id == user_id,
        Usuario.activo == True,
    ).first()
    if usuario is None:
        raise exc
    return usuario


# ── Control de roles ─────────────────────────────────────────────────────────

def require_roles(*roles: Rol):
    """
    Uso: Depends(require_roles(Rol.admin, Rol.ventas))
    """
    def checker(
        current_user: Annotated[Usuario, Depends(get_current_user)],
    ) -> Usuario:
        if current_user.rol not in roles:
            raise HTTPException(
                status_code=status.HTTP_403_FORBIDDEN,
                detail='No tienes permiso para realizar esta acción',
            )
        return current_user
    return checker
