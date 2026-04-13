@extends('layouts.app')

@section('title', 'MACUIN - Catálogo de Refacciones')

@section('content')

    <div class="relative overflow-hidden mb-8 shadow-md -mx-4 sm:-mx-6 lg:-mx-8" style="height: 300px;">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('images/hero.png') }}')">
        </div>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative h-full flex flex-col items-center justify-center text-center text-white px-4">
            <h1 class="text-3xl font-bold mb-2">Catálogo Completo de Refacciones</h1>
            <p class="text-gray-200">Calidad garantizada para tu taller.</p>
        </div>
    </div>

    @if(count($categorias) > 0)
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Explorar por Categorías</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-12">
        @foreach($categorias as $cat)
        <a href="/buscar?q={{ urlencode($cat['nombre']) }}"
            class="relative rounded-lg overflow-hidden shadow-sm hover:shadow-md transition group h-32 flex items-center justify-center text-center">
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('{{ asset('images/categorias/' . ($cat['imagen'] ?? 'default.jpg')) }}')">
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-50 transition"></div>
            <div class="relative z-10 px-2">
                <h3 class="font-semibold text-white text-sm group-hover:scale-105 transition">
                    {{ $cat['nombre'] }}
                </h3>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    <div class="flex justify-between items-end mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Todos los Productos</h2>
        <span class="text-sm text-gray-500">{{ count($partes) }} productos</span>
    </div>

    @if(count($partes) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($partes as $parte)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition group
            {{ ($parte['stock'] ?? 0) == 0 ? 'opacity-75' : '' }}">

            {{-- Imagen --}}
            <a href="/producto/{{ $parte['id'] }}" class="block overflow-hidden bg-gray-50 flex items-center justify-center h-40">
                <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                </svg>
            </a>

            {{-- Contenido --}}
            <div class="p-4 flex flex-col flex-grow">
                <p class="text-xs text-gray-400 mb-1">
                    {{ $parte['categoria']['nombre'] ?? '' }}
                    @if($parte['marca']) · {{ $parte['marca'] }} @endif
                </p>
                <h3 class="font-semibold text-gray-800 mb-1 leading-tight">
                    <a href="/producto/{{ $parte['id'] }}" class="hover:text-macuin-blue transition">
                        {{ $parte['nombre'] }}
                    </a>
                </h3>
                @if($parte['numero_parte'])
                <p class="text-xs text-gray-500 mb-3">Part #: {{ $parte['numero_parte'] }}</p>
                @endif
                <div class="text-2xl font-bold text-macuin-red mb-4">
                    ${{ number_format($parte['precio'], 2) }}
                </div>

                {{-- Botón --}}
                <div class="mt-auto">
                    @if(($parte['stock'] ?? 0) == 0)
                        <button disabled
                            class="w-full bg-gray-300 text-gray-500 font-semibold py-2 rounded-md cursor-not-allowed flex items-center justify-center gap-2">
                            Sin stock
                        </button>
                    @else
                        <form action="/carrito/agregar" method="POST">
                            @csrf
                            <input type="hidden" name="autoparte_id" value="{{ $parte['id'] }}">
                            <input type="hidden" name="cantidad" value="1">
                            @if(session('token'))
                            <button type="submit"
                                class="w-full bg-macuin-red hover:bg-red-700 text-white font-semibold py-2 rounded-md transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Agregar
                            </button>
                            @else
                            <a href="/login"
                                class="w-full block text-center bg-macuin-blue hover:bg-blue-900 text-white font-semibold py-2 rounded-md transition duration-200">
                                Agregar al carrito
                            </a>
                            @endif
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-16 text-gray-400">
        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <p class="text-lg">No hay productos disponibles en este momento.</p>
    </div>
    @endif

@endsection