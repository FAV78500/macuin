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
<body class="bg-macuin-bg text-gray-800 font-sans antialiased">

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

                <form action="/login" method="POST" class="space-y-5">
                    @csrf 
                    
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
                        <a href="#" class="text-xs text-macuin-blue hover:underline">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="w-full bg-macuin-red hover:bg-red-700 text-white font-semibold py-2.5 rounded-md transition duration-200">
                        Acceder
                    </button>
                </form>

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

</body>
</html>