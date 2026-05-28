<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Chalet Motel 192 - Motel Rentals</title>

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
                <a href="/" class="flex items-center gap-2 group">
                    <span class="text-xl font-black font-outfit tracking-wider text-white group-hover:text-gold transition-colors duration-300">
                        CHALET MOTEL 192
                    </span>
                </a>

                <nav class="flex items-center gap-3">
                    <a href="/nosotros" class="px-4 py-2 text-slate-300 hover:text-white font-semibold transition-all duration-300 text-sm">
                        Nosotros
                    </a>
                    <a href="{{ route('contact.create') }}" class="px-4 py-2 text-slate-300 hover:text-white font-semibold transition-all duration-300 text-sm">
                        Contacto
                    </a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-navy border border-blue-900/60 text-slate-200 hover:text-white rounded-xl font-medium transition-all duration-300 hover:bg-blue-950 flex items-center gap-2 text-sm">
                            <span>Mi Dashboard</span>
                        </a>
                    @endauth
                </nav>
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
                                MOTEL
                            </span>
                            <span class="block text-5xl sm:text-6.5xl font-black font-outfit text-gold leading-none tracking-tight">
                                RENTALS
                            </span>
                        </div>

                        <!-- Ribbon: LONG TERM STAYS -->
                        <div class="inline-block bg-[#0284c7] px-6 py-2 text-center text-white font-black font-outfit text-md sm:text-xl tracking-wider uppercase clip-ribbon shadow-lg shadow-sky-600/10 max-w-xs">
                            Long Term Stays
                        </div>

                        <!-- Duration Subheading -->
                        <div class="flex items-center gap-3 max-w-sm">
                            <div class="h-[1px] bg-gold/50 flex-grow"></div>
                            <span class="text-gold font-extrabold text-xs sm:text-sm tracking-widest whitespace-nowrap uppercase">
                                6 Month to 1 Year
                            </span>
                            <div class="h-[1px] bg-gold/50 flex-grow"></div>
                        </div>

                        <!-- Price -->
                        <div class="flex flex-col">
                            <span class="text-5xl sm:text-7xl font-black font-outfit text-gold leading-none">
                                $1,200
                            </span>
                            <div class="flex items-center gap-2 mt-0.5">
                                <div class="h-[1px] w-6 bg-white/40"></div>
                                <span class="text-white/70 font-extrabold uppercase tracking-widest text-[10px] sm:text-xs">
                                    Per Month
                                </span>
                                <div class="h-[1px] w-6 bg-white/40"></div>
                            </div>
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
                                <span class="block text-[13px] font-black font-outfit leading-tight uppercase text-navy">First</span>
                                <span class="block text-[18px] font-black font-outfit leading-none uppercase text-navy">Month</span>
                                <span class="block text-[18px] font-black font-outfit leading-none uppercase text-navy">Free!</span>
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
        </div>
        </section>

        <!-- Booking Search Bar (Overlapping) -->
        <div class="w-full max-w-7xl mx-auto px-6 -mt-8 relative z-20">
            <x-availability-search />
        </div>

        <!-- Main Content Area (Rooms Gallery & Amenities) -->
        <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-grow flex flex-col justify-center gap-12 relative z-10">

            <!-- Bottom Sections (Rooms Gallery & Amenities) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-[#0a1831]/90 p-8 sm:p-10 rounded-[2rem] border border-blue-950 shadow-2xl">
                
                <!-- Left Section (Gallery) -->
                <div class="lg:col-span-8 space-y-10">
                    
                    <!-- Title -->
                    <div class="border-b border-blue-950 pb-4">
                        <h2 class="text-2xl font-black font-outfit text-white tracking-wide uppercase">Nuestras Habitaciones</h2>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Espacios listos y equipados para tu comodidad</p>
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
                                <span class="text-white font-bold font-outfit text-lg uppercase tracking-wide">2 Kings Room</span>
                                <span class="text-gold font-extrabold text-xs uppercase tracking-widest bg-gold/10 px-2 py-0.5 rounded-full">Ready!</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="group border border-blue-950 rounded-2xl overflow-hidden aspect-[4/3] bg-navy-dark relative shadow-md">
                                <img src="/images/room_2kings.png" alt="2 Kings Bed Room" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 flex justify-between items-end">
                                    <span class="text-xs font-bold text-white uppercase tracking-wider">Dormitorio Principal</span>
                                </div>
                            </div>
                            <div class="group border border-blue-950 rounded-2xl overflow-hidden aspect-[4/3] bg-navy-dark relative shadow-md">
                                <img src="/images/bathroom.png" alt="2 Kings Bath Room" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 flex justify-between items-end">
                                    <span class="text-xs font-bold text-white uppercase tracking-wider">Baño Privado</span>
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
                                <span class="text-white font-bold font-outfit text-lg uppercase tracking-wide">More Rooms</span>
                                <span class="text-gold font-extrabold text-xs uppercase tracking-widest bg-gold/10 px-2 py-0.5 rounded-full">To Come!</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="group border border-blue-950 rounded-2xl overflow-hidden aspect-[4/3] bg-navy-dark relative shadow-md">
                                <img src="/images/room_king.png" alt="King Bed Room" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 flex justify-between items-end">
                                    <span class="text-xs font-bold text-white uppercase tracking-wider">King Suite</span>
                                </div>
                            </div>
                            <div class="border border-blue-900/20 border-dashed flex flex-col justify-center items-center p-6 text-center rounded-2xl aspect-[4/3] bg-[#081326]/40">
                                <svg class="w-10 h-10 text-blue-900/60 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="text-slate-400 font-bold text-xs uppercase tracking-wider">Próximas Suites</span>
                                <p class="text-slate-500 text-[10px] mt-1 max-w-[180px]">Estamos renovando más espacios exclusivos para ti.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Section (Amenities) -->
                <div class="lg:col-span-4 flex flex-col justify-start space-y-8 lg:pl-8 lg:border-l lg:border-blue-950">
                    
                    <!-- Header -->
                    <div class="border-b border-blue-950 pb-4">
                        <h2 class="text-2xl font-black font-outfit text-white tracking-wide uppercase">Servicios</h2>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Comodidades incluidas para tu estancia</p>
                    </div>

                    <!-- Amenities Checklist -->
                    <ul class="space-y-6">
                        <!-- Free Wifi -->
                        <li class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-gold/10 text-gold border border-gold/20 rounded-xl flex items-center justify-center transition-all group-hover:scale-110 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10.5 10.5 0 0114.14 0M1.414 8.05a16 16 0 0121.172 0" />
                                </svg>
                            </div>
                            <span class="text-slate-200 font-bold font-outfit text-md uppercase tracking-wider group-hover:text-gold transition-colors">
                                Free Wifi
                            </span>
                        </li>

                        <!-- Cable TV -->
                        <li class="flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-gold/10 text-gold border border-gold/20 rounded-xl flex items-center justify-center transition-all group-hover:scale-110 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <span class="text-slate-200 font-bold font-outfit text-md uppercase tracking-wider group-hover:text-gold transition-colors">
                                Cable TV
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
                                A/C
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
                                Free Parking
                            </span>
                        </li>
                    </ul>

                </div>

            </div>

        </main>

        <!-- Bottom Contact Expedia-style Banner -->
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
                        <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest leading-none mb-1">Any Question? Call</span>
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
                        <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest leading-none mb-1">Located At</span>
                        <span class="text-white font-extrabold font-outfit text-xs sm:text-sm leading-snug">
                            4743 W Irlo Bronson Memorial Hwy #192, <br class="hidden sm:inline">Kissimmee, FL 34746
                        </span>
                    </div>
                </div>

            </div>
            
            <!-- Bottom Copyright Bar -->
            <div class="w-full bg-[#061021] py-4 text-center text-xs text-slate-500 border-t border-blue-950">
                <p>&copy; {{ date('Y') }} Chalet Motel 192. Todos los derechos reservados. Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
            </div>
        </footer>

    </body>
</html>
