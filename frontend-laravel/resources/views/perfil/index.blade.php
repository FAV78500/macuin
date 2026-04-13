@extends('layouts.app')

@section('title', 'MACUIN - Mi Perfil')

@section('content')

    <div class="flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-64 flex-shrink-0 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full bg-macuin-blue flex items-center justify-center mb-4 text-white text-3xl font-bold ring-4 ring-blue-100 shadow-md">
                    {{ strtoupper(substr($usuario['nombre'] ?? session('user_name', 'U'), 0, 1)) }}
                </div>
                <h2 class="font-bold text-gray-900 text-lg">{{ $usuario['nombre'] ?? session('user_name') }}</h2>
                <p class="text-sm text-gray-500">{{ $usuario['email'] ?? '' }}</p>
                @if(isset($usuario['rol']))
                <span class="mt-2 inline-block bg-macuin-blue text-white text-xs font-semibold px-3 py-1 rounded-full">
                    {{ ucfirst(strtolower($usuario['rol'])) }}
                </span>
                @endif
            </div>

            <nav class="bg-white rounded-lg shadow-sm border border-gray-200 p-2 space-y-1">
                <a href="/perfil" class="flex items-center gap-3 px-4 py-3 bg-macuin-blue text-white rounded-md transition font-medium shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Mi Perfil
                </a>
                <a href="/mis-pedidos" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-md transition font-medium">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Mis Pedidos
                </a>
                <div class="pt-4 mt-2 border-t border-gray-100"></div>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 text-macuin-red hover:bg-red-50 rounded-md transition font-medium w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Cerrar Sesión
                    </button>
                </form>
            </nav>
        </aside>

        <section class="flex-1">
            <h1 class="text-2xl font-bold text-macuin-blue mb-6">Configuración de la Cuenta</h1>

            <div class="space-y-6">

                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-md px-4 py-3 flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-md px-4 py-3 flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    {{ session('error') }}
                </div>
                @endif

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-md px-4 py-3 space-y-1">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-1">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
                @endif

                {{-- Información personal --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b border-gray-100">Información Personal</h3>
                    <form action="/perfil/actualizar" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del taller</label>
                                <input type="text" name="nombre" value="{{ old('nombre', $usuario['nombre'] ?? '') }}"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:ring-2 focus:ring-macuin-blue focus:border-macuin-blue outline-none transition" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                                <input type="email" value="{{ $usuario['email'] ?? '' }}"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 bg-gray-50 outline-none cursor-not-allowed" readonly>
                                <p class="text-xs text-gray-400 mt-1">El correo no se puede cambiar.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                <input type="tel" name="telefono" value="{{ old('telefono', $usuario['telefono'] ?? '') }}"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:ring-2 focus:ring-macuin-blue focus:border-macuin-blue outline-none transition"
                                    placeholder="10 dígitos" maxlength="10">
                            </div>
                        </div>
                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-macuin-blue hover:bg-blue-900 text-white font-semibold py-2 px-6 rounded-md transition shadow-sm">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Cambio de contraseña --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1 pb-4 border-b border-gray-100">Seguridad</h3>
                    <p class="text-sm text-gray-500 mb-4 mt-3">La contraseña debe tener al menos 8 caracteres.</p>

                    <form action="/perfil/cambiar-password" method="POST" class="space-y-4 max-w-lg" id="form-password">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                            <input type="password" name="new_password" id="new_password" placeholder="Mínimo 8 caracteres"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-macuin-blue outline-none transition"
                                minlength="8">
                            {{-- Indicador de fortaleza --}}
                            <div class="mt-2 h-1.5 rounded-full bg-gray-200 overflow-hidden">
                                <div id="strength-bar" class="h-full rounded-full transition-all duration-300 w-0"></div>
                            </div>
                            <p id="strength-text" class="text-xs text-gray-400 mt-1"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nueva Contraseña</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Repite la contraseña"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-macuin-blue outline-none transition">
                            <p id="match-text" class="text-xs mt-1 hidden"></p>
                        </div>
                        <div class="pt-4">
                            <button type="submit" id="btn-password"
                                class="bg-macuin-blue hover:bg-blue-900 text-white font-semibold py-2 px-6 rounded-md transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>

    {{-- Validación JS de contraseña --}}
    <script>
        const pwdInput  = document.getElementById('new_password');
        const confInput = document.getElementById('new_password_confirmation');
        const bar       = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');
        const matchText = document.getElementById('match-text');
        const btn       = document.getElementById('btn-password');

        function checkStrength(pwd) {
            let score = 0;
            if (pwd.length >= 8)  score++;
            if (pwd.length >= 12) score++;
            if (/[A-Z]/.test(pwd)) score++;
            if (/[0-9]/.test(pwd)) score++;
            if (/[^A-Za-z0-9]/.test(pwd)) score++;
            return score;
        }

        pwdInput.addEventListener('input', () => {
            const pwd   = pwdInput.value;
            const score = checkStrength(pwd);
            const widths  = ['0%', '25%', '50%', '75%', '90%', '100%'];
            const colors  = ['', 'bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-blue-400', 'bg-green-500'];
            const labels  = ['', 'Muy débil', 'Débil', 'Regular', 'Buena', 'Fuerte'];

            bar.style.width = widths[score];
            bar.className   = `h-full rounded-full transition-all duration-300 ${colors[score]}`;
            strengthText.textContent = pwd.length > 0 ? labels[score] : '';
            strengthText.className   = `text-xs mt-1 ${score <= 2 ? 'text-red-500' : score <= 3 ? 'text-yellow-500' : 'text-green-600'}`;

            checkMatch();
        });

        confInput.addEventListener('input', checkMatch);

        function checkMatch() {
            const pwd  = pwdInput.value;
            const conf = confInput.value;

            if (conf.length === 0) {
                matchText.classList.add('hidden');
                return;
            }

            matchText.classList.remove('hidden');
            if (pwd === conf) {
                matchText.textContent = '✓ Las contraseñas coinciden';
                matchText.className   = 'text-xs mt-1 text-green-600';
                btn.disabled = false;
            } else {
                matchText.textContent = '✗ Las contraseñas no coinciden';
                matchText.className   = 'text-xs mt-1 text-red-500';
                btn.disabled = true;
            }
        }

        document.getElementById('form-password').addEventListener('submit', function(e) {
            const pwd  = pwdInput.value;
            const conf = confInput.value;

            if (pwd.length < 8) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 8 caracteres.');
                return;
            }
            if (pwd !== conf) {
                e.preventDefault();
                alert('Las contraseñas no coinciden.');
            }
        });
    </script>

@endsection