<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Chalet Motel 192 - {{ __('Motel Rentals') }}</title>

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
            html {
                scroll-behavior: smooth;
            }
            body {
                background-color: #040a17;
                font-family: 'Inter', sans-serif;
            }
            .clip-ribbon {
                clip-path: polygon(5% 0%, 95% 0%, 100% 50%, 95% 100%, 5% 100%, 0% 50%);
            }
            .hero-banner-contained {
                background-image: linear-gradient(to right, rgba(6, 16, 33, 0.95) 0%, rgba(6, 16, 33, 0.9) 35%, rgba(6, 16, 33, 0.4) 100%), url('/images/motel_banner.png');
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

        <!-- Hero Section (Contained Banner Card) -->
        <section class="max-w-7xl w-full mx-auto px-6 pt-8 pb-4 relative z-10">
            <!-- Contained Hero Banner Box -->
            <div class="hero-banner-contained w-full rounded-[2.5rem] border border-blue-900/40 p-8 sm:p-12 min-h-[380px] sm:min-h-[420px] flex items-center shadow-2xl relative overflow-hidden">
                
                <!-- Background Glowing Circle Inside the Card -->
                <div class="absolute -top-20 -left-20 w-80 h-80 bg-blue-700/10 rounded-full filter blur-3xl pointer-events-none"></div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center w-full">
                    
                    <!-- Left Column (Flyer Text) -->
                    <div class="md:col-span-8 flex flex-col space-y-5 relative z-10">
                        <!-- Main Title: MOTEL RENTALS -->
                        <div class="space-y-0.5">
                            <span class="block text-4xl sm:text-5xl font-black font-outfit text-white leading-none tracking-tight">
                                {{ __('MOTEL') }}
                            </span>
                            <span class="block text-5xl sm:text-6.5xl font-black font-outfit text-gold leading-none tracking-tight">
                                {{ __('RENTALS') }}
                            </span>
                        </div>

                        <!-- Ribbon: LONG TERM STAYS -->
                        <div class="inline-block bg-[#0284c7] px-6 py-2 text-center text-white font-black font-outfit text-md sm:text-xl tracking-wider uppercase clip-ribbon shadow-lg shadow-sky-600/10 max-w-xs">
                            {{ __('Long Term Stays') }}
                        </div>

                        <!-- Duration Subheading -->
                        <div class="flex items-center gap-3 max-w-sm">
                            <div class="h-[1px] bg-gold/50 flex-grow"></div>
                            <span class="text-gold font-extrabold text-xs sm:text-sm tracking-widest whitespace-nowrap uppercase">
                                {{ __('6 Month to 1 Year') }}
                            </span>
                            <div class="h-[1px] bg-gold/50 flex-grow"></div>
                        </div>

                        <!-- Price -->
                        <div class="flex flex-col">
                            <span class="text-white/70 font-bold uppercase tracking-widest text-xs mb-1">
                                {{ __('Desde') }}
                            </span>
                            <span class="text-5xl sm:text-7xl font-black font-outfit text-gold leading-none">
                                $800
                            </span>
                            <div class="flex items-center gap-2 mt-0.5">
                                <div class="h-[1px] w-6 bg-white/40"></div>
                                <span class="text-white/70 font-extrabold uppercase tracking-widest text-[10px] sm:text-xs">
                                    {{ __('Per Month') }}
                                </span>
                                <div class="h-[1px] w-6 bg-white/40"></div>
                            </div>
                            <span class="text-white/40 text-[9px] sm:text-[10px] font-bold uppercase tracking-widest mt-3 block">
                                * {{ __('1 Month Free applies to minimum 6-month contracts') }}
                            </span>
                        </div>
                    </div>

                    <!-- Right Column (Floating Gold Badge on top right of the container) -->
                    <div class="md:col-span-4 flex justify-center md:justify-end relative">
                        <!-- Jagged Badge: FIRST MONTH FREE! -->
                        <div class="w-28 h-28 sm:w-36 sm:h-36 bg-gold rounded-full flex flex-col items-center justify-center text-center text-navy p-3 shadow-2xl animate-bounce hover:scale-105 transition-transform duration-300">
                            <svg class="absolute w-full h-full text-gold-hover animate-spin" style="animation-duration: 25s;" viewBox="0 0 100 100" fill="none">
                                <path d="M50 0 L58 35 L93 25 L65 50 L93 75 L58 65 L50 100 L42 65 L7 75 L35 50 L7 25 L42 35 Z" fill="currentColor"/>
                            </svg>
                            <div class="relative z-10 flex flex-col items-center">
                                <!-- Star icons -->
                                <div class="flex gap-0.5 text-navy mb-0.5">
                                    <svg class="w-2 h-2 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-2 h-2 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-2 h-2 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <span class="block text-[24px] font-black font-outfit leading-none uppercase text-navy mb-1">1</span>
                                <span class="block text-[18px] font-black font-outfit leading-none uppercase text-navy">{{ __('Month') }}</span>
                                <span class="block text-[18px] font-black font-outfit leading-none uppercase text-navy">{{ __('Free!') }}</span>
                                <div class="flex gap-0.5 text-navy mt-0.5">
                                    <svg class="w-2 h-2 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-2 h-2 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-2 h-2 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Main Content Area (Rooms Gallery & Amenities) -->
        <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-grow flex flex-col justify-center gap-12 relative z-10">

            <!-- Bottom Sections (Rooms Gallery & Amenities) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-[#0a1831]/90 p-8 sm:p-10 rounded-[2rem] border border-blue-950 shadow-2xl">
                
                <!-- Left Section (Gallery) -->
                <div class="lg:col-span-8 space-y-10">
                    
                    <!-- Title -->
                    <div class="border-b border-blue-950 pb-4">
                        <h2 class="text-2xl font-black font-outfit text-white tracking-wide uppercase">{{ __('Nuestras Habitaciones') }}</h2>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">{{ __('Espacios listos y equipados para tu comodidad') }}</p>
                    </div>

                    <!-- 2 Kings Room Ready -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-gold/10 text-gold border border-gold/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                </svg>
                            </span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-white font-bold font-outfit text-lg uppercase tracking-wide">{{ __('2 Kings Room') }}</span>
                                <span class="text-gold font-extrabold text-xs uppercase tracking-widest bg-gold/10 px-2 py-0.5 rounded-full">{{ __('Ready!') }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="group border border-blue-950 rounded-2xl overflow-hidden aspect-[4/3] bg-navy-dark relative shadow-md">
                                <img src="/images/room_2kings.png" alt="2 Kings Bed Room" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 flex justify-between items-end">
                                    <span class="text-xs font-bold text-white uppercase tracking-wider">{{ __('Dormitorio Principal') }}</span>
                                </div>
                            </div>
                            <div class="group border border-blue-950 rounded-2xl overflow-hidden aspect-[4/3] bg-navy-dark relative shadow-md">
                                <img src="/images/bathroom.png" alt="2 Kings Bath Room" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 flex justify-between items-end">
                                    <span class="text-xs font-bold text-white uppercase tracking-wider">{{ __('Baño Privado') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- More Rooms to Come -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-gold/10 text-gold border border-gold/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-white font-bold font-outfit text-lg uppercase tracking-wide">{{ __('More Rooms') }}</span>
                                <span class="text-gold font-extrabold text-xs uppercase tracking-widest bg-gold/10 px-2 py-0.5 rounded-full">{{ __('To Come!') }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="group border border-blue-950 rounded-2xl overflow-hidden aspect-[4/3] bg-navy-dark relative shadow-md">
                                <img src="/images/room_king.png" alt="King Bed Room" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 flex justify-between items-end">
                                    <span class="text-xs font-bold text-white uppercase tracking-wider">{{ __('King Suite') }}</span>
                                </div>
                            </div>
                            <a href="#photo-gallery" class="group border border-blue-950 rounded-2xl overflow-hidden aspect-[4/3] relative shadow-md block">
                                <img src="/images/room_2kings.png" alt="Gallery Preview" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/60 group-hover:bg-black/40 transition-colors duration-300 flex flex-col justify-center items-center p-6 text-center">
                                    <svg class="w-10 h-10 text-gold mb-3 group-hover:scale-110 group-hover:-translate-y-1 transition-transform duration-300 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-white font-black font-outfit text-sm uppercase tracking-widest group-hover:text-gold transition-colors drop-shadow-md">{{ __('Ver Galería Completa') }}</span>
                                    <div class="mt-4 flex items-center justify-center animate-bounce text-gold group-hover:text-gold drop-shadow-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Right Section (Amenities) -->
                <div class="lg:col-span-4 flex flex-col justify-start space-y-8 lg:pl-8 lg:border-l lg:border-blue-950">
                    
                    <!-- Header -->
                    <div class="border-b border-blue-950 pb-4">
                        <h2 class="text-2xl font-black font-outfit text-white tracking-wide uppercase">{{ __('Servicios') }}</h2>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">{{ __('Comodidades incluidas para tu estancia') }}</p>
                    </div>

                    <!-- Amenities Checklist -->
                    <ul class="space-y-6">

                        <!-- Cable TV -->
                        <li class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-gold/10 text-gold border border-gold/20 rounded-xl flex items-center justify-center transition-all group-hover:scale-110 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <span class="text-slate-200 font-bold font-outfit text-md uppercase tracking-wider group-hover:text-gold transition-colors">
                                {{ __('Cable TV') }}
                            </span>
                        </li>

                        <!-- A/C -->
                        <li class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-gold/10 text-gold border border-gold/20 rounded-xl flex items-center justify-center transition-all group-hover:scale-110 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m11.314 11.314l.707.707M12 5a7 7 0 100 14 7 7 0 000-14z" />
                                </svg>
                            </div>
                            <span class="text-slate-200 font-bold font-outfit text-md uppercase tracking-wider group-hover:text-gold transition-colors">
                                {{ __('A/C') }}
                            </span>
                        </li>

                        <!-- Free Parking -->
                        <li class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-gold/10 text-gold border border-gold/20 rounded-xl flex items-center justify-center transition-all group-hover:scale-110 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <span class="text-slate-200 font-bold font-outfit text-md uppercase tracking-wider group-hover:text-gold transition-colors">
                                {{ __('Free Parking') }}
                            </span>
                        </li>
                    </ul>

                </div>

            </div>

            <!-- Photo Gallery Section -->
            @php
            $nombresBonitos = [
                __('Suite King Majestic'),
                __('Rincón de Descanso'),
                __('Confort Absoluto'),
                __('Baño de Lujo'),
                __('Iluminación Cálida'),
                __('Diseño Contemporáneo'),
                __('Detalles Elegantes'),
                __('Suite Presidencial King'),
                __('Ambiente Relajante'),
                __('Espacio Renovado'),
                __('Suite King Premium'),
                __('Comodidad Total'),
                __('Estilo Moderno'),
                __('Cama King Size'),
                __('Baño Privado Renovado'),
                __('Suite King Ejecutiva'),
                __('Acabados de Lujo'),
                __('Descanso Perfecto')
            ];
            @endphp
            <div id="photo-gallery" class="bg-[#0a1831]/90 p-8 sm:p-10 rounded-[2rem] border border-blue-950 shadow-2xl w-full mt-12 scroll-mt-24">
                <!-- Header -->
                <div class="border-b border-blue-950 pb-4 mb-8">
                    <h2 class="text-2xl font-black font-outfit text-white tracking-wide uppercase">{{ __('Galería de Fotos') }}</h2>
                    <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">{{ __('Conoce nuestros espacios completamente renovados') }}</p>
                </div>

                <!-- Grid Gallery -->
                @php
                    $images = glob(public_path('images/room_king.png (*).jpg'));
                    // Sort naturally to keep numeric order 1, 2, 10, etc.
                    natsort($images);
                    $images = array_values($images); 
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($images as $index => $imagePath)
                    @php 
                        $fileName = basename($imagePath);
                        $nombreActual = $nombresBonitos[$index % count($nombresBonitos)]; 
                    @endphp
                    <div class="group border border-blue-950 rounded-xl overflow-hidden aspect-[3/4] bg-navy-dark relative shadow-md" onclick="openLightbox('/images/{{ $fileName }}', '{{ $nombreActual }}')">
                        <img src="/images/{{ $fileName }}" loading="lazy" alt="{{ $nombreActual }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 cursor-pointer">
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-blue-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end items-center pointer-events-none pb-4">
                            <span class="text-white border border-white/30 bg-black/50 backdrop-blur-md px-3 py-1.5 rounded-lg font-bold font-outfit text-[10px] uppercase tracking-wider shadow-lg text-center mx-2">{{ $nombreActual }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </main>

        <!-- Bottom Contact Expedia-style Banner -->
        <footer class="w-full relative z-10 bg-[#0a1831] mt-12 border-t-2 border-gold/40 shadow-2xl">
            <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Phone Call Section -->
                <div class="flex items-center gap-4 group">
                    <a href="tel:+14077731461" class="w-12 h-12 bg-gold rounded-xl flex items-center justify-center text-navy shadow-lg shadow-gold/10 transition-transform group-hover:scale-105 duration-300">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </a>
                    <div class="flex flex-col">
                        <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest leading-none mb-1">{{ __('Any Question? Call') }}</span>
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
                        <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest leading-none mb-1">{{ __('Located At') }}</span>
                        <a href="https://maps.google.com/?q=4741+W+Irlo+Bronson+Memorial+Hwy,+Kissimmee,+FL+34746" target="_blank" class="text-white hover:text-gold transition-colors font-extrabold font-outfit text-xs sm:text-sm leading-snug">
                            4741 W Irlo Bronson Memorial Hwy, <br class="hidden sm:inline">Kissimmee, FL 34746
                        </a>
                    </div>
                </div>

            </div>
            
            <!-- Social Media Links -->
            <div class="w-full bg-[#0a1831] py-8">
                <div class="max-w-7xl mx-auto px-6 flex flex-col items-center justify-center gap-4">
                    <span class="text-slate-400 text-[11px] font-black uppercase tracking-widest">{{ __('Síguenos en nuestras redes') }}</span>
                    <div class="flex items-center gap-4">
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/profile.php?id=61590106737806" target="_blank" class="w-12 h-12 rounded-full bg-[#1877F2]/10 text-[#1877F2] border border-[#1877F2]/20 flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#1877F2]/30">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/kissmemotel192/" target="_blank" class="w-12 h-12 rounded-full bg-pink-500/10 text-pink-500 border border-pink-500/20 flex items-center justify-center hover:bg-gradient-to-tr hover:from-yellow-500 hover:via-pink-500 hover:to-purple-500 hover:text-white transition-all duration-300 hover:-translate-y-1 hover:border-transparent hover:shadow-lg hover:shadow-pink-500/30">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <!-- TikTok -->
                        <a href="https://www.tiktok.com/@chalet.motel.192" target="_blank" class="w-12 h-12 rounded-full bg-slate-100/10 text-white border border-slate-100/20 flex items-center justify-center hover:bg-black hover:text-white transition-all duration-300 hover:-translate-y-1 hover:border-transparent hover:shadow-[0_0_15px_rgba(37,244,238,0.4),-5px_5px_15px_rgba(254,44,85,0.4)]">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 2.78-1.15 5.54-3.14 7.49-1.95 1.94-4.8 2.98-7.53 2.56-2.52-.39-4.8-1.93-6.1-4.14C-1.22 19.8-.3 16.48 1.48 14.1c1.6-2.12 4.31-3.35 6.94-3.23v4.06c-1.46-.06-2.98.54-3.9 1.68-.84 1.05-.98 2.54-.53 3.79.52 1.43 1.97 2.44 3.49 2.53 1.5.09 3.03-.52 3.96-1.66.86-1.05 1.16-2.45 1.12-3.8V.02z"/></svg>
                        </a>
                        <!-- WhatsApp -->
                        <a href="https://wa.me/14077731461" class="w-12 h-12 rounded-full bg-[#25D366]/10 text-[#25D366] border border-[#25D366]/20 flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#25D366]/30">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.888-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.88-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.876 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Copyright Bar -->
            <div class="w-full bg-[#061021] py-4 text-center text-xs text-slate-500 border-t border-blue-950">
                <p>&copy; {{ date('Y') }} Chalet Motel 192. {{ __('Todos los derechos reservados.') }} Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
            </div>
        </footer>

        <!-- Lightbox Modal -->
        <div id="gallery-lightbox" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-sm hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300">
            <!-- Close Button -->
            <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white/50 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-all duration-300 z-[101]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <!-- Image Container -->
            <div class="relative max-w-5xl w-full max-h-[85vh] flex flex-col items-center px-4">
                <img id="lightbox-img" src="" alt="Gallery Image" class="max-w-full max-h-[75vh] object-contain rounded-lg shadow-2xl border border-white/10">
                
                <!-- Beautiful Name Title -->
                <div class="mt-6 text-center">
                    <span id="lightbox-title" class="text-2xl md:text-3xl font-black font-outfit text-gold uppercase tracking-widest drop-shadow-lg">
                        Nombre Bonito
                    </span>
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <div class="h-[1px] w-12 bg-gold/50"></div>
                        <span class="text-white/60 font-bold text-xs uppercase tracking-widest">Chalet Motel 192</span>
                        <div class="h-[1px] w-12 bg-gold/50"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lightbox Script -->
        <script>
            const lightbox = document.getElementById('gallery-lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxTitle = document.getElementById('lightbox-title');

            function openLightbox(src, title) {
                lightboxImg.src = src;
                lightboxTitle.textContent = title;
                lightbox.classList.remove('hidden');
                lightbox.style.display = 'flex';
                // Trigger reflow for animation
                void lightbox.offsetWidth;
                lightbox.classList.remove('opacity-0');
                lightbox.classList.add('opacity-100');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }

            function closeLightbox() {
                lightbox.classList.remove('opacity-100');
                lightbox.classList.add('opacity-0');
                setTimeout(() => {
                    lightbox.classList.add('hidden');
                    lightbox.style.display = '';
                    lightboxImg.src = '';
                    document.body.style.overflow = ''; // Restore scrolling
                }, 300);
            }

            // Close on click outside image
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) {
                    closeLightbox();
                }
            });
        </script>

        <x-chatbot />
    </body>
</html>
