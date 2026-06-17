<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chalet Motel 192 - {{ __('Guía de Reciclaje') }}</title>
    
    <!-- Fonts from Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cantarell:ital,wght@0,400;0,700;1,400;1,700&family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                        cantarell: ['Cantarell', 'sans-serif'],
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
                        },
                        emerald: {
                            DEFAULT: '#10b981',
                            dark: '#047857',
                            light: '#34d399',
                        },
                        brand: {
                            DEFAULT: '#2b1fd1',
                            hover: '#1b0fb3',
                            light: '#f0efff',
                            dark: '#0f0761',
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .hero-recycling-banner {
            background-image: linear-gradient(to right, rgba(6, 16, 33, 0.98) 25%, rgba(6, 16, 33, 0.7) 60%, rgba(6, 16, 33, 0.2) 100%), url('/images/recycling_banner.png');
            background-size: cover;
            background-position: right 25% center;
        }
        .category-tab {
            border-color: #1e293b;
        }
        .active-tab {
            border-color: #34d399;
            background-color: rgba(16, 185, 129, 0.1);
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-[#040a17] text-slate-100 antialiased min-h-screen flex flex-col justify-between selection:bg-gold selection:text-navy">

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

    <!-- Main Tab Switcher -->
    <div class="w-full bg-[#061021] border-b border-blue-950 py-3 z-45 relative">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-start gap-4 overflow-x-auto whitespace-nowrap no-scrollbar py-1">
            <button id="main-tab-recycling" onclick="switchMainTab('recycling')" class="flex-shrink-0 px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2">
                <span>♻️</span> <span>{{ __('Reciclaje') }}</span>
            </button>
            <button id="main-tab-callcenter" onclick="switchMainTab('callcenter')" class="flex-shrink-0 px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2">
                <span>📞</span> <span>{{ __('Marketing / Call Center') }}</span>
            </button>
            <button id="main-tab-statistics" onclick="switchMainTab('statistics')" class="flex-shrink-0 px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2">
                <span>📈</span> <span>{{ __('Estadísticas') }}</span>
            </button>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- SECTION 1: GUEST RECYCLING GUIDE                          -->
    <!-- ========================================================= -->
    <div id="section-recycling" class="flex-grow flex flex-col justify-between">
        
        <!-- Hero Section -->
        <section class="max-w-7xl w-full mx-auto px-6 pt-8 pb-4 relative z-10">
            <div class="hero-recycling-banner w-full rounded-[2.5rem] border border-emerald-950/40 p-8 sm:p-12 min-h-[340px] flex items-center shadow-2xl relative overflow-hidden">
                <div class="absolute -top-20 -left-20 w-80 h-80 bg-emerald-700/10 rounded-full filter blur-3xl pointer-events-none"></div>

                <div class="max-w-2xl flex flex-col space-y-4 relative z-10">
                    <div class="flex items-center gap-2">
                        <span class="h-[1px] w-8 bg-emerald-400"></span>
                        <span class="text-emerald-400 font-extrabold text-xs uppercase tracking-widest">
                            {{ __('Por un Entorno Verde y Limpio') }}
                        </span>
                    </div>
                    <h1 class="text-4xl sm:text-5.5xl font-black font-outfit text-white uppercase tracking-tight">
                        @if(app()->getLocale() == 'en')
                            Recycling <span class="text-emerald-400">Guide</span>
                        @else
                            Guía de <span class="text-emerald-400">Reciclaje</span>
                        @endif
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        {{ __('En Chalet Motel 192, estamos comprometidos con la sostenibilidad y la preservación de nuestra comunidad en Kissimmee. Ayúdanos a reciclar de manera correcta siguiendo esta guía interactiva.') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-grow flex flex-col gap-12 relative z-10 text-slate-100">
            <!-- Staff Logging Section -->
                <!-- Header -->
                <div class="border-b border-blue-950 pb-4 mb-6">
                    <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide">
                        {{ __('Registro de Recolección') }}
                    </h2>
                    <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">
                        {{ __('Ingresa los datos de recolección diaria de bolsas de reciclaje') }}
                    </p>
                </div>

                <!-- Logging Form -->
                <div id="logger-unlocked-view" class="space-y-6">
                    <form id="guest-recycling-log-form" onsubmit="guestSubmitRecyclingLog(event)" class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Date Input (4 cols) -->
                        <div class="md:col-span-4 flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Fecha') }}</label>
                            <input type="date" id="guest-log-date" required class="w-full bg-[#061021]/80 border border-blue-950 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all">
                        </div>

                        <!-- Store Autocomplete Search (8 cols) -->
                        <div class="md:col-span-8 flex flex-col space-y-2 relative">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Tienda / Origen') }}</label>
                            <div class="relative">
                                <input type="text" id="guest-log-store" required autocomplete="off" placeholder="{{ __('Buscar tienda o escribir nueva...') }}" oninput="guestFilterStores()" onfocus="guestShowStoresDropdown()" onblur="guestHideStoresDropdown()" class="w-full bg-[#061021]/80 border border-blue-950 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition-all">
                                <button type="button" onclick="guestToggleStoresDropdown(event)" class="absolute right-3 top-3 text-slate-500 hover:text-slate-300">
                                    ▼
                                </button>
                            </div>
                            <!-- Autocomplete Dropdown List -->
                            <div id="guest-stores-dropdown" class="hidden absolute left-0 right-0 top-[4.5rem] bg-[#061021] border border-blue-950 rounded-xl max-h-60 overflow-y-auto z-50 shadow-2xl py-2">
                                <div id="guest-stores-list-container" class="flex flex-col">
                                    <!-- Dynamic Store list items -->
                                </div>
                                <div id="guest-add-new-store-btn" class="hidden border-t border-blue-950/60 p-2">
                                    <button type="button" onmousedown="guestAddNewStore()" class="w-full text-left px-3 py-2 text-xs font-bold text-emerald-400 hover:bg-emerald-950/20 rounded-lg transition-all flex items-center gap-2">
                                        <span>✚</span> <span>{{ __('Agregar como nueva tienda') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Big Bags (4 cols) -->
                        <div class="md:col-span-4 flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Bolsas Grandes (BIG)') }}</label>
                            <div class="flex items-center bg-[#061021]/80 border border-blue-950 rounded-xl overflow-hidden">
                                <button type="button" onclick="guestAdjustCount('guest-log-big', -1)" class="px-4 py-3 text-slate-400 hover:text-white hover:bg-blue-950/40 font-bold text-lg select-none transition-all">-</button>
                                <input type="number" id="guest-log-big" required min="0" value="0" oninput="guestCalculateTotal()" class="w-full bg-transparent border-none text-center text-sm text-white focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <button type="button" onclick="guestAdjustCount('guest-log-big', 1)" class="px-4 py-3 text-slate-400 hover:text-white hover:bg-blue-950/40 font-bold text-lg select-none transition-all">+</button>
                            </div>
                        </div>

                        <!-- Small Bags (4 cols) -->
                        <div class="md:col-span-4 flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Bolsas Pequeñas (SMALL)') }}</label>
                            <div class="flex items-center bg-[#061021]/80 border border-blue-950 rounded-xl overflow-hidden">
                                <button type="button" onclick="guestAdjustCount('guest-log-small', -1)" class="px-4 py-3 text-slate-400 hover:text-white hover:bg-blue-950/40 font-bold text-lg select-none transition-all">-</button>
                                <input type="number" id="guest-log-small" required min="0" value="0" oninput="guestCalculateTotal()" class="w-full bg-transparent border-none text-center text-sm text-white focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <button type="button" onclick="guestAdjustCount('guest-log-small', 1)" class="px-4 py-3 text-slate-400 hover:text-white hover:bg-blue-950/40 font-bold text-lg select-none transition-all">+</button>
                            </div>
                        </div>

                        <!-- Total Bags (4 cols) -->
                        <div class="md:col-span-4 flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Total (BIG + SMALL)') }}</label>
                            <input type="number" id="guest-log-total" required min="0" value="0" class="w-full bg-[#061021]/50 border border-blue-950 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all font-black">
                        </div>

                        <!-- Submit Button (12 cols) -->
                        <div class="md:col-span-12 flex justify-end pt-2">
                            <button type="submit" id="guest-log-submit-btn" class="w-full sm:w-auto px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-[#061021] font-black font-outfit rounded-xl transition-all duration-300 text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/10 flex items-center justify-center gap-2">
                                <span id="guest-submit-btn-spinner" class="hidden animate-spin h-4 w-4 border-2 border-[#061021] border-t-transparent rounded-full"></span>
                                <span id="guest-submit-btn-text">{{ __('Guardar Registro') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- PIN Unlock Modal Removed -->

        </main>

        <!-- Guest View Footer -->
        <footer class="w-full relative z-10 bg-[#0a1831] border-t-2 border-gold/40 shadow-2xl">
            <!-- Bottom Copyright Bar -->
            <div class="w-full bg-[#061021] py-4 text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Chalet Motel 192. {{ __('Todos los derechos reservados.') }} Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
            </div>
        </footer>
    </div>


    <!-- ========================================================= -->
    <!-- SECTION 2: MARKETING / CALL CENTER                       -->
    <!-- ========================================================= -->
    <div id="section-callcenter" class="flex-grow flex flex-col justify-between hidden">
        <!-- Main Container -->
        <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 py-8 flex-grow space-y-8 text-slate-800">

            <!-- Navbar Local to call center -->
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">♻️</span>
                    <div>
                        <h1 class="text-lg font-black font-outfit text-brand tracking-tight">Ameritex Diversion Inc.</h1>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ __('Portal de Reciclaje Textil') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">
                        {{ __('Directorio Logístico - Jovancito') }}
                    </span>
                </div>
            </div>

            <!-- Session Status Messages -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm">
                    <span>✅</span> <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm">
                    <span>❌</span> <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Create Store Form Card -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black font-outfit text-slate-900 tracking-tight">{{ __('Agregar Nueva Tienda al Directorio') }}</h3>
                        <p class="text-xs text-slate-500">{{ __('Crea una nueva ubicación de reciclaje en la base de datos de Google Sheets.') }}</p>
                    </div>
                    <span class="text-xs bg-brand/10 text-brand px-3 py-1 rounded-full font-bold uppercase tracking-wider">{{ __('Formulario de Registro') }}</span>
                </div>
                
                <form action="{{ route('recycling.save') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-4">
                    @csrf
                    <!-- Nombre (3 cols) -->
                    <div class="md:col-span-3 flex flex-col space-y-1">
                        <label for="nombre" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">{{ __('Nombre de la Tienda') }}</label>
                        <input type="text" name="nombre" id="nombre" required placeholder="{{ __('Ej. Exxon DeLand') }}" value="{{ old('nombre') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                    </div>

                    <!-- Teléfono (2 cols) -->
                    <div class="md:col-span-2 flex flex-col space-y-1">
                        <label for="telefono" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">{{ __('Teléfono') }}</label>
                        <input type="text" name="telefono" id="telefono" required placeholder="{{ __('Ej. (386) 555-0192') }}" value="{{ old('telefono') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                    </div>

                    <!-- Web / Enlace (3 cols) -->
                    <div class="md:col-span-3 flex flex-col space-y-1">
                        <label for="web" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">{{ __('Sitio Web (Enlace)') }}</label>
                        <input type="text" name="web" id="web" required placeholder="{{ __('Ej. https://exxon.com o #') }}" value="{{ old('web', '#') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                    </div>

                    <!-- Empresa (2 cols) -->
                    <div class="md:col-span-2 flex flex-col space-y-1">
                        <label for="empresa" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">{{ __('Empresa / Tipo') }}</label>
                        <input type="text" name="empresa" id="empresa" required placeholder="{{ __('Ej. Gasolineras') }}" value="{{ old('empresa') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                    </div>

                    <!-- Ruta (1 col) -->
                    <div class="md:col-span-1 flex flex-col space-y-1">
                        <label for="ruta" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">{{ __('Ruta') }}</label>
                        <select name="ruta" id="ruta" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                            <option value="Volusia" {{ old('ruta') == 'Volusia' ? 'selected' : '' }}>Volusia</option>
                            <option value="Orlando" {{ old('ruta') == 'Orlando' ? 'selected' : '' }}>Orlando</option>
                            <option value="Kissimmee" {{ old('ruta') == 'Kissimmee' ? 'selected' : '' }}>Kissimmee</option>
                            <option value="Lakeland" {{ old('ruta') == 'Lakeland' ? 'selected' : '' }}>Lakeland</option>
                            <option value="Miami" {{ old('ruta') == 'Miami' ? 'selected' : '' }}>Miami</option>
                            <option value="Ft. Lauderdale" {{ old('ruta') == 'Ft. Lauderdale' ? 'selected' : '' }}>Ft. Lauderdale</option>
                        </select>
                    </div>

                    <!-- Alerta (1 col) -->
                    <div class="md:col-span-1 flex flex-col space-y-1">
                        <label for="alerta" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">{{ __('Alerta') }}</label>
                        <select name="alerta" id="alerta" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                            <option value="No" {{ old('alerta') == 'No' ? 'selected' : '' }}>{{ __('No') }}</option>
                            <option value="Sí" {{ old('alerta') == 'Sí' ? 'selected' : '' }}>{{ __('Sí') }}</option>
                        </select>
                    </div>

                    <!-- Submit Button (12 cols) -->
                    <div class="md:col-span-12 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-brand hover:bg-brand-hover text-white font-bold font-outfit rounded-xl text-xs uppercase tracking-wider transition-all duration-300 shadow-md shadow-brand/10 hover:shadow-brand/20">
                            {{ __('Guardar Tienda') }}
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Welcome Card & Global Controls -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-1">
                    <h2 class="text-2xl font-black font-outfit text-slate-900 tracking-tight">{{ __('Directorio de 100 Tiendas') }}</h2>
                    <p class="text-sm text-slate-500">{{ __('Busca tiendas por ruta o empresa y registra las bolsas de reciclaje recolectadas directamente en Google Sheets.') }}</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Manual Entry Button -->
                    <button onclick="openLogModal(null)" class="px-5 py-3 bg-brand hover:bg-brand-hover text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all duration-300 shadow-md shadow-brand/10 hover:shadow-brand/20 flex items-center justify-center gap-2">
                        <span>➕</span> <span>{{ __('Registro Manual') }}</span>
                    </button>
                </div>
            </div>

            <!-- Filter and Search Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- View Toggle -->
                <div class="flex bg-slate-100 p-1 rounded-xl w-full md:w-auto">
                    <button id="toggle-ruta" onclick="cambiarVista('ruta')" class="flex-1 md:flex-none px-6 py-2.5 bg-white text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300 shadow-sm">
                        {{ __('Por Ruta') }}
                    </button>
                    <button id="toggle-empresa" onclick="cambiarVista('empresa')" class="flex-1 md:flex-none px-6 py-2.5 text-slate-500 hover:text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300">
                        {{ __('Por Empresa') }}
                    </button>
                </div>

                <!-- Live Search Input -->
                <div class="relative w-full md:max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        🔍
                    </span>
                    <input type="text" id="search-input" oninput="filterDirectory()" placeholder="{{ __('Buscar por nombre, teléfono, ruta o empresa...') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-brand transition-all">
                </div>
            </div>

            <!-- Directory Render Container -->
            <div id="directorio" class="space-y-6">
                <!-- Dynamically populated via JS -->
            </div>
        </main>

        <!-- Directory Footer -->
        <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
            <p>&copy; {{ date('Y') }} Ameritex Diversion Inc. &bull; {{ __('Directorio Logístico 100') }}</p>
        </footer>
    </div>

    <!-- ========================================================= -->
    <!-- SECTION 3: STATISTICS                                     -->
    <!-- ========================================================= -->
    <div id="section-statistics" class="flex-grow flex flex-col justify-between hidden">
        <!-- Main Container -->
        <main class="max-w-7xl w-full mx-auto px-6 py-8 flex-grow space-y-8 text-slate-100">
            <!-- Header -->
            <div class="border-b border-blue-950 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide">
                        {{ __('Panel de Estadísticas') }}
                    </h2>
                    <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">
                        {{ __('Visualiza los consolidados y detalles de reciclaje acumulados') }}
                    </p>
                </div>
                
                <!-- Date Filters Form -->
                <div class="flex flex-wrap items-center gap-3 bg-[#061021]/80 border border-blue-950 p-2.5 rounded-2xl">
                    <!-- Quick Filters -->
                    <div class="flex items-center gap-1 border-r border-blue-950/60 pr-2">
                        <button onclick="setStatsQuickRange(7)" class="text-[10px] font-bold text-slate-400 hover:text-white hover:bg-blue-950/50 px-2.5 py-1.5 rounded-lg transition-colors uppercase tracking-wider">{{ __('7 Días') }}</button>
                        <button onclick="setStatsQuickRange(30)" class="text-[10px] font-bold text-slate-400 hover:text-white hover:bg-blue-950/50 px-2.5 py-1.5 rounded-lg transition-colors uppercase tracking-wider">{{ __('30 Días') }}</button>
                        <button onclick="setStatsQuickRange('month')" class="text-[10px] font-bold text-slate-400 hover:text-white hover:bg-blue-950/50 px-2.5 py-1.5 rounded-lg transition-colors uppercase tracking-wider">{{ __('Mes') }}</button>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ __('Desde') }}</label>
                        <input type="date" id="stats-start-date" onchange="loadStatistics()" class="bg-[#040a17] border border-blue-950 rounded-lg px-2 py-1 text-xs text-white focus:outline-none focus:border-gold">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ __('Hasta') }}</label>
                        <input type="date" id="stats-end-date" onchange="loadStatistics()" class="bg-[#040a17] border border-blue-950 rounded-lg px-2 py-1 text-xs text-white focus:outline-none focus:border-gold">
                    </div>
                    <button onclick="clearStatsDates()" class="text-xs font-bold text-slate-400 hover:text-white px-2 py-1 border border-blue-950 rounded-lg transition-colors">
                        {{ __('Limpiar') }}
                    </button>
                </div>
            </div>

            <!-- Summary Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Total Bags -->
                <div class="bg-gradient-to-br from-gold/20 to-gold/5 border border-gold/20 rounded-[2rem] p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute right-4 top-4 text-3xl opacity-20 select-none group-hover:scale-110 transition-transform duration-300">📦</div>
                    <span class="text-[10px] font-black text-gold uppercase tracking-widest">{{ __('Total Bolsas Recolectadas') }}</span>
                    <h3 id="stat-card-total" class="text-4xl font-black font-outfit text-white mt-2">0</h3>
                    <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">{{ __('Bolsas Totales') }}</p>
                </div>

                <!-- Card 2: Big Bags -->
                <div class="bg-gradient-to-br from-emerald-500/20 to-emerald-500/5 border border-emerald-950/40 rounded-[2rem] p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute right-4 top-4 text-3xl opacity-20 select-none group-hover:scale-110 transition-transform duration-300">🟢</div>
                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">{{ __('Bolsas Grandes') }}</span>
                    <h3 id="stat-card-big" class="text-4xl font-black font-outfit text-white mt-2">0</h3>
                    <p id="stat-card-big-percent" class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">0% {{ __('del total') }}</p>
                </div>

                <!-- Card 3: Small Bags -->
                <div class="bg-gradient-to-br from-blue-500/20 to-blue-500/5 border border-blue-950 rounded-[2rem] p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute right-4 top-4 text-3xl opacity-20 select-none group-hover:scale-110 transition-transform duration-300">🔵</div>
                    <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest">{{ __('Bolsas Pequeñas') }}</span>
                    <h3 id="stat-card-small" class="text-4xl font-black font-outfit text-white mt-2">0</h3>
                    <p id="stat-card-small-percent" class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">0% {{ __('del total') }}</p>
                </div>

                <!-- Card 4: Daily Logged Count -->
                <div class="bg-gradient-to-br from-purple-500/20 to-purple-500/5 border border-purple-950 rounded-[2rem] p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute right-4 top-4 text-3xl opacity-20 select-none group-hover:scale-110 transition-transform duration-300">📋</div>
                    <span class="text-[10px] font-black text-purple-400 uppercase tracking-widest">{{ __('Total Registros') }}</span>
                    <h3 id="stat-card-count" class="text-4xl font-black font-outfit text-white mt-2">0</h3>
                    <p id="stat-card-count-label" class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">{{ __('Días Registrados') }}</p>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Chart A: Temporal Trend -->
                <div class="lg:col-span-7 bg-[#061021]/60 border border-blue-950 rounded-[2rem] p-6 shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="border-b border-blue-950 pb-3 mb-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black font-outfit text-white tracking-tight uppercase">{{ __('Tendencia Temporal') }}</h3>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider">{{ __('Evolución histórica de recolección por fecha') }}</p>
                            </div>
                            <span class="text-[10px] bg-emerald-500/10 text-emerald-400 px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">{{ __('Línea de Tiempo') }}</span>
                        </div>
                        <div class="w-full relative h-[300px]">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart B: Route/Company/Store Distribution -->
                <div class="lg:col-span-5 bg-[#061021]/60 border border-blue-950 rounded-[2rem] p-6 shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="border-b border-blue-950 pb-3 mb-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black font-outfit text-white tracking-tight uppercase">{{ __('Distribución de Bolsas') }}</h3>
                                <p id="dist-subtitle" class="text-[10px] text-slate-400 uppercase tracking-wider">{{ __('Proporción acumulada por ruta o empresa') }}</p>
                            </div>
                            <!-- Distribution Toggle Button -->
                            <div class="flex bg-blue-950/40 p-0.5 rounded-lg border border-blue-900/60 shrink-0">
                                <button id="dist-toggle-ruta" onclick="switchDistributionChart('ruta')" class="px-2.5 py-1 bg-gold text-[#061021] font-bold rounded-md text-[9px] uppercase tracking-wider transition-all duration-200">
                                    {{ __('Ruta') }}
                                </button>
                                <button id="dist-toggle-empresa" onclick="switchDistributionChart('empresa')" class="px-2.5 py-1 text-slate-400 hover:text-white font-bold rounded-md text-[9px] uppercase tracking-wider transition-all duration-200">
                                    {{ __('Empresa') }}
                                </button>
                                <button id="dist-toggle-tienda" onclick="switchDistributionChart('tienda')" class="px-2.5 py-1 text-slate-400 hover:text-white font-bold rounded-md text-[9px] uppercase tracking-wider transition-all duration-200">
                                    {{ __('Tienda') }}
                                </button>
                            </div>
                        </div>
                        <div class="w-full relative h-[300px] flex items-center justify-center">
                            <canvas id="distributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Top Locations -->
                <div class="lg:col-span-7 bg-[#061021]/60 border border-blue-950 rounded-[2rem] p-6 shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="border-b border-blue-950 pb-3 mb-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black font-outfit text-white tracking-tight uppercase">{{ __('Ubicaciones Destacadas') }}</h3>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider">{{ __('Total acumulado por tienda u origen — mayor a menor') }}</p>
                            </div>
                            <span class="text-[10px] bg-gold/10 text-gold px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">🏆 {{ __('Ranking') }}</span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-blue-950/20 border-b border-blue-950 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                        <th class="px-4 py-3 font-bold w-8">#</th>
                                        <th class="px-4 py-3 font-bold">{{ __('Tienda / Origen') }}</th>
                                        <th class="px-4 py-3 font-bold text-center">{{ __('Grandes') }}</th>
                                        <th class="px-4 py-3 font-bold text-center">{{ __('Pequeñas') }}</th>
                                        <th class="px-4 py-3 font-bold text-right">{{ __('Total') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="stats-locations-table-body" class="divide-y divide-blue-950/40 text-slate-300 font-medium">
                                    <!-- Dynamic rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Logs Timeline -->
                <div class="lg:col-span-5 bg-[#061021]/60 border border-blue-950 rounded-[2rem] p-6 shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="border-b border-blue-950 pb-3 mb-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black font-outfit text-white tracking-tight uppercase">{{ __('Historial Reciente') }}</h3>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider">{{ __('Últimos 20 registros ingresados') }}</p>
                            </div>
                            <span class="text-[10px] bg-emerald-500/10 text-emerald-400 px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">📋 {{ __('Registro') }}</span>
                        </div>
                        
                        <div id="stats-recent-logs-list" class="space-y-3 max-h-[350px] overflow-y-auto pr-1">
                            <!-- Dynamic logs -->
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Stats Footer -->
        <footer class="w-full bg-[#0a1831] border-t-2 border-gold/40 shadow-2xl">
            <div class="w-full bg-[#061021] py-4 text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Chalet Motel 192 &bull; {{ __('Consolidado de Estadísticas') }}</p>
            </div>
        </footer>
    </div>

    <!-- Form Logger Modal (Directory Log Modal) -->
    <div id="log-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-6 shadow-2xl relative">
            <button onclick="closeLogModal()" class="absolute right-5 top-5 text-slate-400 hover:text-slate-600 transition-colors text-lg font-bold">
                ✕
            </button>
            
            <div class="space-y-1 text-slate-800">
                <span class="text-xs font-bold text-brand uppercase tracking-widest">{{ __('Ameritex Sheets Logger') }}</span>
                <h3 class="text-xl font-black font-outfit text-slate-900 uppercase tracking-tight">
                    {{ __('Registrar Recolección') }}
                </h3>
                <p class="text-xs text-slate-500">{{ __('Ingresa la cantidad de bolsas recolectadas para esta ubicación.') }}</p>
            </div>

            <form id="recycling-log-form" onsubmit="submitRecyclingLog(event)" class="space-y-4">
                <!-- Date Input -->
                <div class="flex flex-col space-y-1.5 text-slate-800">
                    <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">{{ __('Fecha de Recolección') }}</label>
                    <input type="date" id="log-date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                </div>

                <!-- Store Input (Read-only if selected, editable if manual) -->
                <div class="flex flex-col space-y-1.5 text-slate-800">
                    <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">{{ __('Tienda / Ubicación') }}</label>
                    <input type="text" id="log-store" required placeholder="{{ __('Nombre de la tienda...') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4 text-slate-800">
                    <!-- Big Bags -->
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">{{ __('Bolsas Grandes (BIG)') }}</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                            <button type="button" onclick="adjustCount('log-big', -1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">-</button>
                            <input type="number" id="log-big" required min="0" value="0" oninput="calculateTotal()" class="w-full bg-transparent border-none text-center text-sm font-bold text-slate-800 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" onclick="adjustCount('log-big', 1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">+</button>
                        </div>
                    </div>

                    <!-- Small Bags -->
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">{{ __('Bolsas Pequeñas (SMALL)') }}</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                            <button type="button" onclick="adjustCount('log-small', -1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">-</button>
                            <input type="number" id="log-small" required min="0" value="0" oninput="calculateTotal()" class="w-full bg-transparent border-none text-center text-sm font-bold text-slate-800 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" onclick="adjustCount('log-small', 1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">+</button>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="flex flex-col space-y-1.5 text-slate-800">
                    <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">{{ __('Total de Bolsas') }}</label>
                    <input type="number" id="log-total" required min="0" value="0" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none font-black">
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="log-submit-btn" class="w-full py-3.5 bg-brand hover:bg-brand-hover text-white font-black font-outfit rounded-xl transition-all duration-300 text-xs uppercase tracking-wider shadow-lg shadow-brand/10 hover:shadow-brand/20 flex items-center justify-center gap-2">
                        <span id="submit-btn-spinner" class="hidden animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                        <span id="submit-btn-text">{{ __('Enviar a Google Sheets') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Chatbot widget helper -->
    <x-chatbot />

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        // Localization Data for JS Components
        const currentLang = "{{ app()->getLocale() }}";
        const apiBaseUrl = "{{ url('/') }}";
        
        // ----------------------------------------------------
        // GUEST VIEW SCRIPTS & TRANSLATIONS
        // ----------------------------------------------------

        // GUEST VIEW LOGGING SCRIPTS
        let guestStores = [];

        function guestLoadStores() {
            fetch(`${apiBaseUrl}/api/recycling/stores`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        guestStores = data.stores;
                        guestRenderStoresList();
                    }
                })
                .catch(err => console.error("Error loading stores:", err));
        }

        function guestRenderStoresList(filterText = '') {
            const listContainer = document.getElementById('guest-stores-list-container');
            listContainer.innerHTML = '';
            
            const filtered = guestStores.filter(store => 
                store.toLowerCase().includes(filterText.toLowerCase())
            );

            if (filtered.length === 0) {
                listContainer.innerHTML = `
                    <div class="px-4 py-3 text-xs text-slate-500 italic">
                        ${currentLang === 'es' ? 'No se encontraron tiendas' : 'No stores found'}
                    </div>
                `;
                document.getElementById('guest-add-new-store-btn').classList.remove('hidden');
            } else {
                document.getElementById('guest-add-new-store-btn').classList.add('hidden');
                filtered.forEach(store => {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className = "w-full text-left px-4 py-2.5 text-xs text-slate-300 hover:text-white hover:bg-blue-950/40 transition-colors";
                    item.textContent = store;
                    item.onmousedown = () => guestSelectStore(store);
                    listContainer.appendChild(item);
                });
            }
        }

        function guestShowStoresDropdown() {
            document.getElementById('guest-stores-dropdown').classList.remove('hidden');
            guestRenderStoresList(document.getElementById('guest-log-store').value);
        }

        function guestHideStoresDropdown() {
            setTimeout(() => {
                document.getElementById('guest-stores-dropdown').classList.add('hidden');
            }, 200);
        }

        function guestToggleStoresDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('guest-stores-dropdown');
            if (dropdown.classList.contains('hidden')) {
                document.getElementById('guest-log-store').focus();
            } else {
                dropdown.classList.add('hidden');
            }
        }

        function guestFilterStores() {
            const text = document.getElementById('guest-log-store').value;
            guestRenderStoresList(text);
        }

        function guestSelectStore(storeName) {
            document.getElementById('guest-log-store').value = storeName;
            document.getElementById('guest-stores-dropdown').classList.add('hidden');
        }

        function guestAddNewStore() {
            const newStore = document.getElementById('guest-log-store').value.trim();
            if (newStore && !guestStores.includes(newStore)) {
                guestStores.push(newStore);
                guestStores.sort((a, b) => a.localeCompare(b));
                guestSelectStore(newStore);
            }
        }

        function guestAdjustCount(inputId, amount) {
            const input = document.getElementById(inputId);
            let current = parseInt(input.value) || 0;
            current = Math.max(0, current + amount);
            input.value = current;
            guestCalculateTotal();
        }

        function guestCalculateTotal() {
            const big = parseInt(document.getElementById('guest-log-big').value) || 0;
            const small = parseInt(document.getElementById('guest-log-small').value) || 0;
            document.getElementById('guest-log-total').value = big + small;
        }

        function guestSubmitRecyclingLog(event) {
            event.preventDefault();
            
            const submitBtn = document.getElementById('guest-log-submit-btn');
            const spinner = document.getElementById('guest-submit-btn-spinner');
            const btnText = document.getElementById('guest-submit-btn-text');

            submitBtn.disabled = true;
            spinner.classList.remove('hidden');
            btnText.textContent = currentLang === 'es' ? 'Guardando...' : 'Saving...';

            const logData = {
                date: document.getElementById('guest-log-date').value,
                store: document.getElementById('guest-log-store').value,
                big: parseInt(document.getElementById('guest-log-big').value) || 0,
                small: parseInt(document.getElementById('guest-log-small').value) || 0,
                total: parseInt(document.getElementById('guest-log-total').value) || 0,
            };

            fetch(`${apiBaseUrl}/api/recycling/log`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(logData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(currentLang === 'es' ? '¡Registro guardado con éxito!' : 'Log saved successfully!');
                    document.getElementById('guest-log-store').value = '';
                    document.getElementById('guest-log-big').value = 0;
                    document.getElementById('guest-log-small').value = 0;
                    document.getElementById('guest-log-total').value = 0;
                    guestLoadStores();
                    loadStatistics();
                } else {
                    alert((currentLang === 'es' ? 'Error: ' : 'Error: ') + data.message);
                }
            })
            .catch(err => {
                console.error("Error submitting log:", err);
                alert(currentLang === 'es' ? 'Error de conexión con el servidor.' : 'Server connection error.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                spinner.classList.add('hidden');
                btnText.textContent = currentLang === 'es' ? 'Guardar Registro' : 'Save Log';
            });
        }


        // ----------------------------------------------------
        // DIRECTORY / CALL CENTER LOG SYSTEM SCRIPTS
        // ----------------------------------------------------
        const customStores = @json($customStores ?? []);
        const lista = [
            // RUTA: Volusia (Alertas)
            {n: "Epiphany Thrift Store ⚠️", t: "(386) 775-6800", w: "https://epiphanythrift.com", a: true, r: "Volusia", e: "Independiente"},
            {n: "Neighborhood of West Volusia ⚠️", t: "(386) 734-8120", w: "https://neighborhoodcenterwv.org", a: true, r: "Volusia", e: "Independiente"},
            {n: "Out Father's Closet ⚠️", t: "(386) 218-4720", w: "https://outfatherscloset.org", a: true, r: "Volusia", e: "Independiente"},
            {n: "Citgo / Punto Conv. ⚠️", t: "N/A", w: "#", a: true, r: "Volusia", e: "Gasolineras"},
            {n: "Habitat ReStore (DeLand)", t: "(386) 279-0622", w: "https://habitatvolusia.org", a: false, r: "Volusia", e: "Habitat for Humanity"},
            {n: "West Volusia Habitat", t: "(386) 734-7170", w: "https://habitatvolusia.org", a: false, r: "Volusia", e: "Habitat for Humanity"},
            {n: "Salvation Army (Deltona)", t: "(386) 574-8666", w: "https://salvationarmyflorida.org", a: false, r: "Volusia", e: "Salvation Army"},
            {n: "Goodwill (Orange City)", t: "(386) 774-5660", w: "https://goodwillcfl.org", a: false, r: "Volusia", e: "Goodwill"},
            {n: "St. Vincent de Paul (Sanford)", t: "(407) 330-4400", w: "https://svdporlando.org", a: false, r: "Volusia", e: "St. Vincent de Paul"},
            {n: "Salvation Army (Sanford)", t: "(407) 322-2642", w: "https://salvationarmyflorida.org", a: false, r: "Volusia", e: "Salvation Army"},
            {n: "Founders Thrift (Lake Mary)", t: "(407) 330-9494", w: "https://foundersthrift.com", a: false, r: "Volusia", e: "Independiente"},
            {n: "Goodwill Xpress (Lake Mary)", t: "(407) 333-2895", w: "https://goodwillcfl.org", a: false, r: "Volusia", e: "Goodwill"},
            {n: "Helping Hand (Eustis)", t: "(352) 589-5654", w: "https://helpinghand.org", a: false, r: "Volusia", e: "Independiente"},
            {n: "Community Thrift (Leesburg)", t: "(352) 326-0000", w: "https://communitythrift.org", a: false, r: "Volusia", e: "Independiente"},
            {n: "Apopka Thrift", t: "(407) 886-0000", w: "https://apopkathrift.com", a: false, r: "Volusia", e: "Independiente"},
            {n: "St. Vincent de Paul (Apopka)", t: "(407) 886-1793", w: "https://svdporlando.org", a: false, r: "Volusia", e: "St. Vincent de Paul"},
            
            // RUTA: Orlando
            {n: "Mustard Seed", t: "(407) 875-2040", w: "https://mustardseedfla.org", a: false, r: "Orlando", e: "Mustard Seed"},
            {n: "Out of the Closet", t: "(407) 583-4916", w: "https://outofthecloset.org", a: false, r: "Orlando", e: "Out of the Closet"},
            {n: "UCP Thrift Store", t: "(407) 852-3300", w: "https://ucponline.org", a: false, r: "Orlando", e: "UCP"},
            {n: "Rescue Mission Thrift", t: "(407) 422-4855", w: "https://orlandorescuemission.org", a: false, r: "Orlando", e: "Rescue Mission"},
            {n: "Amvets Thrift Store", t: "(407) 290-2812", w: "https://amvets.org", a: false, r: "Orlando", e: "Amvets"},
            {n: "Goodwill (Winter Park)", t: "(407) 628-1111", w: "https://goodwillcfl.org", a: false, r: "Orlando", e: "Goodwill"},
            {n: "Hope & Help Thrift", t: "(407) 645-2533", w: "https://hopeandhelp.org", a: false, r: "Orlando", e: "Hope & Help"},
            {n: "Discovery Shop", t: "(407) 629-9114", w: "https://cancer.org", a: false, r: "Orlando", e: "ACS"},
            {n: "Pet Thrift Shop", t: "(407) 644-4860", w: "https://petthriftshop.com", a: false, r: "Orlando", e: "Independiente"},
            {n: "Christian Sharing Center", t: "(407) 260-9155", w: "https://thesharingcenter.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Second Harvest", t: "(407) 295-1066", w: "https://feedhopenow.org", a: false, r: "Orlando", e: "Food Bank"},
            {n: "Thrift Boutique", t: "(407) 896-0101", w: "https://thriftboutique.com", a: false, r: "Orlando", e: "Independiente"},
            {n: "Jewish Family Services", t: "(407) 644-7671", w: "https://jfsorlando.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "St. Vincent de Paul (Orlando)", t: "(407) 859-0099", w: "https://svdporlando.org", a: false, r: "Orlando", e: "St. Vincent de Paul"},
            {n: "Thrift Mart", t: "(407) 246-0000", w: "https://thriftmart.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Sunshine Thrift", t: "(407) 425-0000", w: "https://sunshinethrift.com", a: false, r: "Orlando", e: "Sunshine Thrift"},
            {n: "Care & Share", t: "(407) 896-0000", w: "https://careandshare.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Unity Thrift", t: "(407) 843-0000", w: "https://unitythrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Joy Thrift", t: "(407) 299-0000", w: "https://joythrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Hope Thrift", t: "(407) 363-0000", w: "https://hopethrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Grace Thrift", t: "(407) 648-0000", w: "https://gracethrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Faith Thrift", t: "(407) 649-0000", w: "https://faiththrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Victory Thrift", t: "(407) 841-0000", w: "https://victorythrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Habitat ReStore (East)", t: "(407) 277-5188", w: "https://habitatorlandoosceola.org", a: false, r: "Orlando", e: "Habitat for Humanity"},
    
            // RUTA: Kissimmee / Lakeland
            {n: "Faith Neighborhood", t: "(407) 847-0100", w: "https://faiththrift.org", a: false, r: "Kissimmee", e: "Independiente"},
            {n: "Salvation Army (Kissimmee)", t: "(407) 846-0683", w: "https://salvationarmyflorida.org", a: false, r: "Kissimmee", e: "Salvation Army"},
            {n: "Habitat ReStore (Kissimmee)", t: "(407) 846-4228", w: "https://habitatorlandoosceola.org", a: false, r: "Kissimmee", e: "Habitat for Humanity"},
            {n: "Goodwill (Kissimmee)", t: "(407) 846-1234", w: "https://goodwillcfl.org", a: false, r: "Kissimmee", e: "Goodwill"},
            {n: "Salvation Army (Lakeland)", t: "(863) 682-1232", w: "https://salvationarmyflorida.org", a: false, r: "Lakeland", e: "Salvation Army"},
            {n: "Helping Hearts", t: "(863) 686-0000", w: "https://helpinghearts.org", a: false, r: "Lakeland", e: "Independiente"},
            {n: "Treasure Chest (Winter Haven)", t: "(863) 293-0000", w: "https://treasurechest.org", a: false, r: "Lakeland", e: "Independiente"},
            {n: "Goodwill (Clermont)", t: "(352) 243-0245", w: "https://goodwillcfl.org", a: false, r: "Lakeland", e: "Goodwill"},
            {n: "The HOPE Chest (Oviedo)", t: "(407) 367-2989", w: "https://thehopechest.com", a: false, r: "Kissimmee", e: "Independiente"},
    
            // RUTA: Miami
            {n: "Miami Rescue Mission", t: "(305) 571-2273", w: "https://miamirescuemission.com", a: false, r: "Miami", e: "Rescue Mission"},
            {n: "Salvation Army Thrift", t: "(305) 573-4200", w: "https://salvationarmyflorida.org", a: false, r: "Miami", e: "Salvation Army"},
            {n: "Goodwill South FL", t: "(305) 325-9114", w: "https://goodwillsouthflorida.org", a: false, r: "Miami", e: "Goodwill"},
            {n: "St. Vincent de Paul", t: "(305) 642-9668", w: "https://svdpmiami.org", a: false, r: "Miami", e: "St. Vincent de Paul"},
            {n: "Sunshine Thrift", t: "(305) 255-0000", w: "https://sunshinethrift.com", a: false, r: "Miami", e: "Sunshine Thrift"},
            {n: "Hope Thrift", t: "(305) 235-0000", w: "https://hopethriftmiami.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Bargain Box", t: "(305) 854-0000", w: "https://bargainboxmiami.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Thrift Mart", t: "(305) 279-0000", w: "https://thriftmart.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Offset Store", t: "(305) 666-0000", w: "https://offset.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Grace Thrift", t: "(305) 674-0000", w: "https://gracethrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Joy Thrift", t: "(305) 635-0000", w: "https://joythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Victory Thrift", t: "(305) 751-0000", w: "https://victorythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Care & Share", t: "(305) 891-0000", w: "https://careandshare.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Unity Thrift", t: "(305) 944-0000", w: "https://unitythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Angel Thrift", t: "(305) 238-0000", w: "https://angelthrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Helping Hearts", t: "(305) 252-0000", w: "https://helpinghearts.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Discovery Shop", t: "(305) 253-0000", w: "https://cancer.org", a: false, r: "Miami", e: "ACS"},
            {n: "Habitat ReStore", t: "(305) 634-3628", w: "https://habitatmiami.org", a: false, r: "Miami", e: "Habitat for Humanity"},
            {n: "Goodwill (Hialeah)", t: "(305) 823-0000", w: "https://goodwillsouthflorida.org", a: false, r: "Miami", e: "Goodwill"},
            {n: "Salvation Army (Hialeah)", t: "(305) 885-0000", w: "https://salvationarmyflorida.org", a: false, r: "Miami", e: "Salvation Army"},
            {n: "St. Vincent de Paul (Hialeah)", t: "(305) 821-0000", w: "https://svdpmiami.org", a: false, r: "Miami", e: "St. Vincent de Paul"},
            {n: "Helping Hands (Hialeah)", t: "(305) 827-0000", w: "https://helpinghands.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Treasure Chest (Coral Gables)", t: "(305) 441-0000", w: "https://treasurechest.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Thrift Shop (Coral Gables)", t: "(305) 445-0000", w: "https://coralgablesthrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Community Thrift (N Miami)", t: "(305) 893-0000", w: "https://communitythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Hope Thrift (N Miami)", t: "(305) 895-0000", w: "https://hopethrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Sunshine Thrift (N Miami)", t: "(305) 899-0000", w: "https://sunshinethrift.com", a: false, r: "Miami", e: "Sunshine Thrift"},
            {n: "Care & Share (Homestead)", t: "(305) 248-0000", w: "https://careandshare.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Unity Thrift (Homestead)", t: "(305) 247-0000", w: "https://unitythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Angel Thrift (Homestead)", t: "(305) 245-0000", w: "https://angelthrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Helping Hearts (Homestead)", t: "(305) 242-0000", w: "https://helpinghearts.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Habitat ReStore (Homestead)", t: "(305) 246-0000", w: "https://habitatmiami.org", a: false, r: "Miami", e: "Habitat for Humanity"},
            {n: "Goodwill (Miami Beach)", t: "(305) 538-0000", w: "https://goodwillsouthflorida.org", a: false, r: "Miami", e: "Goodwill"},
            {n: "Salvation Army (Miami Beach)", t: "(305) 534-0000", w: "https://salvationarmyflorida.org", a: false, r: "Miami", e: "Salvation Army"},
            {n: "St. Vincent de Paul (Miami Beach)", t: "(305) 531-0000", w: "https://svdpmiami.org", a: false, r: "Miami", e: "St. Vincent de Paul"},
            {n: "Helping Hands (Miami Beach)", t: "(305) 532-0000", w: "https://helpinghands.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Treasure Chest (Aventura)", t: "(305) 935-0000", w: "https://treasurechest.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Thrift Shop (Aventura)", t: "(305) 932-0000", w: "https://aventurathrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Community Thrift (Kendall)", t: "(305) 271-0000", w: "https://communitythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Hope Thrift (Kendall)", t: "(305) 273-0000", w: "https://hopethrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Sunshine Thrift (Kendall)", t: "(305) 275-0000", w: "https://sunshinethrift.com", a: false, r: "Miami", e: "Sunshine Thrift"},
            {n: "Care & Share (Kendall)", t: "(305) 279-0000", w: "https://careandshare.org", a: false, r: "Miami", e: "Independiente"},
    
            // RUTA: Ft. Lauderdale / Hollywood
            {n: "Helping Hands (Ft Laud)", t: "(954) 522-4855", w: "https://helpinghands.org", a: false, r: "Ft. Lauderdale", e: "Independiente"},
            {n: "Goodwill (Ft Laud)", t: "(954) 749-0000", w: "https://goodwillsouthflorida.org", a: false, r: "Ft. Lauderdale", e: "Goodwill"},
            {n: "Salvation Army (Ft Laud)", t: "(954) 524-0000", w: "https://salvationarmyflorida.org", a: false, r: "Ft. Lauderdale", e: "Salvation Army"},
            {n: "St. Vincent de Paul (Ft Laud)", t: "(954) 462-0000", w: "https://svdpmiami.org", a: false, r: "Ft. Lauderdale", e: "St. Vincent de Paul"},
            {n: "Rescue Mission (Ft Laud)", t: "(954) 524-6991", w: "https://ftlauderdalerescue.org", a: false, r: "Ft. Lauderdale", e: "Rescue Mission"},
            {n: "Treasure Chest (Hollywood)", t: "(954) 921-0000", w: "https://treasurechest.org", a: false, r: "Ft. Lauderdale", e: "Independiente"},
            {n: "Community Thrift (Hollywood)", t: "(954) 961-0000", w: "https://communitythrift.org", a: false, r: "Ft. Lauderdale", e: "Independiente"},
            {n: "Hope Thrift (Hollywood)", t: "(954) 989-0000", w: "https://hopethrift.org", a: false, r: "Ft. Lauderdale", e: "Independiente"},
            {n: "New Life Thrift (Rockledge)", t: "(321) 632-4416", w: "https://newlifethrift.com", a: false, r: "Ft. Lauderdale", e: "Independiente"}
        ];

        // Append custom stores from Google Sheets
        lista.push(...customStores);

        let vistaActual = 'ruta';
        let filtroTexto = '';

        function cambiarVista(modo) {
            vistaActual = modo;
            
            const btnRuta = document.getElementById('toggle-ruta');
            const btnEmpresa = document.getElementById('toggle-empresa');
            
            if (modo === 'ruta') {
                btnRuta.className = "flex-1 md:flex-none px-6 py-2.5 bg-brand text-white font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300 shadow-sm shadow-brand/10";
                btnEmpresa.className = "flex-1 md:flex-none px-6 py-2.5 text-slate-500 hover:text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300";
            } else {
                btnEmpresa.className = "flex-1 md:flex-none px-6 py-2.5 bg-brand text-white font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300 shadow-sm shadow-brand/10";
                btnRuta.className = "flex-1 md:flex-none px-6 py-2.5 text-slate-500 hover:text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300";
            }
            
            renderDirectorio();
        }

        function filterDirectory() {
            filtroTexto = document.getElementById('search-input').value.toLowerCase();
            renderDirectorio();
        }

        function renderDirectorio() {
            let html = "";
            let grupos = {};
            
            const listaFiltrada = lista.filter(item => 
                item.n.toLowerCase().includes(filtroTexto) || 
                item.t.toLowerCase().includes(filtroTexto) || 
                item.r.toLowerCase().includes(filtroTexto) || 
                item.e.toLowerCase().includes(filtroTexto)
            );
            
            listaFiltrada.forEach(item => {
                let clave = vistaActual === 'ruta' ? item.r : item.e;
                if (!grupos[clave]) grupos[clave] = [];
                grupos[clave].push(item);
            });
            
            const keys = Object.keys(grupos).sort();
            
            if (keys.length === 0) {
                const langNoStores = currentLang === 'es' 
                    ? 'No se encontraron tiendas que coincidan con la búsqueda.' 
                    : 'No stores matching the search were found.';
                document.getElementById("directorio").innerHTML = `
                    <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center text-slate-400">
                        <span class="text-4xl block mb-2">🔍</span>
                        ${langNoStores}
                    </div>
                `;
                return;
            }
            
            const langTienda = currentLang === 'es' ? 'Tienda' : 'Store';
            const langTiendas = currentLang === 'es' ? 'Tiendas' : 'Stores';
            const langNombre = currentLang === 'es' ? 'Nombre' : 'Name';
            const langTelefono = currentLang === 'es' ? 'Teléfono' : 'Phone';
            const langWeb = currentLang === 'es' ? 'Web' : 'Web';
            const langAccion = currentLang === 'es' ? 'Acción' : 'Action';
            const langVisitar = currentLang === 'es' ? 'Visitar ↗' : 'Visit ↗';
            const langRegistrar = currentLang === 'es' ? 'Registrar' : 'Log';
            
            keys.forEach(clave => {
                const translatedClave = currentLang === 'es' ? clave : (clave === 'Volusia' ? 'Volusia' : (clave === 'Orlando' ? 'Orlando' : (clave === 'Kissimmee' ? 'Kissimmee' : (clave === 'Lakeland' ? 'Lakeland' : (clave === 'Miami' ? 'Miami' : (clave === 'Ft. Lauderdale' ? 'Ft. Lauderdale' : (clave === 'Gasolineras' ? 'Gas Stations' : (clave === 'Independiente' ? 'Independent' : clave))))))));
                html += `
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                            <span class="text-white font-black font-outfit text-sm uppercase tracking-wider">${translatedClave}</span>
                            <span class="text-xs bg-slate-800 text-slate-400 px-2.5 py-1 rounded-full font-medium">
                                ${grupos[clave].length} ${grupos[clave].length === 1 ? langTienda : langTiendas}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                        <th class="px-6 py-3.5 font-bold">${langNombre}</th>
                                        <th class="px-6 py-3.5 font-bold">${langTelefono}</th>
                                        <th class="px-6 py-3.5 font-bold">${langWeb}</th>
                                        <th class="px-6 py-3.5 font-bold text-right">${langAccion}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    `;
                
                grupos[clave].forEach(item => {
                    const cleanName = item.n.replace("⚠️", "").trim();
                    html += `
                        <tr class="${item.a ? 'bg-red-50/70 text-red-900 font-semibold' : 'hover:bg-slate-50/50'} transition-colors">
                            <td class="px-6 py-4 flex items-center gap-2">
                                ${item.a ? '<span class="text-red-500">⚠️</span>' : ''}
                                <span class="tracking-wide">${cleanName}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-normal">${item.t}</td>
                            <td class="px-6 py-4">
                                ${item.w !== '#' ? `<a href="${item.w}" target="_blank" class="text-brand hover:underline flex items-center gap-1 font-bold">${langVisitar}</a>` : '<span class="text-slate-400 font-normal">N/A</span>'}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="openLogModal('${cleanName.replace(/'/g, "\\'")}')" class="px-3.5 py-2 bg-brand/10 hover:bg-brand text-brand hover:text-white rounded-lg text-[10px] uppercase font-black tracking-wider transition-all duration-200">
                                    📝 ${langRegistrar}
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                html += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
            });
            
            document.getElementById("directorio").innerHTML = html;
        }

        // Modal Helpers
        function openLogModal(storeName) {
            document.getElementById('log-modal').classList.remove('hidden');
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('log-date').value = today;
            
            const storeInput = document.getElementById('log-store');
            if (storeName) {
                storeInput.value = storeName;
                storeInput.readOnly = true;
                storeInput.classList.replace('bg-slate-50', 'bg-slate-100');
                storeInput.classList.add('text-slate-500', 'font-semibold');
            } else {
                storeInput.value = '';
                storeInput.readOnly = false;
                storeInput.classList.replace('bg-slate-100', 'bg-slate-50');
                storeInput.classList.remove('text-slate-550', 'font-semibold');
                storeInput.focus();
            }
            
            document.getElementById('log-big').value = 0;
            document.getElementById('log-small').value = 0;
            document.getElementById('log-total').value = 0;
        }

        function closeLogModal() {
            document.getElementById('log-modal').classList.add('hidden');
            document.getElementById('log-store').value = '';
        }

        function adjustCount(inputId, amount) {
            const input = document.getElementById(inputId);
            let current = parseInt(input.value) || 0;
            current = Math.max(0, current + amount);
            input.value = current;
            calculateTotal();
        }

        function calculateTotal() {
            const big = parseInt(document.getElementById('log-big').value) || 0;
            const small = parseInt(document.getElementById('log-small').value) || 0;
            document.getElementById('log-total').value = big + small;
        }

        function submitRecyclingLog(event) {
            event.preventDefault();
            
            const submitBtn = document.getElementById('log-submit-btn');
            const spinner = document.getElementById('submit-btn-spinner');
            const btnText = document.getElementById('submit-btn-text');

            submitBtn.disabled = true;
            spinner.classList.remove('hidden');
            btnText.textContent = currentLang === 'es' ? 'Enviando...' : 'Sending...';

            const logData = {
                date: document.getElementById('log-date').value,
                store: document.getElementById('log-store').value,
                big: parseInt(document.getElementById('log-big').value) || 0,
                small: parseInt(document.getElementById('log-small').value) || 0,
                total: parseInt(document.getElementById('log-total').value) || 0,
            };

            fetch(`${apiBaseUrl}/api/recycling/log`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(logData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(currentLang === 'es' ? '¡Registro guardado con éxito!' : 'Log saved successfully!');
                    closeLogModal();
                    loadStatistics();
                } else {
                    alert((currentLang === 'es' ? 'Error: ' : 'Error: ') + data.message);
                }
            })
            .catch(err => {
                console.error("Error submitting log:", err);
                alert(currentLang === 'es' ? 'Error de conexión con el servidor.' : 'Server connection error.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                spinner.classList.add('hidden');
                btnText.textContent = currentLang === 'es' ? 'Enviar a Google Sheets' : 'Send to Google Sheets';
            });
        }

        // ----------------------------------------------------
        // CORE TAB SWITCHER & PAGE INITIALIZATION
        // ----------------------------------------------------
        function switchMainTab(tab) {
            localStorage.setItem('active_recycling_tab', tab);
            
            const secRecycling = document.getElementById('section-recycling');
            const secCallcenter = document.getElementById('section-callcenter');
            const secStatistics = document.getElementById('section-statistics');
            
            const tabBtnRecycling = document.getElementById('main-tab-recycling');
            const tabBtnCallcenter = document.getElementById('main-tab-callcenter');
            const tabBtnStatistics = document.getElementById('main-tab-statistics');
            
            // Hide all sections
            secRecycling.classList.add('hidden');
            secCallcenter.classList.add('hidden');
            secStatistics.classList.add('hidden');
            
            // Reset active button classes
            tabBtnRecycling.className = "flex-shrink-0 px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 border border-blue-900/60 text-slate-300 hover:text-white hover:bg-blue-950/40";
            tabBtnCallcenter.className = "flex-shrink-0 px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 border border-blue-900/60 text-slate-300 hover:text-white hover:bg-blue-950/40";
            tabBtnStatistics.className = "flex-shrink-0 px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 border border-blue-900/60 text-slate-300 hover:text-white hover:bg-blue-950/40";

            if (tab === 'recycling') {
                secRecycling.classList.remove('hidden');
                tabBtnRecycling.className = "flex-shrink-0 px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 bg-emerald-500 text-[#061021] shadow-lg shadow-emerald-500/10";
                document.body.className = "bg-[#040a17] text-slate-100 antialiased min-h-screen flex flex-col justify-between selection:bg-gold selection:text-navy";
            } else if (tab === 'callcenter') {
                secCallcenter.classList.remove('hidden');
                tabBtnCallcenter.className = "flex-shrink-0 px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 bg-brand text-white shadow-lg shadow-brand/10";
                document.body.className = "bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between";
            } else if (tab === 'statistics') {
                secStatistics.classList.remove('hidden');
                tabBtnStatistics.className = "flex-shrink-0 px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 bg-gold text-[#061021] shadow-lg shadow-gold/10";
                document.body.className = "bg-[#040a17] text-slate-100 antialiased min-h-screen flex flex-col justify-between selection:bg-gold selection:text-navy";
                loadStatistics();
            }
        }

        // ----------------------------------------------------
        // STATISTICS LOGIC
        // ----------------------------------------------------
        // ----------------------------------------------------
        // STATISTICS LOGIC & CHARTING
        // ----------------------------------------------------
        let trendChartInstance = null;
        let distributionChartInstance = null;
        let activeDistributionMode = 'ruta';
        let lastStatsData = null;

        // Register chartjs-plugin-datalabels globally
        Chart.register(ChartDataLabels);

        function setStatsQuickRange(range) {
            const today = new Date();
            let startDate = '';
            const endDate = today.toISOString().split('T')[0];

            if (range === 7) {
                const pastDate = new Date();
                pastDate.setDate(today.getDate() - 7);
                startDate = pastDate.toISOString().split('T')[0];
            } else if (range === 30) {
                const pastDate = new Date();
                pastDate.setDate(today.getDate() - 30);
                startDate = pastDate.toISOString().split('T')[0];
            } else if (range === 'month') {
                startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
            }

            document.getElementById('stats-start-date').value = startDate;
            document.getElementById('stats-end-date').value = endDate;
            loadStatistics();
        }

        function normalizeStoreName(name) {
            if (!name) return '';
            const upper = name.toUpperCase().trim();
            if (upper === 'OFC' || upper === 'OUT FATHERS CLOSET' || upper.startsWith("OUT FATHER'S CLOSET") || upper === 'OUT FATHERS CLOSET') {
                return "Out Father's Closet";
            }
            if (upper === 'NHC' || upper === 'THE NEIGHBORHOOD OF WEST VOLUSIA' || upper.startsWith('NEIGHBORHOOD OF WEST VOLUSIA')) {
                return "Neighborhood of West Volusia";
            }
            if (upper === 'EP' || upper === 'EPIPHANY THRIFT STORE') {
                return "Epiphany Thrift Store";
            }
            if (upper === 'CITCO' || upper === 'CITGO') {
                return "Citgo / Punto Conv.";
            }
            if (upper === 'ORMOND' || upper === 'ORMOND BEACH') {
                return "Ormond Beach";
            }
            for (const item of lista) {
                const cleanN = item.n.replace("⚠️", "").trim();
                if (cleanN.toUpperCase() === upper) {
                    return cleanN;
                }
            }
            return name;
        }

        function getStoreRouteAndCompany(storeName) {
            const normalized = normalizeStoreName(storeName);
            const found = lista.find(item => {
                const cleanN = item.n.replace("⚠️", "").trim();
                return cleanN.toLowerCase() === normalized.toLowerCase();
            });
            if (found) {
                return { r: found.r, e: found.e };
            }
            return { r: 'Volusia', e: 'Independiente' };
        }

        function loadStatistics() {
            const startDate = document.getElementById('stats-start-date').value;
            const endDate = document.getElementById('stats-end-date').value;

            let url = `${apiBaseUrl}/api/recycling/stats`;
            const params = [];
            if (startDate) params.push(`start_date=${startDate}`);
            if (endDate) params.push(`end_date=${endDate}`);
            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        lastStatsData = data;
                        renderStatistics(data);
                    } else {
                        console.error("Failed to load statistics:", data.message);
                    }
                })
                .catch(err => console.error("Error loading statistics:", err));
        }

        function clearStatsDates() {
            document.getElementById('stats-start-date').value = '';
            document.getElementById('stats-end-date').value = '';
            loadStatistics();
        }

        function switchDistributionChart(mode) {
            activeDistributionMode = mode;
            
            const btnRuta = document.getElementById('dist-toggle-ruta');
            const btnEmpresa = document.getElementById('dist-toggle-empresa');
            const btnTienda = document.getElementById('dist-toggle-tienda');
            const subtitle = document.getElementById('dist-subtitle');

            const activeClass = "px-2.5 py-1 bg-gold text-[#061021] font-bold rounded-md text-[9px] uppercase tracking-wider transition-all duration-200 shadow-sm";
            const inactiveClass = "px-2.5 py-1 text-slate-400 hover:text-white font-bold rounded-md text-[9px] uppercase tracking-wider transition-all duration-200";

            btnRuta.className = inactiveClass;
            btnEmpresa.className = inactiveClass;
            btnTienda.className = inactiveClass;

            if (mode === 'ruta') {
                btnRuta.className = activeClass;
                if (subtitle) subtitle.textContent = currentLang === 'es' ? 'Proporción acumulada por ruta' : 'Accumulated proportion by route';
            } else if (mode === 'empresa') {
                btnEmpresa.className = activeClass;
                if (subtitle) subtitle.textContent = currentLang === 'es' ? 'Proporción acumulada por empresa' : 'Accumulated proportion by company';
            } else {
                btnTienda.className = activeClass;
                if (subtitle) subtitle.textContent = currentLang === 'es' ? 'Top 12 tiendas con más bolsas recolectadas' : 'Top 12 stores with most bags collected';
            }

            if (lastStatsData) {
                renderDistributionChart();
            }
        }

        function renderStatistics(data) {
            const summary = data.summary;
            
            // Set summary cards
            document.getElementById('stat-card-total').textContent = summary.total.toLocaleString();
            document.getElementById('stat-card-big').textContent = summary.big.toLocaleString();
            document.getElementById('stat-card-small').textContent = summary.small.toLocaleString();
            document.getElementById('stat-card-count').textContent = summary.count.toLocaleString();

            const bigPercent = summary.total > 0 ? Math.round((summary.big / summary.total) * 100) : 0;
            const smallPercent = summary.total > 0 ? Math.round((summary.small / summary.total) * 100) : 0;

            document.getElementById('stat-card-big-percent').textContent = `${bigPercent}% ${currentLang === 'es' ? 'del total' : 'of total'}`;
            document.getElementById('stat-card-small-percent').textContent = `${smallPercent}% ${currentLang === 'es' ? 'del total' : 'of total'}`;

            // Render top locations table (normalized/grouped)
            const tableBody = document.getElementById('stats-locations-table-body');
            tableBody.innerHTML = '';
            
            // Let's normalize and group the locations list to avoid duplicate listings (e.g. OFC vs Out Father's Closet)
            const groupedLocations = {};
            data.locations.forEach(loc => {
                const normName = normalizeStoreName(loc.store);
                if (!groupedLocations[normName]) {
                    groupedLocations[normName] = {
                        store: normName,
                        big_sum: 0,
                        small_sum: 0,
                        total_sum: 0
                    };
                }
                groupedLocations[normName].big_sum += parseInt(loc.big_sum) || 0;
                groupedLocations[normName].small_sum += parseInt(loc.small_sum) || 0;
                groupedLocations[normName].total_sum += parseInt(loc.total_sum) || 0;
            });

            const sortedLocations = Object.values(groupedLocations).sort((a, b) => b.total_sum - a.total_sum);

            if (sortedLocations.length === 0) {
                const emptyMsg = currentLang === 'es' ? 'No hay registros en este rango' : 'No logs in this range';
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500 italic font-semibold">
                            ${emptyMsg}
                        </td>
                    </tr>
                `;
            } else {
                sortedLocations.forEach((loc, idx) => {
                    const tr = document.createElement('tr');
                    tr.className = "hover:bg-blue-950/20 transition-colors";
                    let rankBadge = '';
                    if (idx === 0) rankBadge = '🥇';
                    else if (idx === 1) rankBadge = '🥈';
                    else if (idx === 2) rankBadge = '🥉';
                    else rankBadge = `<span class="text-slate-500 font-bold">${idx + 1}</span>`;
                    tr.innerHTML = `
                        <td class="px-4 py-3 text-center">${rankBadge}</td>
                        <td class="px-4 py-3 font-semibold text-white">${loc.store}</td>
                        <td class="px-4 py-3 text-center text-emerald-400 font-bold">${loc.big_sum.toLocaleString()}</td>
                        <td class="px-4 py-3 text-center text-blue-400 font-bold">${loc.small_sum.toLocaleString()}</td>
                        <td class="px-4 py-3 text-right text-gold font-black">${loc.total_sum.toLocaleString()}</td>
                    `;
                    tableBody.appendChild(tr);
                });
            }

            // Render recent logs timeline (normalized store names)
            const logsList = document.getElementById('stats-recent-logs-list');
            logsList.innerHTML = '';
            
            if (data.logs.length === 0) {
                const emptyMsg = currentLang === 'es' ? 'No hay registros recientes' : 'No recent logs';
                logsList.innerHTML = `
                    <div class="text-center text-slate-500 italic py-8 font-semibold">
                        ${emptyMsg}
                    </div>
                `;
            } else {
                data.logs.forEach(log => {
                    const item = document.createElement('div');
                    item.className = "bg-blue-950/20 border border-blue-950/60 p-3 rounded-xl flex items-center justify-between gap-4";
                    
                    const dateParts = log.date.split('-');
                    const formattedDate = dateParts.length === 3 ? `${dateParts[1]}/${dateParts[2]}/${dateParts[0]}` : log.date;
                    const normStoreName = normalizeStoreName(log.store);

                    const bigLabel = currentLang === 'es' ? 'G' : 'B';
                    const smallLabel = currentLang === 'es' ? 'P' : 'S';
                    const totalLabel = currentLang === 'es' ? 'Total' : 'Total';
                    item.innerHTML = `
                        <div class="flex flex-col min-w-0">
                            <span class="text-white font-bold text-xs truncate">${normStoreName}</span>
                            <span class="text-[10px] text-slate-400 font-medium">${formattedDate}</span>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-[10px] bg-emerald-950/60 text-emerald-400 border border-emerald-900/50 px-2 py-0.5 rounded font-black" title="${currentLang === 'es' ? 'Grandes' : 'Big'}">
                                ${bigLabel}: ${log.big}
                            </span>
                            <span class="text-[10px] bg-blue-950/60 text-blue-400 border border-blue-900/50 px-2 py-0.5 rounded font-black" title="${currentLang === 'es' ? 'Pequeñas' : 'Small'}">
                                ${smallLabel}: ${log.small}
                            </span>
                            <span class="text-xs bg-gold/10 text-gold px-2.5 py-0.5 rounded-full font-black border border-gold/25">
                                ${log.total}
                            </span>
                        </div>
                    `;
                    logsList.appendChild(item);
                });
            }

            // Render Charts
            renderTrendChart(data.trend || []);
            renderDistributionChart();
        }

        function renderTrendChart(trendData) {
            if (trendChartInstance) {
                trendChartInstance.destroy();
            }

            const ctx = document.getElementById('trendChart').getContext('2d');
            
            if (trendData.length === 0) {
                trendChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: { labels: [], datasets: [] },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: currentLang === 'es' ? 'Sin datos en este rango' : 'No data in this range',
                                color: '#94a3b8'
                            }
                        }
                    }
                });
                return;
            }

            const labels = trendData.map(t => {
                const dateParts = t.date.split('-');
                return dateParts.length === 3 ? `${dateParts[1]}/${dateParts[2]}` : t.date;
            });
            const bigs = trendData.map(t => parseInt(t.big_sum) || 0);
            const smalls = trendData.map(t => parseInt(t.small_sum) || 0);
            const totals = trendData.map(t => parseInt(t.total_sum) || 0);

            trendChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: currentLang === 'es' ? 'Total Bolsas' : 'Total Bags',
                            data: totals,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.3,
                            borderWidth: 3,
                            pointBackgroundColor: '#10b981',
                            pointRadius: 4
                        },
                        {
                            label: currentLang === 'es' ? 'Bolsas Grandes (B)' : 'Big Bags (B)',
                            data: bigs,
                            borderColor: '#ffb703',
                            backgroundColor: 'transparent',
                            tension: 0.3,
                            borderWidth: 2,
                            pointBackgroundColor: '#ffb703',
                            pointRadius: 3
                        },
                        {
                            label: currentLang === 'es' ? 'Bolsas Pequeñas (S)' : 'Small Bags (S)',
                            data: smalls,
                            borderColor: '#3b82f6',
                            backgroundColor: 'transparent',
                            tension: 0.3,
                            borderWidth: 2,
                            pointBackgroundColor: '#3b82f6',
                            pointRadius: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#cbd5e1',
                                font: { family: 'Inter', size: 10, weight: 'bold' }
                            }
                        },
                        datalabels: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#0a1831',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: '#1e293b',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(30, 41, 59, 0.3)' },
                            ticks: { color: '#94a3b8', font: { size: 9 } }
                        },
                        y: {
                            grid: { color: 'rgba(30, 41, 59, 0.3)' },
                            ticks: { color: '#94a3b8', font: { size: 9 } },
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function renderDistributionChart() {
            if (distributionChartInstance) {
                distributionChartInstance.destroy();
            }

            const ctx = document.getElementById('distributionChart').getContext('2d');

            if (!lastStatsData || !lastStatsData.locations || lastStatsData.locations.length === 0) {
                distributionChartInstance = new Chart(ctx, {
                    type: 'doughnut',
                    data: { labels: [], datasets: [] },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: currentLang === 'es' ? 'Sin datos' : 'No data',
                                color: '#94a3b8'
                            }
                        }
                    }
                });
                return;
            }

            let labels = [];
            let values = [];

            if (activeDistributionMode === 'tienda') {
                // Group by individual store name, then take top 12
                const storeGrouping = {};
                lastStatsData.locations.forEach(loc => {
                    const normName = normalizeStoreName(loc.store);
                    storeGrouping[normName] = (storeGrouping[normName] || 0) + (parseInt(loc.total_sum) || 0);
                });

                const sortedStores = Object.entries(storeGrouping)
                    .sort((a, b) => b[1] - a[1])
                    .slice(0, 12); // Top 12 stores for readability

                labels = sortedStores.map(item => item[0]);
                values = sortedStores.map(item => item[1]);
            } else {
                // Group by ruta or empresa
                const grouping = {};
                lastStatsData.locations.forEach(loc => {
                    const info = getStoreRouteAndCompany(loc.store);
                    const key = activeDistributionMode === 'ruta' ? info.r : info.e;
                    grouping[key] = (grouping[key] || 0) + (parseInt(loc.total_sum) || 0);
                });

                const sortedItems = Object.entries(grouping).sort((a, b) => b[1] - a[1]);
                labels = sortedItems.map(item => {
                    const name = item[0];
                    return currentLang === 'es' ? name : (name === 'Gasolineras' ? 'Gas Stations' : (name === 'Independiente' ? 'Independent' : name));
                });
                values = sortedItems.map(item => item[1]);
            }

            const palette = [
                '#10b981', '#ffb703', '#3b82f6', '#8b5cf6',
                '#ec4899', '#14b8a6', '#f43f5e', '#6b7280',
                '#f97316', '#84cc16', '#06b6d4', '#a78bfa'
            ];

            const colors = labels.map((_, i) => palette[i % palette.length]);

            distributionChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors,
                        borderColor: '#061021',
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#cbd5e1',
                                boxWidth: 12,
                                font: { family: 'Inter', size: activeDistributionMode === 'tienda' ? 8 : 9, weight: 'bold' },
                                padding: activeDistributionMode === 'tienda' ? 6 : 10
                            }
                        },
                        datalabels: {
                            display: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = (context.dataset.data[context.dataIndex] / total) * 100;
                                return pct >= 4; // Only show label if slice >= 4%
                            },
                            formatter: function(value, context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = Math.round((value / total) * 100);
                                return pct + '%';
                            },
                            color: '#ffffff',
                            font: {
                                family: 'Inter',
                                size: activeDistributionMode === 'tienda' ? 9 : 11,
                                weight: 'bold'
                            },
                            textShadowBlur: 4,
                            textShadowColor: 'rgba(0,0,0,0.6)',
                            anchor: 'center',
                            align: 'center',
                            offset: 0,
                        },
                        tooltip: {
                            backgroundColor: '#0a1831',
                            borderColor: '#1e293b',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = Math.round((value / total) * 100);
                                    const bagWord = currentLang === 'es' ? 'bolsas' : 'bags';
                                    return ` ${context.label}: ${value.toLocaleString()} ${bagWord} (${pct}%)`;
                                }
                            }
                        }
                    },
                    cutout: '55%'
                }
            });
        }

        // Initialize Page
        window.addEventListener('DOMContentLoaded', () => {
            // Initialize Guest Log Form Date and Load Stores
            const guestLogDateInput = document.getElementById('guest-log-date');
            if (guestLogDateInput) {
                const today = new Date().toISOString().split('T')[0];
                guestLogDateInput.value = today;
            }
            guestLoadStores();

            // Determine initial view tab:
            // If there's an active Laravel validation/status message redirection, show the Call Center tab.
            @if(session('success') || session('error') || $errors->any())
                const initialTab = 'callcenter';
            @else
                const initialTab = localStorage.getItem('active_recycling_tab') || 'recycling';
            @endif
            
            switchMainTab(initialTab);
            cambiarVista('ruta');
        });
    </script>
</body>
</html>
