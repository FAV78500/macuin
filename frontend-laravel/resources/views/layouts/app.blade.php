<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MACUIN')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        macuin: {
                            blue: '#16285A',
                            red: '#D9232B',
                            bg: '#F4F6F9',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-macuin-bg text-gray-800 font-sans antialiased min-h-screen flex flex-col">

    <nav class="bg-macuin-blue text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-8">
                    <a href="/catalogo" class="text-2xl font-bold tracking-wider">MACUIN</a>
                    <div class="hidden md:flex space-x-6 text-sm">
                        <a href="/catalogo" class="hover:text-gray-300 transition">Catálogo</a>
                    </div>
                </div>

                <div class="flex items-center space-x-5">

                    <form action="/buscar" method="GET" class="hidden sm:block relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar autopartes..."
                            class="w-64 pl-4 pr-10 py-1.5 rounded-full bg-blue-900 border border-transparent focus:bg-white focus:text-gray-900 focus:border-macuin-red focus:outline-none transition-all duration-300 text-sm placeholder-blue-300">
                        <button type="submit" class="absolute right-0 top-0 mt-1.5 mr-3 text-blue-300 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>

                    @if(session('token'))
                        <a href="/perfil" class="hover:text-gray-300 transition flex items-center gap-1 text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="hidden md:inline">{{ session('user_name') }}</span>
                        </a>

                        <a href="/carrito" class="relative hover:text-gray-300 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            @php $cart_count = count(session('carrito', [])); @endphp
                            @if($cart_count > 0)
                            <span class="absolute -top-2 -right-2 bg-macuin-red text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $cart_count }}</span>
                            @endif
                        </a>

                        <form action="/logout" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-300 hover:text-white transition">Salir</button>
                        </form>
                    @else
                        <a href="/login" class="text-sm hover:text-gray-300 transition">Iniciar sesión</a>
                        <a href="/register" class="text-sm bg-macuin-red hover:bg-red-700 px-3 py-1.5 rounded-md transition">Registrarse</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <div class="bg-red-100 border border-red-300 text-red-800 rounded-md px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        @yield('content')
    </main>

    <footer class="bg-macuin-blue text-white mt-12 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h2 class="text-2xl font-bold tracking-wider mb-4">MACUIN</h2>
                <p class="text-sm text-gray-300 mb-4">Tu distribuidor confiable de autopartes con calidad garantizada.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Enlaces Rápidos</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="/catalogo" class="hover:text-white transition">Catálogo</a></li>
                    <li><a href="/mis-pedidos" class="hover:text-white transition">Mis Pedidos</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Contáctanos</h3>
                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        ventas@macuin.com
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 pt-8 border-t border-gray-700 text-sm text-center text-gray-400">
            &copy; 2026 MACUIN. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>
