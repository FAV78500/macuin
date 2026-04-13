@extends('layouts.app')

@section('title', 'MACUIN - ' . ($parte['nombre'] ?? 'Detalle de Producto'))

@section('content')

    <nav class="text-sm text-gray-500 mb-6">
        <ol class="flex space-x-2">
            <li><a href="/catalogo" class="hover:text-macuin-blue">Catálogo</a></li>
            <li>&gt;</li>
            <li><a href="/buscar?q={{ urlencode($parte['categoria']['nombre'] ?? '') }}" class="hover:text-macuin-blue">{{ $parte['categoria']['nombre'] ?? 'Categoría' }}</a></li>
            <li>&gt;</li>
            <li class="text-gray-700">{{ $parte['nombre'] }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        <div class="flex items-center justify-center bg-white rounded-lg shadow-sm border border-gray-200 h-80 overflow-hidden">
            @if(isset($parte['imagen']) && $parte['imagen'])
                <img src="{{ $parte['imagen'] }}" alt="{{ $parte['nombre'] }}" class="w-full h-full object-cover">
            @else
                <svg class="w-32 h-32 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                </svg>
            @endif
        </div>

        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $parte['nombre'] }}</h1>
            @if($parte['numero_parte'])
            <p class="text-sm text-gray-500 mb-2">Part #: {{ $parte['numero_parte'] }}</p>
            @endif
            @if($parte['marca'])
            <p class="text-sm text-gray-500 mb-4">Marca: <span class="font-semibold text-gray-700">{{ $parte['marca'] }}</span></p>
            @endif

            <div class="text-4xl font-bold text-macuin-red mb-6">${{ number_format($parte['precio'], 2) }} MXN</div>

            <div class="mb-6">
                <span class="inline-flex items-center gap-1.5 bg-blue-50 text-macuin-blue px-3 py-1.5 rounded-md text-sm font-semibold border border-blue-100">
                    {{ $parte['categoria']['nombre'] ?? 'Sin categoría' }}
                </span>
                @if($parte['activo'])
                <span class="ml-2 inline-flex items-center gap-1.5 bg-green-100 text-green-800 px-3 py-1.5 rounded-md text-sm font-semibold border border-green-200">
                    Disponible
                </span>
                @else
                <span class="ml-2 inline-flex items-center bg-gray-100 text-gray-600 px-3 py-1.5 rounded-md text-sm font-semibold">
                    Sin disponibilidad
                </span>
                @endif
            </div>

            @if($parte['descripcion'])
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                <p class="text-sm text-gray-600 leading-relaxed">{{ $parte['descripcion'] }}</p>
            </div>
            @endif

            @if($parte['activo'])
            <form action="/carrito/agregar" method="POST" class="flex gap-4 mb-4">
                @csrf
                <input type="hidden" name="autoparte_id" value="{{ $parte['id'] }}">
                <div class="flex items-center border border-gray-300 rounded-md bg-white w-32">
                    <button type="button" onclick="decrement()" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition rounded-l-md">-</button>
                    <input type="number" name="cantidad" id="qty" value="1" min="1" class="w-full text-center focus:outline-none text-gray-800 font-semibold bg-transparent">
                    <button type="button" onclick="increment()" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition rounded-r-md">+</button>
                </div>
                @if(session('token'))
                <button type="submit"
                    class="flex-1 bg-macuin-red hover:bg-red-700 text-white font-semibold py-3 rounded-md transition duration-200 flex items-center justify-center gap-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Agregar al Carrito
                </button>
                @else
                <a href="/login"
                    class="flex-1 text-center bg-macuin-blue hover:bg-blue-900 text-white font-semibold py-3 rounded-md transition duration-200 shadow-md">
                    Iniciar sesión para comprar
                </a>
                @endif
            </form>
            @endif
        </div>
    </div>

    <script>
        function decrement() {
            const q = document.getElementById('qty');
            if (parseInt(q.value) > 1) q.value = parseInt(q.value) - 1;
        }
        function increment() {
            const q = document.getElementById('qty');
            q.value = parseInt(q.value) + 1;
        }
    </script>

@endsection
