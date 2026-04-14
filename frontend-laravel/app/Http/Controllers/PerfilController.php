<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    private ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $usuario = $this->api->get('/auth/me');
        if (isset($usuario['error'])) {
            $usuario = [];
        }
        return view('perfil.index', compact('usuario'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'nullable|digits:10',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede tener más de 100 caracteres.',
            'telefono.digits' => 'El teléfono debe tener exactamente 10 dígitos numéricos.',
        ]);

        $this->api->put('/auth/me', [
            'nombre'   => $request->nombre,
            'telefono' => $request->telefono,
        ]);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'new_password'     => 'required|min:6|confirmed',
        ], [
            'new_password.required'  => 'La nueva contraseña es obligatoria.',
            'new_password.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'new_password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $this->api->put('/auth/me', [
            'password' => $request->new_password,
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    public function pedidos()
    {
        $pedidos = $this->api->get('/pedidos');
        if (!is_array($pedidos) || isset($pedidos['error'])) {
            $pedidos = [];
        }
        return view('perfil.pedidos', compact('pedidos'));
    }

    public function cancelar($id)
    {
        $result = $this->api->delete("/pedidos/{$id}");
        if (isset($result['error']) || isset($result['detail'])) {
            $msg = $result['detail'] ?? ($result['error'] ?? 'No se pudo cancelar el pedido.');
            return redirect('/mis-pedidos')->with('error', $msg);
        }
        return redirect('/mis-pedidos')->with('success', 'Pedido cancelado correctamente.');
    }

    public function factura($id)
    {
        $result = $this->api->getBytes("/pedidos/{$id}/factura");
        if ($result['status'] !== 200) {
            return back()->with('error', 'No se pudo generar la factura.');
        }
        return response($result['body'], 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=factura-{$id}.pdf",
        ]);
    }
}