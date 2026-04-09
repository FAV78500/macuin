<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    private ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $carrito  = session('carrito', []);
        $subtotal = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], $carrito));
        return view('carrito.index', compact('carrito', 'subtotal'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'autoparte_id' => 'required|integer',
            'cantidad'     => 'sometimes|integer|min:1',
        ]);

        $autoparte_id = (int) $request->autoparte_id;
        $cantidad     = max(1, (int) $request->get('cantidad', 1));

        $parte = $this->api->get("/autopartes/{$autoparte_id}");
        if (!is_array($parte) || isset($parte['error'])) {
            return back()->with('error', 'Producto no disponible.');
        }

        $carrito = session('carrito', []);

        $encontrado = false;
        foreach ($carrito as &$item) {
            if ($item['autoparte_id'] === $autoparte_id) {
                $item['cantidad'] += $cantidad;
                $encontrado = true;
                break;
            }
        }
        unset($item);

        if (!$encontrado) {
            $carrito[] = [
                'autoparte_id' => $autoparte_id,
                'nombre'       => $parte['nombre'],
                'precio'       => (float) $parte['precio'],
                'cantidad'     => $cantidad,
            ];
        }

        session(['carrito' => $carrito]);
        return redirect('/carrito');
    }

    public function quitar(Request $request)
    {
        $autoparte_id = (int) $request->autoparte_id;
        $carrito = session('carrito', []);
        $carrito = array_values(array_filter($carrito, fn($i) => $i['autoparte_id'] !== $autoparte_id));
        session(['carrito' => $carrito]);
        return redirect('/carrito');
    }

    public function confirmar()
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect('/carrito')->with('error', 'El carrito está vacío.');
        }

        $detalles = array_map(fn($i) => [
            'autoparte_id' => $i['autoparte_id'],
            'cantidad'     => $i['cantidad'],
        ], $carrito);

        $result = $this->api->post('/pedidos', ['detalles' => $detalles]);

        if (isset($result['detail']) || isset($result['error'])) {
            $msg = $result['detail'] ?? ($result['error'] ?? 'Error al crear el pedido.');
            return redirect('/carrito')->with('error', $msg);
        }

        session()->forget('carrito');
        return view('pedido.confirmacion', ['pedido' => $result]);
    }
}
