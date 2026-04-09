@extends('layouts.app')

@section('title', 'MACUIN - Catálogo de Refacciones')

@section('content')

    <div class="bg-macuin-blue rounded-xl p-8 mb-8 text-center text-white shadow-md">
        <h1 class="text-3xl font-bold mb-2">Catálogo Completo de Refacciones</h1>
        <p class="text-gray-300">Explora más de 10,000 productos de la mejor calidad para tu taller.</p>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-6">Explorar por Categorías</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-12">
        @php
            $categorias = [
                ['nombre' => 'Motor', 'icono' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                ['nombre' => 'Frenos', 'icono' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['nombre' => 'Suspensión', 'icono' => 'M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4'],
                ['nombre' => 'Eléctrico', 'icono' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                ['nombre' => 'Transmisión', 'icono' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                ['nombre' => 'Accesorios', 'icono' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4']
            ];
        @endphp

        @foreach($categorias as $cat)
        <a href="/buscar" class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:border-macuin-red hover:shadow-md transition text-center group">
            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-red-50 transition">
                <svg class="w-6 h-6 text-macuin-blue group-hover:text-macuin-red transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat['icono'] }}"></path>
                </svg>
            </div>
            <h3 class="font-medium text-gray-700 group-hover:text-macuin-red transition">{{ $cat['nombre'] }}</h3>
        </a>
        @endforeach
    </div>

    <div class="flex justify-between items-end mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Marcas Destacadas</h2>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 grid grid-cols-2 md:grid-cols-4 gap-8 items-center text-center">
        <div class="text-xl font-bold text-gray-400 grayscale hover:grayscale-0 transition cursor-pointer">BOSCH</div>
        <div class="text-xl font-bold text-gray-400 grayscale hover:grayscale-0 transition cursor-pointer">GATES</div>
        <div class="text-xl font-bold text-gray-400 grayscale hover:grayscale-0 transition cursor-pointer">NGK</div>
        <div class="text-xl font-bold text-gray-400 grayscale hover:grayscale-0 transition cursor-pointer">CASTROL</div>
    </div>

@endsection