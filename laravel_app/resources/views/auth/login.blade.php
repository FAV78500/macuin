<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MACUIN - Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        macuin: {
                            blue: '#16285A',
                            red: '#D9232B',
                            bg: '#F4F6F9',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-macuin-bg text-gray-800 font-sans antialiased relative">

    <div class="min-h-screen flex flex-col md:flex-row">

        <div class="hidden md:flex md:w-1/2 bg-macuin-blue relative items-center justify-center flex-col overflow-hidden">
            <div class="absolute inset-0 z-0 opacity-30 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=1200&auto=format&fit=crop'); mix-blend-mode: multiply;"></div>
            
            <div class="relative z-10 text-center px-8">
                <h1 class="text-white text-5xl md:text-6xl font-bold tracking-wider mb-4">MACUIN</h1>
                <p class="text-gray-300 italic text-lg absolute -bottom-48 w-full left-0 right-0">"Tu taller, siempre abastecido."</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center bg-white p-6 sm:p-12">
            <div class="w-full max-w-md">
                
                <div class="flex border-b border-gray-200 mb-8">
                    <button class="w-1/2 py-3 text-center text-macuin-red font-semibold border-b-2 border-macuin-red">
                        Iniciar Sesión
                    </button>
                    <a href="/register" class="w-1/2 py-3 text-center text-gray-400 font-semibold hover:text-gray-600 transition block">
                        Registrarse
                    </a>
                </div>

                <h2 class="text-2xl font-semibold text-macuin-blue mb-8 text-center md:text-left">Bienvenido de nuevo</h2>

                <div class="space-y-5">
                    
                    <div>
                        <label for="email" class="block text-sm text-gray-600 mb-1">Correo Electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-macuin-blue focus:border-macuin-blue text-sm transition" placeholder="tu@email.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm text-gray-600 mb-1">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-macuin-blue focus:border-macuin-blue text-sm transition" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="#" id="openForgotModalBtn" class="text-xs text-macuin-blue hover:underline">¿Olvidaste tu contraseña?</a>
                    </div>

                    <a href="/" class="w-full bg-macuin-red hover:bg-red-700 text-white font-semibold py-2.5 rounded-md transition duration-200 block text-center">
                        Acceder
                    </a>
                </div>

                <div class="mt-8 mb-6 relative flex items-center justify-center">
                    <div class="border-t border-gray-200 w-full absolute"></div>
                    <span class="bg-white px-3 text-xs text-gray-400 relative z-10">Or</span>
                </div>

                <a href="/register" type="button" class="w-full bg-macuin-blue hover:bg-blue-900 text-white font-semibold py-2.5 rounded-md transition duration-200 block text-center">
                    Registrarse como Nuevo Taller
                </a>
            </div>
        </div>
    </div>

    <div id="forgotPasswordModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 relative mx-4">
            
            <button class="close-modal-btn absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div id="modalStep1" class="block">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 text-macuin-blue mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-macuin-blue mb-2">Recuperar Contraseña</h3>
                <p class="text-sm text-gray-600 mb-6">Ingresa el correo electrónico asociado a tu cuenta de taller y te enviaremos las instrucciones para restablecer tu contraseña.</p>
                
                <div class="mb-6">
                    <label for="recovery_email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input type="email" id="recovery_email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-macuin-blue text-sm transition" placeholder="ejemplo@taller.com">
                </div>

                <div class="flex gap-3 justify-end">
                    <button class="close-modal-btn px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition">
                        Cancelar
                    </button>
                    <button id="sendRecoveryBtn" class="px-4 py-2 text-sm font-medium text-white bg-macuin-blue hover:bg-blue-900 rounded-md transition">
                        Enviar Instrucciones
                    </button>
                </div>
            </div>

            <div id="modalStep2" class="hidden text-center py-4">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">¡Revisa tu bandeja!</h3>
                <p class="text-sm text-gray-600 mb-6">Si el correo ingresado coincide con nuestros registros, recibirás un enlace seguro para crear una nueva contraseña en los próximos minutos.</p>
                
                <button class="close-modal-btn w-full px-4 py-2 text-sm font-medium text-white bg-macuin-blue hover:bg-blue-900 rounded-md transition">
                    Entendido
                </button>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('forgotPasswordModal');
            const openBtn = document.getElementById('openForgotModalBtn');
            const closeBtns = document.querySelectorAll('.close-modal-btn');
            const step1 = document.getElementById('modalStep1');
            const step2 = document.getElementById('modalStep2');
            const sendBtn = document.getElementById('sendRecoveryBtn');
            const emailInput = document.getElementById('recovery_email');
            
            openBtn.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.remove('hidden');
            });
            
            const closeModal = () => {
                modal.classList.add('hidden');
                setTimeout(() => {
                    step1.classList.remove('hidden');
                    step2.classList.add('hidden');
                    emailInput.value = ''; 
                }, 300);
            };

            closeBtns.forEach(btn => btn.addEventListener('click', closeModal));
            
            sendBtn.addEventListener('click', () => {
                if(emailInput.value.trim() === '') {
                    emailInput.classList.add('border-red-500', 'focus:ring-red-500');
                    return;
                }
                emailInput.classList.remove('border-red-500', 'focus:ring-red-500');
                step1.classList.add('hidden');
                step2.classList.remove('hidden');
            });
            
            modal.addEventListener('click', (e) => {
                if(e.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>