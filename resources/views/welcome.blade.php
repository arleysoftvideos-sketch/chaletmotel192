<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Chalet Motel 192 - Reservas de Lujo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;800;900&display=swap" rel="stylesheet">

        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --bg-primary: #030712;
                --accent-gradient: linear-gradient(135deg, #a78bfa 0%, #6366f1 50%, #3b82f6 100%);
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--bg-primary);
                overflow-x: hidden;
            }

            /* Ambient Glow */
            .glow-orb {
                position: absolute;
                border-radius: 50%;
                filter: blur(150px);
                z-index: 0;
                opacity: 0.15;
                pointer-events: none;
            }

            .orb-1 {
                background: #818cf8;
                width: 600px;
                height: 600px;
                top: -200px;
                left: -150px;
            }

            .orb-2 {
                background: #ec4899;
                width: 500px;
                height: 500px;
                bottom: -150px;
                right: -100px;
            }

            .glow-text {
                background: var(--accent-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                filter: drop-shadow(0 0 30px rgba(99, 102, 241, 0.2));
            }

            .hero-banner {
                background-image: linear-gradient(to bottom, rgba(3, 7, 18, 0.3) 0%, rgba(3, 7, 18, 0.9) 100%), url('/images/motel_banner.png');
                background-size: cover;
                background-position: center;
            }
        </style>
    </head>
    <body class="text-slate-100 antialiased min-h-screen flex flex-col justify-between relative selection:bg-indigo-500 selection:text-white">
        <!-- Background Orbs -->
        <div class="glow-orb orb-1"></div>
        <div class="glow-orb orb-2"></div>

        <!-- Navigation Header -->
        <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-10">
            <a href="/" class="flex items-center gap-2 group">
                <span class="text-2xl font-black font-['Outfit'] tracking-tight glow-text group-hover:scale-105 transition-transform duration-300">
                    CHALET MOTEL 192
                </span>
            </a>

            @if (Route::has('login'))
                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 hover:text-white rounded-full font-medium transition-all duration-300 hover:bg-slate-800 flex items-center gap-2">
                            <span>Mi Dashboard</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-slate-400 hover:text-slate-200 font-medium transition-all duration-300">
                            Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white rounded-full font-semibold transition-all duration-300 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 hover:-translate-y-0.5">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Expedia Style Hero Banner Container -->
        <main class="w-full max-w-7xl mx-auto px-6 py-6 flex-grow flex flex-col justify-center relative z-10">
            
            <!-- Hero Banner Box -->
            <div class="hero-banner w-full rounded-[2.5rem] border border-slate-800/80 p-8 sm:p-16 min-h-[520px] flex flex-col justify-end shadow-2xl relative overflow-hidden mb-12">
                
                <!-- Hero Text overlay -->
                <div class="max-w-2xl mb-8 relative z-10">
                    <div class="mb-4 px-3 py-1 bg-indigo-500/25 border border-indigo-400/30 text-indigo-300 text-xs font-semibold rounded-full tracking-wider uppercase inline-flex items-center gap-1.5 backdrop-blur-md">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        Ofertas Exclusivas de Temporada
                    </div>
                    
                    <h1 class="text-4xl sm:text-6xl font-black font-['Outfit'] tracking-tight text-white mb-4 leading-[1.1]">
                        Encuentra tu estancia en Chalet Motel 192
                    </h1>
                    
                    <p class="text-slate-200 text-base sm:text-lg font-medium leading-relaxed drop-shadow-md">
                        Hospedaje de lujo al pie de la carretera con confort futurista y check-in inmediato.
                    </p>
                </div>

                <!-- Floating Search Box (Expedia Widget Style) -->
                <div class="w-full relative z-10 translate-y-4 sm:translate-y-8">
                    <x-availability-search />
                </div>
            </div>

            <!-- Features Section -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 w-full mt-4 text-left">
                <div class="p-6 bg-slate-900/40 border border-slate-800/80 rounded-2xl backdrop-blur-md">
                    <div class="w-10 h-10 bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 rounded-xl flex items-center justify-center mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-white font-bold mb-2">Reserva Segura</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Tus datos personales y reservas están protegidos con la máxima encriptación.</p>
                </div>
                
                <div class="p-6 bg-slate-900/40 border border-slate-800/80 rounded-2xl backdrop-blur-md">
                    <div class="w-10 h-10 bg-purple-500/10 border border-purple-500/30 text-purple-400 rounded-xl flex items-center justify-center mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-white font-bold mb-2">Tarifa Garantizada</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Sin costos ocultos ni tasas inesperadas. Paga el precio que ves.</p>
                </div>

                <div class="p-6 bg-slate-900/40 border border-slate-800/80 rounded-2xl backdrop-blur-md">
                    <div class="w-10 h-10 bg-pink-500/10 border border-pink-500/30 text-pink-400 rounded-xl flex items-center justify-center mb-4">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L11 3z" />
                        </svg>
                    </div>
                    <h3 class="text-white font-bold mb-2">Máximo Confort</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Disfruta de suites de lujo con jacuzzi, room service 24/7 y domótica avanzada.</p>
                </div>
            </div>

        </main>

        <!-- Footer -->
        <footer class="w-full border-t border-slate-900/80 bg-slate-950/60 backdrop-blur-lg py-8 text-center text-xs text-slate-500 relative z-10 mt-12">
            <p>&copy; {{ date('Y') }} Chalet Motel 192. Todos los derechos reservados. Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
        </footer>
    </body>
</html>
