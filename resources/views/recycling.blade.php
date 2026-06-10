<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Chalet Motel 192 - {{ __('Guía de Reciclaje') }}</title>

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
                            },
                            emerald: {
                                DEFAULT: '#10b981',
                                dark: '#047857',
                                light: '#34d399',
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
            .hero-recycling-banner {
                background-image: linear-gradient(to right, rgba(4, 30, 23, 0.95) 0%, rgba(6, 16, 33, 0.85) 50%, rgba(6, 16, 33, 0.4) 100%), url('/images/recycling_banner.png');
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
        <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-grow flex flex-col gap-12 relative z-10">
            
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
                                <span class="text-emerald-400">✔</span>
                                <span>{{ __('Limpio y Seco: Enjuaga envases antes de tirarlos.') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-slate-300">
                                <span class="text-emerald-400">✔</span>
                                <span>{{ __('Desinfla y Aplana: Reduce el volumen de cajas de cartón.') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-slate-300">
                                <span class="text-emerald-400">✔</span>
                                <span>{{ __('Sin Bolsas: No uses bolsas de plástico en los contenedores de reciclaje.') }}</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="p-4 bg-navy-light/40 border border-blue-900/40 rounded-2xl space-y-2">
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

                        <button onclick="switchCategory('paper')" id="tab-paper" class="category-tab flex items-center gap-4 p-5 rounded-2xl border text-left transition-all duration-300 border-blue-950 bg-navy hover:border-emerald-500/30">
                            <span class="text-2xl">📦</span>
                            <div>
                                <h3 class="font-bold text-sm uppercase tracking-wider text-slate-300">{{ __('Papel y Cartón') }}</h3>
                                <p class="text-[10px] text-slate-500 mt-0.5">{{ __('Cajas, periódicos, folders') }}</p>
                            </div>
                        </button>

                        <button onclick="switchCategory('glass')" id="tab-glass" class="category-tab flex items-center gap-4 p-5 rounded-2xl border text-left transition-all duration-300 border-blue-950 bg-navy hover:border-emerald-500/30">
                            <span class="text-2xl">🍾</span>
                            <div>
                                <h3 class="font-bold text-sm uppercase tracking-wider text-slate-300">{{ __('Vidrio') }}</h3>
                                <p class="text-[10px] text-slate-500 mt-0.5">{{ __('Botellas y frascos de vidrio') }}</p>
                            </div>
                        </button>

                        <button onclick="switchCategory('trash')" id="tab-trash" class="category-tab flex items-center gap-4 p-5 rounded-2xl border text-left transition-all duration-300 border-blue-950 bg-navy hover:border-emerald-500/30">
                            <span class="text-2xl">🗑</span>
                            <div>
                                <h3 class="font-bold text-sm uppercase tracking-wider text-slate-300">{{ __('Basura Común') }}</h3>
                                <p class="text-[10px] text-slate-500 mt-0.5">{{ __('Desechos no reciclables') }}</p>
                            </div>
                        </button>

                        <button onclick="switchCategory('special')" id="tab-special" class="category-tab flex items-center gap-4 p-5 rounded-2xl border text-left transition-all duration-300 border-blue-950 bg-navy hover:border-emerald-500/30">
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
                                        <span>✔</span> {{ __('Permitido') }}
                                    </h4>
                                    <ul id="content-allowed" class="space-y-2 text-xs text-slate-300">
                                        <!-- JS Inserted -->
                                    </ul>
                                </div>

                                <!-- Forbidden items -->
                                <div class="bg-[#061021]/50 p-5 rounded-2xl border border-red-950/30">
                                    <h4 class="text-red-400 font-bold text-xs uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <span>✘</span> {{ __('No Permitido') }}
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
                            <span class="text-5xl">♻</span>
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
                <div class="border-b border-blue-950 pb-4 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-wide">
                            {{ __('Registro de Recolección (Staff)') }}
                        </h2>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">
                            {{ __('Acceso exclusivo para el personal del Chalet Motel 192') }}
                        </p>
                    </div>
                    <!-- Admin status / Unlock button -->
                    <div id="admin-status-container">
                        <button id="admin-toggle-btn" onclick="openAdminPinModal()" class="px-4 py-2 border border-emerald-500/35 text-emerald-400 hover:bg-emerald-500/10 font-bold font-outfit rounded-xl text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2">
                            <span>🔒</span> <span>{{ __('Desbloquear Acceso') }}</span>
                        </button>
                    </div>
                </div>

                <!-- Locked Overlay State -->
                <div id="logger-locked-view" class="flex flex-col items-center justify-center py-10 text-center space-y-4">
                    <span class="text-5xl">🔐</span>
                    <p class="text-slate-400 text-xs max-w-sm leading-relaxed">
                        {{ __('Esta sección requiere un código PIN de seguridad para evitar registros no autorizados en la base de datos de Google Sheets.') }}
                    </p>
                    <button onclick="openAdminPinModal()" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-[#061021] font-black font-outfit rounded-xl transition-all duration-300 text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/10">
                        {{ __('Ingresar PIN') }}
                    </button>
                </div>

                <!-- Unlocked Logging Form (Hidden initially) -->
                <div id="logger-unlocked-view" class="hidden space-y-6">
                    <form id="recycling-log-form" onsubmit="submitRecyclingLog(event)" class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Date Input (4 cols) -->
                        <div class="md:col-span-4 flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Fecha') }}</label>
                            <input type="date" id="log-date" required class="w-full bg-[#061021]/80 border border-blue-950 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all">
                        </div>

                        <!-- Store Autocomplete Search (8 cols) -->
                        <div class="md:col-span-8 flex flex-col space-y-2 relative">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Tienda / Origen') }}</label>
                            <div class="relative">
                                <input type="text" id="log-store" required autocomplete="off" placeholder="{{ __('Buscar tienda o escribir nueva...') }}" oninput="filterStores()" onfocus="showStoresDropdown()" onblur="hideStoresDropdown()" class="w-full bg-[#061021]/80 border border-blue-950 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition-all">
                                <button type="button" onclick="toggleStoresDropdown(event)" class="absolute right-3 top-3 text-slate-500 hover:text-slate-300">
                                    ▼
                                </button>
                            </div>
                            <!-- Autocomplete Dropdown List -->
                            <div id="stores-dropdown" class="hidden absolute left-0 right-0 top-[4.5rem] bg-[#061021] border border-blue-950 rounded-xl max-h-60 overflow-y-auto z-50 shadow-2xl py-2">
                                <div id="stores-list-container" class="flex flex-col">
                                    <!-- Dynamic Store list items -->
                                </div>
                                <div id="add-new-store-btn" class="hidden border-t border-blue-950/60 p-2">
                                    <button type="button" onmousedown="addNewStore()" class="w-full text-left px-3 py-2 text-xs font-bold text-emerald-400 hover:bg-emerald-950/20 rounded-lg transition-all flex items-center gap-2">
                                        <span>➕</span> <span>{{ __('Agregar como nueva tienda') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Big Bags (4 cols) -->
                        <div class="md:col-span-4 flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Bolsas Grandes (BIG)') }}</label>
                            <div class="flex items-center bg-[#061021]/80 border border-blue-950 rounded-xl overflow-hidden">
                                <button type="button" onclick="adjustCount('log-big', -1)" class="px-4 py-3 text-slate-400 hover:text-white hover:bg-blue-950/40 font-bold text-lg select-none transition-all">-</button>
                                <input type="number" id="log-big" required min="0" value="0" oninput="calculateTotal()" class="w-full bg-transparent border-none text-center text-sm text-white focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <button type="button" onclick="adjustCount('log-big', 1)" class="px-4 py-3 text-slate-400 hover:text-white hover:bg-blue-950/40 font-bold text-lg select-none transition-all">+</button>
                            </div>
                        </div>

                        <!-- Small Bags (4 cols) -->
                        <div class="md:col-span-4 flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Bolsas Pequeñas (SMALL)') }}</label>
                            <div class="flex items-center bg-[#061021]/80 border border-blue-950 rounded-xl overflow-hidden">
                                <button type="button" onclick="adjustCount('log-small', -1)" class="px-4 py-3 text-slate-400 hover:text-white hover:bg-blue-950/40 font-bold text-lg select-none transition-all">-</button>
                                <input type="number" id="log-small" required min="0" value="0" oninput="calculateTotal()" class="w-full bg-transparent border-none text-center text-sm text-white focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <button type="button" onclick="adjustCount('log-small', 1)" class="px-4 py-3 text-slate-400 hover:text-white hover:bg-blue-950/40 font-bold text-lg select-none transition-all">+</button>
                            </div>
                        </div>

                        <!-- Total Bags (4 cols) -->
                        <div class="md:col-span-4 flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Total (BIG + SMALL)') }}</label>
                            <input type="number" id="log-total" required min="0" value="0" class="w-full bg-[#061021]/50 border border-blue-950 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all font-black">
                        </div>

                        <!-- Submit Button (12 cols) -->
                        <div class="md:col-span-12 flex justify-end pt-2">
                            <button type="submit" id="log-submit-btn" class="w-full sm:w-auto px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-[#061021] font-black font-outfit rounded-xl transition-all duration-300 text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/10 flex items-center justify-center gap-2">
                                <span id="submit-btn-spinner" class="hidden animate-spin h-4 w-4 border-2 border-[#061021] border-t-transparent rounded-full"></span>
                                <span id="submit-btn-text">{{ __('Guardar Registro') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- PIN Unlock Modal -->
            <div id="pin-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
                <div class="bg-[#0a1831] border border-blue-950 rounded-3xl p-6 sm:p-8 max-w-sm w-full space-y-6 shadow-2xl relative">
                    <button onclick="closeAdminPinModal()" class="absolute right-4 top-4 text-slate-500 hover:text-slate-300">
                        ✕
                    </button>
                    <div class="text-center space-y-2">
                        <span class="text-4xl">🔑</span>
                        <h3 class="text-lg font-black font-outfit text-white uppercase tracking-wide">
                            {{ __('Acceso de Personal') }}
                        </h3>
                        <p class="text-[10px] text-slate-400">
                            {{ __('Ingrese el PIN de seguridad para desbloquear el formulario.') }}
                        </p>
                    </div>
                    <div class="space-y-4">
                        <input type="password" id="pin-input" placeholder="••••" maxlength="6" class="w-full bg-[#061021] border border-blue-950 rounded-xl px-4 py-3 text-center text-xl tracking-[0.5em] font-black text-white focus:outline-none focus:border-emerald-500 transition-all">
                        <p id="pin-error-msg" class="hidden text-center text-[10px] text-red-400 font-bold">
                            {{ __('PIN Incorrecto. Intente de nuevo.') }}
                        </p>
                        <button onclick="verifyAdminPin()" class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-[#061021] font-black font-outfit rounded-xl transition-all duration-300 text-xs uppercase tracking-wider shadow-lg">
                            {{ __('Verificar') }}
                        </button>
                    </div>
                </div>
            </div>

        </main>

        <!-- Footer -->
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

        <!-- INTERACTIVE JS CODE -->
        <script>
            // Localization Data for JS Components
            const currentLang = "{{ app()->getLocale() }}";
            
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
                    icon: '🍾',
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
                    icon: '🗑',
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
                // Update active tab styling
                document.querySelectorAll('.category-tab').forEach(btn => {
                    btn.classList.remove('border-emerald-400', 'bg-emerald-950/20');
                    btn.classList.add('border-blue-950', 'bg-navy');
                    btn.querySelector('h3').classList.replace('text-white', 'text-slate-300');
                });
                
                const activeBtn = document.getElementById(`tab-${key}`);
                activeBtn.classList.replace('border-blue-950', 'border-emerald-400');
                activeBtn.classList.replace('bg-navy', 'bg-emerald-950/20');
                activeBtn.querySelector('h3').classList.replace('text-slate-300', 'text-white');

                // Update content card
                const cat = categoriesData[key];
                
                // Animate card content transition
                const card = document.getElementById('category-content-card');
                card.style.opacity = '0';
                card.style.transform = 'translateY(10px)';
                card.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    document.getElementById('content-icon').textContent = cat.icon;
                    document.getElementById('content-title').textContent = cat.title;
                    document.getElementById('content-bin').textContent = cat.bin;
                    
                    // Render Allowed list
                    const allowedList = document.getElementById('content-allowed');
                    allowedList.innerHTML = cat.allowed.map(item => `
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">✔</span>
                            <span>${item}</span>
                        </li>
                    `).join('');

                    // Render Forbidden list
                    const forbiddenList = document.getElementById('content-forbidden');
                    forbiddenList.innerHTML = cat.forbidden.map(item => `
                        <li class="flex items-center gap-2">
                            <span class="text-red-400 font-bold">✘</span>
                            <span>${item}</span>
                        </li>
                    `).join('');

                    // Render Prep instructions
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
                    // Close all others first
                    document.querySelectorAll('[id^="faq-content-"]').forEach(el => {
                        el.style.maxHeight = null;
                    });
                    document.querySelectorAll('[id^="faq-icon-"]').forEach(el => {
                        el.textContent = '+';
                        el.style.transform = 'rotate(0deg)';
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
                    correct: 1, // index of option
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
                
                // Progress
                const progressPercent = ((currentQuestionIdx + 1) / quizQuestions.length) * 100;
                document.getElementById('quiz-progress-bar').style.width = `${progressPercent}%`;
                document.getElementById('quiz-progress-text').textContent = currentLang === 'es' 
                    ? `Pregunta ${currentQuestionIdx + 1} de ${quizQuestions.length}`
                    : `Question ${currentQuestionIdx + 1} of ${quizQuestions.length}`;
                
                document.getElementById('quiz-score-text').textContent = currentLang === 'es'
                    ? `Puntuación: ${quizScore}`
                    : `Score: ${quizScore}`;

                // Options
                const optionsContainer = document.getElementById('quiz-options');
                optionsContainer.innerHTML = '';
                
                qData.options.forEach((opt, idx) => {
                    const btn = document.createElement('button');
                    btn.className = "quiz-option-btn w-full p-4 rounded-xl border border-blue-950 bg-navy hover:border-emerald-500/30 text-left text-xs transition-all duration-300 font-medium text-slate-300 hover:text-white";
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
                
                // Correct or Incorrect styling
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
                    // Show positive animation / feedback
                }
                
                // Append feedback message
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

            // Initialize Page Elements
            window.addEventListener('DOMContentLoaded', () => {
                switchCategory('plastic');
                
                // Auto unlock recycling admin if previously authenticated
                if (localStorage.getItem('recycling_admin_unlocked') === 'true') {
                    unlockLogger();
                }
            });

            // RECYCLING DATABASE LOGGER SYSTEM
            let stores = [];
            const pinCorrect = "192";

            function openAdminPinModal() {
                document.getElementById('pin-modal').classList.remove('hidden');
                document.getElementById('pin-input').focus();
            }

            function closeAdminPinModal() {
                document.getElementById('pin-modal').classList.add('hidden');
                document.getElementById('pin-input').value = '';
                document.getElementById('pin-error-msg').classList.add('hidden');
            }

            function verifyAdminPin() {
                const pin = document.getElementById('pin-input').value;
                if (pin === pinCorrect) {
                    unlockLogger();
                    closeAdminPinModal();
                } else {
                    document.getElementById('pin-error-msg').classList.remove('hidden');
                    document.getElementById('pin-input').value = '';
                }
            }

            function unlockLogger() {
                localStorage.setItem('recycling_admin_unlocked', 'true');
                document.getElementById('logger-locked-view').classList.add('hidden');
                document.getElementById('logger-unlocked-view').classList.remove('hidden');
                
                // Update header status
                document.getElementById('admin-status-container').innerHTML = `
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider bg-emerald-950/60 border border-emerald-500/20 px-3 py-1.5 rounded-xl flex items-center gap-1.5 animate-fade-in">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            ${currentLang === 'es' ? 'Modo Admin Activo' : 'Admin Mode Active'}
                        </span>
                        <button onclick="lockLogger()" class="text-slate-400 hover:text-white text-xs underline font-bold ml-1">
                            ${currentLang === 'es' ? 'Bloquear' : 'Lock'}
                        </button>
                    </div>
                `;

                // Set default date to today
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('log-date').value = today;

                // Load stores
                loadStores();
            }

            function lockLogger() {
                localStorage.removeItem('recycling_admin_unlocked');
                document.getElementById('logger-locked-view').classList.remove('hidden');
                document.getElementById('logger-unlocked-view').classList.add('hidden');
                
                document.getElementById('admin-status-container').innerHTML = `
                    <button id="admin-toggle-btn" onclick="openAdminPinModal()" class="px-4 py-2 border border-emerald-500/35 text-emerald-400 hover:bg-emerald-500/10 font-bold font-outfit rounded-xl text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2">
                        <span>🔒</span> <span>${currentLang === 'es' ? 'Desbloquear Acceso' : 'Unlock Access'}</span>
                    </button>
                `;
            }

            function loadStores() {
                fetch('/api/recycling/stores')
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            stores = data.stores;
                            renderStoresList();
                        }
                    })
                    .catch(err => console.error("Error loading stores:", err));
            }

            function renderStoresList(filterText = '') {
                const listContainer = document.getElementById('stores-list-container');
                listContainer.innerHTML = '';
                
                const filtered = stores.filter(store => 
                    store.toLowerCase().includes(filterText.toLowerCase())
                );

                if (filtered.length === 0) {
                    listContainer.innerHTML = `
                        <div class="px-4 py-3 text-xs text-slate-500 italic">
                            ${currentLang === 'es' ? 'No se encontraron tiendas' : 'No stores found'}
                        </div>
                    `;
                    document.getElementById('add-new-store-btn').classList.remove('hidden');
                } else {
                    document.getElementById('add-new-store-btn').classList.add('hidden');
                    filtered.forEach(store => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = "w-full text-left px-4 py-2.5 text-xs text-slate-300 hover:text-white hover:bg-blue-950/40 transition-colors";
                        item.textContent = store;
                        // Use onmousedown instead of onclick because onmousedown triggers before blur event
                        item.onmousedown = () => selectStore(store);
                        listContainer.appendChild(item);
                    });
                }
            }

            function showStoresDropdown() {
                document.getElementById('stores-dropdown').classList.remove('hidden');
                renderStoresList(document.getElementById('log-store').value);
            }

            function hideStoresDropdown() {
                // Delay hiding dropdown so that clicks on items have time to register
                setTimeout(() => {
                    document.getElementById('stores-dropdown').classList.add('hidden');
                }, 200);
            }

            function toggleStoresDropdown(event) {
                event.stopPropagation();
                const dropdown = document.getElementById('stores-dropdown');
                if (dropdown.classList.contains('hidden')) {
                    document.getElementById('log-store').focus();
                } else {
                    dropdown.classList.add('hidden');
                }
            }

            function filterStores() {
                const text = document.getElementById('log-store').value;
                renderStoresList(text);
            }

            function selectStore(storeName) {
                document.getElementById('log-store').value = storeName;
                document.getElementById('stores-dropdown').classList.add('hidden');
            }

            function addNewStore() {
                const newStore = document.getElementById('log-store').value.trim();
                if (newStore && !stores.includes(newStore)) {
                    stores.push(newStore);
                    stores.sort((a, b) => a.localeCompare(b));
                    selectStore(newStore);
                }
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

                // Loading state
                submitBtn.disabled = true;
                spinner.classList.remove('hidden');
                btnText.textContent = currentLang === 'es' ? 'Guardando...' : 'Saving...';

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
                        alert(currentLang === 'es' ? '¡Registro guardado con éxito!' : 'Log saved successfully!');
                        
                        // Reset Form fields (except Date)
                        document.getElementById('log-store').value = '';
                        document.getElementById('log-big').value = 0;
                        document.getElementById('log-small').value = 0;
                        document.getElementById('log-total').value = 0;
                        
                        // Reload stores list (which now contains the new store if added)
                        loadStores();
                    } else {
                        alert((currentLang === 'es' ? 'Error: ' : 'Error: ') + data.message);
                    }
                })
                .catch(err => {
                    console.error("Error submitting log:", err);
                    alert(currentLang === 'es' ? 'Error de conexión con el servidor.' : 'Server connection error.');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    spinner.classList.add('hidden');
                    btnText.textContent = currentLang === 'es' ? 'Guardar Registro' : 'Save Log';
                });
            }
        </script>

        <x-chatbot />
    </body>
</html>
