@extends('layouts.app')

@section('title', 'MACUIN - Pedido Confirmado')

@section('content')
    <div class="max-w-2xl mx-auto mt-10">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8 md:p-12 text-center">
            
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-macuin-blue mb-2">¡Pedido Confirmado!</h1>
            <p class="text-gray-600 mb-8">Tu orden ha sido recibida y ya estamos preparando tus refacciones en el almacén.</p>

            <div class="bg-macuin-bg rounded-lg p-6 mb-8 text-left border border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between mb-4 pb-4 border-b border-gray-300">
                    <div>
                        <p class="text-sm text-gray-500">Número de Orden</p>
                        <p class="text-lg font-bold text-gray-800">#MAC-88392-MX</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:text-right">
                        <p class="text-sm text-gray-500">Fecha estimada de entrega</p>
                        <p class="text-lg font-bold text-macuin-blue">Mañana, antes de las 2:00 PM</p>
                    </div>
                </div>
                
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">Total pagado:</span>
                    <span class="font-bold text-gray-900">$4,408.00 MXN</span>
                </div>
                <div class="flex justify-between items-center text-sm mt-2">
                    <span class="text-gray-600">Método de pago:</span>
                    <span class="font-medium text-gray-800">Crédito Taller a 30 días</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/catalogo" class="bg-macuin-blue hover:bg-blue-900 text-white font-semibold py-3 px-6 rounded-md transition duration-200">
                    Seguir Comprando
                </a>
                <a href="/mis-pedidos" class="bg-white border-2 border-macuin-blue text-macuin-blue hover:bg-gray-50 font-semibold py-3 px-6 rounded-md transition duration-200">
                    Ver mis Pedidos
                </a>
            </div>

        </div>
    </div>
@endsection