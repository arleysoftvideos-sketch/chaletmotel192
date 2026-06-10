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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .hero-recycling-banner {
            background-image: linear-gradient(to right, rgba(4, 30, 23, 0.95) 0%, rgba(6, 16, 33, 0.85) 50%, rgba(6, 16, 33, 0.4) 100%), url('/images/recycling_banner.png');
            background-size: cover;
            background-position: center;
        }
        .category-tab {
            border-color: #1e293b;
        }
        .active-tab {
            border-color: #34d399;
            background-color: rgba(16, 185, 129, 0.1);
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
                    <a href="/recycling" class="px-4 py-2 text-gold font-semibold transition-all duration-300 text-sm">
                        {{ __('Reciclaje') }}
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
        <div class="max-w-7xl mx-auto px-6 flex justify-center sm:justify-start gap-4">
            <button id="main-tab-recycling" onclick="switchMainTab('recycling')" class="px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2">
                <span>♻️</span> <span>{{ __('Reciclaje (Motel)') }}</span>
            </button>
            <button id="main-tab-callcenter" onclick="switchMainTab('callcenter')" class="px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2">
                <span>📞</span> <span>{{ __('Marketing / Call Center') }}</span>
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
                        {{ __('Guía de') }} <span class="text-emerald-400">{{ __('Reciclaje') }}</span>
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        {{ __('En Chalet Motel 192, estamos comprometidos con la sostenibilidad y la preservación de nuestra comunidad en Kissimmee. Ayúdanos a reciclar de manera correcta siguiendo esta guía interactiva.') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-grow flex flex-col gap-12 relative z-10 text-slate-100">
            
            <!-- Quick Rules & Bins Location -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-[#0a1831]/90 p-8 sm:p-10 rounded-[2rem] border border-blue-950 shadow-2xl">
                <!-- Bins Location (8 cols) -->
                <div class="lg:col-span-8 space-y-6">
                    <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide border-b border-blue-950 pb-3">
                        {{ __('Estación de Reciclaje') }}
                    </h2>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        {{ __('Para la comodidad de todos los residentes a largo plazo, Chalet Motel 192 cuenta con una estación ecológica centralizada. Todos los desechos deben ser clasificados antes de su depósito.') }}
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                        <div class="bg-[#061021]/60 p-6 rounded-2xl border border-blue-900/30 flex flex-col items-center text-center space-y-2">
                            <span class="text-emerald-400 text-3xl">📍</span>
                            <h3 class="text-white font-bold font-outfit text-sm uppercase tracking-wide">{{ __('Ubicación') }}</h3>
                            <p class="text-slate-400 text-[11px] leading-relaxed">
                                {{ __('Extremo norte del estacionamiento principal, adyacente a la salida.') }}
                            </p>
                        </div>
                        
                        <div class="bg-[#061021]/60 p-6 rounded-2xl border border-blue-900/30 flex flex-col items-center text-center space-y-2">
                            <span class="text-emerald-400 text-3xl">⏰</span>
                            <h3 class="text-white font-bold font-outfit text-sm uppercase tracking-wide">{{ __('Horarios') }}</h3>
                            <p class="text-slate-400 text-[11px] leading-relaxed">
                                {{ __('Disponible las 24 horas. Por favor, evite hacer ruidos excesivos de noche.') }}
                            </p>
                        </div>
                        
                        <div class="bg-[#061021]/60 p-6 rounded-2xl border border-blue-900/30 flex flex-col items-center text-center space-y-2">
                            <span class="text-emerald-400 text-3xl">🧹</span>
                            <h3 class="text-white font-bold font-outfit text-sm uppercase tracking-wide">{{ __('Norma Clave') }}</h3>
                            <p class="text-slate-400 text-[11px] leading-relaxed">
                                {{ __('Mantenga las tapas de los contenedores cerradas para evitar malos olores y plagas.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fast Guidelines (4 cols) -->
                <div class="lg:col-span-4 flex flex-col space-y-6 lg:pl-8 lg:border-l lg:border-blue-950 justify-between">
                    <div>
                        <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide border-b border-blue-950 pb-3 mb-4">
                            {{ __('Reglas de Oro') }}
                        </h2>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2 text-xs text-slate-300">
                                <span class="text-emerald-400">✓</span>
                                <span>{{ __('Limpio y Seco: Enjuaga envases antes de tirarlos.') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-slate-300">
                                <span class="text-emerald-400">✓</span>
                                <span>{{ __('Desinfla y Aplana: Reduce el volumen de cajas de cartón.') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-slate-300">
                                <span class="text-emerald-400">✓</span>
                                <span>{{ __('Sin Bolsas: No uses bolsas de plástico en los contenedores de reciclaje.') }}</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="p-4 bg-[#14274c]/40 border border-blue-900/40 rounded-2xl space-y-2">
                        <span class="block text-[10px] font-bold text-gold uppercase tracking-widest">
                            {{ __('¿Necesitas Contenedores?') }}
                        </span>
                        <p class="text-[11px] text-slate-400 leading-relaxed">
                            {{ __('Si requieres un cesto de reciclaje adicional para tu habitación, por favor solicítalo en la administración sin costo alguno.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Interactive Recycling Categories Explorer -->
            <div class="space-y-6">
                <div class="text-center">
                    <h2 class="text-3xl font-black font-outfit text-white uppercase tracking-wide">
                        {{ __('Categorías de Reciclaje') }}
                    </h2>
                    <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">
                        {{ __('Selecciona una categoría para ver qué depositar en cada contenedor') }}
                    </p>
                    <div class="h-1 w-12 bg-emerald-400 rounded-full mx-auto mt-3"></div>
                </div>

                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Categories list sidebar (5 cols) -->
                    <div class="lg:w-1/3 flex flex-col gap-3" id="categories-tabs">
                        <button onclick="switchCategory('plastic')" id="tab-plastic" class="category-tab active-tab flex items-center gap-4 p-5 rounded-2xl border text-left transition-all duration-300">
                            <span class="text-2xl">🥤</span>
                            <div>
                                <h3 class="font-bold text-sm uppercase tracking-wider text-white">{{ __('Plásticos y Metales') }}</h3>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ __('Botellas, latas, envases') }}</p>
                            </div>
                        </button>

                        <button onclick="switchCategory('paper')" id="tab-paper" class="category-tab flex items-center gap-4 p-5 rounded-2xl border text-left transition-all duration-300 border-blue-950 bg-[#0a1831] hover:border-emerald-500/30">
                            <span class="text-2xl">📦</span>
                            <div>
                                <h3 class="font-bold text-sm uppercase tracking-wider text-slate-300">{{ __('Papel y Cartón') }}</h3>
                                <p class="text-[10px] text-slate-500 mt-0.5">{{ __('Cajas, periódicos, folders') }}</p>
                            </div>
                        </button>

                        <button onclick="switchCategory('glass')" id="tab-glass" class="category-tab flex items-center gap-4 p-5 rounded-2xl border text-left transition-all duration-300 border-blue-950 bg-[#0a1831] hover:border-emerald-500/30">
                            <span class="text-2xl">🍷</span>
                            <div>
                                <h3 class="font-bold text-sm uppercase tracking-wider text-slate-300">{{ __('Vidrio') }}</h3>
                                <p class="text-[10px] text-slate-500 mt-0.5">{{ __('Botellas y frascos de vidrio') }}</p>
                            </div>
                        </button>

                        <button onclick="switchCategory('trash')" id="tab-trash" class="category-tab flex items-center gap-4 p-5 rounded-2xl border text-left transition-all duration-300 border-blue-950 bg-[#0a1831] hover:border-emerald-500/30">
                            <span class="text-2xl">🗑️</span>
                            <div>
                                <h3 class="font-bold text-sm uppercase tracking-wider text-slate-300">{{ __('Basura Común') }}</h3>
                                <p class="text-[10px] text-slate-500 mt-0.5">{{ __('Desechos no reciclables') }}</p>
                            </div>
                        </button>

                        <button onclick="switchCategory('special')" id="tab-special" class="category-tab flex items-center gap-4 p-5 rounded-2xl border text-left transition-all duration-300 border-blue-950 bg-[#0a1831] hover:border-emerald-500/30">
                            <span class="text-2xl">🔋</span>
                            <div>
                                <h3 class="font-bold text-sm uppercase tracking-wider text-slate-300">{{ __('Especiales') }}</h3>
                                <p class="text-[10px] text-slate-500 mt-0.5">{{ __('Pilas, focos, electrónicos') }}</p>
                            </div>
                        </button>
                    </div>

                    <!-- Category Content Card (7 cols) -->
                    <div class="lg:w-2/3 bg-[#0a1831]/90 border border-blue-950 rounded-3xl p-8 shadow-2xl relative overflow-hidden flex flex-col justify-between" id="category-content-card">
                        <!-- Top details -->
                        <div class="space-y-6">
                            <div class="flex items-center justify-between border-b border-blue-950 pb-4">
                                <div class="flex items-center gap-3">
                                    <span id="content-icon" class="text-4xl">🥤</span>
                                    <div>
                                        <h3 id="content-title" class="text-xl font-black font-outfit text-white uppercase tracking-wide">Plásticos y Metales</h3>
                                        <span id="content-bin" class="inline-block mt-0.5 text-[9px] font-bold text-emerald-400 uppercase tracking-widest bg-emerald-950/50 px-2 py-0.5 rounded-full">Contenedor Azul</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Allowed items -->
                                <div class="bg-[#061021]/50 p-5 rounded-2xl border border-emerald-900/20">
                                    <h4 class="text-emerald-400 font-bold text-xs uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <span>✓</span> {{ __('Permitido') }}
                                    </h4>
                                    <ul id="content-allowed" class="space-y-2 text-xs text-slate-300">
                                        <!-- JS Inserted -->
                                    </ul>
                                </div>

                                <!-- Forbidden items -->
                                <div class="bg-[#061021]/50 p-5 rounded-2xl border border-red-950/30">
                                    <h4 class="text-red-400 font-bold text-xs uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <span>✗</span> {{ __('No Permitido') }}
                                    </h4>
                                    <ul id="content-forbidden" class="space-y-2 text-xs text-slate-300">
                                        <!-- JS Inserted -->
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Preparation Tips -->
                        <div class="mt-6 pt-5 border-t border-blue-950 flex items-start gap-4 bg-emerald-950/10 p-4 rounded-xl border border-emerald-950/40">
                            <span class="text-2xl">💡</span>
                            <div>
                                <h5 class="text-emerald-400 font-bold text-xs uppercase tracking-wider">{{ __('Preparación') }}</h5>
                                <p id="content-prep" class="text-xs text-slate-300 mt-1 leading-relaxed">
                                    <!-- JS Inserted -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quiz Game Section -->
            <div class="bg-gradient-to-r from-[#061021] via-[#0a1831] to-[#061021] border border-blue-900/40 rounded-[2.5rem] p-8 sm:p-12 shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 bg-emerald-950/5 mix-blend-color-dodge"></div>
                
                <div class="relative z-10 max-w-2xl mx-auto text-center space-y-6">
                    <span class="text-emerald-400 text-3xl block">🏆</span>
                    <h2 class="text-2xl sm:text-3xl font-black font-outfit text-white uppercase tracking-wide">
                        {{ __('Ponte a Prueba') }}
                    </h2>
                    <p class="text-slate-300 text-xs sm:text-sm">
                        {{ __('¿Quieres ver cuánto sabes sobre reciclaje? Responde este corto cuestionario y obtén tu insignia ecológica de Chalet Motel 192.') }}
                    </p>
                    <div class="h-[1px] w-12 bg-emerald-500 rounded-full mx-auto my-2"></div>
                    
                    <!-- Quiz Box -->
                    <div id="quiz-container" class="bg-[#061021]/90 border border-blue-950 rounded-2xl p-6 sm:p-8 text-left space-y-6 shadow-xl">
                        <!-- Quiz Start View -->
                        <div id="quiz-start-view" class="flex flex-col items-center text-center space-y-4">
                            <span class="text-5xl">♻️</span>
                            <button onclick="startQuiz()" class="px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-[#061021] font-black font-outfit rounded-xl transition-all duration-300 text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/10 hover:shadow-emerald-500/20">
                                {{ __('Comenzar Quiz') }}
                            </button>
                        </div>

                        <!-- Quiz Play View (Hidden initially) -->
                        <div id="quiz-play-view" class="hidden space-y-4">
                            <div class="flex justify-between items-center text-xs text-slate-400 border-b border-blue-950 pb-2">
                                <span id="quiz-progress-text">Pregunta 1 de 3</span>
                                <span id="quiz-score-text">Puntuación: 0</span>
                            </div>
                            
                            <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                <div id="quiz-progress-bar" class="bg-emerald-400 h-1.5 rounded-full" style="width: 33%"></div>
                            </div>
                            
                            <h3 id="quiz-question" class="text-white font-bold font-outfit text-sm uppercase tracking-wider py-2">
                                ¿Cuál de estos materiales es reciclable?
                            </h3>
                            
                            <div id="quiz-options" class="flex flex-col gap-3">
                                <!-- JS Inserted options -->
                            </div>

                            <div class="flex justify-end pt-2">
                                <button id="quiz-next-btn" disabled onclick="nextQuestion()" class="px-6 py-2 bg-emerald-500 disabled:bg-slate-700 text-[#061021] disabled:text-slate-400 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300">
                                    {{ __('Siguiente Pregunta') }}
                                </button>
                            </div>
                        </div>

                        <!-- Quiz Result View (Hidden initially) -->
                        <div id="quiz-result-view" class="hidden flex flex-col items-center text-center space-y-4">
                            <span id="quiz-result-icon" class="text-6xl">🎉</span>
                            <h3 id="quiz-result-title" class="text-white font-black font-outfit text-lg uppercase tracking-wide">
                                ¡Felicidades!
                            </h3>
                            <p id="quiz-result-desc" class="text-slate-300 text-xs max-w-sm">
                                Has obtenido una puntuación perfecta. Eres un verdadero campeón ecológico en nuestra comunidad.
                            </p>
                            <span id="quiz-result-score" class="text-3xl font-black font-outfit text-emerald-400">Score: 3/3</span>
                            <button onclick="restartQuiz()" class="px-6 py-2 border border-emerald-500 text-emerald-400 hover:bg-emerald-500/10 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300">
                                {{ __('Volver a Intentar') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="space-y-6">
                <div class="text-center">
                    <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide">
                        {{ __('Preguntas Frecuentes') }}
                    </h2>
                    <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">
                        {{ __('Respuestas a dudas comunes sobre el servicio de reciclaje en el motel') }}
                    </p>
                    <div class="h-1 w-12 bg-emerald-400 rounded-full mx-auto mt-3"></div>
                </div>

                <div class="max-w-3xl mx-auto space-y-4">
                    <!-- FAQ 1 -->
                    <div class="bg-[#0a1831] border border-blue-950 rounded-2xl overflow-hidden transition-all duration-300">
                        <button onclick="toggleFaq(1)" class="w-full p-6 text-left flex justify-between items-center hover:bg-blue-900/10 transition-colors">
                            <span class="text-white font-bold text-xs sm:text-sm uppercase tracking-wider">{{ __('¿Qué días se recolectan los materiales reciclables?') }}</span>
                            <span id="faq-icon-1" class="text-emerald-400 font-bold transition-transform duration-300">+</span>
                        </button>
                        <div id="faq-content-1" class="max-h-0 overflow-hidden transition-all duration-300 bg-[#061021]/40">
                            <p class="p-6 text-xs text-slate-300 leading-relaxed border-t border-blue-950/50">
                                {{ __('La recolección se realiza todos los martes y viernes temprano en la mañana. Recomendamos dejar los contenedores organizados la noche anterior.') }}
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="bg-[#0a1831] border border-blue-950 rounded-2xl overflow-hidden transition-all duration-300">
                        <button onclick="toggleFaq(2)" class="w-full p-6 text-left flex justify-between items-center hover:bg-blue-900/10 transition-colors">
                            <span class="text-white font-bold text-xs sm:text-sm uppercase tracking-wider">{{ __('¿Se pueden reciclar envases de pizza o cajas manchadas de grasa?') }}</span>
                            <span id="faq-icon-2" class="text-emerald-400 font-bold transition-transform duration-300">+</span>
                        </button>
                        <div id="faq-content-2" class="max-h-0 overflow-hidden transition-all duration-300 bg-[#061021]/40">
                            <p class="p-6 text-xs text-slate-300 leading-relaxed border-t border-blue-950/50">
                                {{ __('No. Los cartones manchados con aceite o grasa de comida no se pueden reciclar, ya que arruinan el proceso de pulpa de papel. Deposítalos en el contenedor de basura común.') }}
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="bg-[#0a1831] border border-blue-950 rounded-2xl overflow-hidden transition-all duration-300">
                        <button onclick="toggleFaq(3)" class="w-full p-6 text-left flex justify-between items-center hover:bg-blue-900/10 transition-colors">
                            <span class="text-white font-bold text-xs sm:text-sm uppercase tracking-wider">{{ __('¿Dónde debo desechar las pilas usadas y los focos?') }}</span>
                            <span id="faq-icon-3" class="text-emerald-400 font-bold transition-transform duration-300">+</span>
                        </button>
                        <div id="faq-content-3" class="max-h-0 overflow-hidden transition-all duration-300 bg-[#061021]/40">
                            <p class="p-6 text-xs text-slate-300 leading-relaxed border-t border-blue-950/50">
                                {{ __('Las pilas, baterías y bombillas fluorescentes contienen químicos peligrosos. No los tires a los botes comunes. Llévalos directamente a la oficina de administración y nosotros los procesaremos de forma segura.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staff Logging Section -->
            <div class="bg-[#0a1831]/90 p-8 sm:p-10 rounded-[2rem] border border-blue-950 shadow-2xl relative mt-8">
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
            <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Phone Call Section -->
                <div class="flex items-center gap-4 group">
                    <a href="tel:+14077731461" class="w-12 h-12 bg-gold rounded-xl flex items-center justify-center text-navy shadow-lg shadow-gold/10 transition-transform group-hover:scale-105 duration-300">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </a>
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
                        <a href="https://maps.google.com/?q=4741+W+Irlo+Bronson+Memorial+Hwy,+Kissimmee,+FL+34746" target="_blank" class="text-white hover:text-gold transition-colors font-extrabold font-outfit text-xs sm:text-sm leading-snug">
                            4741 W Irlo Bronson Memorial Hwy, <br class="hidden sm:inline">Kissimmee, FL 34746
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Copyright Bar -->
            <div class="w-full bg-[#061021] py-4 text-center text-xs text-slate-500 border-t border-blue-950">
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
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Textile Recycling Portal</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">
                        Directorio Logístico - Jovancito
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
                        <h3 class="text-lg font-black font-outfit text-slate-900 tracking-tight">Agregar Nueva Tienda al Directorio</h3>
                        <p class="text-xs text-slate-500">Crea una nueva ubicación de reciclaje en la base de datos de Google Sheets.</p>
                    </div>
                    <span class="text-xs bg-brand/10 text-brand px-3 py-1 rounded-full font-bold uppercase tracking-wider">Formulario de Registro</span>
                </div>
                
                <form action="{{ route('recycling.save') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-4">
                    @csrf
                    <!-- Nombre (3 cols) -->
                    <div class="md:col-span-3 flex flex-col space-y-1">
                        <label for="nombre" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">Nombre de la Tienda</label>
                        <input type="text" name="nombre" id="nombre" required placeholder="Ej. Exxon DeLand" value="{{ old('nombre') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                    </div>

                    <!-- Teléfono (2 cols) -->
                    <div class="md:col-span-2 flex flex-col space-y-1">
                        <label for="telefono" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" required placeholder="Ej. (386) 555-0192" value="{{ old('telefono') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                    </div>

                    <!-- Web / Enlace (3 cols) -->
                    <div class="md:col-span-3 flex flex-col space-y-1">
                        <label for="web" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">Sitio Web (Enlace)</label>
                        <input type="text" name="web" id="web" required placeholder="Ej. https://exxon.com o #" value="{{ old('web', '#') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                    </div>

                    <!-- Empresa (2 cols) -->
                    <div class="md:col-span-2 flex flex-col space-y-1">
                        <label for="empresa" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">Empresa / Tipo</label>
                        <input type="text" name="empresa" id="empresa" required placeholder="Ej. Gasolineras" value="{{ old('empresa') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                    </div>

                    <!-- Ruta (1 col) -->
                    <div class="md:col-span-1 flex flex-col space-y-1">
                        <label for="ruta" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">Ruta</label>
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
                        <label for="alerta" class="text-slate-500 font-bold text-[10px] uppercase tracking-wider">Alerta</label>
                        <select name="alerta" id="alerta" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                            <option value="No" {{ old('alerta') == 'No' ? 'selected' : '' }}>No</option>
                            <option value="Sí" {{ old('alerta') == 'Sí' ? 'selected' : '' }}>Sí</option>
                        </select>
                    </div>

                    <!-- Submit Button (12 cols) -->
                    <div class="md:col-span-12 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-brand hover:bg-brand-hover text-white font-bold font-outfit rounded-xl text-xs uppercase tracking-wider transition-all duration-300 shadow-md shadow-brand/10 hover:shadow-brand/20">
                            Guardar Tienda
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Welcome Card & Global Controls -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-1">
                    <h2 class="text-2xl font-black font-outfit text-slate-900 tracking-tight">Directorio de 100 Tiendas</h2>
                    <p class="text-sm text-slate-500">Busca tiendas por ruta o empresa y registra las bolsas de reciclaje recolectadas directamente en Google Sheets.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Manual Entry Button -->
                    <button onclick="openLogModal(null)" class="px-5 py-3 bg-brand hover:bg-brand-hover text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all duration-300 shadow-md shadow-brand/10 hover:shadow-brand/20 flex items-center justify-center gap-2">
                        <span>➕</span> <span>Registro Manual</span>
                    </button>
                </div>
            </div>

            <!-- Filter and Search Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- View Toggle -->
                <div class="flex bg-slate-100 p-1 rounded-xl w-full md:w-auto">
                    <button id="toggle-ruta" onclick="cambiarVista('ruta')" class="flex-1 md:flex-none px-6 py-2.5 bg-white text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300 shadow-sm">
                        Por Ruta
                    </button>
                    <button id="toggle-empresa" onclick="cambiarVista('empresa')" class="flex-1 md:flex-none px-6 py-2.5 text-slate-500 hover:text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300">
                        Por Empresa
                    </button>
                </div>

                <!-- Live Search Input -->
                <div class="relative w-full md:max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        🔍
                    </span>
                    <input type="text" id="search-input" oninput="filterDirectory()" placeholder="Buscar por nombre, teléfono, ruta o empresa..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-brand transition-all">
                </div>
            </div>

            <!-- Directory Render Container -->
            <div id="directorio" class="space-y-6">
                <!-- Dynamically populated via JS -->
            </div>
        </main>

        <!-- Directory Footer -->
        <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
            <p>&copy; {{ date('Y') }} Ameritex Diversion Inc. &bull; Directorio Logístico 100</p>
        </footer>
    </div>

    <!-- Form Logger Modal (Directory Log Modal) -->
    <div id="log-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-6 shadow-2xl relative">
            <button onclick="closeLogModal()" class="absolute right-5 top-5 text-slate-400 hover:text-slate-600 transition-colors text-lg font-bold">
                ✕
            </button>
            
            <div class="space-y-1 text-slate-800">
                <span class="text-xs font-bold text-brand uppercase tracking-widest">Ameritex Sheets Logger</span>
                <h3 class="text-xl font-black font-outfit text-slate-900 uppercase tracking-tight">
                    Registrar Recolección
                </h3>
                <p class="text-xs text-slate-500">Ingresa la cantidad de bolsas recolectadas para esta ubicación.</p>
            </div>

            <form id="recycling-log-form" onsubmit="submitRecyclingLog(event)" class="space-y-4">
                <!-- Date Input -->
                <div class="flex flex-col space-y-1.5 text-slate-800">
                    <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Fecha de Recolección</label>
                    <input type="date" id="log-date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                </div>

                <!-- Store Input (Read-only if selected, editable if manual) -->
                <div class="flex flex-col space-y-1.5 text-slate-800">
                    <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Tienda / Ubicación</label>
                    <input type="text" id="log-store" required placeholder="Nombre de la tienda..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4 text-slate-800">
                    <!-- Big Bags -->
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Bolsas Grandes (BIG)</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                            <button type="button" onclick="adjustCount('log-big', -1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">-</button>
                            <input type="number" id="log-big" required min="0" value="0" oninput="calculateTotal()" class="w-full bg-transparent border-none text-center text-sm font-bold text-slate-800 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" onclick="adjustCount('log-big', 1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">+</button>
                        </div>
                    </div>

                    <!-- Small Bags -->
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Bolsas Pequeñas (SMALL)</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                            <button type="button" onclick="adjustCount('log-small', -1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">-</button>
                            <input type="number" id="log-small" required min="0" value="0" oninput="calculateTotal()" class="w-full bg-transparent border-none text-center text-sm font-bold text-slate-800 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" onclick="adjustCount('log-small', 1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">+</button>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="flex flex-col space-y-1.5 text-slate-800">
                    <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Total de Bolsas</label>
                    <input type="number" id="log-total" required min="0" value="0" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none font-black">
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="log-submit-btn" class="w-full py-3.5 bg-brand hover:bg-brand-hover text-white font-black font-outfit rounded-xl transition-all duration-300 text-xs uppercase tracking-wider shadow-lg shadow-brand/10 hover:shadow-brand/20 flex items-center justify-center gap-2">
                        <span id="submit-btn-spinner" class="hidden animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                        <span id="submit-btn-text">Enviar a Google Sheets</span>
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
        
        // ----------------------------------------------------
        // GUEST VIEW SCRIPTS & TRANSLATIONS
        // ----------------------------------------------------
        const categoriesData = {
            plastic: {
                title: currentLang === 'es' ? 'Plásticos y Metales' : 'Plastics & Metals',
                icon: '🥤',
                bin: currentLang === 'es' ? 'Contenedor Azul' : 'Blue Bin',
                allowed: currentLang === 'es' 
                    ? ['Botellas de agua y refresco', 'Envases de galones (leche, jugos)', 'Latas de aluminio (refresco, cerveza)', 'Latas de conservas/comida', 'Recipientes plásticos de comida vacíos']
                    : ['Water & soda bottles', 'Gallon containers (milk, juice)', 'Aluminum cans (soda, beer)', 'Canned food cans', 'Empty plastic food containers'],
                forbidden: currentLang === 'es'
                    ? ['Bolsas de plástico de supermercado', 'Pajillas / Popotes', 'Envolturas de plástico', 'Latas con residuos de pintura o químicos', 'Mangueras de agua']
                    : ['Grocery plastic bags', 'Drinking straws', 'Plastic wraps / cling film', 'Cans with paint or chemical residue', 'Water hoses'],
                prep: currentLang === 'es'
                    ? 'Enjuague bien todos los envases para eliminar cualquier residuo de comida o bebida. Escúrralos antes de depositarlos en el contenedor azul.'
                    : 'Rinse all containers thoroughly to remove food or liquid residue. Drain them completely before placing them in the blue bin.'
            },
            paper: {
                title: currentLang === 'es' ? 'Papel y Cartón' : 'Paper & Cardboard',
                icon: '📦',
                bin: currentLang === 'es' ? 'Contenedor Azul (Separador)' : 'Blue Bin (Divider)',
                allowed: currentLang === 'es'
                    ? ['Cajas de cartón corrugado', 'Periódicos y revistas', 'Papel de oficina e impreso', 'Sobres de cartas', 'Cajas de cereal y cartulina limpia']
                    : ['Corrugated cardboard boxes', 'Newspapers & magazines', 'Office & printed paper', 'Envelopes', 'Cereal boxes & clean cardboards'],
                forbidden: currentLang === 'es'
                    ? ['Cajas de pizza con grasa', 'Servilletas usadas', 'Papel encerado o plastificado', 'Papel higiénico', 'Cajas de leche tipo tetra pack con líquido']
                    : ['Pizza boxes with grease', 'Used paper napkins', 'Waxed or plastic-coated paper', 'Toilet paper', 'Juice/milk cartons with remaining liquid'],
                prep: currentLang === 'es'
                    ? 'Desarme y aplane completamente todas las cajas de cartón para no saturar el contenedor. Mantenga el papel seco en todo momento.'
                    : 'Break down and completely flatten all cardboard boxes to save space. Keep paper dry at all times.'
            },
            glass: {
                title: currentLang === 'es' ? 'Vidrio' : 'Glass',
                icon: '🍷',
                bin: currentLang === 'es' ? 'Contenedor de Vidrio Especial' : 'Special Glass Container',
                allowed: currentLang === 'es'
                    ? ['Botellas de vidrio transparentes y de color', 'Frascos de comida (aderezos, mermeladas)']
                    : ['Clear and colored glass bottles', 'Food jars (dressings, jams)'],
                forbidden: currentLang === 'es'
                    ? ['Focos y bombillas', 'Espejos o vidrios de ventanas', 'Vajilla de cerámica o porcelana', 'Copas de cristal para beber']
                    : ['Lightbulbs', 'Mirrors or window glass', 'Ceramic or porcelain dinnerware', 'Crystal drinking glasses'],
                prep: currentLang === 'es'
                    ? 'Retire las tapas metálicas o plásticas (estas van en el contenedor de plástico/metal) y enjuague el interior para eliminar residuos.'
                    : 'Remove metal or plastic caps (which go into the plastic/metal bin) and rinse the interior to remove residues.'
            },
            trash: {
                title: currentLang === 'es' ? 'Basura Común' : 'General Waste',
                icon: '🗑️',
                bin: currentLang === 'es' ? 'Contenedor Negro' : 'Black Bin',
                allowed: currentLang === 'es'
                    ? ['Desechos de alimentos / orgánicos', 'Cajas de pizza grasientas', 'Servilletas de papel sucias', 'Productos de higiene personal', 'Vasos térmicos de poliestireno (Styrofoam)']
                    : ['Food scraps / organic waste', 'Greasy pizza boxes', 'Dirty paper napkins', 'Personal hygiene products', 'Styrofoam cups/containers'],
                forbidden: currentLang === 'es'
                    ? ['Pilas y baterías', 'Aparatos electrónicos', 'Medicinas vencidas', 'Materiales reciclables limpios']
                    : ['Batteries', 'Electronic devices', 'Expired medicines', 'Clean recyclable materials'],
                prep: currentLang === 'es'
                    ? 'Deposite la basura en bolsas bien cerradas para evitar la proliferación de insectos y animales silvestres en Kissimmee.'
                    : 'Deposit trash in securely tied bags to prevent bugs and local wildlife from accessing it.'
            },
            special: {
                title: currentLang === 'es' ? 'Desechos Especiales' : 'Special Waste',
                icon: '🔋',
                bin: currentLang === 'es' ? 'Entregar en Recepción' : 'Hand in at Reception',
                allowed: currentLang === 'es'
                    ? ['Pilas alcalinas y recargables', 'Focos ahorradores y tubos LED', 'Celulares y cargadores viejos', 'Aceite de cocina usado (embotellado)', 'Pinturas y aerosoles (vacíos)']
                    : ['Alkaline & rechargeable batteries', 'CFL bulbs & LED tubes', 'Old cellphones & chargers', 'Used cooking oil (bottled)', 'Empty paints & aerosol cans'],
                forbidden: currentLang === 'es'
                    ? ['Basura orgánica común', 'Muebles grandes (reportar a mantenimiento)', 'Escombros de construcción']
                    : ['General organic waste', 'Large furniture (contact maintenance)', 'Construction debris'],
                prep: currentLang === 'es'
                    ? 'No arroje estos desechos a los contenedores normales. Tráigalos a la oficina del motel para su almacenamiento y reciclaje ecológico certificado.'
                    : 'Do not throw these items into normal bins. Bring them directly to the motel office for certified eco-friendly recycling and storage.'
            }
        };

        // Switch Tab Category
        function switchCategory(key) {
            document.querySelectorAll('.category-tab').forEach(btn => {
                btn.classList.remove('border-emerald-400', 'bg-emerald-950/20');
                btn.classList.add('border-blue-950', 'bg-[#0a1831]');
                btn.querySelector('h3').classList.replace('text-white', 'text-slate-300');
            });
            
            const activeBtn = document.getElementById(`tab-${key}`);
            activeBtn.classList.replace('border-blue-950', 'border-emerald-400');
            activeBtn.classList.replace('bg-[#0a1831]', 'bg-emerald-950/20');
            activeBtn.querySelector('h3').classList.replace('text-slate-300', 'text-white');

            const cat = categoriesData[key];
            const card = document.getElementById('category-content-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(10px)';
            card.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                document.getElementById('content-icon').textContent = cat.icon;
                document.getElementById('content-title').textContent = cat.title;
                document.getElementById('content-bin').textContent = cat.bin;
                
                const allowedList = document.getElementById('content-allowed');
                allowedList.innerHTML = cat.allowed.map(item => `
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-400 font-bold">✓</span>
                        <span>${item}</span>
                    </li>
                `).join('');

                const forbiddenList = document.getElementById('content-forbidden');
                forbiddenList.innerHTML = cat.forbidden.map(item => `
                    <li class="flex items-center gap-2">
                        <span class="text-red-400 font-bold">✗</span>
                        <span>${item}</span>
                    </li>
                `).join('');

                document.getElementById('content-prep').textContent = cat.prep;
                
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 150);
        }

        // FAQ Toggle
        function toggleFaq(id) {
            const content = document.getElementById(`faq-content-${id}`);
            const icon = document.getElementById(`faq-icon-${id}`);
            
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                icon.textContent = '+';
                icon.style.transform = 'rotate(0deg)';
            } else {
                document.querySelectorAll('[id^="faq-content-"]').forEach(el => {
                    el.style.maxHeight = null;
                });
                document.querySelectorAll('[id^="faq-icon-"]').forEach(el => {
                    el.textContent = '+';
                    icon.style.transform = 'rotate(0deg)';
                });

                content.style.maxHeight = content.scrollHeight + "px";
                icon.textContent = '−';
                icon.style.transform = 'rotate(180deg)';
            }
        }

        // QUIZ GAME SYSTEM
        const quizQuestions = [
            {
                q: currentLang === 'es' 
                    ? '¿Cuál de estos materiales NO se puede reciclar en los contenedores de reciclaje comunes del motel?' 
                    : 'Which of these materials CANNOT be recycled in the general recycling bins at the motel?',
                options: currentLang === 'es'
                    ? ['Botellas de plástico vacías', 'Cajas de pizza grasosas', 'Latas de aluminio enjuagadas', 'Cajas de cartón aplanadas']
                    : ['Empty plastic bottles', 'Greasy pizza boxes', 'Rinsed aluminum cans', 'Flattened cardboard boxes'],
                correct: 1,
                feedback: currentLang === 'es'
                    ? '¡Correcto! El cartón manchado con aceite o comida no se puede reciclar porque degrada el proceso de papel. Debe ir a la basura común.'
                    : 'Correct! Cardboard stained with food or grease cannot be recycled because it degrades the paper process. It must go in general waste.'
            },
            {
                q: currentLang === 'es'
                    ? '¿Qué debes hacer con una lata de conserva de aluminio antes de reciclarla?'
                    : 'What should you do with an aluminum food can before recycling it?',
                options: currentLang === 'es'
                    ? ['Dejar los residuos de comida adentro', 'Aplastarla sin limpiarla', 'Enjuagarla rápidamente para remover restos de comida', 'Tirarla a la basura de inmediato']
                    : ['Leave food scraps inside', 'Crush it without cleaning', 'Quickly rinse it to remove food scraps', 'Throw it directly into the trash'],
                correct: 2,
                feedback: currentLang === 'es'
                    ? '¡Excelente! Enjuagar los envases previene malos olores en la estación ecológica y evita plagas en Kissimmee.'
                    : 'Excellent! Rinsing containers prevents odors at the eco-station and avoids pests in Kissimmee.'
            },
            {
                q: currentLang === 'es'
                    ? '¿Dónde deben depositarse las pilas, focos fluorescentes y electrónicos viejos?'
                    : 'Where should batteries, fluorescent bulbs, and old electronics be deposited?',
                options: currentLang === 'es'
                    ? ['En el contenedor azul de reciclaje', 'En el contenedor negro de basura común', 'Entregándolos directamente en la recepción del motel', 'Dejándolos en el suelo del estacionamiento']
                    : ['In the blue recycling bin', 'In the black general waste bin', 'By handing them in directly at the motel reception', 'By leaving them on the parking lot ground'],
                correct: 3,
                feedback: currentLang === 'es'
                    ? '¡Exactamente! Son desechos químicos o electrónicos especiales. Tráelos a recepción para darles un destino seguro y ecológico.'
                    : 'Exactly! These are special chemical or electronic waste. Bring them to reception to give them a safe and eco-friendly destination.'
            }
        ];

        let currentQuestionIdx = 0;
        let quizScore = 0;
        let answered = false;

        function startQuiz() {
            document.getElementById('quiz-start-view').classList.add('hidden');
            document.getElementById('quiz-play-view').classList.remove('hidden');
            currentQuestionIdx = 0;
            quizScore = 0;
            showQuizQuestion();
        }

        function showQuizQuestion() {
            answered = false;
            document.getElementById('quiz-next-btn').disabled = true;
            
            const qData = quizQuestions[currentQuestionIdx];
            document.getElementById('quiz-question').textContent = qData.q;
            
            const progressPercent = ((currentQuestionIdx + 1) / quizQuestions.length) * 100;
            document.getElementById('quiz-progress-bar').style.width = `${progressPercent}%`;
            document.getElementById('quiz-progress-text').textContent = currentLang === 'es' 
                ? `Pregunta ${currentQuestionIdx + 1} de ${quizQuestions.length}`
                : `Question ${currentQuestionIdx + 1} of ${quizQuestions.length}`;
            
            document.getElementById('quiz-score-text').textContent = currentLang === 'es'
                ? `Puntuación: ${quizScore}`
                : `Score: ${quizScore}`;

            const optionsContainer = document.getElementById('quiz-options');
            optionsContainer.innerHTML = '';
            
            qData.options.forEach((opt, idx) => {
                const btn = document.createElement('button');
                btn.className = "quiz-option-btn w-full p-4 rounded-xl border border-blue-950 bg-[#0a1831] hover:border-emerald-500/30 text-left text-xs transition-all duration-300 font-medium text-slate-300 hover:text-white";
                btn.onclick = () => selectOption(idx);
                btn.innerHTML = `<span class="inline-block w-6 h-6 bg-slate-800 rounded-full text-center leading-6 text-[10px] font-bold text-slate-400 mr-3">${String.fromCharCode(65 + idx)}</span>${opt}`;
                optionsContainer.appendChild(btn);
            });
        }

        function selectOption(selectedIdx) {
            if (answered) return;
            answered = true;
            
            const qData = quizQuestions[currentQuestionIdx];
            const options = document.querySelectorAll('.quiz-option-btn');
            
            options.forEach((btn, idx) => {
                btn.disabled = true;
                if (idx === qData.correct) {
                    btn.classList.replace('border-blue-950', 'border-emerald-400');
                    btn.classList.add('bg-emerald-950/20', 'text-white');
                    btn.querySelector('span').classList.replace('bg-slate-800', 'bg-emerald-400');
                    btn.querySelector('span').classList.replace('text-slate-400', 'text-[#061021]');
                } else if (idx === selectedIdx) {
                    btn.classList.replace('border-blue-950', 'border-red-500');
                    btn.classList.add('bg-red-950/10', 'text-white');
                    btn.querySelector('span').classList.replace('bg-slate-800', 'bg-red-500');
                    btn.querySelector('span').classList.replace('text-slate-400', 'text-white');
                }
            });

            if (selectedIdx === qData.correct) {
                quizScore++;
            }
            
            const feedbackDiv = document.createElement('p');
            feedbackDiv.className = "text-[11px] font-medium leading-relaxed mt-4 p-3 rounded-lg " + (selectedIdx === qData.correct ? 'text-emerald-400 bg-emerald-950/20 border border-emerald-900/30' : 'text-red-400 bg-red-950/10 border border-red-900/30');
            feedbackDiv.textContent = qData.feedback;
            document.getElementById('quiz-options').appendChild(feedbackDiv);
            
            document.getElementById('quiz-score-text').textContent = currentLang === 'es'
                ? `Puntuación: ${quizScore}`
                : `Score: ${quizScore}`;
            
            document.getElementById('quiz-next-btn').disabled = false;
        }

        function nextQuestion() {
            currentQuestionIdx++;
            if (currentQuestionIdx < quizQuestions.length) {
                showQuizQuestion();
            } else {
                showQuizResults();
            }
        }

        function showQuizResults() {
            document.getElementById('quiz-play-view').classList.add('hidden');
            document.getElementById('quiz-result-view').classList.remove('hidden');

            const percent = (quizScore / quizQuestions.length) * 100;
            const resultIcon = document.getElementById('quiz-result-icon');
            const resultTitle = document.getElementById('quiz-result-title');
            const resultDesc = document.getElementById('quiz-result-desc');
            
            document.getElementById('quiz-result-score').textContent = currentLang === 'es'
                ? `Puntuación: ${quizScore} / ${quizQuestions.length}`
                : `Score: ${quizScore} / ${quizQuestions.length}`;

            if (percent === 100) {
                resultIcon.textContent = '🏆';
                resultTitle.textContent = currentLang === 'es' ? '¡Campeón Ecológico!' : 'Eco Champion!';
                resultDesc.textContent = currentLang === 'es' 
                    ? '¡Excelente trabajo! Conoces perfectamente las reglas de reciclaje de Chalet Motel 192. Gracias por ayudarnos a cuidar el medio ambiente.'
                    : 'Excellent work! You perfectly know the recycling rules at Chalet Motel 192. Thank you for helping us protect the environment.';
            } else if (percent >= 50) {
                resultIcon.textContent = '🌱';
                resultTitle.textContent = currentLang === 'es' ? '¡Buen Intento!' : 'Good Attempt!';
                resultDesc.textContent = currentLang === 'es'
                    ? '¡Vas por buen camino! Repasa las reglas de la estación ecológica para lograr una puntuación perfecta la próxima vez.'
                    : 'You\'re on the right track! Review the rules of the eco-station to achieve a perfect score next time.';
            } else {
                resultIcon.textContent = '❌';
                resultTitle.textContent = currentLang === 'es' ? 'Necesitas Practicar' : 'Need Practice';
                resultDesc.textContent = currentLang === 'es'
                    ? 'Te sugerimos volver a leer las categorías de reciclaje arriba. Clasificar bien los desechos ayuda a toda nuestra comunidad.'
                    : 'We suggest reading the recycling categories above again. Properly sorting waste benefits our entire community.';
            }
        }

        function restartQuiz() {
            document.getElementById('quiz-result-view').classList.add('hidden');
            document.getElementById('quiz-start-view').classList.remove('hidden');
        }

        // GUEST VIEW LOGGING SCRIPTS
        let guestStores = [];

        function guestLoadStores() {
            fetch('/api/recycling/stores')
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

            fetch('/api/recycling/log', {
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
                document.getElementById("directorio").innerHTML = `
                    <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center text-slate-400">
                        <span class="text-4xl block mb-2">🔍</span>
                        No se encontraron tiendas que coincidan con la búsqueda.
                    </div>
                `;
                return;
            }
            
            keys.forEach(clave => {
                html += `
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                            <span class="text-white font-black font-outfit text-sm uppercase tracking-wider">${clave}</span>
                            <span class="text-xs bg-slate-800 text-slate-400 px-2.5 py-1 rounded-full font-medium">
                                ${grupos[clave].length} ${grupos[clave].length === 1 ? 'Tienda' : 'Tiendas'}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                        <th class="px-6 py-3.5 font-bold">Nombre</th>
                                        <th class="px-6 py-3.5 font-bold">Teléfono</th>
                                        <th class="px-6 py-3.5 font-bold">Web</th>
                                        <th class="px-6 py-3.5 font-bold text-right">Acción</th>
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
                                ${item.w !== '#' ? `<a href="${item.w}" target="_blank" class="text-brand hover:underline flex items-center gap-1 font-bold">Visitar ↗</a>` : '<span class="text-slate-400 font-normal">N/A</span>'}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="openLogModal('${cleanName.replace(/'/g, "\\'")}')" class="px-3.5 py-2 bg-brand/10 hover:bg-brand text-brand hover:text-white rounded-lg text-[10px] uppercase font-black tracking-wider transition-all duration-200">
                                    📝 Registrar
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
            btnText.textContent = 'Enviando...';

            const logData = {
                date: document.getElementById('log-date').value,
                store: document.getElementById('log-store').value,
                big: parseInt(document.getElementById('log-big').value) || 0,
                small: parseInt(document.getElementById('log-small').value) || 0,
                total: parseInt(document.getElementById('log-total').value) || 0,
            };

            fetch('/api/recycling/log', {
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
                    alert('¡Registro guardado con éxito!');
                    closeLogModal();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error("Error submitting log:", err);
                alert('Error de conexión con el servidor.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                spinner.classList.add('hidden');
                btnText.textContent = 'Enviar a Google Sheets';
            });
        }

        // ----------------------------------------------------
        // CORE TAB SWITCHER & PAGE INITIALIZATION
        // ----------------------------------------------------
        function switchMainTab(tab) {
            localStorage.setItem('active_recycling_tab', tab);
            
            const secRecycling = document.getElementById('section-recycling');
            const secCallcenter = document.getElementById('section-callcenter');
            const tabBtnRecycling = document.getElementById('main-tab-recycling');
            const tabBtnCallcenter = document.getElementById('main-tab-callcenter');
            
            if (tab === 'recycling') {
                secRecycling.classList.remove('hidden');
                secCallcenter.classList.add('hidden');
                
                // Style Active Recycling Tab
                tabBtnRecycling.className = "px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 bg-emerald-500 text-[#061021] shadow-lg shadow-emerald-500/10";
                tabBtnCallcenter.className = "px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 border border-blue-900/60 text-slate-300 hover:text-white hover:bg-blue-950/40";
                
                // Set dark body styles
                document.body.className = "bg-[#040a17] text-slate-100 antialiased min-h-screen flex flex-col justify-between selection:bg-gold selection:text-navy";
            } else {
                secRecycling.classList.add('hidden');
                secCallcenter.classList.remove('hidden');
                
                // Style Active Callcenter Tab
                tabBtnCallcenter.className = "px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 bg-brand text-white shadow-lg shadow-brand/10";
                tabBtnRecycling.className = "px-5 py-2.5 rounded-xl font-black font-outfit text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 border border-blue-900/60 text-slate-300 hover:text-white hover:bg-blue-950/40";
                
                // Set light body styles
                document.body.className = "bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between";
            }
        }

        // Initialize Page
        window.addEventListener('DOMContentLoaded', () => {
            // Check category tab default
            switchCategory('plastic');
            
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
