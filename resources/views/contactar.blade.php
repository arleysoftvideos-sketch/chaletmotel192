<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Chalet Motel 192 - Contáctanos</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">

        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            outfit: ['Outfit', 'sans-serif'],
                        },
                        colors: {
                            navy: {
                                DEFAULT: '#0a1831',
                                dark: '#061021',
                                light: '#14274c',
                            },
                            gold: {
                                DEFAULT: '#ffb703',
                                hover: '#fbc02d',
                            }
                        }
                    }
                }
            }
        </script>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background-color: #061021;
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="text-slate-100 antialiased min-h-screen flex flex-col justify-between selection:bg-gold selection:text-navy">

        <!-- Navigation Header -->
        <header class="w-full bg-navy border-b border-blue-900/40 relative z-50">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 group">
                    <span class="text-xl font-black font-outfit tracking-wider text-white group-hover:text-gold transition-colors duration-300">
                        CHALET MOTEL 192
                    </span>
                </a>

                <nav class="flex items-center gap-4">
                    <a href="/" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors">
                        Inicio
                    </a>
                    <a href="/nosotros" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors">
                        Nosotros
                    </a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-navy-light border border-blue-900 text-slate-200 hover:text-white rounded-xl font-medium transition-all duration-300 hover:bg-blue-950 text-xs">
                            Mi Dashboard
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Main Form Container -->
        <main class="w-full max-w-3xl mx-auto px-6 py-12 flex-grow flex flex-col justify-center relative z-10">
            
            <div class="bg-navy p-8 sm:p-12 rounded-[2rem] border border-blue-900/40 shadow-2xl space-y-8">
                
                <!-- Title & Header -->
                <div class="text-center space-y-2">
                    <h1 class="text-3xl sm:text-4xl font-black font-outfit text-white uppercase tracking-wider">
                        Contáctanos
                    </h1>
                    <p class="text-sm text-slate-400 max-w-md mx-auto">
                        ¿Tienes dudas sobre las tarifas a largo plazo o disponibilidad? Déjanos un mensaje y te responderemos pronto.
                    </p>
                    <div class="h-1 w-12 bg-gold rounded-full mx-auto mt-4"></div>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 p-4 rounded-xl flex items-center gap-3 text-sm">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-rose-500/10 border border-rose-500/25 text-rose-400 p-4 rounded-xl space-y-1 text-sm">
                        <p class="font-bold">Por favor corrige los siguientes errores:</p>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Full Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-xs font-bold text-yellow-500 uppercase tracking-wider">
                            Nombre Completo
                        </label>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}"
                            placeholder="Ej. Juan Pérez"
                            class="block w-full px-4 py-3 bg-[#081326] border border-blue-900 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all hover:border-blue-800">
                    </div>

                    <!-- Email & Phone Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-xs font-bold text-yellow-500 uppercase tracking-wider">
                                Correo Electrónico
                            </label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                placeholder="juan@ejemplo.com"
                                class="block w-full px-4 py-3 bg-[#081326] border border-blue-900 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all hover:border-blue-800">
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-xs font-bold text-yellow-500 uppercase tracking-wider">
                                Teléfono (Opcional)
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                placeholder="+1 (407) 123-4567"
                                class="block w-full px-4 py-3 bg-[#081326] border border-blue-900 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all hover:border-blue-800">
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="space-y-2">
                        <label for="message" class="block text-xs font-bold text-yellow-500 uppercase tracking-wider">
                            Mensaje / Pregunta
                        </label>
                        <textarea name="message" id="message" rows="5" required
                            placeholder="Escribe tu mensaje o pregunta aquí..."
                            class="block w-full px-4 py-3 bg-[#081326] border border-blue-900 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all hover:border-blue-800 resize-none">{{ old('message') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-4 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-400 hover:to-amber-500 text-[#0a1831] font-extrabold text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-yellow-500/10 hover:shadow-yellow-500/20 hover:-translate-y-0.5 transition-all duration-300">
                            Enviar Mensaje
                        </button>
                    </div>
                </form>

            </div>

        </main>

        <!-- Footer -->
        <footer class="w-full bg-[#0a1831] py-6 text-center text-xs text-slate-500 border-t border-blue-950/40">
            <p>&copy; {{ date('Y') }} Chalet Motel 192. Todos los derechos reservados.</p>
        </footer>

    </body>
</html>
