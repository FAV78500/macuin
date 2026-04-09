@extends('layouts.app')

@section('title', 'MACUIN - Resultados de Búsqueda')

@section('content')

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-macuin-blue">Resultados para <span class="text-macuin-red">'Frenos'</span></h1>
        <p class="text-gray-500 mt-1">3 productos encontrados</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <aside class="w-full lg:w-1/4">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-lg font-semibold text-macuin-blue mb-4">Filtrar por Vehículo</h2>
                
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Marca</label>
                        <select class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-macuin-blue">
                            <option>Todas las marcas</option>
                            <option>Nissan</option>
                            <option>Volkswagen</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Modelo</label>
                        <select class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-macuin-blue">
                            <option>Todos los modelos</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Año</label>
                        <select class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-macuin-blue">
                            <option>Todos los años</option>
                        </select>
                    </div>
                </div>

                <hr class="border-gray-200 my-4">

                <h3 class="text-sm font-semibold text-gray-700 mb-3">Categorías</h3>
                <div class="space-y-2 mb-6">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" class="rounded text-macuin-blue focus:ring-macuin-blue">
                        <span class="text-sm text-gray-600">Motor</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" checked class="rounded text-macuin-blue focus:ring-macuin-blue accent-macuin-blue">
                        <span class="text-sm text-gray-600">Frenos</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" class="rounded text-macuin-blue focus:ring-macuin-blue">
                        <span class="text-sm text-gray-600">Suspensión</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" class="rounded text-macuin-blue focus:ring-macuin-blue">
                        <span class="text-sm text-gray-600">Eléctrico</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" class="rounded text-macuin-blue focus:ring-macuin-blue">
                        <span class="text-sm text-gray-600">Transmisión</span>
                    </label>
                </div>

                <button class="w-full bg-macuin-blue hover:bg-blue-900 text-white font-semibold py-2 rounded-md transition duration-200">
                    Aplicar Filtros
                </button>
            </div>
        </aside>

        <section class="w-full lg:w-3/4">
            
            <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-200 flex justify-between items-center mb-6">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                    <span class="text-sm text-gray-600">Ordenar por:</span>
                    <select class="border border-gray-300 rounded-md py-1 px-2 text-sm focus:outline-none focus:ring-1 focus:ring-macuin-blue">
                        <option>Relevancia</option>
                        <option>Menor Precio</option>
                        <option>Mayor Precio</option>
                    </select>
                </div>
                <span class="text-sm text-gray-500">Mostrando 3 de 3</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition group">
                    <a href="/producto" class="block overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=600&auto=format&fit=crop" alt="Disco de Freno" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-semibold text-gray-800 mb-1 leading-tight">
                            <a href="/producto" class="hover:text-macuin-blue transition">Disco de Freno Ventilado</a>
                        </h3>
                        <p class="text-xs text-gray-500 mb-3">SKU: BRK-2024-VNT</p>
                        <div class="text-2xl font-bold text-macuin-red mb-3">$1,450.00</div>
                        <div class="mb-4">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-green-200">Disponible: 12 pzas</span>
                        </div>
                        <div class="mt-auto">
                            <button class="w-full bg-macuin-red hover:bg-red-700 text-white font-semibold py-2 rounded-md transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition group">
                    <a href="/producto" class="block overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1600706432502-789ce86862a4?q=80&w=600&auto=format&fit=crop" alt="Pastillas de Freno" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-semibold text-gray-800 mb-1 leading-tight">
                            <a href="/producto" class="hover:text-macuin-blue transition">Pastillas de Freno Cerámicas</a>
                        </h3>
                        <p class="text-xs text-gray-500 mb-3">SKU: BRK-CER-8845</p>
                        <div class="text-2xl font-bold text-macuin-red mb-3">$899.00</div>
                        <div class="mb-4">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-green-200">Disponible: 24 pzas</span>
                        </div>
                        <div class="mt-auto">
                            <button class="w-full bg-macuin-red hover:bg-red-700 text-white font-semibold py-2 rounded-md transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition group">
                    <a href="/producto" class="block overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=600&auto=format&fit=crop" alt="Kit de Frenos" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-semibold text-gray-800 mb-1 leading-tight">
                            <a href="/producto" class="hover:text-macuin-blue transition">Kit de Frenos Hidráulicos</a>
                        </h3>
                        <p class="text-xs text-gray-500 mb-3">SKU: BRK-HYD-3322</p>
                        <div class="text-2xl font-bold text-macuin-red mb-3">$3,299.00</div>
                        <div class="mb-4">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-green-200">Disponible: 5 pzas</span>
                        </div>
                        <div class="mt-auto">
                            <button class="w-full bg-macuin-red hover:bg-red-700 text-white font-semibold py-2 rounded-md transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

@endsection