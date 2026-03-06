<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MACUIN - Clientes Externos</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background-color: #f4f4f9; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px; }
        .btn-flask { background-color: #28a745; }
    </style>
</head>
<body>
    <h1>Bienvenido a MACUIN - Portal de Clientes</h1>
    <p>Este es el frontend desarrollado en Laravel para clientes externos (Talleres, Refaccionarias).</p>
    
    <div>
        <a href="#" class="btn">Ver Catálogo de Autopartes</a>
        <a href="#" class="btn">Mi Carrito</a>
    </div>

    <hr style="margin-top: 40px;">
    
    <h3>¿Eres personal interno?</h3>
    <a href="http://localhost:5000" class="btn btn-flask">Ir al Portal Interno (Ventas/Almacén)</a>
</body>
</html>