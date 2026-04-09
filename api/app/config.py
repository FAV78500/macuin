import os
from dotenv import load_dotenv

load_dotenv()

SECRET_KEY: str                  = os.getenv('SECRET_KEY', 'clave_secreta_macuin_2026')
ALGORITHM: str                   = 'HS256'
ACCESS_TOKEN_EXPIRE_MINUTES: int = int(os.getenv('ACCESS_TOKEN_EXPIRE_MINUTES', '480'))  # 8 horas
DATABASE_URL: str                = os.getenv('DATABASE_URL', 'postgresql://macuin:macuin@db:5432/macuin_db')
