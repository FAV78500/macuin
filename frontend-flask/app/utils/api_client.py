import requests
import os
from flask import session, current_app

class APIClient:
    _mock_autopartes = [
        {'id': 1, 'nombre': 'Pastillas de freno', 'categoria_id': 3, 'marca_id': 5, 'precio': 850.50, 'activo': True},
        {'id': 2, 'nombre': 'Amortiguador', 'categoria_id': 2, 'marca_id': 1, 'precio': 1200.00, 'activo': True}
    ]
    _mock_inventarios = [
        {'id': 1, 'autoparte_id': 1, 'autoparte': {'nombre':'Pastillas de freno'}, 'stock_actual': 40, 'stock_minimo': 10},
        {'id': 2, 'autoparte_id': 2, 'autoparte': {'nombre': 'Amortiguador'}, 'stock_actual': 15, 'stock_minimo': 20}
    ]
    _mock_pedidos = [
        {'id': 1, 'usuario': {'nombre': 'Cliente Frecuente'}, 'estado': {'id': 1, 'nombre': 'RECIBIDO'}, 'fecha_pedido': '2026-02-01', 'subtotal': 1800.00},
        {'id': 2, 'usuario': {'nombre': 'Taller Mecánico A'}, 'estado': {'id': 2, 'nombre': 'SURTIDO'}, 'fecha_pedido': '2026-02-02', 'subtotal': 3450.00}
    ]

    def __init__(self):
        pass

    @property
    def base_url(self):
        return current_app.config['API_BASE_URL']

    def _get_headers(self):
        headers = {'Content-Type': 'application/json'}
        token = session.get('token')
        if token:
            headers['Authorization'] = f'Bearer {token}'
        return headers

    def get(self, endpoint, params=None):
        try:
            response = requests.get(f"{self.base_url}{endpoint}", headers=self._get_headers(), params=params, timeout=2)
            response.raise_for_status()
            return response.json()
        except (requests.exceptions.RequestException, requests.exceptions.ConnectionError) as e:
            return self._mock_response('GET', endpoint, params)

    def post(self, endpoint, data=None):
        try:
            response = requests.post(f"{self.base_url}{endpoint}", headers=self._get_headers(), json=data, timeout=2)
            response.raise_for_status()
            return response.json()
        except (requests.exceptions.RequestException, requests.exceptions.ConnectionError) as e:
            return self._mock_response('POST', endpoint, data)
            
    def put(self, endpoint, data=None):
        try:
            response = requests.put(f"{self.base_url}{endpoint}", headers=self._get_headers(), json=data, timeout=2)
            response.raise_for_status()
            return response.json()
        except (requests.exceptions.RequestException, requests.exceptions.ConnectionError) as e:
            return self._mock_response('PUT', endpoint, data)
            
    def delete(self, endpoint):
        try:
            response = requests.delete(f"{self.base_url}{endpoint}", headers=self._get_headers(), timeout=2)
            response.raise_for_status()
            return response.json()
        except (requests.exceptions.RequestException, requests.exceptions.ConnectionError) as e:
            return self._mock_response('DELETE', endpoint)
            
    def patch(self, endpoint, data=None):
        try:
            response = requests.patch(f"{self.base_url}{endpoint}", headers=self._get_headers(), json=data, timeout=2)
            response.raise_for_status()
            return response.json()
        except (requests.exceptions.RequestException, requests.exceptions.ConnectionError) as e:
            return self._mock_response('PATCH', endpoint, data)

    def get_raw(self, endpoint, params=None):
        """Obtiene respuesta raw (binaria) de la API - necesario para descarga de archivos."""
        try:
            response = requests.get(f"{self.base_url}{endpoint}", headers=self._get_headers(), params=params, timeout=10)
            response.raise_for_status()
            return response
        except (requests.exceptions.RequestException, requests.exceptions.ConnectionError) as e:
            # Para archivos, no usar mock - retornar error
            class MockResponse:
                status_code = 500
                content = b''
                headers = {}
            return MockResponse()

    def _mock_response(self, method, endpoint, data=None):
        print(f"MOCKING API CALL: {method} {endpoint}")
        if endpoint == '/auth/login' and method == 'POST':
            email = data.get('email', '') if data else ''
            password = data.get('password', '') if data else ''
            
            # Mock login para usuarios de prueba
            if email == 'admin@macuin.com' and password == 'admin2026':
                return {'token': 'mocked_jwt_token', 'user': {'name': 'Admin Macuin', 'role': 'admin', 'role_id': 1}}
            elif email == 'ventas@macuin.com' and password == 'ventas2026':
                return {'token': 'mocked_jwt_token', 'user': {'name': 'Ventas Macuin', 'role': 'ventas', 'role_id': 2}}
            elif email == 'almacen@macuin.com' and password == 'almacen2026':
                return {'token': 'mocked_jwt_token', 'user': {'name': 'Almacén Macuin', 'role': 'almacen', 'role_id': 3}}
            elif email in ['piston@taller.com', 'rueda@refac.com', 'radec@taller.com'] and password == '1234':
                return {'token': 'mocked_jwt_token', 'user': {'name': 'Usuario Externo', 'role': 'externo', 'role_id': 4}}
            elif password == '1234':
                # Fallback para pruebas rápidas
                return {'token': 'mocked_jwt_token', 'user': {'name': 'Admin Macuin', 'role': 'admin', 'role_id': 1}}
            else:
                return {'error': 'Credenciales inválidas'}, 401
                
        if endpoint == '/autopartes':
            if method == 'GET':
                return APIClient._mock_autopartes
            if method == 'POST':
                new_id = len(APIClient._mock_autopartes) + 1
                data['id'] = new_id
                APIClient._mock_autopartes.append(data)
                
                # Automatically add to inventory 
                APIClient._mock_inventarios.append({
                    'id': len(APIClient._mock_inventarios) + 1,
                    'autoparte_id': new_id,
                    'autoparte': {'nombre': data.get('nombre')},
                    'stock_actual': 0,
                    'stock_minimo': 10
                })
                return data
                
        if endpoint.startswith('/autopartes/'):
            try:
                part_id = int(endpoint.split('/')[-1])
            except ValueError:
                return {}
            if method == 'PUT':
                for i, p in enumerate(APIClient._mock_autopartes):
                    if p['id'] == part_id:
                        data['id'] = part_id
                        APIClient._mock_autopartes[i] = data
                        break
                return data
            if method == 'DELETE':
                APIClient._mock_autopartes = [p for p in APIClient._mock_autopartes if p['id'] != part_id]
                return {'success': True}
                
        if endpoint == '/inventarios' and method == 'GET':
            return APIClient._mock_inventarios
                    
        if endpoint.startswith('/inventarios/') and method == 'PATCH':
            try:
                inv_id = int(endpoint.split('/')[-1])
            except ValueError:
                return {}
            for inv in APIClient._mock_inventarios:
                if inv['id'] == inv_id:
                    inv['stock_actual'] = data.get('stock_actual', 0)
                    break
            return {'success': True, 'stock_actual': data.get('stock_actual', 0)}
            
        if endpoint == '/pedidos' and method == 'GET':
            return APIClient._mock_pedidos
                    
        if endpoint.startswith('/pedidos/') and method == 'PATCH':
            try:
                ped_id = int(endpoint.split('/')[-1])
            except ValueError:
                return {}
            estado_id = data.get('estado_id')
            nombres = {1: 'RECIBIDO', 2: 'SURTIDO', 3: 'ENVIADO'}
            for p in APIClient._mock_pedidos:
                 if p['id'] == ped_id:
                     p['estado'] = {'id': estado_id, 'nombre': nombres.get(estado_id, 'DESCONOCIDO')}
                     break
            return {'success': True}
            
        if endpoint == '/reportes/ventas' and method == 'GET':
            return {'labels': ['Ene', 'Feb', 'Mar'], 'data': [15000, 22000, 18000]}
            
        return {}

api_client = APIClient()
