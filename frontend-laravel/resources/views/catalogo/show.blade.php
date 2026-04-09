@extends('layouts.app')

@section('title', 'MACUIN - Detalle de Producto')

@section('content')

    <nav class="text-sm text-gray-500 mb-6">
        <ol class="flex space-x-2">
            <li><a href="/" class="hover:text-macuin-blue">Home</a></li>
            <li>&gt;</li>
            <li><a href="/catalogo" class="hover:text-macuin-blue">Frenos</a></li>
            <li>&gt;</li>
            <li><a href="#" class="hover:text-macuin-blue">Discos</a></li>
            <li>&gt;</li>
            <li class="text-gray-700">Disco Ventilado Delantero</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <div class="flex flex-col gap-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex items-center justify-center p-4 h-96">
                <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=800&auto=format&fit=crop" alt="Disco de Freno Principal" class="max-h-full object-contain">
            </div>
            <div class="flex gap-4">
                <div class="w-24 h-24 bg-white rounded-md border-2 border-macuin-red overflow-hidden cursor-pointer shadow-sm p-1">
                    <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=200&auto=format&fit=crop" alt="Thumb 1" class="w-full h-full object-cover">
                </div>
                <div class="w-24 h-24 bg-white rounded-md border border-gray-200 hover:border-macuin-blue overflow-hidden cursor-pointer shadow-sm p-1 transition">
                    <img src="https://images.unsplash.com/photo-1600706432502-789ce86862a4?q=80&w=200&auto=format&fit=crop" alt="Thumb 2" class="w-full h-full object-cover">
                </div>
                <div class="w-24 h-24 bg-white rounded-md border border-gray-200 hover:border-macuin-blue overflow-hidden cursor-pointer shadow-sm p-1 transition">
                    <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=200&auto=format&fit=crop" alt="Thumb 3" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Disco de Freno Ventilado - Delantero (OEM Quality)</h1>
            <p class="text-sm text-gray-500 mb-6">Part #: BRK-5592-X</p>
            
            <div class="text-4xl font-bold text-macuin-red mb-4">$1,250.00 MXN</div>
            
            <div class="mb-6">
                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-800 px-3 py-1.5 rounded-md text-sm font-semibold border border-green-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm3.707 9.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 1.414L11.414 9H16a1 1 0 110 2h-4.586l1.293 1.293z" clip-rule="evenodd"></path></svg>
                    Disponible en Almacén: 45 pzas
                </span>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg border border-gray-200 mb-6">
                <p class="text-sm text-gray-600 mb-2 font-semibold">Compatible con:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-macuin-red rounded-full"></span> Nissan Versa (2018-2023)</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-macuin-red rounded-full"></span> Nissan Kicks (2019-2022)</li>
                </ul>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-8 text-center text-macuin-blue border-y border-gray-200 py-4">
                <div class="flex flex-col items-center gap-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span class="text-xs font-semibold">Garantía 12 Meses</span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    <span class="text-xs font-semibold">Envío Gratis</span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <span class="text-xs font-semibold">OEM Quality</span>
                </div>
            </div>

            <div class="flex gap-4 mb-4">
                <div class="flex items-center border border-gray-300 rounded-md bg-white w-32">
                    <button class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition rounded-l-md">-</button>
                    <input type="text" value="1" class="w-full text-center focus:outline-none text-gray-800 font-semibold bg-transparent" readonly>
                    <button class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition rounded-r-md">+</button>
                </div>
                <button class="flex-1 bg-macuin-red hover:bg-red-700 text-white font-semibold py-3 rounded-md transition duration-200 flex items-center justify-center gap-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Agregar al Carrito
                </button>
            </div>

            <div class="text-sm text-gray-600 space-y-1">
                <p><strong>Tiempo de entrega:</strong> 2-5 días hábiles</p>
                <p><strong>Devoluciones:</strong> 30 días de garantía de satisfacción</p>
            </div>
        </div>
    </div>

    <div class="mt-16 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 px-6 pt-4 flex space-x-8">
            <button class="pb-3 border-b-2 border-macuin-red text-macuin-red font-semibold text-sm">Descripción Técnica</button>
            <button class="pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm transition">Especificaciones</button>
            <button class="pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm transition">Garantía</button>
        </div>
        
        <div class="p-6">
            <h3 class="text-xl font-bold text-macuin-blue mb-4">Descripción del Producto</h3>
            <p class="text-gray-700 mb-4 leading-relaxed">
                El Disco de Freno Ventilado Delantero BRK-5592-X es una pieza de alta calidad diseñada para proporcionar un rendimiento óptimo de frenado en condiciones exigentes. Fabricado con materiales de grado OEM, este disco garantiza durabilidad y seguridad excepcionales.
            </p>
            <p class="text-gray-700 mb-6 leading-relaxed">
                Su diseño ventilado permite una mejor disipación del calor, reduciendo el riesgo de sobrecalentamiento durante el uso intensivo. Ideal para reemplazos directos en vehículos Nissan Versa y Kicks.
            </p>
            
            <h4 class="font-semibold text-gray-800 mb-3">Características Principales:</h4>
            <ul class="space-y-2">
                <li class="flex items-start gap-2 text-gray-700">
                    <svg class="w-5 h-5 text-macuin-red mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Construcción ventilada para mejor disipación de calor
                </li>
                <li class="flex items-start gap-2 text-gray-700">
                    <svg class="w-5 h-5 text-macuin-red mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Material de alto carbono para mayor durabilidad
                </li>
                <li class="flex items-start gap-2 text-gray-700">
                    <svg class="w-5 h-5 text-macuin-red mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Acabado anticorrosivo de larga duración
                </li>
                <li class="flex items-start gap-2 text-gray-700">
                    <svg class="w-5 h-5 text-macuin-red mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Instalación directa sin modificaciones
                </li>
            </ul>
        </div>
    </div>

@endsection