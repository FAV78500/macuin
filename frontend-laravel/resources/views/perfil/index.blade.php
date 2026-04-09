@extends('layouts.app')

@section('title', 'MACUIN - Mi Perfil')

@section('content')

    <div class="flex flex-col lg:flex-row gap-8 relative overflow-hidden">
        
        <aside class="w-full lg:w-64 flex-shrink-0 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center text-center">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full bg-macuin-blue flex items-center justify-center mb-4 text-white text-3xl font-bold">
                        {{ strtoupper(substr(session('user_name', 'U'), 0, 1)) }}
                    </div>
                <h2 class="font-bold text-gray-900 text-lg">{{ session('user_name') }}</h2>
            </div>

            <nav class="bg-white rounded-lg shadow-sm border border-gray-200 p-2 space-y-1">
                <a href="/perfil" class="flex items-center gap-3 px-4 py-3 bg-macuin-blue text-white rounded-md transition font-medium shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Mi Perfil
                </a>
                <a href="/mis-pedidos" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-md transition font-medium">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
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
            <h1 class="text-2xl font-bold text-macuin-blue mb-6">Configuración de la Cuenta</h1>
            
            <div class="space-y-6">
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b border-gray-100">Información del Taller / Negocio</h3>
                    
                    <form id="profileForm" action="#" method="POST" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nombre_taller" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Taller / Empresa</label>
                                <input type="text" id="nombre_taller" name="nombre_taller" value="Taller Mecánico Velocidad" class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:ring-2 focus:ring-macuin-blue focus:border-macuin-blue outline-none transition">
                            </div>
                            <div>
                                <label for="contacto" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Contacto Principal</label>
                                <input type="text" id="contacto" name="contacto" value="Juan Pérez" class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:ring-2 focus:ring-macuin-blue focus:border-macuin-blue outline-none transition">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                                <input type="email" id="email" name="email" value="contacto@tallervelocidad.com" class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 bg-gray-50 focus:ring-2 focus:ring-macuin-blue focus:border-macuin-blue outline-none transition" readonly>
                                <p class="text-xs text-gray-500 mt-1">El correo no se puede cambiar directamente. Contacta a soporte.</p>
                            </div>
                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono Fijo / Móvil</label>
                                <input type="tel" id="telefono" name="telefono" value="(55) 1234-5678" class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:ring-2 focus:ring-macuin-blue focus:border-macuin-blue outline-none transition">
                            </div>
                        </div>
                        
                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-macuin-blue hover:bg-blue-900 text-white font-semibold py-2 px-6 rounded-md transition shadow-sm">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b border-gray-100">Seguridad</h3>
                    
                    <form id="passwordForm" action="#" method="POST" class="space-y-4 max-w-lg">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña Actual</label>
                            <input type="password" id="current_password" name="current_password" placeholder="••••••••" class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:ring-2 focus:ring-macuin-blue focus:border-macuin-blue outline-none transition">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                            <input type="password" id="new_password" name="new_password" placeholder="••••••••" class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:ring-2 focus:ring-macuin-blue focus:border-macuin-blue outline-none transition">
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nueva Contraseña</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:ring-2 focus:ring-macuin-blue focus:border-macuin-blue outline-none transition">
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="bg-macuin-blue hover:bg-blue-900 text-white font-semibold py-2 px-6 rounded-md transition shadow-sm">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </section>

    </div>

    <div id="toastNotification" class="fixed bottom-4 right-4 transform translate-y-24 opacity-0 transition-all duration-300 ease-in-out z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg pointer-events-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span id="toastMessage" class="font-medium text-sm">Cambios guardados con éxito</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const profileForm = document.getElementById('profileForm');
            const passwordForm = document.getElementById('passwordForm');
            const toast = document.getElementById('toastNotification');
            const toastMessage = document.getElementById('toastMessage');
            let toastTimeout;
            const showToast = (message) => {
                toastMessage.textContent = message;
                toast.classList.remove('translate-y-24', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
                clearTimeout(toastTimeout);
                toastTimeout = setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-24', 'opacity-0');
                }, 3500);
            };
            profileForm.addEventListener('submit', (e) => {
                e.preventDefault(); 
                showToast('¡Información del taller actualizada correctamente!');
            });
            passwordForm.addEventListener('submit', (e) => {
                e.preventDefault(); 
                passwordForm.reset(); 
                showToast('¡Contraseña actualizada correctamente!');
            });
        });
    </script>

@endsection