<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function loginForm()
    {
        if (session('token')) {
            return redirect('/catalogo');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Ingresa un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $result = $this->api->post('/auth/login', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if (isset($result['detail']) || isset($result['error'])) {
            return back()
                ->withErrors(['email' => 'Credenciales inválidas.'])
                ->withInput($request->only('email'));
        }

        session([
            'token'     => $result['token'],
            'user_name' => $result['user']['name'],
            'user_role' => $result['user']['role'],
        ]);

        return redirect('/catalogo');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }

    public function registerForm()
    {
        if (session('token')) {
            return redirect('/catalogo');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|email',
            'telefono' => 'nullable|digits:10',
            'password' => 'required|min:6|confirmed',
        ], [
            'nombre.required'           => 'El nombre del taller es obligatorio.',
            'nombre.max'                => 'El nombre no puede tener más de 100 caracteres.',
            'email.required'            => 'El correo es obligatorio.',
            'email.email'               => 'Ingresa un correo válido.',
            'telefono.digits'           => 'El teléfono debe tener exactamente 10 dígitos.',
            'password.required'         => 'La contraseña es obligatoria.',
            'password.min'              => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed'        => 'Las contraseñas no coinciden.',
        ]);

        $result = $this->api->post('/auth/registro', [
            'nombre'   => $request->nombre,
            'email'    => $request->email,
            'password' => $request->password,
            'telefono' => $request->telefono,
        ]);

        if (isset($result['detail']) || isset($result['error'])) {
            $msg = $result['detail'] ?? ($result['error'] ?? 'Error al registrarse.');
            return back()->withErrors(['email' => $msg])->withInput($request->only('nombre', 'email', 'telefono'));
        }

        // Auto-login after register
        $login = $this->api->post('/auth/login', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if (isset($login['token'])) {
            session([
                'token'     => $login['token'],
                'user_name' => $login['user']['name'],
                'user_role' => $login['user']['role'],
            ]);
        }

        return redirect('/catalogo');
    }
}
