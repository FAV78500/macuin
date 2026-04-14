@extends('layouts.app')

@section('title', 'MACUIN - Carrito de Compras')

@section('content')

    <h1 class="text-2xl font-bold text-macuin-blue mb-6">Tu Carrito ({{ count($carrito) }} artículo(s))</h1>

    @if(count($carrito) > 0)
    <div class="flex flex-col lg:flex-row gap-8">

        <div class="flex-1 space-y-4">
            @foreach($carrito as $item)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex flex-col sm:flex-row items-center sm:items-start gap-4 transition hover:shadow-md">
                <div class="w-24 h-24 bg-gray-50 rounded-md border border-gray-100 flex-shrink-0 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    </svg>
                </div>

                <div class="flex-1 flex flex-col justify-between h-full w-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">
                                <a href="/producto/{{ $item['autoparte_id'] }}" class="hover:text-macuin-blue transition">{{ $item['nombre'] }}</a>
                            </h3>
                            <div class="text-xl font-bold text-gray-900 mt-1">${{ number_format($item['precio'], 2) }} <span class="text-sm text-gray-500 font-normal">c/u</span></div>
                        </div>
                        <form action="/carrito/quitar" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="autoparte_id" value="{{ $item['autoparte_id'] }}">
                            <button type="submit" class="text-gray-400 hover:text-macuin-red transition p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Control de cantidad -->
                    <div class="flex items-center gap-4 mt-3">
                        <form action="/carrito/actualizar" method="POST" class="flex items-center gap-2">
                            @csrf
                            <input type="hidden" name="autoparte_id" value="{{ $item['autoparte_id'] }}">
                            <span class="text-sm font-semibold text-gray-700">Cantidad:</span>
                            <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                                <button type="submit" name="accion" value="restar"
                                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition text-lg leading-none">−</button>
                                <span class="px-4 py-1 text-sm font-bold text-gray-800 border-x border-gray-300">{{ $item['cantidad'] }}</span>
                                <button type="submit" name="accion" value="sumar"
                                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition text-lg leading-none">+</button>
                            </div>
                        </form>
                        <span class="text-sm text-gray-500">Subtotal: <strong>${{ number_format($item['precio'] * $item['cantidad'], 2) }}</strong></span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="w-full lg:w-96">
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden sticky top-6">
                <div class="h-1.5 w-full bg-macuin-blue"></div>

                <div class="p-6">
                    <h2 class="text-xl font-bold text-macuin-blue mb-6">Resumen del Pedido</h2>

                    <div class="space-y-3 text-sm text-gray-700 mb-4">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span class="font-semibold text-gray-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Envío:</span>
                            <span class="font-semibold text-gray-900">Por calcular</span>
                        </div>
                    </div>

                    <hr class="my-4 border-gray-200">

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg font-bold text-gray-900">Total aprox:</span>
                        <span class="text-2xl font-bold text-macuin-blue">${{ number_format($subtotal, 2) }} MXN</span>
                    </div>

                    <form action="/pedido/confirmar" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-macuin-red hover:bg-red-700 text-white font-bold py-3 px-4 rounded-md transition duration-200 shadow-md">
                            Confirmar Pedido
                        </button>
                    </form>

                    <p class="text-xs text-center text-gray-500 mt-4">
                        La orden se enviará a almacén para surtido tras la confirmación.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-20 text-gray-400">
        <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        <p class="text-xl mb-4">Tu carrito está vacío.</p>
        <a href="/catalogo" class="bg-macuin-red hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-md transition">
            Ver Catálogo
        </a>
    </div>
    @endif

@endsection