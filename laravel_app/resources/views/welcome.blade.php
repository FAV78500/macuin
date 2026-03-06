@extends('layouts.app')

@section('title', 'MACUIN - Refacciones y Autopartes')

@section('content')

    <section class="relative bg-macuin-blue rounded-2xl overflow-hidden shadow-lg mb-12">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=1200&auto=format&fit=crop" alt="Taller Mecánico" class="w-full h-full object-cover opacity-30">
        </div>
        <div class="relative px-8 py-16 md:py-24 max-w-3xl">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">
                Las mejores refacciones <br> <span class="text-macuin-red">para tu taller</span>
            </h1>
            <p class="text-gray-200 text-lg mb-8 max-w-xl">
                Encuentra balatas, filtros, bujías y más con calidad garantizada. Precios exclusivos para clientes B2B y envío rápido a todo México.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#productos" class="bg-macuin-red hover:bg-red-700 text-white font-bold py-3 px-8 rounded-md transition text-center shadow-md">
                    Ver Catálogo
                </a>
                <a href="#" class="bg-white hover:bg-gray-100 text-macuin-blue font-bold py-3 px-8 rounded-md transition text-center shadow-md">
                    Cotizar por WhatsApp
                </a>
            </div>
        </div>
    </section>

    <section class="mb-12">
        <h2 class="text-2xl font-bold text-macuin-blue mb-6">Categorías Populares</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            
            <a href="#" class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md hover:border-macuin-blue transition group flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-blue-50 text-macuin-blue rounded-full flex items-center justify-center mb-4 group-hover:bg-macuin-blue group-hover:text-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-semibold text-gray-900">Motor</h3>
            </a>

            <a href="#" class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md hover:border-macuin-blue transition group flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-blue-50 text-macuin-blue rounded-full flex items-center justify-center mb-4 group-hover:bg-macuin-blue group-hover:text-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="font-semibold text-gray-900">Eléctrico</h3>
            </a>

            <a href="#" class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md hover:border-macuin-blue transition group flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-blue-50 text-macuin-blue rounded-full flex items-center justify-center mb-4 group-hover:bg-macuin-blue group-hover:text-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-semibold text-gray-900">Frenos</h3>
            </a>

            <a href="#" class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md hover:border-macuin-blue transition group flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-blue-50 text-macuin-blue rounded-full flex items-center justify-center mb-4 group-hover:bg-macuin-blue group-hover:text-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                </div>
                <h3 class="font-semibold text-gray-900">Suspensión</h3>
            </a>

        </div>
    </section>

    <section id="productos" class="mb-12">
        <div class="flex justify-between items-end mb-6">
            <h2 class="text-2xl font-bold text-macuin-blue">Productos Destacados</h2>
            <a href="/catalogo" class="text-macuin-red hover:text-red-800 font-semibold text-sm transition flex items-center gap-1">
                Ver todos <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col relative">
                <span class="absolute top-2 left-2 bg-macuin-red text-white text-[10px] font-bold px-2 py-1 rounded">OFERTA</span>
                <a href="/producto" class="h-48 bg-gray-50 p-4 flex items-center justify-center border-b border-gray-100 group block">
                    <img src="https://images.unsplash.com/photo-1542282088-fe8426682b8f?q=80&w=200&auto=format&fit=crop" alt="Producto" class="max-h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-300">
                </a>
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-xs text-gray-500 mb-1">SKU: BLT-4592</p>
                    <h3 class="font-semibold text-gray-900 mb-2 leading-tight">
                        <a href="/producto" class="hover:text-macuin-blue transition">Juego de Balatas Delanteras de Cerámica</a>
                    </h3>
                    <div class="mt-auto">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xl font-bold text-macuin-blue">$450.00</span>
                            <span class="text-sm text-gray-400 line-through">$580.00</span>
                        </div>
                        <a href="/carrito" class="w-full bg-macuin-blue hover:bg-blue-900 text-white font-medium py-2 px-4 rounded transition flex items-center justify-center gap-2 text-sm text-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Agregar
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                <a href="/producto" class="h-48 bg-gray-50 p-4 flex items-center justify-center border-b border-gray-100 group block">
                    <img src="https://images.unsplash.com/photo-1621252179027-94459d278660?q=80&w=200&auto=format&fit=crop" alt="Producto" class="max-h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-300">
                </a>
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-xs text-gray-500 mb-1">SKU: FLT-102</p>
                    <h3 class="font-semibold text-gray-900 mb-2 leading-tight">
                        <a href="/producto" class="hover:text-macuin-blue transition">Filtro de Aceite Sintético Alto Rendimiento</a>
                    </h3>
                    <div class="mt-auto">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xl font-bold text-macuin-blue">$125.00</span>
                        </div>
                        <a href="/carrito" class="w-full border border-macuin-blue text-macuin-blue hover:bg-blue-50 font-medium py-2 px-4 rounded transition flex items-center justify-center gap-2 text-sm text-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Agregar
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                <a href="/producto" class="h-48 bg-gray-50 p-4 flex items-center justify-center border-b border-gray-100 group block text-gray-300">
                    <svg class="w-16 h-16 group-hover:scale-105 transition-transform duration-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                </a>
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-xs text-gray-500 mb-1">SKU: AMT-883</p>
                    <h3 class="font-semibold text-gray-900 mb-2 leading-tight">
                        <a href="/producto" class="hover:text-macuin-blue transition">Amortiguador de Gas Trasero (Izquierdo/Derecho)</a>
                    </h3>
                    <div class="mt-auto">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xl font-bold text-macuin-blue">$1,150.00</span>
                        </div>
                        <a href="/carrito" class="w-full border border-macuin-blue text-macuin-blue hover:bg-blue-50 font-medium py-2 px-4 rounded transition flex items-center justify-center gap-2 text-sm text-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Agregar
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                <a href="/producto" class="h-48 bg-gray-50 p-4 flex items-center justify-center border-b border-gray-100 group block text-gray-300">
                    <svg class="w-16 h-16 group-hover:scale-105 transition-transform duration-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </a>
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-xs text-gray-500 mb-1">SKU: BUJ-200</p>
                    <h3 class="font-semibold text-gray-900 mb-2 leading-tight">
                        <a href="/producto" class="hover:text-macuin-blue transition">Bujía de Iridio Larga Duración (Paquete 4)</a>
                    </h3>
                    <div class="mt-auto">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xl font-bold text-macuin-blue">$620.00</span>
                        </div>
                        <a href="/carrito" class="w-full border border-macuin-blue text-macuin-blue hover:bg-blue-50 font-medium py-2 px-4 rounded transition flex items-center justify-center gap-2 text-sm text-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Agregar
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection