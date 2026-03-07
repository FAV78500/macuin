<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome'); 
});


Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    return redirect('/');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/catalogo', function () {
    return view('catalogo.index');
});

Route::get('/producto', function () {
    return view('catalogo.show');
});

Route::get('/buscar', function (Request $request) {
    return view('catalogo.busqueda');
});

Route::get('/carrito', function () {
    return view('carrito.index');
});

Route::get('/pedido/confirmacion', function () {
    return view('pedido.confirmacion');
});

Route::get('/perfil', function () {
    return view('perfil.index');
});

Route::get('/mis-pedidos', function () {
    return view('perfil.pedidos');
});