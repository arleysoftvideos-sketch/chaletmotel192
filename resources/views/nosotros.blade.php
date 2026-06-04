<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Chalet Motel 192 - {{ __('Quiénes Somos') }}</title>

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
                background-image: linear-gradient(to right, rgba(6, 16, 33, 0.95) 0%, rgba(6, 16, 33, 0.85) 50%, rgba(6, 16, 33, 0.4) 100%), url('/images/motel_about.png?v=2');
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
                        <a href="/nosotros" class="px-4 py-2 text-gold font-semibold transition-all duration-300 text-sm">
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
                    <div class="flex items-center gap-3 border-l border-blue-950 pl-4">
                        <a href="?lang=es" class="hover:scale-110 transition-transform" title="Español">
                            <img src="https://flagcdn.com/w20/es.png" srcset="https://flagcdn.com/w40/es.png 2x" width="20" alt="Español" class="rounded-[2px] shadow-sm">
                        </a>
                        <a href="?lang=en" class="hover:scale-110 transition-transform" title="English">
                            <img src="https://flagcdn.com/w20/us.png" srcset="https://flagcdn.com/w40/us.png 2x" width="20" alt="English" class="rounded-[2px] shadow-sm">
                        </a>
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
                            {{ __('Conoce Nuestra Historia') }}
                        </span>
                    </div>
                    <h1 class="text-4xl sm:text-5.5xl font-black font-outfit text-white uppercase tracking-tight">
                        {{ __('Quiénes') }} <span class="text-gold">{{ __('Somos') }}</span>
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        {{ __('Chalet Motel 192 ofrece un concepto único de alquileres a largo plazo en Kissimmee, Florida. Brindamos un espacio seguro, cómodo y accesible para estancias extendidas de 6 meses a 1 año.') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-grow flex flex-col gap-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-[#0a1831]/90 p-8 sm:p-10 rounded-[2rem] border border-blue-950 shadow-2xl">
                
                <!-- Left Side: History & Mission (8 cols) -->
                <div class="lg:col-span-8 space-y-8">
                    <div class="space-y-4">
                        <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide border-b border-blue-950 pb-3">
                            {{ __('Nuestra Historia') }}
                        </h2>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            {!! __('Fundado con la visión de resolver la alta demanda de alojamiento a largo plazo de calidad en el área de Kissimmee y Orlando, <strong>Chalet Motel 192</strong> ha sido completamente rediseñado para ofrecer una alternativa residencial cómoda y económica.') !!}
                        </p>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            {{ __('Ubicado estratégicamente sobre la conocida autopista 192 (Irlo Bronson Memorial Highway), nos encontramos a solo minutos de los principales centros comerciales, restaurantes y atracciones turísticas más famosas de Florida Central, incluyendo Walt Disney World. Nuestro motel ha evolucionado de un alojamiento temporal a una verdadera comunidad de residentes de estancias prolongadas.') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                        <div class="bg-[#061021]/60 p-6 rounded-2xl border border-blue-900/30 space-y-2">
                            <span class="text-gold text-2xl">🎯</span>
                            <h3 class="text-white font-bold font-outfit text-lg uppercase tracking-wide">{{ __('Nuestra Misión') }}</h3>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                {{ __('Ofrecer soluciones habitacionales a largo plazo a través de tarifas competitivas, un servicio de mantenimiento de primera clase y un entorno pacífico y limpio que nuestros residentes puedan llamar hogar.') }}
                            </p>
                        </div>

                        <div class="bg-[#061021]/60 p-6 rounded-2xl border border-blue-900/30 space-y-2">
                            <span class="text-gold text-2xl">✨</span>
                            <h3 class="text-white font-bold font-outfit text-lg uppercase tracking-wide">{{ __('Nuestra Visión') }}</h3>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                {{ __('Consolidarnos como la principal opción de renta de largo plazo en Kissimmee, destacando por la seguridad de nuestras instalaciones, la renovación constante de nuestros espacios y la calidez en la atención.') }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4">
                        <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide border-b border-blue-950 pb-3">
                            {{ __('El Concepto de Larga Estancia') }}
                        </h2>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            {!! __('A diferencia de los moteles tradicionales enfocados en turistas de paso, en Chalet Motel 192 nos especializamos en alquileres de <strong>6 meses a 1 año</strong>. Este enfoque nos permite fomentar una atmósfera residencial de paz y respeto mutuo. Cada una de nuestras habitaciones cuenta con las amenidades básicas que garantizan un estilo de vida sin complicaciones: aire acondicionado de alta eficiencia, refrigerador, televisión con cable, Internet inalámbrico de alta velocidad y amplios estacionamientos para ti y tus visitas.') !!}
                        </p>
                    </div>
                </div>

                <!-- Right Side: Stats & Contact Info (4 cols) -->
                <div class="lg:col-span-4 flex flex-col space-y-6 lg:pl-8 lg:border-l lg:border-blue-950">
                    <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide border-b border-blue-950 pb-3">
                        {{ __('Datos Clave') }}
                    </h2>

                    <!-- Key stats cards -->
                    <div class="space-y-4">
                        <!-- Stat 1 -->
                        <div class="flex items-center gap-4 p-4 bg-[#081326] border border-blue-900/40 rounded-xl">
                            <div class="text-3xl font-black font-outfit text-gold">
                                <span class="block text-xs text-white/50 font-bold tracking-widest uppercase mb-0.5">{{ __('Desde') }}</span>
                                $1,000
                            </div>
                            <div class="flex flex-col">
                                <span class="text-white font-bold text-xs uppercase tracking-wide">{{ __('Tarifa Fija Mensual') }}</span>
                                <span class="text-slate-500 text-[10px]">{{ __('Servicios incluidos') }}</span>
                            </div>
                        </div>

                        <!-- Stat 2 -->
                        <div class="flex items-center gap-4 p-4 bg-[#081326] border border-blue-900/40 rounded-xl">
                            <div class="text-3xl font-black font-outfit text-gold">1º Mes</div>
                            <div class="flex flex-col">
                                <span class="text-white font-bold text-xs uppercase tracking-wide">{{ __('¡Completamente Gratis!') }}</span>
                                <span class="text-slate-500 text-[10px]">{{ __('En contratos calificados') }}</span>
                            </div>
                        </div>

                        <!-- Stat 3 -->
                        <div class="flex items-center gap-4 p-4 bg-[#081326] border border-blue-900/40 rounded-xl">
                            <div class="text-3xl font-black font-outfit text-gold">10 min</div>
                            <div class="flex flex-col">
                                <span class="text-white font-bold text-xs uppercase tracking-wide font-outfit">{{ __('De Disney World') }}</span>
                                <span class="text-slate-500 text-[10px]">{{ __('Ubicación céntrica') }}</span>
                            </div>
                        </div>

                        <!-- Stat 4 -->
                        <div class="flex items-center gap-4 p-4 bg-[#081326] border border-blue-900/40 rounded-xl">
                            <div class="text-3xl font-black font-outfit text-gold">24/7</div>
                            <div class="flex flex-col">
                                <span class="text-white font-bold text-xs uppercase tracking-wide">{{ __('Atención y Seguridad') }}</span>
                                <span class="text-slate-500 text-[10px]">{{ __('Residentes tranquilos') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Short card about long term -->
                    <div class="p-6 bg-navy-light/40 border border-blue-900/40 rounded-2xl space-y-3">
                        <span class="block text-xs font-bold text-yellow-500 uppercase tracking-widest">
                            {{ __('Requisitos de Renta') }}
                        </span>
                        <ul class="text-slate-400 text-xs space-y-2 list-disc list-inside">
                            <li>{{ __('Identificación oficial vigente.') }}</li>
                            <li>{{ __('Comprobante de ingresos.') }}</li>
                            <li>{{ __('Contrato mínimo de 6 meses.') }}</li>
                            <li>{{ __('Verificación de antecedentes básicos.') }}</li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Values Section (Horizontal Cards) -->
            <div class="space-y-6">
                <div class="text-center">
                    <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide">
                        {{ __('Nuestros Valores Corporativos') }}
                    </h2>
                    <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">
                        {{ __('Los pilares que guían nuestro servicio diario') }}
                    </p>
                    <div class="h-1 w-12 bg-gold rounded-full mx-auto mt-3"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Value 1 -->
                    <div class="bg-[#0a1831] border border-blue-950 p-6 rounded-2xl space-y-3 hover:border-gold/30 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-gold/10 text-gold rounded-xl flex items-center justify-center font-bold text-lg group-hover:scale-105 transition-transform duration-300">
                            🤝
                        </div>
                        <h3 class="text-white font-bold font-outfit text-base uppercase tracking-wider group-hover:text-gold transition-colors">
                            {{ __('Hospitalidad y Respeto') }}
                        </h3>
                        <p class="text-slate-400 text-xs leading-relaxed">
                            {{ __('Tratamos a cada residente como parte de nuestra familia, fomentando una convivencia armoniosa y respetuosa entre todos los miembros de la comunidad.') }}
                        </p>
                    </div>

                    <!-- Value 2 -->
                    <div class="bg-[#0a1831] border border-blue-950 p-6 rounded-2xl space-y-3 hover:border-gold/30 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-gold/10 text-gold rounded-xl flex items-center justify-center font-bold text-lg group-hover:scale-105 transition-transform duration-300">
                            🛡️
                        </div>
                        <h3 class="text-white font-bold font-outfit text-base uppercase tracking-wider group-hover:text-gold transition-colors">
                            {{ __('Seguridad y Confianza') }}
                        </h3>
                        <p class="text-slate-400 text-xs leading-relaxed">
                            {{ __('Mantenemos un estricto control de ingreso y cámaras de seguridad para asegurar que las instalaciones permanezcan seguras y tranquilas a cualquier hora.') }}
                        </p>
                    </div>

                    <!-- Value 3 -->
                    <div class="bg-[#0a1831] border border-blue-950 p-6 rounded-2xl space-y-3 hover:border-gold/30 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-gold/10 text-gold rounded-xl flex items-center justify-center font-bold text-lg group-hover:scale-105 transition-transform duration-300">
                            🧹
                        </div>
                        <h3 class="text-white font-bold font-outfit text-base uppercase tracking-wider group-hover:text-gold transition-colors">
                            {{ __('Limpieza y Calidad') }}
                        </h3>
                        <p class="text-slate-400 text-xs leading-relaxed">
                            {{ __('Nos enorgullecemos de ofrecer áreas comunes limpias, mantenimiento rápido para cualquier reporte en tu habitación e inspecciones periódicas de calidad.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Call to Action Section -->
            <div class="w-full bg-gradient-to-r from-[#061021] via-[#0a1831] to-[#061021] border border-blue-900/40 rounded-[2rem] p-8 sm:p-12 text-center space-y-6 relative overflow-hidden shadow-2xl">
                <!-- Background blur element -->
                <div class="absolute inset-0 bg-blue-900/5 mix-blend-color-dodge"></div>
                
                <div class="relative z-10 max-w-xl mx-auto space-y-4">
                    <h2 class="text-2xl sm:text-3xl font-black font-outfit text-white uppercase tracking-wide">
                        {{ __('¿Listo para Mudarte?') }}
                    </h2>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                        {{ __('Nuestras habitaciones King y 2 Kings se rentan rápidamente. Ponte en contacto con nosotros hoy mismo para consultar disponibilidad y agendar una visita a nuestras instalaciones.') }}
                    </p>
                    <div class="h-1 w-12 bg-gold rounded-full mx-auto mt-2"></div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                        <a href="{{ route('contact.create') }}" class="px-8 py-3.5 bg-gold hover:bg-gold-hover text-[#0a1831] font-black font-outfit rounded-xl transition-all duration-300 text-sm uppercase tracking-wider shadow-lg shadow-gold/10 hover:shadow-gold/20 hover:-translate-y-0.5">
                            {{ __('Contáctanos Ahora') }}
                        </a>
                    </div>
                </div>
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
                            4741 W Irlo Bronson Memorial Hwy, <br class="hidden sm:inline">Kissimmee, FL 34746
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
