<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;

class PerfilController extends Controller
{
    private ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function pedidos()
    {
        // GET /pedidos con token de externo → devuelve solo los pedidos del usuario
        $pedidos = $this->api->get('/pedidos');
        if (!is_array($pedidos) || isset($pedidos['error'])) {
            $pedidos = [];
        }
        return view('perfil.pedidos', compact('pedidos'));
    }
}
