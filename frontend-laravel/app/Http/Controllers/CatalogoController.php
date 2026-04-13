<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    private ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    private array $imagenes = [
        'Frenos'      => 'frenos.png',
        'Motor'       => 'motor.png',
        'Suspensión'  => 'suspension.png',
        'Eléctrico'   => 'electrico.png',
        'Transmisión' => 'transmision.png',
    ];

    public function index()
    {
        $categorias = $this->api->get('/autopartes/categorias');
        $partes     = $this->api->get('/autopartes');

        if (!is_array($categorias) || isset($categorias['error'])) $categorias = [];
        if (!is_array($partes)     || isset($partes['error']))     $partes     = [];

        $categorias = array_map(function ($cat) {
            return [
                'nombre' => $cat['nombre'],
                'imagen' => $this->imagenes[$cat['nombre']] ?? 'default.jpg'
            ];
        }, $categorias);

        $partes = array_values(array_filter($partes, fn($p) => $p['activo'] ?? true));

        $partes = array_map(function ($p) {
            $cat = $p['categoria']['nombre'] ?? '';
            // $p['imagen'] = $this->imagenes[$cat] ?? 'default.jpg';
            return $p;
        }, $partes);

        return view('catalogo.index', compact('categorias', 'partes'));
    }

    public function show(int $id)
    {
        $parte = $this->api->get("/autopartes/{$id}");
        if (!is_array($parte) || isset($parte['error'])) {
            return redirect('/catalogo')->with('error', 'Producto no encontrado.');
        }

        $cat = $parte['categoria']['nombre'] ?? '';
        // $parte['imagen'] = $this->imagenes[$cat] ?? 'default.jpg';

        return view('catalogo.show', compact('parte'));
    }

    public function busqueda(Request $request)
    {
        $query      = trim($request->get('q', ''));
        $categorias = $this->api->get('/autopartes/categorias');
        $partes     = $this->api->get('/autopartes');

        if (!is_array($categorias) || isset($categorias['error'])) $categorias = [];
        if (!is_array($partes)     || isset($partes['error']))     $partes     = [];

        $partes = array_values(array_filter($partes, fn($p) => $p['activo'] ?? true));

        if ($query !== '') {
            $partes = array_values(array_filter($partes, function ($p) use ($query) {
                return stripos($p['nombre']                  ?? '', $query) !== false
                    || stripos($p['descripcion']             ?? '', $query) !== false
                    || stripos($p['marca']                   ?? '', $query) !== false
                    || stripos($p['numero_parte']            ?? '', $query) !== false
                    || stripos($p['categoria']['nombre']     ?? '', $query) !== false; // 👈 esto faltaba
            }));
        }

        $partes = array_map(function ($p) {
            $cat = $p['categoria']['nombre'] ?? '';
            // $p['imagen'] = $this->imagenes[$cat] ?? 'default.png';
            return $p;
        }, $partes);

        return view('catalogo.busqueda', compact('partes', 'query', 'categorias'));
    }

}