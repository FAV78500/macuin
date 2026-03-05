from flask import Flask
from dotenv import load_dotenv
import os

load_dotenv()

def create_app():
    app = Flask(__name__)
    app.config['SECRET_KEY'] = os.getenv('SECRET_KEY', 'default_secret')
    app.config['API_BASE_URL'] = os.getenv('API_BASE_URL', 'http://localhost:8000/api/v1')

    # Register blueprints 
    from app.routes.auth import auth_bp
    from app.routes.dashboard import dashboard_bp
    from app.routes.autopartes import autopartes_bp
    from app.routes.inventario import inventario_bp
    from app.routes.pedidos import pedidos_bp
    from app.routes.reportes import reportes_bp

    app.register_blueprint(auth_bp)
    app.register_blueprint(dashboard_bp)
    app.register_blueprint(autopartes_bp)
    app.register_blueprint(inventario_bp)
    app.register_blueprint(pedidos_bp)
    app.register_blueprint(reportes_bp)

    return app
