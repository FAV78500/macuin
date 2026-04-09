@extends('layouts.app')

@section('title', 'MACUIN - Carrito de Compras')

@section('content')
    
    <h1 class="text-2xl font-bold text-macuin-blue mb-6">Tu Carrito (3 Artículos)</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <div class="flex-1 space-y-4">
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex flex-col sm:flex-row items-center sm:items-start gap-4 transition hover:shadow-md">
                <div class="w-32 h-32 bg-gray-50 rounded-md border border-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center p-2">
                    <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=200&auto=format&fit=crop" alt="Batería LTH" class="max-h-full object-contain">
                </div>
                
                <div class="flex-1 flex flex-col justify-between h-full w-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800"><a href="/producto" class="hover:text-macuin-blue transition">Batería LTH - 12V (Heavy Duty)</a></h3>
                            <p class="text-sm text-gray-500 mb-2">Part #: BAT-LTH-099</p>
                            <div class="text-xl font-bold text-gray-900">$2,100.00</div>
                        </div>
                        <button class="text-gray-400 hover:text-macuin-red transition p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                    
                    <div class="flex items-center gap-4 mt-4">
                        <span class="text-sm font-semibold text-gray-700">Cantidad:</span>
                        <div class="flex items-center border border-gray-300 rounded-md bg-white w-28 h-9">
                            <button class="px-3 text-gray-600 hover:bg-gray-100 transition rounded-l-md h-full">-</button>
                            <input type="text" value="1" class="w-full text-center focus:outline-none text-gray-800 font-semibold bg-transparent text-sm h-full" readonly>
                            <button class="px-3 text-gray-600 hover:bg-gray-100 transition rounded-r-md h-full">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex flex-col sm:flex-row items-center sm:items-start gap-4 transition hover:shadow-md">
                <div class="w-32 h-32 bg-gray-50 rounded-md border border-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center p-2">
                    <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=200&auto=format&fit=crop" alt="Disco de Freno" class="max-h-full object-contain">
                </div>
                
                <div class="flex-1 flex flex-col justify-between h-full w-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800"><a href="/producto" class="hover:text-macuin-blue transition">Disco de Freno Ventilado - Delantero</a></h3>
                            <p class="text-sm text-gray-500 mb-1">Part #: BRK-5592-X</p>
                            <div class="text-xl font-bold text-gray-900">$850.00 <span class="text-sm text-gray-500 font-normal">c/u</span></div>
                            <p class="text-sm text-macuin-red flex items-center gap-1 mt-1 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                ¡Ojo! Solo quedan 3 piezas disponibles
                            </p>
                        </div>
                        <button class="text-gray-400 hover:text-macuin-red transition p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                    
                    <div class="flex items-center gap-4 mt-4">
                        <span class="text-sm font-semibold text-gray-700">Cantidad:</span>
                        <div class="flex items-center border border-gray-300 rounded-md bg-white w-28 h-9">
                            <button class="px-3 text-gray-600 hover:bg-gray-100 transition rounded-l-md h-full">-</button>
                            <input type="text" value="2" class="w-full text-center focus:outline-none text-gray-800 font-semibold bg-transparent text-sm h-full" readonly>
                            <button class="px-3 text-gray-600 hover:bg-gray-100 transition rounded-r-md h-full">+</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="w-full lg:w-96">
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden sticky top-6">
                <div class="h-1.5 w-full bg-macuin-blue"></div>
                
                <div class="p-6">
                    <h2 class="text-xl font-bold text-macuin-blue mb-6">Resumen del Pedido</h2>
                    
                    <div class="space-y-4 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span class="font-semibold text-gray-900">$3,800.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Envío:</span>
                            <span class="font-semibold text-gray-900">Por calcular</span>
                        </div>
                        <div class="flex justify-between">
                            <span>IVA (16%):</span>
                            <span class="font-semibold text-gray-900">$608.00</span>
                        </div>
                    </div>
                    
                    <hr class="my-4 border-gray-200">
                    
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg font-bold text-gray-900">Total:</span>
                        <span class="text-2xl font-bold text-macuin-blue">$4,408.00 MXN</span>
                    </div>
                    
                    <a href="/pedido/confirmacion" class="w-full bg-macuin-red hover:bg-red-700 text-white font-bold py-3 px-4 rounded-md transition duration-200 shadow-md">
                        Confirmar Pedido
                    </a>
                    
                    <p class="text-xs text-center text-gray-500 mt-4">
                        La orden se enviará a almacén para surtido inmediato tras la confirmación.
                    </p>
                </div>
                
                <div class="bg-gray-50 p-4 border-t border-gray-200 flex justify-center gap-3 text-gray-400">
                    <svg class="h-6 w-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                    <svg class="h-6 w-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
            </div>
        </div>

    </div>

@endsection