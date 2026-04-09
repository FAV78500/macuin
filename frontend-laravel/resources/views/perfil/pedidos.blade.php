@extends('layouts.app')

@section('title', 'MACUIN - Mis Pedidos')

@section('content')

    <div class="flex flex-col lg:flex-row gap-8">
        
        <aside class="w-full lg:w-64 flex-shrink-0 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-gray-100 mb-4 shadow-sm">
                    <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=200&auto=format&fit=crop" alt="Perfil" class="w-full h-full object-cover">
                </div>
                <h2 class="font-bold text-gray-900 text-lg">Taller Mecánico Velocidad</h2>
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
            </nav>
        </aside>

        <section class="flex-1">
            <h1 class="text-2xl font-bold text-macuin-blue mb-6">Historial de Pedidos</h1>
            
            <div class="space-y-4">
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 transition hover:shadow-md">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 flex-1 w-full">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Pedido</p>
                            <p class="font-bold text-gray-900">#ORD-9921</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Fecha</p>
                            <p class="font-semibold text-gray-800">Jan 28, 2026</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total</p>
                            <p class="font-bold text-gray-900">$3,450 MXN</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                        <span class="bg-[#10B981] text-white px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide shadow-sm">
                            Entregado
                        </span>
                        <button class="bg-macuin-red hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md text-sm transition duration-200 shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Descargar Factura
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 transition hover:shadow-md">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 flex-1 w-full">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Pedido</p>
                            <p class="font-bold text-gray-900">#ORD-9925</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Fecha</p>
                            <p class="font-semibold text-gray-800">Jan 30, 2026</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total</p>
                            <p class="font-bold text-gray-900">$4,408 MXN</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                        <span class="bg-[#3B82F6] text-white px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide shadow-sm">
                            Enviado / En Camino
                        </span>
                        <a href="http://fedex.com/es-mx/tracking.html" target="_blank" class="bg-macuin-red hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md text-sm transition duration-200 shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Rastrear Paquete
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 transition hover:shadow-md">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 flex-1 w-full">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Pedido</p>
                            <p class="font-bold text-gray-900">#ORD-9928</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Fecha</p>
                            <p class="font-semibold text-gray-800">Jan 30, 2026</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total</p>
                            <p class="font-bold text-gray-900">$1,250 MXN</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end w-full md:w-auto mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100 min-w-[160px]">
                        <span class="bg-[#F59E0B] text-white px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide shadow-sm ml-auto">
                            Pendiente de Surtido
                        </span>
                    </div>
                </div>

            </div>
        </section>

    </div>

@endsection