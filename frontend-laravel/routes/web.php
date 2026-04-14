<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PerfilController;

// ── Públicas ─────────────────────────────────────────────────────────────────

Route::get('/', fn() => redirect('/catalogo'));

Route::get('/login',    [AuthController::class, 'loginForm']);
Route::post('/login',   [AuthController::class, 'login']);
Route::post('/logout',  [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register',[AuthController::class, 'register']);

Route::get('/catalogo',          [CatalogoController::class, 'index']);
Route::get('/catalogo/{id}',     [CatalogoController::class, 'show'])->where('id', '[0-9]+');
Route::get('/producto/{id}',     [CatalogoController::class, 'show'])->where('id', '[0-9]+');
Route::get('/buscar',            [CatalogoController::class, 'busqueda']);

// ── Requieren sesión ──────────────────────────────────────────────────────────

Route::middleware('auth.api')->group(function () {
    Route::get('/carrito',              [CarritoController::class, 'index']);
    Route::post('/carrito/agregar',     [CarritoController::class, 'agregar']);
    Route::post('/carrito/quitar',      [CarritoController::class, 'quitar']);
    Route::post('/pedido/confirmar',    [CarritoController::class, 'confirmar']);
    Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar']);

    Route::get('/perfil',                        [PerfilController::class, 'index']);
    Route::get('/mis-pedidos',                   [PerfilController::class, 'pedidos']);
    Route::get('/mis-pedidos/{id}/factura',      [PerfilController::class, 'factura'])->where('id', '[0-9]+');
    Route::post('/mis-pedidos/{id}/cancelar',    [PerfilController::class, 'cancelar'])->where('id', '[0-9]+');
    Route::post('/perfil/actualizar',         [PerfilController::class, 'actualizar']);
    Route::post('/perfil/cambiar-password',   [PerfilController::class, 'cambiarPassword']);
   
});
