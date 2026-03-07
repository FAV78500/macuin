<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MACUIN - Registro de Taller</title>
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
<body class="bg-macuin-bg text-gray-800 font-sans antialiased">

    <div class="min-h-screen flex flex-col md:flex-row">

        <div class="hidden md:flex md:w-1/2 bg-macuin-blue relative items-center justify-center flex-col overflow-hidden">
            <div class="absolute inset-0 z-0 opacity-30 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=1200&auto=format&fit=crop'); mix-blend-mode: multiply;"></div>
            
            <div class="relative z-10 text-center px-8">
                <h1 class="text-white text-5xl md:text-6xl font-bold tracking-wider mb-4">MACUIN</h1>
                <p class="text-gray-300 italic text-lg absolute -bottom-48 w-full left-0 right-0">"Tu taller, siempre abastecido."</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center bg-white p-6 sm:p-12 overflow-y-auto">
            <div class="w-full max-w-md my-auto">
                
                <div class="flex border-b border-gray-200 mb-6 mt-4">
                    <a href="/login" class="w-1/2 py-3 text-center text-gray-400 font-semibold hover:text-gray-600 transition">
                        Iniciar Sesión
                    </a>
                    <div class="w-1/2 py-3 text-center text-macuin-red font-semibold border-b-2 border-macuin-red">
                        Registrarse
                    </div>
                </div>

                <h2 class="text-2xl font-semibold text-macuin-blue mb-6 text-center md:text-left">Crear Cuenta</h2>

                <form action="#" method="POST" class="space-y-4">
                    
                    <div>
                        <label for="name" class="block text-sm text-gray-600 mb-1">Nombre del Taller</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" id="name" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-macuin-blue focus:border-macuin-blue text-sm transition" placeholder="Taller Mecánico Express">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm text-gray-600 mb-1">Correo Electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" id="email" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-macuin-blue focus:border-macuin-blue text-sm transition" placeholder="contacto@taller.com">
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm text-gray-600 mb-1">Teléfono</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <input type="tel" id="phone" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-macuin-blue focus:border-macuin-blue text-sm transition" placeholder="+52 (555) 123-4567">
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
                            <input type="password" id="password" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-macuin-blue focus:border-macuin-blue text-sm transition" placeholder="••••••••">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm text-gray-600 mb-1">Confirmar Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password_confirmation" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-macuin-blue focus:border-macuin-blue text-sm transition" placeholder="••••••••">
                        </div>
                    </div>

                    <a href="/login" type="submit" class="w-full bg-macuin-red hover:bg-red-700 text-white font-semibold py-2.5 rounded-md transition duration-200 block text-center">
                        Crear Cuenta
                    </a>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        Al registrarte, aceptas nuestros <a href="#" class="text-macuin-blue hover:underline">Términos y Condiciones</a>
                    </p>
                </div>

            </div>
        </div>
    </div>

</body>
</html>