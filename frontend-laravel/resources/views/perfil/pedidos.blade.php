@extends('layouts.app')

@section('title', 'MACUIN - Mis Pedidos')

@section('content')

    <div class="flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-64 flex-shrink-0 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full bg-macuin-blue flex items-center justify-center mb-4 text-white text-2xl font-bold">
                    {{ strtoupper(substr(session('user_name', 'U'), 0, 1)) }}
                </div>
                <h2 class="font-bold text-gray-900 text-lg">{{ session('user_name') }}</h2>
            </div>

            <nav class="bg-white rounded-lg shadow-sm border border-gray-200 p-2 space-y-1">
                <a href="/perfil" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-md transition font-medium">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Mi Perfil
                </a>
                <a href="/mis-pedidos" class="flex items-center gap-3 px-4 py-3 bg-macuin-blue text-white rounded-md transition font-medium shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
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
            <h1 class="text-2xl font-bold text-macuin-blue mb-6">Historial de Pedidos</h1>

            @if(count($pedidos) > 0)
            <div class="space-y-4">
                @foreach($pedidos as $pedido)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 transition hover:shadow-md">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 flex-1 w-full">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Pedido</p>
                            <p class="font-bold text-gray-900">#ORD-{{ str_pad($pedido['id'], 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Fecha</p>
                            <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($pedido['fecha_pedido'])->format('d M, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total</p>
                            <p class="font-bold text-gray-900">${{ number_format($pedido['total'], 2) }} MXN</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                        @php $estado = $pedido['estado']; @endphp
                        @if($estado === 'RECIBIDO')
                        <span class="bg-yellow-100 text-yellow-800 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide">Pendiente de Surtido</span>
                        @elseif($estado === 'SURTIDO')
                        <span class="bg-orange-100 text-orange-800 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide">Surtido</span>
                        @elseif($estado === 'ENVIADO')
                        <span class="bg-blue-100 text-blue-800 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide">Enviado / En Camino</span>
                        @elseif($estado === 'CANCELADO')
                        <span class="bg-gray-100 text-gray-600 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide">Cancelado</span>
                        @else
                        <span class="bg-gray-100 text-gray-600 px-4 py-1.5 rounded-full text-xs font-semibold">{{ $estado }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <p class="text-lg">Aún no tienes pedidos.</p>
                <a href="/catalogo" class="mt-4 inline-block bg-macuin-red hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-md transition">
                    Hacer mi primer pedido
                </a>
            </div>
            @endif
        </section>
    </div>

@endsection
