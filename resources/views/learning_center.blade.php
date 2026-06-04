<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Chalet Motel 192 - {{ __('Learning Center') }}</title>

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
                background-color: #040a17;
                font-family: 'Inter', sans-serif;
            }
            .clip-ribbon {
                clip-path: polygon(5% 0%, 95% 0%, 100% 50%, 95% 100%, 5% 100%, 0% 50%);
            }
            .hero-about-banner {
                background-image: linear-gradient(to right, rgba(6, 16, 33, 0.95) 0%, rgba(6, 16, 33, 0.85) 50%, rgba(6, 16, 33, 0.4) 100%), url('/images/learning_banner.png');
                background-size: cover;
                background-position: center;
            }
        </style>
    </head>
    <body class="text-slate-100 antialiased min-h-screen flex flex-col justify-between selection:bg-gold selection:text-navy">

        <!-- Navigation Header -->
        <header class="w-full bg-[#061021]/80 backdrop-blur-md sticky top-0 border-b border-blue-950 relative z-50">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <div></div>

                <div class="flex items-center gap-4">
                    <nav class="flex items-center gap-3">
                        <a href="/" class="px-4 py-2 text-slate-300 hover:text-white font-semibold transition-all duration-300 text-sm">
                            {{ __('Inicio') }}
                        </a>
                        <a href="/nosotros" class="px-4 py-2 text-slate-300 hover:text-white font-semibold transition-all duration-300 text-sm">
                            {{ __('Nosotros') }}
                        </a>
                        <a href="{{ route('contact.create') }}" class="px-4 py-2 text-slate-300 hover:text-white font-semibold transition-all duration-300 text-sm">
                            {{ __('Contacto') }}
                        </a>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-navy border border-blue-900/60 text-slate-200 hover:text-white rounded-xl font-medium transition-all duration-300 hover:bg-blue-950 flex items-center gap-2 text-sm">
                                <span>{{ __('Mi Dashboard') }}</span>
                            </a>
                        @endauth
                    </nav>
                    <div class="flex items-center gap-2 border-l border-blue-950 pl-4">
                        <a href="?lang=es" class="text-lg hover:scale-110 transition-transform" title="Español">🇪🇸</a>
                        <a href="?lang=en" class="text-lg hover:scale-110 transition-transform" title="English">🇺🇸</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="max-w-7xl w-full mx-auto px-6 pt-8 pb-4 relative z-10">
            <div class="hero-about-banner w-full rounded-[2.5rem] border border-blue-900/40 p-8 sm:p-12 min-h-[340px] flex items-center shadow-2xl relative overflow-hidden">
                <div class="absolute -top-20 -left-20 w-80 h-80 bg-blue-700/10 rounded-full filter blur-3xl pointer-events-none"></div>

                <div class="max-w-2xl flex flex-col space-y-4 relative z-10">
                    <div class="flex items-center gap-2">
                        <span class="h-[1px] w-8 bg-gold"></span>
                        <span class="text-gold font-extrabold text-xs uppercase tracking-widest">
                            {{ __('Recursos e Información') }}
                        </span>
                    </div>
                    <h1 class="text-4xl sm:text-5.5xl font-black font-outfit text-white uppercase tracking-tight">
                        {{ __('Learning') }} <span class="text-gold">{{ __('Center') }}</span>
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        {{ __('Bienvenido a nuestra plataforma exclusiva de aprendizaje. Un espacio diseñado para que nuestros residentes de Sri Lanka, Canadá y el mundo entero dominen nuevos idiomas con herramientas de alta calidad.') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-grow flex flex-col gap-12 relative z-10">
            <div class="text-center space-y-4 mb-8">
                <h2 class="text-3xl sm:text-4xl font-black font-outfit text-white uppercase tracking-wide">
                    {{ __('Elige tu idioma') }}
                </h2>
                <p class="text-slate-400 text-sm max-w-2xl mx-auto uppercase tracking-wider">
                    {{ __('Selecciona el idioma que deseas aprender hoy.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto w-full">
                <!-- English Card -->
                <a href="#" class="group relative overflow-hidden rounded-[2.5rem] border border-blue-900/50 bg-[#061021]/80 aspect-square sm:aspect-auto sm:h-[400px] flex flex-col items-center justify-center p-8 hover:border-gold/50 transition-all duration-500 shadow-2xl hover:shadow-gold/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="w-32 h-32 mb-8 relative z-10 transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2">
                        <!-- US/UK Flag abstract representation or icon -->
                        <div class="w-full h-full bg-[#0a1831] border-2 border-gold/30 rounded-full flex items-center justify-center shadow-[0_0_30px_rgba(255,183,3,0.15)] group-hover:shadow-[0_0_50px_rgba(255,183,3,0.3)] transition-all">
                            <span class="text-6xl">🇺🇸</span>
                        </div>
                    </div>
                    
                    <h3 class="text-3xl font-black font-outfit text-white tracking-widest uppercase mb-3 relative z-10 group-hover:text-gold transition-colors">
                        {{ __('Aprender Inglés') }}
                    </h3>
                    <p class="text-slate-400 text-sm text-center max-w-[250px] relative z-10">
                        {{ __('Domina el idioma inglés con nuestras lecciones interactivas y ejercicios prácticos.') }}
                    </p>
                    
                    <div class="absolute bottom-8 right-8 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </div>
                </a>

                <!-- Spanish Card -->
                <a href="#" class="group relative overflow-hidden rounded-[2.5rem] border border-blue-900/50 bg-[#061021]/80 aspect-square sm:aspect-auto sm:h-[400px] flex flex-col items-center justify-center p-8 hover:border-gold/50 transition-all duration-500 shadow-2xl hover:shadow-gold/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="w-32 h-32 mb-8 relative z-10 transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2">
                        <!-- Spain/LatAm Flag abstract representation or icon -->
                        <div class="w-full h-full bg-[#0a1831] border-2 border-gold/30 rounded-full flex items-center justify-center shadow-[0_0_30px_rgba(255,183,3,0.15)] group-hover:shadow-[0_0_50px_rgba(255,183,3,0.3)] transition-all">
                            <span class="text-6xl">🇪🇸</span>
                        </div>
                    </div>
                    
                    <h3 class="text-3xl font-black font-outfit text-white tracking-widest uppercase mb-3 relative z-10 group-hover:text-gold transition-colors">
                        {{ __('Aprender Español') }}
                    </h3>
                    <p class="text-slate-400 text-sm text-center max-w-[250px] relative z-10">
                        {{ __('Domina el idioma español con nuestras lecciones interactivas y ejercicios prácticos.') }}
                    </p>
                    
                    <div class="absolute bottom-8 right-8 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </div>
                </a>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full relative z-10 bg-[#0a1831] mt-12 border-t-2 border-gold/40 shadow-2xl">
            <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Phone Call Section -->
                <div class="flex items-center gap-4 group">
                    <div class="w-12 h-12 bg-gold rounded-xl flex items-center justify-center text-navy shadow-lg shadow-gold/10 transition-transform group-hover:scale-105 duration-300">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest leading-none mb-1">{{ __('¿Preguntas? Llámanos') }}</span>
                        <a href="tel:+14077731461" class="text-gold font-black font-outfit text-xl sm:text-2xl hover:underline leading-none">
                            +1 407 773 1461
                        </a>
                    </div>
                </div>

                <!-- Location Section -->
                <div class="flex items-center gap-4 group">
                    <div class="w-12 h-12 bg-white text-navy rounded-xl flex items-center justify-center shadow-lg transition-transform group-hover:scale-105 duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest leading-none mb-1">{{ __('Ubicados en') }}</span>
                        <span class="text-white font-extrabold font-outfit text-xs sm:text-sm leading-snug">
                            4741 W Irlo Bronson Memorial Hwy #192, <br class="hidden sm:inline">Kissimmee, FL 34746
                        </span>
                    </div>
                </div>

            </div>
            
            <!-- Bottom Copyright Bar -->
            <div class="w-full bg-[#061021] py-4 text-center text-xs text-slate-500 border-t border-blue-950">
                <p>&copy; {{ date('Y') }} Chalet Motel 192. {{ __('Todos los derechos reservados.') }} Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
            </div>
        </footer>

    </body>
</html>
