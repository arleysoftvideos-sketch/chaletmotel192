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

            /* ARLINGO APP CSS */
            .screen { display: none !important; min-height: 400px; flex-direction: column; align-items: center; width: 100%; box-sizing: border-box; }
            .active-screen { display: flex !important; }
            .modal-header { display: flex; flex-direction: column; padding: 15px 20px; border-bottom: 1px solid #ffb703; position: sticky; top: 0; background-color: rgba(6, 16, 33, 0.95); z-index: 1000; backdrop-filter: blur(10px); }
            .back-btn { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 8px 15px; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 0.8rem; transition: 0.3s; }
            .back-btn:hover { background: rgba(255,255,255,0.1); border-color: #ffb703; }
            .tabs-container { display: grid; grid-template-columns: repeat(1, 1fr); gap: 15px; width: 100%; max-width: 1000px; }
            @media (min-width: 640px) { .tabs-container { grid-template-columns: repeat(3, 1fr); } }
            .tab-btn { background: rgba(10, 24, 49, 0.8); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 15px; border-radius: 15px; font-weight: 600; cursor: pointer; font-size: 0.9rem; min-height: 80px; display: flex; align-items: center; justify-content: center; text-align: center; line-height: 1.3; transition: 0.3s; }
            .tab-btn:hover { border-color: #ffb703; box-shadow: 0 0 15px rgba(255,183,3,0.15); transform: translateY(-2px); }

            .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(4,10,23, 0.95); z-index: 2000; flex-direction: column; backdrop-filter: blur(5px); }
            .modal-body { padding: 20px; overflow-y: auto; flex: 1; max-width: 800px; margin: 0 auto; width: 100%; }
            .card-word { background: rgba(10, 24, 49, 0.9); border-radius: 15px; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border: 1px solid rgba(255,255,255,0.1); transition: 0.3s; }
            .playing-card { border-color: #ffb703; background: rgba(255,183,3, 0.1); transform: scale(1.02); }
            
            .play-all-btn { background: #ffb703; color: #0a1831; border: none; padding: 10px 20px; border-radius: 10px; font-weight: bold; font-size: 0.8rem; cursor: pointer; transition: 0.3s; }
            .play-all-btn:hover { background: #fbc02d; transform: translateY(-2px); }
            .play-btn { background: none; border: 1px solid #ffb703; color: #ffb703; width: 45px; height: 45px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: 0.3s; }
            .play-btn:hover { background: #ffb703; color: #0a1831; }

            .mode-card { background: rgba(10, 24, 49, 0.8); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 25px; margin: 10px 0; width: 100%; max-width: 450px; display: flex; align-items: center; gap: 20px; cursor: pointer; transition: 0.3s; text-align: left; }
            .mode-card:hover { border-color: #ffb703; transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
            .dict-main-btn { width: 100%; max-width: 450px; margin-top: 15px; background: linear-gradient(45deg, #0a1831, #14274c); border: 2px solid #ffb703; color: white; border-radius: 20px; height: 80px; font-weight: bold; font-size: 1rem; cursor: pointer; transition: 0.3s; }
            .dict-main-btn:hover { box-shadow: 0 0 20px rgba(255,183,3,0.3); }
            .modal-top-row { display: flex; justify-content: space-between; align-items: center; width: 100%; max-width: 800px; margin: 0 auto; gap: 10px; }
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

        <!-- Main Content Area / Interactive App -->
        <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-grow flex flex-col items-center relative z-10">
            
            <!-- LANGUAGE SCREEN -->
            <div id="languageScreen" class="screen active-screen w-full flex flex-col items-center">
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
                    <button onclick="chooseLanguage('en')" class="group relative overflow-hidden rounded-[2.5rem] border border-blue-900/50 bg-[#061021]/80 aspect-square sm:aspect-auto sm:h-[400px] flex flex-col items-center justify-center p-8 hover:border-gold/50 transition-all duration-500 shadow-2xl hover:shadow-gold/20 w-full text-center">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="w-32 h-32 mb-8 relative z-10 transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2 mx-auto">
                            <div class="w-full h-full bg-[#0a1831] border-2 border-gold/30 rounded-full flex items-center justify-center overflow-hidden shadow-[0_0_30px_rgba(255,183,3,0.15)] group-hover:shadow-[0_0_50px_rgba(255,183,3,0.3)] transition-all">
                                <img src="https://flagcdn.com/w160/us.png" srcset="https://flagcdn.com/w320/us.png 2x" alt="English" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                            </div>
                        </div>
                        
                        <h3 class="text-3xl font-black font-outfit text-white tracking-widest uppercase mb-3 relative z-10 group-hover:text-gold transition-colors">
                            {{ __('Aprender Inglés') }}
                        </h3>
                        <p class="text-slate-400 text-sm max-w-[250px] mx-auto relative z-10">
                            {{ __('Domina el idioma inglés con nuestras lecciones interactivas y ejercicios prácticos.') }}
                        </p>
                    </button>

                    <!-- Spanish Card -->
                    <button onclick="chooseLanguage('es')" class="group relative overflow-hidden rounded-[2.5rem] border border-blue-900/50 bg-[#061021]/80 aspect-square sm:aspect-auto sm:h-[400px] flex flex-col items-center justify-center p-8 hover:border-gold/50 transition-all duration-500 shadow-2xl hover:shadow-gold/20 w-full text-center">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="w-32 h-32 mb-8 relative z-10 transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2 mx-auto">
                            <div class="w-full h-full bg-[#0a1831] border-2 border-gold/30 rounded-full flex items-center justify-center overflow-hidden shadow-[0_0_30px_rgba(255,183,3,0.15)] group-hover:shadow-[0_0_50px_rgba(255,183,3,0.3)] transition-all">
                                <img src="https://flagcdn.com/w160/es.png" srcset="https://flagcdn.com/w320/es.png 2x" alt="Español" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                            </div>
                        </div>
                        
                        <h3 class="text-3xl font-black font-outfit text-white tracking-widest uppercase mb-3 relative z-10 group-hover:text-gold transition-colors">
                            {{ __('Aprender Español') }}
                        </h3>
                        <p class="text-slate-400 text-sm max-w-[250px] mx-auto relative z-10">
                            {{ __('Domina el idioma español con nuestras lecciones interactivas y ejercicios prácticos.') }}
                        </p>
                    </button>
                </div>
            </div>

            <!-- WELCOME SCREEN -->
            <div id="welcomeScreen" class="screen w-full flex flex-col items-center">
                <div class="w-full max-w-5xl flex justify-start items-center mb-4">
                    <button class="back-btn" onclick="showScreen('languageScreen')">← {{ __('VOLVER') }}</button>
                </div>
                <div class="text-center space-y-4 mb-8 flex flex-col items-center">
                    <img src="{{ asset('images/arlingo-logo.png') }}?v={{ time() }}" alt="Arlingo Mascot" class="w-32 h-32 mb-2 drop-shadow-[0_0_20px_rgba(57,255,20,0.4)] rounded-2xl">
                    <h2 class="text-3xl sm:text-4xl font-black font-outfit text-white uppercase tracking-wide">
                        {{ __('ARLINGO') }} <span class="text-gold">{{ __('Interactive Guide') }}</span>
                    </h2>
                    <p class="text-slate-400 text-sm max-w-2xl mx-auto uppercase tracking-wider">
                        {{ __('Selecciona un modo de aprendizaje para comenzar.') }}
                    </p>
                </div>

                <button class="mode-card" onclick="showScreen('lobbyScreen')">
                    <span class="text-4xl">⚡</span>
                    <div class="flex flex-col">
                        <strong class="text-white font-outfit text-xl uppercase tracking-wider">{{ __('Modo Interactivo') }}</strong>
                        <p class="text-slate-400 text-xs mt-1">{{ __('Toca y aprende por categorías de vocabulario.') }}</p>
                    </div>
                </button>

                <button class="mode-card border-red-900/30 hover:border-red-500/50" onclick="openSleepMode()">
                    <span class="text-4xl">🌙</span>
                    <div class="flex flex-col">
                        <strong class="text-white font-outfit text-xl uppercase tracking-wider">{{ __('Modo Descanso') }}</strong>
                        <p class="text-slate-400 text-xs mt-1">{{ __('Escucha lecciones continuas mientras duermes.') }}</p>
                    </div>
                </button>
            </div>

            <!-- LOBBY SCREEN -->
            <div id="lobbyScreen" class="screen w-full flex flex-col items-center">
                <div class="w-full max-w-5xl flex justify-between items-center mb-8 border-b border-blue-950 pb-4">
                    <button class="back-btn" onclick="showScreen('welcomeScreen')">← {{ __('VOLVER') }}</button>
                    <span class="text-gold font-bold font-outfit text-sm uppercase tracking-widest">{{ __('Categorías de Estudio') }}</span>
                </div>
                <div class="tabs-container" id="tabs"></div>
            </div>



        </main>

        <!-- CATEGORY MODAL -->
        <div id="categoryModal" class="modal">
            <div class="modal-header">
                <div class="w-full max-w-5xl mx-auto flex justify-start items-center mb-4">
                    <button class="back-btn" onclick="closeModal()">← {{ __('VOLVER') }}</button>
                </div>
                <div class="modal-top-row">
                    <div class="flex items-center gap-4 sm:gap-6">
                        <div id="modalTargetFlag" class="shrink-0"></div>
                        <div class="flex flex-col">
                            <h2 id="modalTitle" class="text-gold font-black font-outfit text-xl sm:text-2xl uppercase tracking-wide m-0">DICCIONARIO</h2>
                            <div class="flex items-center gap-3 mt-1">
                                <span id="itemCount" class="text-slate-400 text-xs font-bold tracking-widest">0 palabras</span>
                                <span class="text-slate-600 text-xs">|</span>
                                <span id="learningLabel" class="tracking-wider uppercase text-[10px] font-bold text-slate-300"></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-4 mt-4 sm:mt-0">
                        <button id="btnPlayCategory" class="play-all-btn font-outfit" onclick="playFullCategory()">▶ {{ __('REPRODUCIR TODO') }}</button>
                    </div>
                </div>
            </div>
            <div id="modalBody" class="modal-body"></div>
        </div>

        <!-- SLEEP MODE MODAL -->
        <div id="sleepModeModal" class="modal" style="background: rgba(2, 6, 15, 0.98);">
            <div class="flex flex-col items-center justify-center h-full w-full p-6 text-center">
                <span class="text-6xl sm:text-8xl mb-6 animate-pulse">🌙</span>
                <h2 class="text-gold font-black font-outfit text-2xl sm:text-4xl uppercase tracking-widest mb-2">{{ __('Modo Descanso') }}</h2>
                <p class="text-slate-400 text-sm sm:text-base mb-8">{{ __('Reproduciendo aleatoriamente todas las categorías durante 1 hora. La pantalla se mantendrá encendida.') }}</p>
                
                <div class="w-full max-w-md bg-navy-800 border border-blue-900/50 rounded-2xl p-6 mb-12 shadow-2xl">
                    <p id="sleepModePhraseEs" class="text-white font-bold text-xl sm:text-2xl mb-4 leading-snug">Cargando...</p>
                    <p id="sleepModePhraseEn" class="text-gold text-lg sm:text-xl font-outfit">Loading...</p>
                </div>

                <div class="w-full max-w-md bg-gray-800 rounded-full h-2 mb-8 overflow-hidden">
                    <div id="sleepModeProgress" class="bg-gold h-2 rounded-full" style="width: 0%"></div>
                </div>

                <button class="bg-red-600 hover:bg-red-500 text-white font-bold py-4 px-10 rounded-full shadow-lg transition-transform hover:scale-105 active:scale-95 flex items-center gap-3" onclick="stopSleepMode()">
                    <span class="text-2xl">⏹️</span> {{ __('DETENER') }}
                </button>
            </div>
        </div>

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

        <!-- ARLINGO JAVASCRIPT -->
        <script>
            const data = {
                "01. MUNDIAL FIFA 2026 🏆": [
                    { es: "La final será en New Jersey.", en: "The final will be in New Jersey.", pro: "de fai-nal guil bi in niu ier-si" },
                    { es: "¡Gol de último minuto!", en: "Last-minute goal!", pro: "last mi-nit goul" },
                    { es: "¿Dónde puedo comprar entradas?", en: "Where can I buy tickets?", pro: "guer can ai bai ti-kets" },
                    { es: "El estadio está lleno.", en: "The stadium is packed.", pro: "de estei-diom is pakt" },
                    { es: "Apuesto por mi equipo.", en: "I bet on my team.", pro: "ai bet on mai tiim" },
                    { es: "¡Árbitro, eso fue falta!", en: "Referee, that was a foul!", pro: "re-fe-rii dat guas a faul" },
                    { es: "Necesito un pase de estacionamiento.", en: "I need a parking pass.", pro: "ai niid a par-kin pas" },
                    { es: "El ambiente está increíble.", en: "The atmosphere is amazing.", pro: "de at-mos-fiar is a-mei-zin" },
                    { es: "¿Quién va ganando?", en: "Who is winning?", pro: "ju is gui-nin" },
                    { es: "Es un partido histórico.", en: "It's a historic match.", pro: "its a jis-to-rik mach" },
                    { es: "La seguridad es muy estricta.", en: "Security is very strict.", pro: "si-kiu-ri-ti is ve-ri estrikt" },
                    { es: "¿Dónde queda la tienda oficial?", en: "Where is the official store?", pro: "guer is di o-fi-shal estoor" },
                    { es: "El partido se va a prórroga.", en: "The game is going to overtime.", pro: "de gueim is gou-in tu ou-ver-taim" },
                    { es: "¡Ganamos la copa!", en: "We won the cup!", pro: "gui guon de cap" },
                    { es: "Muéstrame tu código QR.", en: "Show me your QR code.", pro: "shou mi ior qui-ar coud" },
                    { es: "Perdimos en los penaltis.", en: "We lost on penalties.", pro: "gui lost on pe-nal-tis" },
                    { es: "¡Qué gran atajada!", en: "What a great save!", pro: "uat a greit seiv" },
                    { es: "Tengo asientos en primera fila.", en: "I have front row seats.", pro: "ai jaf front rou siits" },
                    { es: "El tráfico está terrible.", en: "The traffic is terrible.", pro: "de tra-fik is te-ri-bol" },
                    { es: "¡Que empiece el juego!", en: "Let the game begin!", pro: "let de gueim bi-guin" },
                    { es: "¿A qué hora abren las puertas?", en: "What time do the gates open?", pro: "uat taim du de gueits ou-pen" },
                    { es: "Mi asiento está en la sección de arriba.", en: "My seat is in the upper section.", pro: "mai siit is in di a-per sek-shon" },
                    { es: "No se permiten bolsos grandes.", en: "Large bags are not allowed.", pro: "larch bags ar not a-laud" },
                    { es: "¿Dónde está el baño más cercano?", en: "Where is the nearest restroom?", pro: "guer is de ni-rest rest-ruum" },
                    { es: "Necesito ver tu identificación.", en: "I need to see your ID.", pro: "ai niid tu sii ior ai-dii" },
                    { es: "El partido fue suspendido.", en: "The match was postponed.", pro: "de mach guas poust-pound" },
                    { es: "¡Vaya jugada de lujo!", en: "What a spectacular play!", pro: "uat a es-pek-ta-kiu-lar plei" },
                    { es: "El equipo local está jugando bien.", en: "The home team is playing well.", pro: "de joum tiim is plei-in guel" },
                    { es: "Estamos en zona de fuera de juego.", en: "That was an offside position.", pro: "dat guas an of-said po-si-shon" },
                    { es: "El próximo partido es mañana.", en: "The next match is tomorrow.", pro: "de nekst mach is tu-ma-rou" },
                    { es: "Compré la camiseta oficial.", en: "I bought the official jersey.", pro: "ai bot di o-fi-shal ier-si" },
                    { es: "Este es el mejor torneo del mundo.", en: "This is the best tournament in the world.", pro: "dis is de best tur-na-ment in de uerld" },
                    { es: "¿Hay wifi gratis en el estadio?", en: "Is there free Wi-Fi in the stadium?", pro: "is der frii uai-fai in de estei-diom" },
                    { es: "No encuentro mi puerta de entrada.", en: "I can't find my entrance gate.", pro: "ai kant faind mai en-trans gueit" },
                    { es: "El pase fue perfecto.", en: "The pass was perfect.", pro: "de pas guas per-fekt" },
                    { es: "Ellos tienen una defensa sólida.", en: "They have a solid defense.", pro: "dei jaf a so-lid di-fens" },
                    { es: "El delantero es muy rápido.", en: "The forward is very fast.", pro: "de for-uard is ve-ri fast" },
                    { es: "¡Eso debió ser tarjeta amarilla!", en: "That should have been a yellow card!", pro: "dat shuld jaf biin a ie-lou card" },
                    { es: "El estadio tiene techo retráctil.", en: "The stadium has a retractable roof.", pro: "de estei-diom jas a ri-trak-ta-bol ruuf" },
                    { es: "Quiero comprar una bufanda del equipo.", en: "I want to buy a team scarf.", pro: "ai uant tu bai a tiim es-karf" },
                    { es: "El tren al estadio está lleno.", en: "The train to the stadium is full.", pro: "de trein tu de estei-diom is ful" },
                    { es: "Hay que hacer fila para entrar.", en: "We have to line up to get in.", pro: "gui jaf tu lain ap tu guet in" },
                    { es: "El himno nacional está comenzando.", en: "The national anthem is starting.", pro: "de na-sho-nal an-zem is es-tar-tin" },
                    { es: "¡Qué golazo de tiro libre!", en: "What a great free-kick goal!", pro: "uat a greit frii-kik goul" },
                    { es: "Él es el jugador del partido.", en: "He is the man of the match.", pro: "ji is de man of de mach" },
                    { es: "Quedan diez minutos de juego.", en: "There are ten minutes left in the game.", pro: "der ar ten mi-nits left in de gueim" },
                    { es: "El árbitro agregó cuatro minutos.", en: "The referee added four minutes.", pro: "de re-fe-rii a-ded for mi-nits" },
                    { es: "El portero tapó el penalti.", en: "The goalkeeper blocked the penalty.", pro: "de goul-kii-per blokt de pe-nal-ti" },
                    { es: "Estamos en los octavos de final.", en: "We are in the round of sixteen.", pro: "gui ar in de raund of siks-tiin" },
                    { es: "El torneo se juega en tres países.", en: "The tournament is played in three countries.", pro: "de tur-na-ment is pleid in zrii can-tris" },
                    { es: "¿Dónde puedo recoger mis boletos?", en: "Where can I pick up my tickets?", pro: "guer can ai pik ap mai ti-kets" },
                    { es: "La entrada digital no funciona.", en: "The digital ticket is not working.", pro: "de di-yi-tal ti-ket is not uer-kin" },
                    { es: "El estacionamiento está carísimo.", en: "Parking is extremely expensive.", pro: "par-kin is eks-triim-li eks-pen-siv" },
                    { es: "No se permite comida de afuera.", en: "Outside food is not allowed.", pro: "aut-said fuud is not a-laud" },
                    { es: "Hay pantallas gigantes por todo lado.", en: "There are giant screens everywhere.", pro: "der ar ia-iant es-criins ev-ri-guer" },
                    { es: "Mi equipo favorito quedó eliminado.", en: "My favorite team was eliminated.", pro: "mai fei-vo-rit tiim guas i-li-mi-nei-ted" },
                    { es: "¡Eso fue mano clara!", en: "That was a clear handball!", pro: "dat guas a cliar jand-bol" },
                    { es: "El VAR está revisando la jugada.", en: "The VAR is reviewing the play.", pro: "de vi-ei-ar is ri-viu-in de plei" },
                    { es: "El capitán del equipo está lesionado.", en: "The team captain is injured.", pro: "de tiim kap-ten is in-jurd" },
                    { es: "El partido terminó en empate.", en: "The game ended in a tie.", pro: "de gueim en-ded in a tai" },
                    { es: "Necesitamos un milagro para clasificar.", en: "We need a miracle to qualify.", pro: "gui niid a mi-ra-kol tu cua-li-fai" },
                    { es: "La policía está controlando la multitud.", en: "The police are controlling the crowd.", pro: "de po-liis ar con-trou-lin de craud" },
                    { es: "Hay muchos puestos de comida rápida.", en: "There are many fast food stands.", pro: "der ar me-ni fast fuud estands" },
                    { es: "¿A qué hora es la ceremonia de apertura?", en: "What time is the opening ceremony?", pro: "uat taim is di ou-pe-nin se-re-mo-ni" },
                    { es: "El clima está perfecto para el partido.", en: "The weather is perfect for the match.", pro: "de gue-der is per-fekt for de mach" },
                    { es: "Quiero una foto con la mascota.", en: "I want a picture with the mascot.", pro: "ai uant a pik-chur guiz de mas-cot" },
                    { es: "Los boletos se agotaron en minutos.", en: "Tickets sold out in minutes.", pro: "ti-kets sould aut in mi-nits" },
                    { es: "El estadio tiene capacidad para ochenta mil personas.", en: "The stadium holds eighty thousand people.", pro: "de estei-diom jolds ei-ti zau-sand pii-pol" },
                    { es: "¡Qué golazo de chilena!", en: "What a bicycle kick goal!", pro: "uat a bai-si-kol kik goul" },
                    { es: "La afición está cantando sin parar.", en: "The fans are chanting without stopping.", pro: "de fans ar chan-tin gui-daut es-to-pin" },
                    { es: "¿Dónde se toma el autobús oficial?", en: "Where do I catch the official bus?", pro: "guer du ai kach di o-fi-shal bas" },
                    { es: "Tengo mi pase de prensa listo.", en: "I have my press pass ready.", pro: "ai jaf mai pres pas re-di" },
                    { es: "El hotel queda cerca del estadio.", en: "The hotel is close to the stadium.", pro: "de jo-tel is clous tu de estei-diom" },
                    { es: "¡Cuidado con los carteristas afuera!", en: "Watch out for pickpockets outside!", pro: "uach aut for pik-po-kets aut-said" },
                    { es: "La transmisión en vivo se cortó.", en: "The live stream cut out.", pro: "de laiv es-triim cat aut" },
                    { es: "El segundo tiempo ya comenzó.", en: "The second half already started.", pro: "de se-kond jaf ol-re-di es-tar-ted" },
                    { es: "El técnico hizo tres cambios.", en: "The coach made three substitutions.", pro: "de couch meid zrii sab-sti-tuu-shons" },
                    { es: "Fue una falta táctica.", en: "It was a tactical foul.", pro: "it guas a tak-ti-kol faul" },
                    { es: "Estamos en los cuartos de final.", en: "We are in the quarterfinals.", pro: "gui ar in de cuor-ter-fai-nals" },
                    { es: "La semifinal va a ser intensa.", en: "The semifinal is going to be intense.", pro: "de se-mi-fai-nal is gou-in tu bi in-tens" },
                    { es: "Quiero ver la repetición en la pantalla.", en: "I want to see the replay on the screen.", pro: "ai uant tu sii de ri-plei on de es-criin" },
                    { es: "Este jugador tiene mucha experiencia.", en: "This player has a lot of experience.", pro: "dis plei-er jas a lot of eks-pi-ri-ens" },
                    { es: "El balón pegó en el poste.", en: "The ball hit the post.", pro: "de bol jit de poust" },
                    { es: "¡Eso fue penal clarísimo!", en: "That was an absolute penalty!", pro: "dat guas an ab-so-lut pe-nal-ti" },
                    { es: "El trofeo original está en exhibición.", en: "The original trophy is on display.", pro: "di o-ri-yi-nal trou-fi is on dis-plei" },
                    { es: "Toda la ciudad está de fiesta.", en: "The whole city is celebrating.", pro: "de joul si-ti is se-le-brei-tin" },
                    { es: "Necesitamos ganar este partido sí o sí.", en: "We must win this game no matter what.", pro: "gui mast guin dis gueim nou ma-ter uat" },
                    { es: "El viaje en metro fue muy rápido.", en: "The subway ride was very fast.", pro: "de sab-guei raid guas ve-ri fast" },
                    { es: "No se puede fumar dentro del estadio.", en: "Smoking is banned inside the stadium.", pro: "es-mou-kin is band in-said de estei-diom" },
                    { es: "El grupo de la muerte está reñido.", en: "The group of death is very tight.", pro: "de grup of dez is ve-ri tait" },
                    { es: "El pase de gol fue increíble.", en: "The assist was incredible.", pro: "di a-sist guas in-crei-di-bol" },
                    { es: "¡Gol en contra, no lo puedo creer!", en: "An own goal, I can't believe it!", pro: "an oun goul, ai kant bi-liiv it" },
                    { es: "El equipo está jugando al contragolpe.", en: "The team is playing on the counterattack.", pro: "de tiim is plei-in on de caun-ter-a-tak" },
                    { es: "La zona de aficionados tiene pantallas gigantes.", en: "The fan zone has giant screens.", pro: "de fan zoun jas ia-iant es-criins" },
                    { es: "Hay oficiales de FIFA por todas partes.", en: "There are FIFA officials everywhere.", pro: "der ar fii-fa o-fi-shals ev-ri-guer" },
                    { es: "El silbato final sonó.", en: "The final whistle blew.", pro: "de fai-nal guis-sol bluu" },
                    { es: "¡Somos los campeones del mundo!", en: "We are the champions of the world!", pro: "gui ar de cham-pions of de uerld" },
                    { es: "El legado de este mundial será enorme.", en: "The legacy of this World Cup will be huge.", pro: "de le-ga-si of dis uerld cap guil bi jiuuch" },
                    { es: "Ya tengo mi código de barras listo.", en: "I have my barcode ready.", pro: "ai jaf mai bar-coud re-di" },
                    { es: "¡Nos vemos en el próximo partido!", en: "See you at the next game!", pro: "sii iu at de nekst gueim" }
                ],
                "Abecedario 🔤": [
                    { es: "A (como en Apple)", en: "A /ei/", pro: "ei" },
                    { es: "B (como en Boy)", en: "B /bi/", pro: "bi" },
                    { es: "C (como en Cat)", en: "C /si/", pro: "si" },
                    { es: "D (como en Door)", en: "D /di/", pro: "di" },
                    { es: "E (como en Easy)", en: "E /i/", pro: "i" },
                    { es: "F (como en Fast)", en: "F /ef/", pro: "ef" },
                    { es: "G (como en Gas)", en: "G /yi/", pro: "yi" },
                    { es: "H (como en Hotel)", en: "H /eich/", pro: "eich" },
                    { es: "I (como en Ice)", en: "I /ai/", pro: "ai" },
                    { es: "J (como en Job)", en: "J /jei/", pro: "jei" },
                    { es: "K (como en Key)", en: "K /kei/", pro: "kei" },
                    { es: "L (como en Light)", en: "L /el/", pro: "el" },
                    { es: "M (como en Men)", en: "M /em/", pro: "em" },
                    { es: "N (como en Now)", en: "N /en/", pro: "en" },
                    { es: "O (como en Open)", en: "O /ou/", pro: "ou" },
                    { es: "P (como en Park)", en: "P /pi/", pro: "pi" },
                    { es: "Q (como en QR)", en: "Q /kiu/", pro: "kiu" },
                    { es: "R (como en Red)", en: "R /ar/", pro: "ar" },
                    { es: "S (como en Street)", en: "S /es/", pro: "es" },
                    { es: "T (como en Ticket)", en: "T /ti/", pro: "ti" },
                    { es: "U (como en Use)", en: "U /iu/", pro: "iu" },
                    { es: "V (como en View)", en: "V /vi/", pro: "vi" },
                    { es: "W (como en Water)", en: "W /da-bol-iu/", pro: "da-bol-iu" },
                    { es: "X (como en Exam)", en: "X /eks/", pro: "eks" },
                    { es: "Y (como en Yellow)", en: "Y /uai/", pro: "uai" },
                    { es: "Z (como en Zone)", en: "Z /sii/", pro: "sii" },
                    { es: "¿Cómo se deletrea tu nombre?", en: "How do you spell your name?", pro: "jau du iu es-pel ior neim" },
                    { es: "Deletrea tu apellido, por favor.", en: "Spell your last name, please.", pro: "es-pel ior last neim pliiz" },
                    { es: "Mi nombre comienza con J.", en: "My name starts with J.", pro: "mai neim es-tarts guiz jei" },
                    { es: "Doble L", en: "Double L", pro: "da-bol el" },
                    { es: "Doble O", en: "Double O", pro: "da-bol ou" },
                    { es: "Arroba (en correos)", en: "At", pro: "at" },
                    { es: "Punto (en correos/webs)", en: "Dot", pro: "dot" },
                    { es: "Guión bajo", en: "Underscore", pro: "an-der-es-kor" },
                    { es: "Guión medio", en: "Hyphen / Dash", pro: "jai-fen / dash" },
                    { es: "Signo de número (#)", en: "Pound key / Hashtag", pro: "paund kii / jash-tag" },
                    { es: "Signo de dólar ($)", en: "Dollar sign", pro: "do-lar sain" },
                    { es: "Espacio", en: "Space", pro: "es-peis" },
                    { es: "Letra mayúscula", en: "Capital letter", pro: "ka-pi-tal le-ter" },
                    { es: "Letra minúscula", en: "Lowercase letter", pro: "lou-er-keis le-ter" },
                    { es: "Todo en mayúsculas", en: "All caps", pro: "ol kaps" },
                    { es: "Código de confirmación", en: "Confirmation code", pro: "con-fer-mei-shon coud" },
                    { es: "Número de apartamento", en: "Apartment number", pro: "a-part-ment nam-ber" },
                    { es: "Código postal", en: "Zip code", pro: "srip coud" },
                    { es: "Dirección de correo", en: "Email address", pro: "ii-meil a-dres" },
                    { es: "A de Alfa", en: "A as in Alpha", pro: "ei as in al-fa" },
                    { es: "B de Bravo", en: "B as in Bravo", pro: "bi as in bra-vo" },
                    { es: "C de Charlie", en: "C as in Charlie", pro: "si as in char-li" },
                    { es: "D de Delta", en: "D as in Delta", pro: "di as in del-ta" },
                    { es: "E de Echo", en: "E as in Echo", pro: "i as in e-cou" },
                    { es: "F de Foxtrot", en: "F as in Foxtrot", pro: "ef as in foks-trot" },
                    { es: "G de Golf", en: "G as in Golf", pro: "yi as in golf" },
                    { es: "H de Hotel", en: "H as in Hotel", pro: "eich as in jo-tel" },
                    { es: "I de India", en: "I as in India", pro: "ai as in in-dia" },
                    { es: "J de Juliet", en: "J as in Juliet", pro: "jei as in ju-liet" },
                    { es: "K de Kilo", en: "K as in Kilo", pro: "kei as in ki-lou" },
                    { es: "L de Lima", en: "L as in Lima", pro: "el as in li-ma" },
                    { es: "M de Mike", en: "M as in Mike", pro: "em as in maik" },
                    { es: "N de November", en: "N as in November", pro: "en as in nou-vem-ber" },
                    { es: "O de Oscar", en: "O as in Oscar", pro: "ou as in os-kar" },
                    { es: "P de Papa", en: "P as in Papa", pro: "pi as in pa-pa" },
                    { es: "Q de Quebec", en: "Q as in Quebec", pro: "kiu as in cue-bek" },
                    { es: "R de Romeo", en: "R as in Romeo", pro: "ar as in rou-mio" },
                    { es: "S de Sierra", en: "S as in Sierra", pro: "es as in sie-ra" },
                    { es: "T de Tango", en: "T as in Tango", pro: "ti as in tan-gou" },
                    { es: "U de Uniform", en: "U as in Uniform", pro: "iu as in iu-ni-form" },
                    { es: "V de Victor", en: "V as in Victor", pro: "vi as in vik-tor" },
                    { es: "W de Whiskey", en: "W as in Whiskey", pro: "da-bol-iu as in guis-ki" },
                    { es: "X de X-ray", en: "X as in X-ray", pro: "eks as in eks-rei" },
                    { es: "Y de Yankee", en: "Y as in Yankee", pro: "uai as in ian-ki" },
                    { es: "Z de Zulu", en: "Z as in Zulu", pro: "sii as in zu-lu" },
                    { es: "No entiendo esa letra.", en: "I don't understand that letter.", pro: "ai dount an-der-es-tand dat le-ter" },
                    { es: "¿Es una B o una P?", en: "Is that a B or a P?", pro: "is dat a bi or a pi" },
                    { es: "¿Es una M o una N?", en: "Is that an M or an N?", pro: "is dat an em or an en" },
                    { es: "Por favor escribe las letras.", en: "Please write down the letters.", pro: "pliis rait daun de le-ters" },
                    { es: "Tu código tiene cinco letras.", en: "Your code has five letters.", pro: "ior coud jas faiv le-ters" },
                    { es: "La contraseña distingue mayúsculas.", en: "The password is case sensitive.", pro: "de pas-guerd is keis sen-si-tiv" },
                    { es: "Primer nombre", en: "First name", pro: "ferst neim" },
                    { es: "Segundo nombre", en: "Middle name", pro: "mi-dol neim" },
                    { es: "Apellido", en: "Last name", pro: "last neim" },
                    { es: "Deletrea la calle.", en: "Spell the street.", pro: "es-pel de es-triit" },
                    { es: "Doble dígito", en: "Double digit", pro: "da-bol di-yit" },
                    { es: "Diga las letras una por una.", en: "Say the letters one by one.", pro: "sei de le-ters uan bai uan" },
                    { es: "Déjame verificar el deletreo.", en: "Let me check the spelling.", pro: "let mi chek de es-pel-in" },
                    { es: "Está mal deletreado.", en: "It's misspelled.", pro: "its mis-peld" },
                    { es: "El sistema no reconoce la letra.", en: "The system doesn't recognize the letter.", pro: "de sis-tem da-sent re-coog-nais de le-ter" },
                    { es: "Usa letras de molde.", en: "Use block letters.", pro: "iuus blok le-ters" },
                    { es: "Firma con tus iniciales.", en: "Sign with your initials.", pro: "sain guiz ior i-ni-shals" },
                    { es: "La última letra es una X.", en: "The last letter is an X.", pro: "de last le-ter is an eks" },
                    { es: "La primera letra es una vocal.", en: "The first letter is a vowel.", pro: "de ferst le-ter is a vau-el" },
                    { es: "Estas letras son consonantes.", en: "These letters are consonants.", pro: "ziis le-ters ar con-so-nants" },
                    { es: "Deletrea la ciudad.", en: "Spell the city.", pro: "es-pel de si-ti" },
                    { es: "Mi correo es todo en minúsculas.", en: "My email is all lowercase.", pro: "mai ii-meil is ol lou-er-keis" },
                    { es: "No lleva espacios.", en: "It has no spaces.", pro: "it jas nou es-pei-ses" },
                    { es: "¿Me escuchas bien?", en: "Can you hear me clearly?", pro: "can iu jiar mi cliar-li" },
                    { es: "Repite la tercera letra.", en: "Repeat the third letter.", pro: "ri-piit de zerd le-ter" },
                    { es: "Ya tengo el deletreo completo.", en: "I have the full spelling now.", pro: "ai jaf de ful es-pel-in nau" },
                    { es: "Gracias por deletrearlo.", en: "Thank you for spelling it.", pro: "zenk iu for es-pel-in it" },
                    { es: "Listo, verificado.", en: "Done, verified.", pro: "dan, ve-ri-faid" }
                ],
                "Adjetivos Comunes 💡": [
                    { es: "Grande", en: "Big", pro: "bigu" },
                    { es: "Pequeño", en: "Small", pro: "es-mol" },
                    { es: "Rápido", en: "Fast", pro: "fast" },
                    { es: "Lento", en: "Slow", pro: "slou" },
                    { es: "Caliente", en: "Hot", pro: "jot" },
                    { es: "Frío", en: "Cold", pro: "could" },
                    { es: "Nuevo", en: "New", pro: "niu" },
                    { es: "Viejo", en: "Old", pro: "ould" },
                    { es: "Barato", en: "Cheap", pro: "chiip" },
                    { es: "Caro", en: "Expensive", pro: "eks-pen-siv" },
                    { es: "Fácil", en: "Easy", pro: "ii-si" },
                    { es: "Difícil", en: "Difficult", pro: "di-fi-kalt" },
                    { es: "Limpio", en: "Clean", pro: "kliin" },
                    { es: "Sucio", en: "Dirty", pro: "der-ti" },
                    { es: "Lleno", en: "Full", pro: "ful" },
                    { es: "Vacío", en: "Empty", pro: "emp-ti" },
                    { es: "Pesado", en: "Heavy", pro: "je-vi" },
                    { es: "Ligero", en: "Light", pro: "lait" },
                    { es: "Abierto", en: "Open", pro: "ou-pen" },
                    { es: "Cerrado", en: "Closed", pro: "clousd" },
                    { es: "Bueno", en: "Good", pro: "gud" },
                    { es: "Malo", en: "Bad", pro: "bad" },
                    { es: "Hermoso / Bonito", en: "Beautiful", pro: "biu-ti-ful" },
                    { es: "Feo", en: "Ugly", pro: "ag-li" },
                    { es: "Largo", en: "Long", pro: "long" },
                    { es: "Corto", en: "Short", pro: "short" },
                    { es: "Alto (Estatura)", en: "Tall", pro: "tol" },
                    { es: "Bajo (Estatura)", en: "Short", pro: "short" },
                    { es: "Fuerte", en: "Strong", pro: "es-trong" },
                    { es: "Débil", en: "Weak", pro: "guiik" },
                    { es: "Rico / Adinerado", en: "Rich", pro: "rich" },
                    { es: "Pobre", en: "Poor", pro: "puor" },
                    { es: "Joven", en: "Young", pro: "iang" },
                    { es: "Anciano / Mayor", en: "Elderly", pro: "el-der-li" },
                    { es: "Feliz", en: "Happy", pro: "ja-pi" },
                    { es: "Triste", en: "Sad", pro: "sad" },
                    { es: "Enojado", en: "Angry", pro: "an-gri" },
                    { es: "Cansado", en: "Tired", pro: "tai-ard" },
                    { es: "Enfermo", en: "Sick", pro: "sik" },
                    { es: "Sano / Saludable", en: "Healthy", pro: "jel-zi" },
                    { es: "Seguro (Lugar/Cosa)", en: "Safe", pro: "seif" },
                    { es: "Peligroso", en: "Dangerous", pro: "dein-ye-ros" },
                    { es: "Inteligente", en: "Smart", pro: "es-mart" },
                    { es: "Amable", en: "Kind", pro: "kaind" },
                    { es: "Grosero", en: "Rude", pro: "ruud" },
                    { es: "Divertido", en: "Fun", pro: "fan" },
                    { es: "Aburrido", en: "Boring", pro: "bo-rin" },
                    { es: "Ancho", en: "Wide", pro: "uaid" },
                    { es: "Estrecho / Angosto", en: "Narrow", pro: "na-rou" },
                    { es: "Oscuro", en: "Dark", pro: "dark" },
                    { es: "Claro / Brillante", en: "Bright", pro: "brait" },
                    { es: "Suave", en: "Soft", pro: "soft" },
                    { es: "Duro", en: "Hard", pro: "jard" },
                    { es: "Áspero", en: "Rough", pro: "raf" },
                    { es: "Liso / Suave", en: "Smooth", pro: "smuuz" },
                    { es: "Ruidoso", en: "Noisy", pro: "noi-si" },
                    { es: "Silencioso", en: "Quiet", pro: "cuai-et" },
                    { es: "Moderno", en: "Modern", pro: "mo-dern" },
                    { es: "Antiguo / Viejo", en: "Ancient", pro: "ein-shent" },
                    { es: "Perfecto", en: "Perfect", pro: "per-fekt" },
                    { es: "Falso", en: "Fake", pro: "feik" },
                    { es: "Verdadero / Real", en: "Real", pro: "rial" },
                    { es: "Importante", en: "Important", pro: "im-por-tant" },
                    { es: "Inútil", en: "Useless", pro: "iuus-les" },
                    { es: "Útil", en: "Useful", pro: "iuus-ful" },
                    { es: "Fresco", en: "Fresh", pro: "fresh" },
                    { es: "Salado", en: "Salty", pro: "sol-ti" },
                    { es: "Dulce", en: "Sweet", pro: "suiit" },
                    { es: "Amargo", en: "Bitter", pro: "bi-ter" },
                    { es: "Ácido / Agrio", en: "Sour", pro: "sau-ar" },
                    { es: "Picante", en: "Spicy", pro: "es-pai-si" },
                    { es: "Sabroso / Delicioso", en: "Delicious", pro: "di-li-shos" },
                    { es: "Asqueroso", en: "Disgusting", pro: "dis-gas-tin" },
                    { es: "Temprano", en: "Early", pro: "er-li" },
                    { es: "Tarde", en: "Late", pro: "leit" },
                    { es: "Cercano", en: "Near", pro: "niar" },
                    { es: "Lejano", en: "Far", pro: "far" },
                    { es: "Diferente", en: "Different", pro: "di-fe-rent" },
                    { es: "Mismo / Igual", en: "Same", pro: "seim" },
                    { es: "Libre / Gratis", en: "Free", pro: "frii" },
                    { es: "Ocupado", en: "Busy", pro: "bi-si" },
                    { es: "Público", en: "Public", pro: "pab-lik" },
                    { es: "Privado", en: "Private", pro: "prai-vat" },
                    { es: "Extraño / Raro", en: "Strange", pro: "es-treinch" },
                    { es: "Normal", en: "Normal", pro: "nor-mal" },
                    { es: "Increíble", en: "Awesome", pro: "ou-som" },
                    { es: "Terrible", en: "Terrible", pro: "te-ri-bol" },
                    { es: "Listo (Preparado)", en: "Ready", pro: "re-di" },
                    { es: "Cómodo", en: "Comfortable", pro: "kam-for-ta-bol" },
                    { es: "Incómodo", en: "Uncomfortable", pro: "an-kam-for-ta-bol" },
                    { es: "Flojo / Suelto", en: "Loose", pro: "luus" },
                    { es: "Apretado", en: "Tight", pro: "tait" },
                    { es: "Húmedad / Mojado", en: "Wet", pro: "uet" },
                    { es: "Seco", en: "Dry", pro: "drai" },
                    { es: "Lleno de gente", en: "Crowded", pro: "crau-ded" },
                    { es: "Fiel / Leal", en: "Loyal", pro: "loi-al" },
                    { es: "Caro", en: "Pricey", pro: "prai-si" },
                    { es: "Tacaño", en: "Cheap (person)", pro: "chiip" },
                    { es: "Orgulloso", en: "Proud", pro: "praud" },
                    { es: "Celoso", en: "Jealous", pro: "je-los" }
                ],
                "Alimentos y Bebidas 🍕": [
                    { es: "Agua", en: "Water", pro: "ua-ter" },
                    { es: "Café", en: "Coffee", pro: "co-fii" },
                    { es: "Pan", en: "Bread", pro: "bred" },
                    { es: "Carne", en: "Meat", pro: "miit" },
                    { es: "Pollo", en: "Chicken", pro: "chi-ken" },
                    { es: "Arroz", en: "Rice", pro: "rais" },
                    { es: "Huevo", en: "Egg", pro: "egu" },
                    { es: "Queso", en: "Cheese", pro: "chiis" },
                    { es: "Leche", en: "Milk", pro: "milk" },
                    { es: "Jugo", en: "Juice", pro: "juus" },
                    { es: "Sal", en: "Salt", pro: "solt" },
                    { es: "Azúcar", en: "Sugar", pro: "shu-gar" },
                    { es: "Mantequilla", en: "Butter", pro: "ba-ter" },
                    { es: "Pescado", en: "Fish", pro: "fish" },
                    { es: "Fruta", en: "Fruit", pro: "frut" },
                    { es: "Verduras", en: "Vegetables", pro: "vech-ta-bols" },
                    { es: "Cerveza", en: "Beer", pro: "bii-ar" },
                    { es: "Sopa", en: "Soup", pro: "suup" },
                    { es: "Aceite", en: "Oil", pro: "oil" },
                    { es: "Papas fritas", en: "French fries", pro: "french frais" },
                    { es: "Carne de res", en: "Beef", pro: "biif" },
                    { es: "Carne de cerdo", en: "Pork", pro: "pork" },
                    { es: "Jamón", en: "Ham", pro: "jam" },
                    { es: "Tocino / Tocineta", en: "Bacon", pro: "bei-kon" },
                    { es: "Salchicha", en: "Sausage", pro: "so-sich" },
                    { es: "Mariscos", en: "Seafood", pro: "sii-fuud" },
                    { es: "Camarones", en: "Shrimp", pro: "shrimp" },
                    { es: "Ensalada", en: "Salad", pro: "sa-lad" },
                    { es: "Pimienta", en: "Pepper", pro: "pe-per" },
                    { es: "Ajo", en: "Garlic", pro: "gar-lik" },
                    { es: "Cebolla", en: "Onion", pro: "o-nion" },
                    { es: "Tomate", en: "Tomato", pro: "tu-mei-tou" },
                    { es: "Papa / Patata", en: "Potato", pro: "tu-tei-tou" },
                    { es: "Zanahoria", en: "Carrot", pro: "ka-rot" },
                    { es: "Lechuga", en: "Lettuce", pro: "le-tis" },
                    { es: "Aguacate", en: "Avocado", pro: "a-vo-ka-dou" },
                    { es: "Limón", en: "Lemon", pro: "le-mon" },
                    { es: "Plátano / Banano", en: "Banana", pro: "ba-na-na" },
                    { es: "Manzana", en: "Apple", pro: "a-pol" },
                    { es: "Naranja (Fruta)", en: "Orange", pro: "o-rench" },
                    { es: "Fresa", en: "Strawberry", pro: "estro-be-ri" },
                    { es: "Uvas", en: "Grapes", pro: "greips" },
                    { es: "Piña", en: "Pineapple", pro: "pain-a-pol" },
                    { es: "Té", en: "Tea", pro: "tii" },
                    { es: "Soda / Gaseosa", en: "Soda", pro: "sou-da" },
                    { es: "Vino", en: "Wine", pro: "uain" },
                    { es: "Agua con gas", en: "Sparkling water", pro: "es-par-klin ua-ter" },
                    { es: "Hielo", en: "Ice", pro: "ais" },
                    { es: "Harina", en: "Flour", pro: "flau-ar" },
                    { es: "Pasta / Fideos", en: "Pasta", pro: "pas-ta" },
                    { es: "Salsa", en: "Sauce", pro: "sos" },
                    { es: "Salsa kétchup", en: "Ketchup", pro: "ke-chap" },
                    { es: "Mayonesa", en: "Mayonnaise", pro: "ma-io-neis" },
                    { es: "Mostaza", en: "Mustard", pro: "mas-tard" },
                    { es: "Arándanos", en: "Blueberries", pro: "bluu-be-ris" },
                    { es: "Miel", en: "Honey", pro: "ja-ni" },
                    { es: "Mermelada", en: "Jam", pro: "jam" },
                    { es: "Cereal", en: "Cereal", pro: "si-rial" },
                    { es: "Avena", en: "Oatmeal", pro: "out-miil" },
                    { es: "Yogur", en: "Yogurt", pro: "io-gurt" },
                    { es: "Pan tostado", en: "Toast", pro: "toust" },
                    { es: "Galleta (Dulce)", en: "Cookie", pro: "cu-ki" },
                    { es: "Galleta (Salada)", en: "Cracker", pro: "cra-ker" },
                    { es: "Pastel / Torta", en: "Cake", pro: "keik" },
                    { es: "Chocolate", en: "Chocolate", pro: "chok-lait" },
                    { es: "Helado", en: "Ice cream", pro: "ais criim" },
                    { es: "Dulce / Caramelo", en: "Candy", pro: "can-di" },
                    { es: "Nueces / Maní", en: "Nuts", pro: "nats" },
                    { es: "Almendras", en: "Almonds", pro: "a-monds" },
                    { es: "Frijoles / Caraotas", en: "Beans", pro: "biins" },
                    { es: "Maíz", en: "Corn", pro: "corn" },
                    { es: "Hongos / Champiñones", en: "Mushrooms", pro: "mash-ruums" },
                    { es: "Espinaca", en: "Spinach", pro: "es-pi-nich" },
                    { es: "Arroz integral", en: "Brown rice", pro: "braun rais" },
                    { es: "Perrito caliente", en: "Hot dog", pro: "jot dog" },
                    { es: "Hamburguesa", en: "Hamburger", pro: "jam-bur-guer" },
                    { es: "Sándwich", en: "Sandwich", pro: "sand-guich" },
                    { es: "Pizza", en: "Pizza", pro: "piit-sa" },
                    { es: "Taco", en: "Taco", pro: "ta-cou" },
                    { es: "Pancake / Tortita", en: "Pancake", pro: "pan-keik" },
                    { es: "Waffle", en: "Waffle", pro: "ua-fol" },
                    { es: "Batido / Smoothie", en: "Smoothie", pro: "smuu-zi" },
                    { es: "Refresco de limón", en: "Lemonade", pro: "le-mo-neid" },
                    { es: "Vinagre", en: "Vinegar", pro: "vi-ne-gar" },
                    { es: "Crema de leche", en: "Heavy cream", pro: "je-vi criim" },
                    { es: "Queso crema", en: "Cream cheese", pro: "criim chiis" },
                    { es: "Mariscos / Almejas", en: "Clams", pro: "clams" },
                    { es: "Filete / Bistec", en: "Steak", pro: "esteik" },
                    { es: "Costillas", en: "Ribs", pro: "ribs" },
                    { es: "Alitas de pollo", en: "Chicken wings", pro: "chi-ken guings" },
                    { es: "Nuggets de pollo", en: "Chicken nuggets", pro: "chi-ken na-guts" },
                    { es: "Puré de papas", en: "Mashed potatoes", pro: "masht tu-tei-tous" },
                    { es: "Comida para llevar", en: "Takeout", pro: "teik-aut" },
                    { es: "La cuenta, por favor.", en: "The bill, please.", pro: "de bil pliiz" },
                    { es: "Propina", en: "Tip", pro: "tip" },
                    { es: "Menú", en: "Menu", pro: "me-niu" },
                    { es: "Mesero", en: "Waiter", pro: "uei-ter" },
                    { es: "Agua de la llave", en: "Tap water", pro: "tap ua-ter" },
                    { es: "Agua embotellada", en: "Bottled water", pro: "bo-told ua-ter" },
                    { es: "¡Buen provecho!", en: "Enjoy your meal!", pro: "in-joi ior miil" }
                ],
                "Animales y Naturaleza 🦁": [
                    { es: "Perro", en: "Dog", pro: "dog" },
                    { es: "Gato", en: "Cat", pro: "kat" },
                    { es: "Pájaro", en: "Bird", pro: "berd" },
                    { es: "Caballo", en: "Horse", pro: "joors" },
                    { es: "Árbol", en: "Tree", pro: "trii" },
                    { es: "Flor", en: "Flower", pro: "flau-er" },
                    { es: "Río", en: "River", pro: "ri-ver" },
                    { es: "Montaña", en: "Mountain", pro: "maun-ten" },
                    { es: "Mar / Océano", en: "Sea", pro: "sii" },
                    { es: "Lluvia", en: "Rain", pro: "rein" },
                    { es: "Sol", en: "Sun", pro: "san" },
                    { es: "Luna", en: "Moon", pro: "muun" },
                    { es: "Planta", en: "Plant", pro: "plant" },
                    { es: "Cielo", en: "Sky", pro: "skai" },
                    { es: "Tierra", en: "Ground", pro: "graund" },
                    { es: "Hierba / Pasto", en: "Grass", pro: "gras" },
                    { es: "Fuego", en: "Fire", pro: "fai-ar" },
                    { es: "Viento", en: "Wind", pro: "guind" },
                    { es: "Bosque", en: "Forest", pro: "fo-rest" },
                    { es: "Pez", en: "Fish", pro: "fish" },
                    { es: "León", en: "Lion", pro: "lai-on" },
                    { es: "Tigre", en: "Tiger", pro: "tai-guer" },
                    { es: "Elefante", en: "Elephant", pro: "e-le-fant" },
                    { es: "Oso", en: "Bear", pro: "be-ar" },
                    { es: "Mono", en: "Monkey", pro: "man-ki" },
                    { es: "Lobo", en: "Wolf", pro: "uulf" },
                    { es: "Zorro", en: "Fox", pro: "foks" },
                    { es: "Mapache", en: "Raccoon", pro: "ra-kuun" },
                    { es: "Ardilla", en: "Squirrel", pro: "escu-i-rel" },
                    { es: "Ratón", en: "Mouse", pro: "maus" },
                    { es: "Vaca", en: "Cow", pro: "cau" },
                    { es: "Cerdo", en: "Pig", pro: "pigu" },
                    { es: "Oveja", en: "Sheep", pro: "shiip" },
                    { es: "Gallina", en: "Hen / Chicken", pro: "jen / chi-ken" },
                    { es: "Gallo", en: "Rooster", pro: "ruus-ter" },
                    { es: "Pato", en: "Duck", pro: "dak" },
                    { es: "Conejo", en: "Rabbit", pro: "ra-bit" },
                    { es: "Serpiente", en: "Snake", pro: "es-neik" },
                    { es: "Lagarto / Lagartija", en: "Lizard", pro: "li-sard" },
                    { es: "Rana", en: "Frog", pro: "frog" },
                    { es: "Tiburón", en: "Shark", pro: "shark" },
                    { es: "Delfín", en: "Dolphin", pro: "dol-fin" },
                    { es: "Ballena", en: "Whale", pro: "ueil" },
                    { es: "Tortuga", en: "Turtle", pro: "ter-tol" },
                    { es: "Águila", en: "Eagle", pro: "ii-gol" },
                    { es: "Búho", en: "Owl", pro: "aul" },
                    { es: "Mosquito", en: "Mosquito", pro: "mos-kii-tou" },
                    { es: "Mosca", en: "Fly", pro: "flai" },
                    { es: "Abeja", en: "Bee", pro: "bii" },
                    { es: "Hormiga", en: "Ant", pro: "ant" },
                    { es: "Araña", en: "Spider", pro: "espai-der" },
                    { es: "Mariposa", en: "Butterfly", pro: "ba-ter-flai" },
                    { es: "Lago", en: "Lake", pro: "leik" },
                    { es: "Playa", en: "Beach", pro: "biich" },
                    { es: "Desierto", en: "Desert", pro: "de-sert" },
                    { es: "Isla", en: "Island", pro: "ai-land" },
                    { es: "Piedra / Roca", en: "Stone / Rock", pro: "estoun / rok" },
                    { es: "Arena", en: "Sand", pro: "sand" },
                    { es: "Ola", en: "Wave", pro: "gueiv" },
                    { es: "Estrella", en: "Star", pro: "es-tar" },
                    { es: "Nube", en: "Cloud", pro: "claud" },
                    { es: "Nieve", en: "Snow", pro: "snou" },
                    { es: "Naturaleza", en: "Nature", pro: "nei-chur" },
                    { es: "Medio ambiente", en: "Environment", pro: "in-vai-ron-ment" },
                    { es: "Hoja (de árbol)", en: "Leaf", pro: "liif" },
                    { es: "Raíz", en: "Root", pro: "ruut" },
                    { es: "Rama", en: "Branch", pro: "branch" },
                    { es: "Semilla", en: "Seed", pro: "siid" },
                    { es: "Tierra / Suelo", en: "Soil / Dirt", pro: "soil / dert" },
                    { es: "Colina / Loma", en: "Hill", pro: "jil" },
                    { es: "Valle", en: "Valley", pro: "va-li" },
                    { es: "Cueva", en: "Cave", pro: "keiv" },
                    { es: "Selva / Jungla", en: "Jungle", pro: "jan-gol" },
                    { es: "Cascada", en: "Waterfall", pro: "ua-ter-fol" },
                    { es: "Costa", en: "Coast", pro: "coust" },
                    { es: "Sendero / Camino", en: "Trail / Path", pro: "treil / paz" },
                    { es: "Paisaje", en: "Landscape", pro: "land-es-keip" },
                    { es: "Tormenta", en: "Storm", pro: "estorm" },
                    { es: "Relámpago / Rayo", en: "Lightning", pro: "lait-nin" },
                    { es: "Trueno", en: "Thunder", pro: "zan-der" },
                    { es: "Arcoíris", en: "Rainbow", pro: "rein-bou" },
                    { es: "Sombras", en: "Shadows", pro: "sha-dous" },
                    { es: "Cachorro", en: "Puppy", pro: "pa-pi" },
                    { es: "Gatito", en: "Kitten", pro: "ki-ten" },
                    { es: "Ciervo / Venado", en: "Deer", pro: "diar" },
                    { es: "Pavo real", en: "Peacock", pro: "pii-cok" },
                    { es: "Loro", en: "Parrot", pro: "pa-rot" },
                    { es: "Cangrejo", en: "Crab", pro: "krab" },
                    { es: "Langosta", en: "Lobster", pro: "lobs-ter" },
                    { es: "Caracol", en: "Snail", pro: "es-neil" },
                    { es: "Gusano", en: "Worm", pro: "uerm" },
                    { es: "Clima templado", en: "Mild weather", pro: "maild gue-der" },
                    { es: "Aire puro", en: "Fresh air", pro: "fresh er" },
                    { es: "Madera", en: "Wood", pro: "uud" },
                    { es: "Peligro de animales", en: "Animal hazard", pro: "a-ni-mol ja-sard" },
                    { es: "Fauna silvestre", en: "Wildlife", pro: "uaild-laif" },
                    { es: "Mascota", en: "Pet", pro: "pet" },
                    { es: "Jaula", en: "Cage", pro: "keich" },
                    { es: "Nido", en: "Nest", pro: "nest" },
                    { es: "El campo", en: "The countryside", pro: "de can-tri-said" }
                ],
                "Casa y el Hogar 🏠": [
                    { es: "Puerta", en: "Door", pro: "door" },
                    { es: "Ventana", en: "Window", pro: "guin-dou" },
                    { es: "Cama", en: "Bed", pro: "bed" },
                    { es: "Mesa", en: "Table", pro: "tei-bol" },
                    { es: "Silla", en: "Chair", pro: "che-ar" },
                    { es: "Cocina", en: "Kitchen", pro: "kit-chen" },
                    { es: "Baño", en: "Bathroom", pro: "baz-ruum" },
                    { es: "Sala", en: "Living room", pro: "li-vin ruum" },
                    { es: "Cuarto / Habitación", en: "Bedroom", pro: "bed-ruum" },
                    { es: "Llave", en: "Key", pro: "kii" },
                    { es: "Pared", en: "Wall", pro: "uol" },
                    { es: "Techo", en: "Ceiling", pro: "sii-lin" },
                    { es: "Piso", en: "Floor", pro: "floor" },
                    { es: "Nevera", en: "Fridge", pro: "frich" },
                    { es: "Microondas", en: "Microwave", pro: "mai-cro-gueiv" },
                    { es: "Sofá", en: "Couch", pro: "cauch" },
                    { es: "Espejo", en: "Mirror", pro: "mi-ror" },
                    { es: "Almohada", en: "Pillow", pro: "pi-lou" },
                    { es: "Cobija / Manta", en: "Blanket", pro: "blan-ket" },
                    { es: "Luz / Lámpara", en: "Light", pro: "lait" },
                    { es: "Techo exterior / Tejado", en: "Roof", pro: "ruuf" },
                    { es: "Patio trasero", en: "Backyard", pro: "bak-iard" },
                    { es: "Patio delantero", en: "Front yard", pro: "front iard" },
                    { es: "Garaje / Cochera", en: "Garage", pro: "ga-rach" },
                    { es: "Pasillo", en: "Hallway", pro: "jol-uei" },
                    { es: "Escaleras", en: "Stairs", pro: "este-ars" },
                    { es: "Sótano", en: "Basement", pro: "beis-ment" },
                    { es: "Ático", en: "Attic", pro: "a-tik" },
                    { es: "Comedor", en: "Dining room", pro: "dai-nin ruum" },
                    { es: "Armario / Clóset", en: "Closet", pro: "clo-set" },
                    { es: "Estufa", en: "Stove", pro: "estouf" },
                    { es: "Horno", en: "Oven", pro: "o-ven" },
                    { es: "Fregadero / Lavaplatos", en: "Sink", pro: "sink" },
                    { es: "Lavavajillas (Máquina)", en: "Dishwasher", pro: "dish-ua-sher" },
                    { es: "Lavadora", en: "Washing machine", pro: "ua-shin ma-shiin" },
                    { es: "Secadora", en: "Dryer", pro: "drai-er" },
                    { es: "Inodoro / Escusado", en: "Toilet", pro: "toi-let" },
                    { es: "Ducha / Regadera", en: "Shower", pro: "shau-er" },
                    { es: "Bañera / Tina", en: "Bathtub", pro: "baz-tab" },
                    { es: "Toalla", en: "Toel", pro: "tau-el" },
                    { es: "Jabón", en: "Soap", pro: "soup" },
                    { es: "Champú", en: "Shampoo", pro: "sham-puu" },
                    { es: "Pasta de dientes", en: "Toothpaste", pro: "zuuz-peist" },
                    { es: "Cepillo de dientes", en: "Toothbrush", pro: "zuuz-brash" },
                    { es: "Sábana", en: "Sheet", pro: "shiit" },
                    { es: "Colchón", en: "Mattress", pro: "ma-tres" },
                    { es: "Televisor", en: "TV", pro: "tii-vii" },
                    { es: "Control remoto", en: "Remote control", pro: "ri-mout con-troul" },
                    { es: "Cortina", en: "Curtain", pro: "ker-ten" },
                    { es: "Alfombra", en: "Rug / Carpet", pro: "rag / car-pet" },
                    { es: "Escritorio", en: "Desk", pro: "desk" },
                    { es: "Cajón / Gaveta", en: "Drawer", pro: "dro-er" },
                    { es: "Basura", en: "Trash / Garbage", pro: "trash / gar-bich" },
                    { es: "Bote de basura", en: "Trash can", pro: "trash can" },
                    { es: "Escoba", en: "Broom", pro: "bruum" },
                    { es: "Trapeador / Mopa", en: "Mop", pro: "mop" },
                    { es: "Plato", en: "Plate", pro: "pleit" },
                    { es: "Vaso", en: "Glass", pro: "glas" },
                    { es: "Taza", en: "Cup", pro: "cap" },
                    { es: "Tenedor", en: "Fork", pro: "fork" },
                    { es: "Cuchara", en: "Spoon", pro: "es-puun" },
                    { es: "Cuchillo", en: "Knife", pro: "naif" },
                    { es: "Servilleta", en: "Napkin", pro: "nap-kin" },
                    { es: "Sartén", en: "Pan", pro: "pan" },
                    { es: "Olla", en: "Pot", pro: "pot" },
                    { es: "Licuadora", en: "Blender", pro: "blen-der" },
                    { es: "Cafetera", en: "Coffee maker", pro: "co-fii mei-ker" },
                    { es: "Enchufe / Toma de corriente", en: "Outlet", pro: "aut-let" },
                    { es: "Cable", en: "Cord / Cable", pro: "cord / kei-bol" },
                    { es: "Interruptor de luz", en: "Light switch", pro: "lait suich" },
                    { es: "Timbre", en: "Doorbells", pro: "door-bels" },
                    { es: "Cerca / Reja", en: "Fence", pro: "fens" },
                    { es: "Puerta trasera", en: "Back door", pro: "bak door" },
                    { es: "Cerradura", en: "Lock", pro: "lok" },
                    { es: "Candado", en: "Padlock", pro: "pad-lok" },
                    { es: "Ventilador", en: "Fan", pro: "fan" },
                    { es: "Aire acondicionado", en: "AC / Air conditioning", pro: "ei-sii / er con-di-shon-in" },
                    { es: "Calefacción", en: "Heater / Heating", pro: "jii-ter / jii-tin" },
                    { es: "Plancha", en: "Iron", pro: "ai-ron" },
                    { es: "Mesa de noche", en: "Nightstand", pro: "nait-estand" },
                    { es: "Estante / Repisa", en: "Shelf", pro: "shelf" },
                    { es: "Alquiler / Renta", en: "Rent", pro: "rent" },
                    { es: "Dueño de casa / Casero", en: "Landlord", pro: "land-lord" },
                    { es: "Vecino", en: "Neighbor", pro: "nei-bor" },
                    { es: "Dirección", en: "Address", pro: "a-dres" },
                    { es: "Mudanza", en: "Moving", pro: "muu-vin" },
                    { es: "Herramientas de casa", en: "Household tools", pro: "jaus-jold tuuls" },
                    { es: "Escalera de tijera", en: "Stepladder", pro: "estep-la-der" },
                    { es: "Manguera", en: "Hose", pro: "jous" },
                    { es: "Corta césped", en: "Lawnmower", pro: "lon-mou-er" },
                    { es: "Cuarto de lavado", en: "Laundry room", pro: "lon-dri ruum" },
                    { es: "Balcón", en: "Balcony", pro: "bal-co-ni" },
                    { es: "Pórtico / Entrada techada", en: "Porch", pro: "porch" },
                    { es: "Buzón de correo", en: "Mailbox", pro: "meil-boks" },
                    { es: "Entrada para autos / Calzada", en: "Driveway", pro: "draiv-uei" },
                    { es: "Alarma", en: "Alarm", pro: "a-larm" },
                    { es: "Detector de humo", en: "Smoke detector", pro: "esmouk di-tek-tor" },
                    { es: "Extintor", en: "Fire extinguisher", pro: "fai-ar eks-tin-gui-sher" },
                    { es: "Botiquín de primeros auxilios", en: "First aid kit", pro: "ferst eid kit" },
                    { es: "Hogar, dulce hogar", en: "Home, sweet home", pro: "joum suiit joum" }
                ],
                "Ciudad y Lugares 🏙️": [
                    { es: "Calle", en: "Street", pro: "estriit" },
                    { es: "Avenida", en: "Avenue", pro: "a-ve-niu" },
                    { es: "Tienda", en: "Store", pro: "estoor" },
                    { es: "Supermercado", en: "Supermarket", pro: "su-per-mar-ket" },
                    { es: "Restaurante", en: "Restaurant", pro: "res-to-rant" },
                    { es: "Banco", en: "Bank", pro: "bank" },
                    { es: "Hospital", en: "Hospital", pro: "jos-pi-tal" },
                    { es: "Estación de gasolina", en: "Gas station", pro: "gas estei-shon" },
                    { es: "Parque", en: "Park", pro: "park" },
                    { es: "Hotel", en: "Hotel", pro: "jo-tel" },
                    { es: "Aeropuerto", en: "Airport", pro: "er-port" },
                    { es: "Farmacia", en: "Pharmacy", pro: "far-ma-si" },
                    { es: "Estacionamiento", en: "Parking lot", pro: "par-kin lot" },
                    { es: "Esquina", en: "Corner", pro: "cor-ner" },
                    { es: "Edificio", en: "Building", pro: "bil-din" },
                    { es: "Centro comercial", en: "Mall", pro: "mol" },
                    { es: "Iglesia", en: "Church", pro: "cherch" },
                    { es: "Escuela", en: "School", pro: "es-kuul" },
                    { es: "Parada de autobús", en: "Bus stop", pro: "bas estop" },
                    { es: "Puente", en: "Bridge", pro: "brich" },
                    { es: "Estación de policía", en: "Police station", pro: "po-liis estei-shon" },
                    { es: "Estación de bomberos", en: "Fire station", pro: "fai-ar estei-shon" },
                    { es: "Oficina de correos", en: "Post office", pro: "poust o-fis" },
                    { es: "Biblioteca", en: "Library", pro: "lai-bre-ri" },
                    { es: "Museo", en: "Museum", pro: "miu-sii-om" },
                    { es: "Cine / Teatro", en: "Movie theater", pro: "muu-vi zii-a-ter" },
                    { es: "Gimnasio", en: "Gym", pro: "yim" },
                    { es: "Panadería", en: "Bakery", pro: "bei-ke-ri" },
                    { es: "Barbería", en: "Barbershop", pro: "bar-ber-shop" },
                    { es: "Salón de belleza", en: "Beauty salon", pro: "biu-ti sa-lon" },
                    { es: "Lavandería", en: "Laundromat", pro: "lon-dro-mat" },
                    { es: "Fábrica / Planta", en: "Factory / Plant", pro: "fak-to-ri / plant" },
                    { es: "Bodega / Almacén", en: "Warehouse", pro: "guer-jaus" },
                    { es: "Taller mecánico", en: "Mechanic shop", pro: "me-ka-nik shop" },
                    { es: "Ferretería", en: "Hardware store", pro: "jard-guer estoor" },
                    { es: "Licorería", en: "Liquor store", pro: "li-kor estoor" },
                    { es: "Bar / Cantina", en: "Bar", pro: "bar" },
                    { es: "Discoteca / Club", en: "Nightclub", pro: "nait-clab" },
                    { es: "Zoológico", en: "Zoo", pro: "suu" },
                    { es: "Plaza / Parque central", en: "Square / Plaza", pro: "escu-er / pla-sa" },
                    { es: "Acera / Banqueta", en: "Sidewalk", pro: "said-uolk" },
                    { es: "Paso peatonal", en: "Crosswalk", pro: "cros-uolk" },
                    { es: "Semáforo", en: "Traffic light", pro: "tra-fik lait" },
                    { es: "Señal de pare", en: "Stop sign", pro: "estop sain" },
                    { es: "Autopista / Freway", en: "Highway / Freeway", pro: "jai-uei / frii-uei" },
                    { es: "Peaje", en: "Toll booth", pro: "tol buuz" },
                    { es: "Estación de metro", en: "Subway station", pro: "sab-guei estei-shon" },
                    { es: "Estación de tren", en: "Train station", pro: "trein estei-shon" },
                    { es: "Centro de la ciudad", en: "Downtown", pro: "daun-taun" },
                    { es: "Suburbio / Afueras", en: "Suburbs", pro: "sa-berbs" },
                    { es: "Vecindario / Barrio", en: "Neighborhood", pro: "nei-bor-juld" },
                    { es: "Bloque / Cuadra", en: "Block", pro: "blok" },
                    { es: "Callejón", en: "Alley", pro: "a-li" },
                    { es: "Estación de carga", en: "Charging station", pro: "char-yin estei-shon" },
                    { es: "Oficina de gobierno", en: "City hall", pro: "si-ti jol" },
                    { es: "Corte / Juzgado", en: "Courthouse", pro: "cort-jaus" },
                    { es: "Cárcel / Prisión", en: "Jail / Prison", pro: "jeil / pri-son" },
                    { es: "Funeraria", en: "Funeral home", pro: "fiu-ne-ral joum" },
                    { es: "Cementerio", en: "Cemetery", pro: "se-me-te-ri" },
                    { es: "Puerto", en: "Port / Harbor", pro: "port / jar-bor" },
                    { es: "Parque de atracciones / Diversiones", en: "Amusement park", pro: "a-mius-ment park" },
                    { es: "Estadio deportivo", en: "Sports arena / Stadium", pro: "sports a-rii-na / estei-diom" },
                    { es: "Piscina pública", en: "Public pool", pro: "pab-lik puul" },
                    { es: "Cancha de tenis", en: "Tennis court", pro: "te-nis cort" },
                    { es: "Campo de golf", en: "Golf course", pro: "golf coors" },
                    { es: "Playa pública", en: "Public beach", pro: "pab-lik biich" },
                    { es: "Muelle", en: "Pier / Dock", pro: "piar / dok" },
                    { es: "Puesto de periódicos / Kiosco", en: "Newsstand", pro: "nius-etand" },
                    { es: "Cafetería / Café", en: "Coffee shop", pro: "co-fii shop" },
                    { es: "Camión de comida / Food truck", en: "Food truck", pro: "fuud trac" },
                    { es: "Mercado de pulgas", en: "Flea market", pro: "flii mar-ket" },
                    { es: "Tienda de segunda mano", en: "Thrift store", pro: "zrift estoor" },
                    { es: "Tienda de empeño", en: "Pawn shop", pro: "pon shop" },
                    { es: "Consecionaria de autos / Dealer", en: "Car dealership", pro: "car dii-ler-ship" },
                    { es: "Estación de pesaje (Camiones)", en: "Weigh station", pro: "uei estei-shon" },
                    { es: "Lugar de construcción", en: "Construction site", pro: "con-estrak-shon sait" },
                    { es: "Terreno baldío", en: "Vacant lot", pro: "vei-kant lot" },
                    { es: "Zona industrial", en: "Industrial zone", pro: "in-das-tri-al zoun" },
                    { es: "Zona residencial", en: "Residential area", pro: "re-si-den-shal e-ria" },
                    { es: "Límites de la ciudad", en: "City limits", pro: "si-ti li-mits" },
                    { es: "Señales de tráfico", en: "Road signs", pro: "roud sains" },
                    { es: "Bache / Hueco en la calle", en: "Pothole", pro: "pot-joul" },
                    { es: "Tráfico pesado", en: "Heavy traffic", pro: "je-vi tra-fik" },
                    { es: "Hora pico", en: "Rush hour", pro: "rash au-ar" },
                    { es: "Atajo", en: "Shortcut", pro: "short-cat" },
                    { es: "Desvío", en: "Detour", pro: "dii-tuur" },
                    { es: "Calle sin salida", en: "Dead end", pro: "ded end" },
                    { es: "Dirección única / Una vía", en: "One-way street", pro: "uan uei es-triit" },
                    { es: "Cámara de tráfico", en: "Traffic camera", pro: "tra-fik ka-me-ra" },
                    { es: "Grúa (para autos)", en: "Tow truck", pro: "tou trac" },
                    { es: "Depósito de autos / Corralón", en: "Impound lot", pro: "im-paund lot" },
                    { es: "Zona escolar", en: "School zone", pro: "escuul zoun" },
                    { es: "Hospital infantil", en: "Children's hospital", pro: "chil-drens jos-pi-tal" },
                    { es: "Centro comunitario", en: "Community center", pro: "co-miu-ni-ti sen-der" },
                    { es: "Refugio", en: "Shelter", pro: "shel-ter" },
                    { es: "Oficina de turismo", en: "Tourist information", pro: "tuu-rist in-for-mei-shon" },
                    { es: "Estatua", en: "Statue", pro: "es-ta-chuu" },
                    { es: "Monumento", en: "Monument", pro: "mo-niu-ment" },
                    { es: "Fuente", en: "Fountain", pro: "faun-ten" },
                    { es: "Guía de la ciudad", en: "City guide", pro: "si-ti gaid" }
                ],
                "Clima y Estaciones ☁️": [
                    { es: "Hace frío.", en: "It's cold.", pro: "its could" },
                    { es: "Hace calor.", en: "It's hot.", pro: "its jot" },
                    { es: "Está lloviendo.", en: "It's raining.", pro: "its rei-nin" },
                    { es: "Está soleado.", en: "It's sunny.", pro: "its sa-ni" },
                    { es: "Está nublado.", en: "It's cloudy.", pro: "its clau-di" },
                    { es: "Está nevando.", en: "It's snowing.", pro: "its snou-in" },
                    { es: "Hace viento.", en: "It's windy.", pro: "its guin-di" },
                    { es: "Verano", en: "Summer", pro: "sa-mer" },
                    { es: "Invierno", en: "Winter", pro: "guin-ter" },
                    { es: "Primavera", en: "Spring", pro: "es-prin" },
                    { es: "Otoño", en: "Fall", pro: "fol" },
                    { es: "Tormenta", en: "Storm", pro: "estorm" },
                    { es: "Humedad", en: "Humidity", pro: "jiu-mi-di-ti" },
                    { es: "Temperatura", en: "Temperature", pro: "tem-pre-chur" },
                    { es: "Pronóstico del tiempo", en: "Weather forecast", pro: "gue-der for-kast" },
                    { es: "Grados", en: "Degrees", pro: "di-griis" },
                    { es: "Está despejado.", en: "It's clear.", pro: "its cliar" },
                    { es: "Niebla", en: "Fog", pro: "fog" },
                    { es: "Hielo", en: "Ice", pro: "ais" },
                    { es: "Clima loco", en: "Crazy weather", pro: "crei-si gue-der" },
                    { es: "Está fresco.", en: "It's cool.", pro: "its kuul" },
                    { es: "Está lloviznando.", en: "It's drizzling.", pro: "its dris-lin" },
                    { es: "Está tormentoso.", en: "It's stormy.", pro: "its estor-mi" },
                    { es: "Hace mucho calor.", en: "It's boiling hot.", pro: "its boi-lin jot" },
                    { es: "Hace un frío helado.", en: "It's freezing cold.", pro: "its frii-sin could" },
                    { es: "Granizo", en: "Hail", pro: "jeil" },
                    { es: "Rayo / Relámpago", en: "Lightning", pro: "lait-nin" },
                    { es: "Trueno", en: "Thunder", pro: "zan-der" },
                    { es: "Arcoíris", en: "Rainbow", pro: "rein-bou" },
                    { es: "Tornado", en: "Tornado", pro: "tor-nei-dou" },
                    { es: "Huracán", en: "Hurricane", pro: "ja-ri-kein" },
                    { es: "Inundación", en: "Flood", pro: "flad" },
                    { es: "Sequía", en: "Drought", pro: "draut" },
                    { es: "Ola de calor", en: "Heatwave", pro: "jiit-gueiv" },
                    { es: "Viento fuerte", en: "Gale / Strong wind", pro: "gueil / estrong guind" },
                    { es: "Brisa", en: "Breeze", pro: "briis" },
                    { es: "Cielo despejado", en: "Clear sky", pro: "cliar es-kai" },
                    { es: "Cielo cubierto", en: "Overcast sky", pro: "ou-ver-kast es-kai" },
                    { es: "Tormenta de nieve", en: "Blizzard", pro: "bli-sard" },
                    { es: "Tormenta de arena", en: "Sandstorm", pro: "sand-estorm" },
                    { es: "Grados Fahrenheit", en: "Degrees Fahrenheit", pro: "di-griis fa-ren-jait" },
                    { es: "Grados Celsius", en: "Degrees Celsius", pro: "di-griis sel-sios" },
                    { es: "Humedad alta", en: "High humidity", pro: "jai jiu-mi-di-ti" },
                    { es: "Presión atmosférica", en: "Atmospheric pressure", pro: "at-mos-fe-rik pre-shur" },
                    { es: "Índice UV", en: "UV index", pro: "iu-vi in-deks" },
                    { es: "Estación lluviosa", en: "Rainy season", pro: "rei-ni sii-son" },
                    { es: "Estación seca", en: "Dry season", pro: "drai sii-son" },
                    { es: "Sombra", en: "Shade", pro: "sheid" },
                    { es: "Rayo de sol", en: "Sunbeam", pro: "san-biim" },
                    { es: "Gota de lluvia", en: "Raindrop", pro: "rein-drop" },
                    { es: "Copo de nieve", en: "Snowflake", pro: "snou-fleik" },
                    { es: "Escarcha", en: "Frost", pro: "frost" },
                    { es: "Rocío (de la mañana)", en: "Dew", pro: "diu" },
                    { es: "Smog / Contaminación", en: "Smog", pro: "smog" },
                    { es: "Clima húmedo", en: "Damp weather", pro: "damp gue-der" },
                    { es: "Clima severo", en: "Severe weather", pro: "si-viar gue-der" },
                    { es: "Alerta de clima", en: "Weather alert", pro: "gue-der a-lert" },
                    { es: "Está mejorando.", en: "It's clearing up.", pro: "its cliar-in ap" },
                    { es: "Se está poniendo nublado.", en: "It's getting cloudy.", pro: "its guet-in clau-di" },
                    { es: "Va a llover.", en: "It's going to rain.", pro: "its gou-in tu rein" },
                    { es: "Paraguas", en: "Umbrella", pro: "am-bre-la" },
                    { es: "Impermeable", en: "Raincoat", pro: "rein-kout" },
                    { es: "Botas de lluvia", en: "Rain boots", pro: "rein buuts" },
                    { es: "Bloqueador solar", en: "Sunscreen", pro: "san-es-criin" },
                    { es: "Gafas de sol", en: "Sunglasses", pro: "san-gla-ses" },
                    { es: "El sol está pegando fuerte.", en: "The sun is beating down.", pro: "de san is bii-tin daun" },
                    { es: "Estamos temblando de frío.", en: "We are freezing.", pro: "gui ar frii-sin" },
                    { es: "Me mojé con la lluvia.", en: "I got soaked in the rain.", pro: "ai got soukt in de rein" },
                    { es: "Hay neblina en la carretera.", en: "It's foggy on the road.", pro: "its fo-gui on de roud" },
                    { es: "El viento sopló mi gorra.", en: "The wind blew my cap off.", pro: "de guind bluu mai kap of" },
                    { es: "Clima tropical", en: "Tropical climate", pro: "tro-pi-kol clai-mat" },
                    { es: "Clima desértico", en: "Desert climate", pro: "de-sert clai-mat" },
                    { es: "Clima polar", en: "Polar climate", pro: "pou-lar clai-mat" },
                    { es: "Previsión diaria", en: "Daily forecast", pro: "dei-li for-kast" },
                    { es: "Previsión semanal", en: "Weekly forecast", pro: "guiik-li for-kast" },
                    { es: "Mudanza de estación", en: "Change of season", pro: "cheinch of sii-son" },
                    { es: "Solsticio de verano", en: "Summer solstice", pro: "sa-mer sols-tis" },
                    { es: "Equinoccio", en: "Equinox", pro: "ii-qui-noks" },
                    { es: "Las hojas están cayendo.", en: "The leaves are falling.", pro: "de liivs ar fol-in" },
                    { es: "Las flores están floreciendo.", en: "The flowers are blooming.", pro: "de flau-ers ar bluu-min" },
                    { es: "Está muy húmedo afuera.", en: "It's very muggy outside.", pro: "its ve-ri ma-gui aut-said" },
                    { es: "Clima agradable", en: "Pleasant weather", pro: "ple-sant gue-der" },
                    { es: "Clima desagradable", en: "Nasty weather", pro: "nas-ti gue-der" },
                    { es: "El lago está congelado.", en: "The lake is frozen.", pro: "de leik is frou-sen" },
                    { es: "La nieve se está derritiendo.", en: "The snow is melting.", pro: "de snou is mel-tin" },
                    { es: "Hay una tormenta eléctrica.", en: "There's a thunderstorm.", pro: "ders a zan-der-estorm" },
                    { es: "Viento racheado", en: "Gusty wind", pro: "gas-ti guind" },
                    { es: "El cielo está gris.", en: "The sky is gray.", pro: "de es-kai is grei" },
                    { es: "No hay ni una nube.", en: "There isn't a cloud in the sky.", pro: "der i-sent a claud in de es-kai" },
                    { es: "El amanecer estuvo hermoso.", en: "The sunrise was beautiful.", pro: "de san-rais guas biu-ti-ful" },
                    { es: "El atardecer fue increíble.", en: "The sunset was amazing.", pro: "de san-set guas a-mei-zin" },
                    { es: "Otoño dorado", en: "Golden autumn", pro: "goul-den o-tom" },
                    { es: "Primeras nevadas", en: "First snowfall", pro: "ferst snou-fol" },
                    { es: "Ola de frío", en: "Cold snap", pro: "could snap" },
                    { es: "Está granizando afuera.", en: "It's hailing outside.", pro: "its jeil-in aut-said" },
                    { es: "El clima cambió de repente.", en: "The weather changed suddenly.", pro: "de gue-der cheinchd sa-den-li" },
                    { es: "Espero que no llueva hoy.", en: "I hope it doesn't rain today.", pro: "ai joup it da-sent rein tu-dei" },
                    { es: "Está perfecto para la playa.", en: "It's perfect for the beach.", pro: "its per-fekt for de biich" },
                    { es: "El viento está calmado.", en: "The wind is calm.", pro: "de guind is calm" },
                    { es: "Disfruta el día soleado.", en: "Enjoy the sunny day.", pro: "in-joi de sa-ni-dei" }
                ],
                "Colores Básicos 🎨": [
                    { es: "Rojo", en: "Red", pro: "red" },
                    { es: "Azul", en: "Blue", pro: "bluu" },
                    { es: "Verde", en: "Green", pro: "griin" },
                    { es: "Amarillo", en: "Yellow", pro: "ie-lou" },
                    { es: "Negro", en: "Black", pro: "blak" },
                    { es: "Blanco", en: "White", pro: "uait" },
                    { es: "Gris", en: "Gray", pro: "grei" },
                    { es: "Naranja", en: "Orange", pro: "o-rench" },
                    { es: "Rosa / Rosado", en: "Pink", pro: "pink" },
                    { es: "Morado", en: "Purple", pro: "per-pol" },
                    { es: "Marrón / Café", en: "Brown", pro: "braun" },
                    { es: "Dorado", en: "Gold", pro: "gould" },
                    { es: "Plateado", en: "Silver", pro: "sil-ver" },
                    { es: "Claro (Color)", en: "Light", pro: "lait" },
                    { es: "Oscuro", en: "Dark", pro: "dark" },
                    { es: "Brillante", en: "Bright", pro: "brait" },
                    { es: "Azul marino", en: "Navy blue", pro: "nei-vi bluu" },
                    { es: "Beige", en: "Beige", pro: "beish" },
                    { es: "Turquesa", en: "Turquoise", pro: "ter-cois" },
                    { es: "Verde neón", en: "Neon green", pro: "ni-on griin" },
                    { es: "Morado oscuro", en: "Dark purple", pro: "dark per-pol" },
                    { es: "Azul claro", en: "Light blue", pro: "lait bluu" },
                    { es: "Verde oliva", en: "Olive green", pro: "o-liv griin" },
                    { es: "Gris oscuro", en: "Dark gray", pro: "dark grei" },
                    { es: "Blanco hueso", en: "Off-white", pro: "of uait" },
                    { es: "Bronce", en: "Bronze", pro: "brons" },
                    { es: "Crema", en: "Cream", pro: "criim" },
                    { es: "Castaño / Marrón oscuro", en: "Chestnut", pro: "ches-nat" },
                    { es: "Rojo oscuro", en: "Dark red", pro: "dark red" },
                    { es: "Amarillo mostaza", en: "Mustard yellow", pro: "mas-tard ie-lou" },
                    { es: "Color pastel", en: "Pastel color", pro: "pas-tel co-lor" },
                    { es: "Transparente", en: "Transparent", pro: "trans-pa-rent" },
                    { es: "Multicolor", en: "Multicolor", pro: "mal-ti-co-lor" },
                    { es: "Arcoíris", en: "Rainbow", pro: "rein-bou" },
                    { es: "¿Cuál es tu color favorito?", en: "What is your favorite color?", pro: "uat is ior fei-vo-rit co-lor" },
                    { es: "Mi color favorito es el azul.", en: "My favorite color is blue.", pro: "mai fei-vo-rit co-lor is bluu" },
                    { es: "Me gusta la camisa roja.", en: "I like the red shirt.", pro: "ai laik de red shert" },
                    { es: "El carro es negro.", en: "The car is black.", pro: "de car is blak" },
                    { es: "Las paredes son blancas.", en: "The walls are white.", pro: "de uols ar uait" },
                    { es: "Prefiero los colores oscuros.", en: "I prefer dark colors.", pro: "ai pri-fer dark co-lors" },
                    { es: "Este color es muy brillante.", en: "This color is very bright.", pro: "dis co-lor is ve-ri brait" },
                    { es: "Combina el rojo con el blanco.", en: "Combine red with white.", pro: "com-bain red guiz uait" },
                    { es: "Esa gorra es de color verde neón.", en: "That cap is neon green.", pro: "dat kap is ni-on griin" },
                    { es: "Los zapatos son de color marrón.", en: "The shoes are brown.", pro: "de shuus ar braun" },
                    { es: "El logo tiene letras doradas.", en: "The logo has gold letters.", pro: "de lo-gou jas gould le-ters" },
                    { es: "El cielo está azul hoy.", en: "The sky is blue today.", pro: "de es-kai is bluu tu-dei" },
                    { es: "La minivan es gris.", en: "The minivan is gray.", pro: "de mi-ni-van is grei" },
                    { es: "El Jeep Cherokee es rojo.", en: "The Jeep Cherokee is red.", pro: "de yiip che-ro-kii is red" },
                    { es: "Me gusta ese tono de verde.", en: "I like that shade of green.", pro: "ai laik dat sheid of griin" },
                    { es: "Color seleccionado.", en: "Color selected.", pro: "co-lor se-lek-ted" }
                ],
                "Compras y Dinero 💰": [
                    { es: "¿Cuánto cuesta esto?", en: "How much is this?", pro: "jau mach is dis" },
                    { es: "Efectivo", en: "Cash", pro: "kash" },
                    { es: "Tarjeta de crédito", en: "Credit card", pro: "cre-dit card" },
                    { es: "Recibo / Factura", en: "Receipt", pro: "re-siit" },
                    { es: "Cambio / Devuelta", en: "Change", pro: "cheinch" },
                    { es: "Bolsa", en: "Bag", pro: "bag" },
                    { es: "Precio", en: "Price", pro: "prais" },
                    { es: "Descuento / Oferta", en: "Discount", pro: "dis-kaunt" },
                    { es: "Cajero", en: "Cashier", pro: "ka-shiar" },
                    { es: "Costo de envío", en: "Shipping fee", pro: "shi-pin fii" },
                    { es: "Impuestos", en: "Taxes", pro: "tak-ses" },
                    { es: "Total", en: "Total", pro: "tou-tal" },
                    { es: "Reembolso", en: "Refund", pro: "rii-fand" },
                    { es: "Gastar dinero", en: "To spend money", pro: "tu es-pend ma-ni" },
                    { es: "Comprar", en: "To buy", pro: "tu bai" },
                    { es: "Pagar", en: "To pay", pro: "tu pei" },
                    { es: "Es muy caro.", en: "It's too expensive.", pro: "its tuu eks-pen-siv" },
                    { es: "Está barato.", en: "It's cheap.", pro: "its chiip" },
                    { es: "Cajero automático", en: "ATM", pro: "ei-tii-em" },
                    { es: "Monedas", en: "Coins", pro: "koins" },
                    { es: "Tarjeta de débito", en: "Debit card", pro: "de-bit card" },
                    { es: "Billetes (Dinero)", en: "Bills / Notes", pro: "bils / nouts" },
                    { es: "Billetera / Cartera", en: "Wallet", pro: "ua-let" },
                    { es: "Precio fijo", en: "Fixed price", pro: "fikst prais" },
                    { es: "Etiqueta de precio", en: "Price tag", pro: "prais tag" },
                    { es: "Pasillo (de tienda)", en: "Aisle", pro: "ail" },
                    { es: "Carrito de compras", en: "Shopping cart", pro: "sho-pin cart" },
                    { es: "Canasta de compras", en: "Shopping basket", pro: "sho-pin bas-ket" },
                    { es: "En venta / Liquidación", en: "On sale", pro: "on seil" },
                    { es: "Cupón de descuento", en: "Coupon", pro: "kuu-pon" },
                    { es: "Código de barras", en: "Barcode", pro: "bar-coud" },
                    { es: "Mostrador", en: "Counter", pro: "caun-ter" },
                    { es: "Probador (Ropa)", en: "Fitting room / Changing room", pro: "fi-tin ruum / chein-yin ruum" },
                    { es: "Garantía", en: "Warranty / Guarantee", pro: "gua-ran-ti / ga-ran-tii" },
                    { es: "Cliente", en: "Customer / Client", pro: "cas-to-mer / clai-ent" },
                    { es: "Gerente / Manager", en: "Manager", pro: "ma-na-yer" },
                    { es: "Comprobante de pago", en: "Proof of payment", pro: "pruuf of pei-ment" },
                    { es: "Dinero suelto", en: "Loose change", pro: "luus cheinch" },
                    { es: "Romper el billete (Cambiarlo)", en: "To break a bill", pro: "tu breik a bil" },
                    { es: "Ahorrar dinero", en: "To save money", pro: "tu seiv ma-ni" },
                    { es: "Cuenta bancaria", en: "Bank account", pro: "bank a-caunt" },
                    { es: "Préstamo", en: "Loan", pro: "loun" },
                    { es: "Hipoteca", en: "Mortgage", pro: "mor-guich" },
                    { es: "Deuda", en: "Debt", pro: "det" },
                    { es: "Presupuesto", en: "Budget", pro: "ba-jet" },
                    { es: "Costo total", en: "Total cost", pro: "tou-tal cost" },
                    { es: "Precio de fábrica", en: "Wholesale price", pro: "joul-seil prais" },
                    { es: "Precio al por menor", en: "Retail price", pro: "rii-teil prais" },
                    { es: "Bancarrota", en: "Bankruptcy", pro: "bank-rap-si" },
                    { es: "Inversión", en: "Investment", pro: "in-vest-ment" },
                    { es: "Efectivo únicamente", en: "Cash only", pro: "kash oun-li" },
                    { es: "Aceptamos tarjetas", en: "Cards accepted", pro: "cards ak-sept-ed" },
                    { es: "Firma aquí, por favor.", en: "Sign here, please.", pro: "sain jiar pliiz" },
                    { es: "Introduce tu PIN.", en: "Enter your PIN.", pro: "en-ter ior pin" },
                    { es: "Fondos insuficientes", en: "Insufficient funds", pro: "in-sa-fi-shent fands" },
                    { es: "Transacción rechazada", en: "Transaction declined", pro: "tran-sak-shon di-claind" },
                    { es: "Transacción aprobada", en: "Transaction approved", pro: "tran-sak-shon a-pruuvd" },
                    { es: "Cobrar de más", en: "To overcharge", pro: "tu ou-ver-charch" },
                    { es: "Estafa / Robo (Muy caro)", en: "Rip-off", pro: "rip of" },
                    { es: "Una ganga / Súper barato", en: "A bargain", pro: "a bar-guin" },
                    { es: "Gratis / Sin costo", en: "Free of charge", pro: "frii of charch" },
                    { es: "Hacer una devolución", en: "To make a return", pro: "tu meik a ri-tern" },
                    { es: "Intereses (Dinero)", en: "Interest", pro: "in-trest" },
                    { es: "Ingresos", en: "Income", pro: "in-kam" },
                    { es: "Gastos", en: "Expenses", pro: "eks-pen-ses" },
                    { es: "Pagar en efectivo", en: "To pay in cash", pro: "tu pei in kash" },
                    { es: "Pagar con tarjeta", en: "To pay by card", pro: "tu pei bai card" },
                    { es: "Moneda local", en: "Local currency", pro: "lou-fol ca-ren-si" },
                    { es: "Tasa de cambio", en: "Exchange rate", pro: "eks-cheinch reit" },
                    { es: "Comisión", en: "Fee / Commission", pro: "fii / co-mi-shon" },
                    { es: "Es una pérdida de dinero.", en: "It's a waste of money.", pro: "its a ueist of ma-ni" },
                    { es: "Vale cada centavo.", en: "It's worth every penny.", pro: "its uerz ev-ri pe-ni" },
                    { es: "Estoy corto de dinero.", en: "I'm short on cash.", pro: "aim short on kash" },
                    { es: "Estoy quebrado.", en: "I'm broke.", pro: "aim brouk" },
                    { es: "Tengo dinero de sobra.", en: "I have money to spare.", pro: "ai jaf ma-ni tu es-pear" },
                    { es: "Costo oculto", en: "Hidden cost", pro: "ji-den cost" },
                    { es: "Financiamiento", en: "Financing", pro: "fai-nan-sin" },
                    { es: "Comprar en línea", en: "Online shopping", pro: "on-lain sho-pin" },
                    { es: "Historial de compras", en: "Purchase history", pro: "per-chas jis-to-ri" },
                    { es: "Seguimiento de pedido", en: "Order tracking", pro: "or-der tra-kin" },
                    { es: "Paquete entregado", en: "Package delivered", pro: "pa-kich di-li-verd" },
                    { es: "Donación", en: "Donation", pro: "dou-nei-shon" },
                    { es: "Riqueza", en: "Wealth", pro: "guelz" },
                    { es: "Cheque de pago", en: "Paycheck", pro: "pei-chek" },
                    { es: "Salario / Sueldo", en: "Salary", pro: "sa-la-ri" },
                    { es: "Impuesto sobre las ventas", en: "Sales tax", pro: "seils taks" },
                    { es: "Libre de impuestos", en: "Tax-free", pro: "taks frii" },
                    { es: "¿Me puede dar un descuento?", en: "Can you give me a discount?", pro: "can iu guiv mi a dis-kaunt" },
                    { es: "Guarde su recibo.", en: "Keep your receipt.", pro: "kiip ior re-siit" },
                    { es: "El pago fue exitoso.", en: "Payment was successful.", pro: "pei-ment guas sak-ses-ful" }
                ],
                "Deportes ⚽": [
                    { es: "Fútbol", en: "Soccer", pro: "so-ker" },
                    { es: "Baloncesto", en: "Basketball", pro: "bas-ket-bol" },
                    { es: "Pelota / Balón", en: "Ball", pro: "bol" },
                    { es: "Juego / Partido", en: "Game", pro: "gueim" },
                    { es: "Equipo", en: "Team", pro: "tiim" },
                    { es: "Correr", en: "To run", pro: "tu ran" },
                    { es: "Gimnasio", en: "Gym", pro: "yim" },
                    { es: "Entrenamiento", en: "Workout", pro: "uer-kaut" },
                    { es: "Zapatos deportivos", en: "Sneakers", pro: "snii-kers" },
                    { es: "Ganar", en: "To win", pro: "tu guin" },
                    { es: "Perder", en: "To lose", pro: "tu luus" },
                    { es: "Empate", en: "Tie", pro: "tai" },
                    { es: "Piscina", en: "Pool", pro: "puul" },
                    { es: "Cancha / Campo", en: "Field", pro: "fiild" },
                    { es: "Estadio", en: "Stadium", pro: "estei-diom" },
                    { es: "Pase", en: "Pass", pro: "pas" },
                    { es: "Tiro / Remate", en: "Shot", pro: "shot" },
                    { es: "Puntuación / Marcador", en: "Score", pro: "es-kor" },
                    { es: "Torneo", en: "Tournament", pro: "tur-na-ment" },
                    { es: "Campeonato", en: "Championship", pro: "cham-pion-ship" },
                    { es: "Atleta", en: "Athlete", pro: "az-liit" },
                    { es: "Béisbol", en: "Baseball", pro: "beis-bol" },
                    { es: "Fútbol americano", en: "Football", pro: "fut-bol" },
                    { es: "Tenis", en: "Tennis", pro: "te-nis" },
                    { es: "Golf", en: "Golf", pro: "golf" },
                    { es: "Boxeo", en: "Boxing", pro: "bok-sin" },
                    { es: "Natación", en: "Swimming", pro: "sui-min" },
                    { es: "Ciclismo", en: "Cycling", pro: "sai-klin" },
                    { es: "Carrera / Maratón", en: "Race / Marathon", pro: "reis / ma-ra-zon" },
                    { es: "Jugador", en: "Player", pro: "plei-er" },
                    { es: "Entrenador / Técnico", en: "Coach", pro: "couch" },
                    { es: "Árbitro", en: "Referee / Umpire", pro: "re-fe-rii / am-pai-ar" },
                    { es: "Capitán del equipo", en: "Team captain", pro: "tiim kap-ten" },
                    { es: "Aficionados / Hinchas", en: "Fans / Supporters", pro: "fans / sa-por-ters" },
                    { es: "Medalla de oro", en: "Gold medal", pro: "gould me-dal" },
                    { es: "Medalla de plata", en: "Silver medal", pro: "sil-ver me-dal" },
                    { es: "Medalla de bronce", en: "Bronze medal", pro: "brons me-dal" },
                    { es: "Trofeo / Copa", en: "Trophy / Cup", pro: "trou-fi / cap" },
                    { es: "Récord mundial", en: "World record", pro: "uerld re-cord" },
                    { es: "Temporada de juegos", en: "Season", pro: "sii-son" },
                    { es: "Playoffs / Eliminatorias", en: "Playoffs", pro: "plei-ofs" },
                    { es: "Final de temporada", en: "Finals", pro: "fai-nals" },
                    { es: "Pista de carreras", en: "Track", pro: "trak" },
                    { es: "Cancha de baloncesto", en: "Basketball court", pro: "bas-ket-bol cort" },
                    { es: "Ring de boxeo", en: "Boxing ring", pro: "bok-sin ring" },
                    { es: "Bate (de béisbol)", en: "Bat", pro: "bat" },
                    { es: "Raqueta (de tenis)", en: "Racket", pro: "ra-ket" },
                    { es: "Casco de protección", en: "Helmet", pro: "jel-met" },
                    { es: "Guantes deportivos", en: "Gloves", pro: "glavs" },
                    { es: "Silbato del árbitro", en: "Whistle", pro: "guis-sol" },
                    { es: "Falta / Infracción", en: "Foul / Violation", pro: "faul / vaio-lei-shon" },
                    { es: "Tarjeta amarilla", en: "Yellow card", pro: "ie-lou card" },
                    { es: "Tarjeta roja", en: "Red card", pro: "red card" },
                    { es: "Fuera de juego", en: "Offside", pro: "of-said" },
                    { es: "Tiro penal / Penalty", en: "Penalty kick", pro: "pe-nal-ti kik" },
                    { es: "Tiro libre", en: "Free kick", pro: "frii kik" },
                    { es: "Esquina / Corner", en: "Corner", pro: "cor-ner" },
                    { es: "Primer tiempo", en: "First half", pro: "ferst jaf" },
                    { es: "Segundo tiempo", en: "Second half", pro: "se-kond jaf" },
                    { es: "Tiempo extra / Prórroga", en: "Overtime / Extra time", pro: "ou-ver-taim / eks-tra taim" },
                    { es: "Hacer ejercicio", en: "To exercise", pro: "tu ek-ser-sais" },
                    { es: "Estirar (Músculos)", en: "To stretch", pro: "tu es-trech" },
                    { es: "Calentamiento", en: "Warm-up", pro: "uorm-ap" },
                    { es: "Lesión deportiva", en: "Sports injury", pro: "sports in-joo-ri" },
                    { es: "Estar en forma", en: "To be in shape", pro: "tu bi in sheip" },
                    { es: "Atajar / Salvar el gol", en: "To save", pro: "tu seiv" },
                    { es: "Anotar un punto / gol", en: "To score a goal / point", pro: "tu es-kor a goul / point" },
                    { es: "Hacer trampa", en: "To cheat", pro: "tu chiit" },
                    { es: "Juego limpio", en: "Fair play", pro: "fer plei" },
                    { es: "Uniforme del equipo", en: "Team uniform", pro: "tiim iu-ni-form" },
                    { es: "Camiseta de juego / Jersey", en: "Jersey", pro: "ier-si" },
                    { es: "Número de jugador", en: "Player number", pro: "plei-er nam-ber" },
                    { es: "Estadísticas del juego", en: "Game stats", pro: "gueim estats" },
                    { es: "Patrocinador deportivo", en: "Sponsor", pro: "es-pon-sor" },
                    { es: "Espectadores", en: "Spectators / Audience", pro: "es-pek-tei-dors / o-diens" },
                    { es: "Entradas agotadas", en: "Sold out", pro: "sould aut" },
                    { es: "Victoria", en: "Victory", pro: "vik-to-ri" },
                    { es: "Derrota", en: "Defeat / Loss", pro: "di-fiit / los" },
                    { es: "Puntuación final", en: "Final score", pro: "fai-nal es-kor" },
                    { es: "Líder del torneo", en: "Tournament leader", pro: "tur-na-ment lii-der" },
                    { es: "Billiards / Billar", en: "Billiards / Pool", pro: "bi-liards / puul" },
                    { es: "Mesa de billar", en: "Pool table", pro: "puul tei-bol" },
                    { es: "Taco de billar", en: "Pool cue", pro: "puul kiu" },
                    { es: "Bola de billar", en: "Pool ball", pro: "puul bol" },
                    { es: "Tiza de billar", en: "Cue chalk", pro: "kiu chok" },
                    { es: "Tronera / Agujero de billar", en: "Pocket", pro: "po-ket" },
                    { es: "Tiro espectacular", en: "Trick shot", pro: "trik shot" },
                    { es: "¡Buen juego!", en: "Good game!", pro: "gud gueim" },
                    { es: "Fue un partido reñido.", en: "It was a tight match.", pro: "it guas a tait mach" },
                    { es: "El equipo local ganó.", en: "The home team won.", pro: "de joum tiim guon" },
                    { es: "El equipo visitante perdió.", en: "The away team lost.", pro: "di a-guei tiim lost" },
                    { es: "¡Vamos equipo!", en: "Let's go team!", pro: "lets gou tiim" },
                    { es: "El defensa bloqueó el tiro.", en: "The defender blocked the shot.", pro: "de di-fen-der blokt de shot" },
                    { es: "El delantero falló el tiro.", en: "The forward missed the shot.", pro: "de for-uard mist de shot" },
                    { es: "El portero cometió un error.", en: "The goalkeeper made a mistake.", pro: "de goul-kii-per meid a mis-teik" },
                    { es: "¡Qué gran jugada!", en: "What a great play!", pro: "uat a greit plei" },
                    { es: "El árbitro detuvo el juego.", en: "The referee stopped the play.", pro: "de re-fe-rii estopt de plei" },
                    { es: "El partido comenzó.", en: "The game started.", pro: "de gueim es-tar-ted" },
                    { es: "El partido terminó.", en: "The game ended.", pro: "de gueim en-ded" }
                ],
                "Días y Tiempo ⏰": [
                    { es: "Hoy", en: "Today", pro: "tu-dei" },
                    { es: "Ayer", en: "Yesterday", pro: "ies-ter-dei" },
                    { es: "Mañana (Día siguiente)", en: "Tomorrow", pro: "tu-ma-rou" },
                    { es: "Mañana (Temprano)", en: "Morning", pro: "mor-nin" },
                    { es: "Tarde", en: "Afternoon", pro: "af-ter-nuun" },
                    { es: "Noche", en: "Night", pro: "nait" },
                    { es: "Semana", en: "Week", pro: "guiik" },
                    { es: "Fin de semana", en: "Weekend", pro: "guiik-end" },
                    { es: "Lunes", en: "Monday", pro: "man-dei" },
                    { es: "Martes", en: "Tuesday", pro: "tuus-dei" },
                    { es: "Miércoles", en: "Wednesday", pro: "guens-dei" },
                    { es: "Jueves", en: "Thursday", pro: "zers-dei" },
                    { es: "Viernes", en: "Friday", pro: "frai-dei" },
                    { es: "Sábado", en: "Saturday", pro: "sa-ter-dei" },
                    { es: "Domingo", en: "Sunday", pro: "san-dei" },
                    { es: "Ahora", en: "Now", pro: "nau" },
                    { es: "Más tarde", en: "Later", pro: "lei-ter" },
                    { es: "Pronto", en: "Soon", pro: "suun" },
                    { es: "A tiempo", en: "On time", pro: "on taim" },
                    { es: "Tarde / Retrasado", en: "Late", pro: "leit" },
                    { es: "Pasado mañana", en: "The day after tomorrow", pro: "de dei af-ter tu-ma-rou" },
                    { es: "Antes de ayer / Anteayer", en: "The day before yesterday", pro: "de dei bi-for ies-ter-dei" },
                    { es: "La semana pasada", en: "Last week", pro: "last guiik" },
                    { es: "La próxima semana", en: "Next week", pro: "nekst guiik" },
                    { es: "Mes", en: "Month", pro: "manz" },
                    { es: "Año", en: "Year", pro: "ii-ar" },
                    { es: "Década", en: "Decade", pro: "de-keid" },
                    { es: "Siglo", en: "Century", pro: "sen-chu-ri" },
                    { es: "Mediodía", en: "Noon / Midday", pro: "nuun / mid-dei" },
                    { es: "Medianoche", en: "Midnight", pro: "mid-nait" },
                    { es: "Madrugada", en: "Early morning / Dawn", pro: "er-li mor-nin / don" },
                    { es: "Anoche", en: "Last night", pro: "last nait" },
                    { es: "Esta noche", en: "Tonight", pro: "tu-nait" },
                    { es: "Diario / Cada día", en: "Daily", pro: "dei-li" },
                    { es: "Semanal / Cada semana", en: "Weekly", pro: "guiik-li" },
                    { es: "Mensual / Cada mes", en: "Monthly", pro: "manz-li" },
                    { es: "Anual / Cada año", en: "Annually / Yearly", pro: "an-iual-i / ii-ar-li" },
                    { es: "Siempre", en: "Always", pro: "ol-gueis" },
                    { es: "Nunca", en: "Never", pro: "ne-ver" },
                    { es: "A veces", en: "Sometimes", pro: "sam-taims" },
                    { es: "A menudo / Frecuentemente", en: "Often", pro: "o-fen" },
                    { es: "Raramente", en: "Rarely / Seldom", pro: "rer-li / sel-dom" },
                    { es: "De vez en cuando", en: "Once in a while", pro: "uans in a uail" },
                    { es: "Temprano en la mañana", en: "Early in the morning", pro: "er-li in de mor-nin" },
                    { es: "Tarde en la noche", en: "Late at night", pro: "leit at nait" },
                    { es: "Día laborable / de semana", en: "Weekday", pro: "guiik-dei" },
                    { es: "Día festivo / Feriado", en: "Holiday", pro: "jo-li-dei" },
                    { es: "Día libre", en: "Day off", pro: "dei of" },
                    { es: "Fecha de vencimiento", en: "Due date", pro: "diuu deit" },
                    { es: "Línea de tiempo", en: "Timeline", pro: "taim-lain" },
                    { es: "Hace un momento", en: "A moment ago", pro: "a mou-ment a-gou" },
                    { es: "En este momento", en: "Right now", pro: "rait nau" },
                    { es: "Para siempre", en: "Forever", pro: "for-e-ver" },
                    { es: "Temporal", en: "Temporary", pro: "tem-po-re-ri" },
                    { es: "Permanente", en: "Permanent", pro: "per-ma-nent" },
                    { es: "Pasado", en: "Past", pro: "past" },
                    { es: "Presente", en: "Present", pro: "pre-sent" },
                    { es: "Futuro", en: "Future", pro: "fiu-chur" },
                    { es: "Zona horaria", en: "Time zone", pro: "taim zoun" },
                    { es: "Horario de verano", en: "Daylight saving time", pro: "dei-lait sei-vin taim" },
                    { es: "Calendario", en: "Calendar", pro: "ka-len-dar" },
                    { es: "Agenda / Horario", en: "Schedule", pro: "es-ke-diuul" },
                    { es: "Puntual", en: "On time / Punctual", pro: "on taim / pank-chual" },
                    { es: "Retraso / Demora", en: "Delay", pro: "di-lei" },
                    { es: "Al mismo tiempo", en: "At the same time", pro: "at de seim taim" },
                    { es: "Mientras tanto", en: "Meanwhile", pro: "miin-uail" },
                    { es: "Hace mucho tiempo", en: "A long time ago", pro: "a long taim a-gou" },
                    { es: "La próxima vez", en: "Next time", pro: "nekst taim" },
                    { es: "La última vez", en: "Last time", pro: "last taim" },
                    { es: "Todo el día", en: "All day long", pro: "ol dei long" },
                    { es: "Toda la noche", en: "All night long", pro: "ol nait long" },
                    { es: "Cada dos días", en: "Every other day", pro: "ev-ri o-der dei" },
                    { es: "Una vez por semana", en: "Once a week", pro: "uans a guiik" },
                    { es: "Dos veces al mes", en: "Twice a month", pro: "tuais a manz" },
                    { es: "Tres veces por año", en: "Three times a year", pro: "zrii taims a ii-ar" },
                    { es: "En las mañanas", en: "In the mornings", pro: "in de mor-nins" },
                    { es: "En las tardes", en: "In the afternoons", pro: "in de af-ter-nuuns" },
                    { es: "Por la noche", en: "At night", pro: "at nait" },
                    { es: "Durante el día", en: "During the day", pro: "diu-rin de dei" },
                    { es: "Espera un minuto.", en: "Wait a minute.", pro: "ueit a mi-nit" },
                    { es: "Dame un segundo.", en: "Give me a second.", pro: "guiv mi a se-kond" },
                    { es: "No tengo tiempo.", en: "I don't have time.", pro: "ai dount jaf taim" },
                    { es: "El tiempo vuela.", en: "Time flies.", pro: "taim flais" },
                    { es: "Es hora de irnos.", en: "It's time to go.", pro: "its taim tu gou" },
                    { es: "Se acabó el tiempo.", en: "Time is up.", pro: "taim is ap" },
                    { es: "Ahorrar tiempo", en: "To save time", pro: "tu seiv taim" },
                    { es: "Perder el tiempo", en: "To waste time", pro: "tu ueist taim" },
                    { es: "Tomarse su tiempo", en: "To take your time", pro: "tu teik ior taim" },
                    { es: "Día a día", en: "Day by day", pro: "dei bai dei" },
                    { es: "Paso a paso", en: "Step by step", pro: "estep bai estep" },
                    { es: "Justo a tiempo", en: "Just in time", pro: "jast in taim" },
                    { es: "Demasiado tarde", en: "Too late", pro: "tuu leit" },
                    { es: "Demasiado temprano", en: "Too early", pro: "tuu er-li" },
                    { es: "El próximo lunes", en: "Next Monday", pro: "nekst man-dei" },
                    { es: "El viernes pasado", en: "Last Friday", pro: "last frai-dei" },
                    { es: "Durante el fin de semana", en: "Over the weekend", pro: "ou-ver de guiik-end" },
                    { es: "¿Qué día es hoy?", en: "What day is today?", pro: "uat dei is tu-dei" },
                    { es: "¡Que tengas un buen día!", en: "Have a nice day!", pro: "jaf a nais dei" },
                    { es: "Nos vemos mañana.", en: "See you tomorrow.", pro: "sii iu tu-ma-rou" },
                    { es: "Nos vemos más tarde.", en: "See you later.", pro: "sii iu lei-ter" }
                ],
                "Educación y Escuela 📚": [
                    { es: "Libro", en: "Book", pro: "buk" },
                    { es: "Cuaderno", en: "Notebook", pro: "nout-buk" },
                    { es: "Bolígrafo / Lapicero", en: "Pen", pro: "pen" },
                    { es: "Lápiz", en: "Pencil", pro: "pen-sil" },
                    { es: "Profesor", en: "Teacher", pro: "tii-cher" },
                    { es: "Estudiante", en: "Student", pro: "es-tuu-dent" },
                    { es: "Clase", en: "Class", pro: "klas" },
                    { es: "Tarea", en: "Homework", pro: "joum-guerk" },
                    { es: "Examen", en: "Exam", pro: "ek-sam" },
                    { es: "Escuela", en: "School", pro: "es-kuul" },
                    { es: "Universidad", en: "University", pro: "iu-ni-ver-si-ti" },
                    { es: "Biblioteca", en: "Library", pro: "lai-bre-ri" },
                    { es: "Aprender", en: "To learn", pro: "tu lern" },
                    { es: "Estudiar", en: "To study", pro: "tu es-ta-di" },
                    { es: "Pregunta", en: "Question", pro: "kues-shon" },
                    { es: "Respuesta", en: "Answer", pro: "an-ser" },
                    { es: "Escritorio", en: "Desk", pro: "desk" },
                    { es: "Computadora", en: "Computer", pro: "com-piu-ter" },
                    { es: "Mochila / Morral", en: "Backpack", pro: "bak-pak" },
                    { es: "Aprobado / Pasado", en: "Passed", pro: "past" },
                    { es: "Reprobado / Raspado", en: "Failed", pro: "feild" },
                    { es: "Aula de clases / Salón", en: "Classroom", pro: "klas-ruum" },
                    { es: "Pizarra / Tablero", en: "Whiteboard / Blackboard", pro: "uait-boord / blak-boord" },
                    { es: "Marcador (de pizarra)", en: "Marker", pro: "mar-ker" },
                    { es: "Borrador (de pizarra)", en: "Eraser", pro: "i-rei-ser" },
                    { es: "Regla", en: "Ruler", pro: "ruu-ler" },
                    { es: "Tijeras", en: "Scissors", pro: "si-sors" },
                    { es: "Pegamento", en: "Glue", pro: "gluu" },
                    { es: "Sacapuntas", en: "Pencil sharpener", pro: "pen-sil shar-pe-ner" },
                    { es: "Diccionario", en: "Dictionary", pro: "dik-shon-e-ri" },
                    { es: "Lección / Tema", en: "Lesson", pro: "le-son" },
                    { es: "Curso", en: "Course", pro: "coors" },
                    { es: "Materia / Asignatura", en: "Subject", pro: "sab-jekt" },
                    { es: "Matemáticas", en: "Math", pro: "maz" },
                    { es: "Ciencias", en: "Science", pro: "sai-ens" },
                    { es: "Historia", en: "History", pro: "jis-to-ri" },
                    { es: "Geografía", en: "Geography", pro: "yi-o-graf-i" },
                    { es: "Idiomas", en: "Languages", pro: "lan-guich-es" },
                    { es: "Inglés", en: "English", pro: "in-glish" },
                    { es: "Educación física", en: "Physical education / PE", pro: "fi-si-kol e-diu-kei-shon / pii-ii" },
                    { es: "Horario de clases", en: "Class schedule", pro: "klas es-ke-diuul" },
                    { es: "Calificación / Nota", en: "Grade / Score", pro: "greid / es-kor" },
                    { es: "Boleta de calificaciones", en: "Report card", pro: "ri-port card" },
                    { es: "Proyecto", en: "Project", pro: "pro-jekt" },
                    { es: "Presentación / Exposición", en: "Presentation", pro: "pre-sen-tei-shon" },
                    { es: "Inscripción / Matrícula", en: "Enrollment / Registration", pro: "in-roul-ment / re-yis-trei-shon" },
                    { es: "Pagar la matrícula", en: "Tuition", pro: "tiu-i-shon" },
                    { es: "Beca", en: "Scholarship", pro: "esco-lar-ship" },
                    { es: "Título / Diploma", en: "Degree / Diploma", pro: "di-grii / di-plou-ma" },
                    { es: "Graduación", en: "Graduation", pro: "gra-diu-ei-shon" },
                    { es: "Director de la escuela", en: "Principal", pro: "prin-si-pol" },
                    { es: "Consejero", en: "Counselor", pro: "caun-se-lor" },
                    { es: "Compañero de clase", en: "Classmate", pro: "klas-meit" },
                    { es: "Asistencia (Estar presente)", en: "Attendance", pro: "a-ten-dans" },
                    { es: "Ausente", en: "Absent", pro: "ab-sent" },
                    { es: "Presente", en: "Present", pro: "pre-sent" },
                    { es: "Llegar tarde", en: "Tardy", pro: "tar-di" },
                    { es: "Vacaciones escolares", en: "School break / Vacation", pro: "kuul breik / vei-kei-shon" },
                    { es: "Locker / Casillero", en: "Locker", pro: "lo-ker" },
                    { es: "Cafetería escolar", en: "Cafeteria", pro: "ka-fe-tii-ria" },
                    { es: "Auditorio", en: "Auditorium", pro: "o-di-to-riom" },
                    { es: "Laboratorio", en: "Laboratory / Lab", pro: "la-bo-ra-to-ri / lab" },
                    { es: "Patio de recreo", en: "Playground", pro: "plei-graund" },
                    { es: "Autobús escolar / Bus", en: "School bus", pro: "skuul bas" },
                    { es: "Hacer una pregunta", en: "To ask a question", pro: "tu ask a kues-shon" },
                    { es: "Responder una pregunta", en: "To answer a question", pro: "tu an-ser a kues-shon" },
                    { es: "Prestar atención", en: "To pay attention", pro: "tu pei a-ten-shon" },
                    { es: "Tomar notas / apuntes", en: "To take notes", pro: "tu teik nouts" },
                    { es: "Leer", en: "To read", pro: "tu riid" },
                    { es: "Escribir", en: "To write", pro: "tu rait" },
                    { es: "Escuchar", en: "To listen", pro: "tu lis-sen" },
                    { es: "Hablar", en: "To speak", pro: "tu es-piik" },
                    { es: "Pronunciar", en: "To pronounce", pro: "tu pro-nauns" },
                    { es: "Deletrear", en: "To spell", pro: "tu es-pel" },
                    { es: "Practicar", en: "To practice", pro: "tu prak-tis" },
                    { es: "Entender / Comprender", en: "To understand", pro: "tu an-der-es-tand" },
                    { es: "Recordar", en: "To remember", pro: "tu ri-mem-ber" },
                    { es: "Olvidar", en: "To forget", pro: "tu for-guet" },
                    { es: "Revisar / Repasar", en: "To review", pro: "tu ri-viu" },
                    { es: "Hacer un examen", en: "To take an exam", pro: "tu teik an ek-sam" },
                    { es: "Pasar / Aprobar un examen", en: "To pass an exam", pro: "tu pas an ek-sam" },
                    { es: "Reprobar / Perder un examen", en: "To fail an exam", pro: "tu feil an ek-sam" },
                    { es: "Educación en línea", en: "Online learning", pro: "on-lain ler-nin" },
                    { es: "Sitio web educativo", en: "Educational website", pro: "e-diu-kei-sho-nal ueb-said" },
                    { es: "Aplicación para aprender", en: "Learning app", pro: "ler-nin ap" },
                    { es: "Nivel básico", en: "Basic level", pro: "bei-sik le-vol" },
                    { es: "Nivel intermedio", en: "Intermediate level", pro: "in-ter-mii-diat le-vol" },
                    { es: "Nivel avanzado", en: "Advanced level", pro: "ad-vanst le-vol" },
                    { es: "Fluido (Idioma)", en: "Fluent", pro: "fluu-ent" },
                    { es: "Vocabulario", en: "Vocabulary", pro: "vo-ka-biu-le-ri" },
                    { es: "Gramática", en: "Grammar", pro: "gra-mar" },
                    { es: "Silencio, por favor.", en: "Silence, please.", pro: "sai-lens pliiz" },
                    { es: "Abran sus libros.", en: "Open your books.", pro: "ou-pen ior buks" },
                    { es: "Cierren sus libros.", en: "Close your books.", pro: "clous ior buks" },
                    { es: "Por favor, siéntense.", en: "Please, take a seat.", pro: "pliis teik a siit" },
                    { es: "Levanten la mano.", en: "Raise your hand.", pro: "reis ior jand" },
                    { es: "Buen trabajo.", en: "Good job.", pro: "gud job" },
                    { es: "Sigan practicando.", en: "Keep practicing.", pro: "kiip prak-ti-sin" },
                    { es: "La clase terminó.", en: "Class is over.", pro: "klas is ou-ver" }
                ],
                "El Cuerpo Humano 🧠": [
                    { es: "Cabeza", en: "Head", pro: "jed" },
                    { es: "Pelo / Cabello", en: "Hair", pro: "jer" },
                    { es: "Cara / Rostro", en: "Face", pro: "feis" },
                    { es: "Ojo", en: "Eye", pro: "ai" },
                    { es: "Oreja / Oído", en: "Ear", pro: "iar" },
                    { es: "Nariz", en: "Nose", pro: "nous" },
                    { es: "Boca", en: "Mouth", pro: "mauz" },
                    { es: "Labios", en: "Lips", pro: "lips" },
                    { es: "Diente", en: "Tooth", pro: "tuuz" },
                    { es: "Dientes (Plural)", en: "Teeth", pro: "tiiz" },
                    { es: "Lengua", en: "Tongue", pro: "tang" },
                    { es: "Cuello", en: "Neck", pro: "nek" },
                    { es: "Garganta", en: "Throat", pro: "zrout" },
                    { es: "Hombro", en: "Shoulder", pro: "shoul-der" },
                    { es: "Brazo", en: "Arm", pro: "arm" },
                    { es: "Codo", en: "Elbow", pro: "el-bou" },
                    { es: "Muñeca (de la mano)", en: "Wrist", pro: "rist" },
                    { es: "Mano", en: "Hand", pro: "jand" },
                    { es: "Dedo (de la mano)", en: "Finger", pro: "fin-guer" },
                    { es: "Uña", en: "Nail", pro: "neil" },
                    { es: "Pecho", en: "Chest", pro: "chest" },
                    { es: "Espalda", en: "Back", pro: "bak" },
                    { es: "Estómago / Panza", en: "Stomach / Belly", pro: "es-to-mak / be-li" },
                    { es: "Cintura", en: "Waist", pro: "gueist" },
                    { es: "Cadera", en: "Hip", pro: "jip" },
                    { es: "Pierna", en: "Leg", pro: "leg" },
                    { es: "Rodilla", en: "Knee", pro: "nii" },
                    { es: "Tobillo", en: "Ankle", pro: "an-kol" },
                    { es: "Pie", en: "Foot", pro: "fut" },
                    { es: "Pies (Plural)", en: "Feet", pro: "fiit" },
                    { es: "Dedo del pie", en: "Toe", pro: "tou" },
                    { es: "Cerebro", en: "Brain", pro: "brein" },
                    { es: "Corazón", en: "Heart", pro: "jart" },
                    { es: "Pulmones", en: "Lungs", pro: "langs" },
                    { es: "Hueso", en: "Bone", pro: "boun" },
                    { es: "Músculo", en: "Muscle", pro: "mas-ol" },
                    { es: "Sangre", en: "Blood", pro: "blad" },
                    { es: "Piel", en: "Skin", pro: "skin" },
                    { es: "Frente", en: "Forehead", pro: "for-jed" },
                    { es: "Cejas", en: "Eyebrows", pro: "ai-braus" },
                    { es: "Pestañas", en: "Eyelashes", pro: "ai-la-shes" },
                    { es: "Mejilla / Cachete", en: "Cheek", pro: "chiik" },
                    { es: "Barbilla / Mentón", en: "Chin", pro: "chin" },
                    { es: "Barba", en: "Beard", pro: "biard" },
                    { es: "Bigote", en: "Mustache", pro: "mas-tach" },
                    { es: "Encías", en: "Gums", pro: "gams" },
                    { es: "Mandíbula", en: "Jaw", pro: "jo" },
                    { es: "Nudillos", en: "Knuckles", pro: "na-kols" },
                    { es: "Dedo pulgar", en: "Thumb", pro: "zam" },
                    { es: "Palma de la mano", en: "Palm", pro: "palm" },
                    { es: "Axila", en: "Armpit", pro: "arm-pit" },
                    { es: "Costillas", en: "Ribs", pro: "ribs" },
                    { es: "Ombligo", en: "Belly button / Navel", pro: "be-li ba-ton / nei-vel" },
                    { es: "Columna vertebral", en: "Spine / Backbone", pro: "espain / bak-boun" },
                    { es: "Trasero / Cola", en: "Butt / Behind", pro: "bat / bi-jaind" },
                    { es: "Muslo", en: "Thigh", pro: "zai" },
                    { es: "Pantorrilla", en: "Calf", pro: "kaf" },
                    { es: "Talón", en: "Heel", pro: "jiil" },
                    { es: "Esqueleto", en: "Skeleton", pro: "es-ke-le-ton" },
                    { es: "Vena", en: "Vein", pro: "vein" },
                    { es: "Arteria", en: "Artery", pro: "ar-te-ri" },
                    { es: "Hígado", en: "Liver", pro: "li-ver" },
                    { es: "Riñones", en: "Kidneys", pro: "kid-nis" },
                    { es: "Vejiga", en: "Bladder", pro: "bla-der" },
                    { es: "Intestinos", en: "Intestines", pro: "in-tes-tins" },
                    { es: "Grasa corporal", en: "Body fat", pro: "bo-di fat" },
                    { es: "Saliva", en: "Saliva / Spit", pro: "sa-lai-va / spit" },
                    { es: "Lágrimas", en: "Tears", pro: "tiars" },
                    { es: "Sudor", en: "Sweat", pro: "suet" },
                    { es: "Voz", en: "Voice", pro: "vois" },
                    { es: "Respiración", en: "Breath", pro: "brez" },
                    { es: "Sistema nervioso", en: "Nervous system", pro: "ner-vos sis-tem" },
                    { es: "Articulación", en: "Joint", pro: "ioint" },
                    { es: "Me duele la cabeza.", en: "I have a headache.", pro: "ai jaf a jed-eik" },
                    { es: "Me duele el estómago.", en: "I have a stomachache.", pro: "ai jaf a es-to-ma-keik" },
                    { es: "Me duele la espalda.", en: "My back hurts.", pro: "mai bak jerts" },
                    { es: "Me duele la garganta.", en: "I have a sore throat.", pro: "ai jaf a sor zrout" },
                    { es: "Tengo los ojos cansados.", en: "My eyes are tired.", pro: "mai ais ar tai-ard" },
                    { es: "Lávate las manos.", en: "Wash your hands.", pro: "uash ior jands" },
                    { es: "Cepíllate los dientes.", en: "Brush your teeth.", pro: "brash ior tiiz" },
                    { es: "Córtate las uñas.", en: "Cut your nails.", pro: "cat ior neils" },
                    { es: "Él tiene brazos fuertes.", en: "He has strong arms.", pro: "ji jas estrong arms" },
                    { es: "Ella tiene el cabello largo.", en: "She has long hair.", pro: "shi jas long jer" },
                    { es: "Me doblé el tobillo.", en: "I twisted my ankle.", pro: "ai tuis-ted mai an-kol" },
                    { es: "El corazón late rápido.", en: "The heart beats fast.", pro: "de jart biits fast" },
                    { es: "Toma un respiro profundo.", en: "Take a deep breath.", pro: "teik a diip brez" },
                    { es: "Tengo la piel seca.", en: "I have dry skin.", pro: "ai jaf drai skin" },
                    { es: "Abre la boca.", en: "Open your mouth.", pro: "ou-pen ior mauz" },
                    { es: "Cierra los ojos.", en: "Close your eyes.", pro: "clous ior ais" },
{ es: "Mueve los dedos.", en: "Move your fingers.", pro: "muuv ior fin-guers" },
                    { es: "Ponte de pie.", en: "Stand on your feet.", pro: "estand on ior fiit" },
                    { es: "Estira las piernas.", en: "Stretch your legs.", pro: "estrech ior legs" },
                    { es: "Tienes una sonrisa hermosa.", en: "You have a beautiful smile.", pro: "iu jaf a biu-ti-ful es-mail" },
                    { es: "Escucha con atención.", en: "Listen with your ears.", pro: "lis-sen guiz ior iars" },
                    { es: "El cerebro controla todo.", en: "The brain controls everything.", pro: "de brein con-trouls ev-ri-zin" },
                    { es: "Tengo un moretón en el brazo.", en: "I have a bruise on my arm.", pro: "ai jaf a bruus on mai arm" },
                    { es: "La sangre es roja.", en: "Blood is red.", pro: "blad is red" },
                    { es: "Cuida tu cuerpo.", en: "Take care of your body.", pro: "teik ker of ior bo-di" },
                    { es: "Mantente saludable.", en: "Stay healthy.", pro: "estei jel-zi" }
                ],
                "Emociones y Sentimientos 😊": [
                    { es: "Feliz", en: "Happy", pro: "ja-pi" },
                    { es: "Triste", en: "Sad", pro: "sad" },
                    { es: "Enojado / Enfadado", en: "Angry", pro: "an-gri" },
                    { es: "Cansado", en: "Tired", pro: "tai-ard" },
                    { es: "Enfermo", en: "Sick", pro: "sik" },
                    { es: "Sano", en: "Healthy", pro: "jel-zi" },
                    { es: "Asustado", en: "Scared / Afraid", pro: "es-kerd / a-freid" },
                    { es: "Sorprendido", en: "Surprised", pro: "ser-praisd" },
                    { es: "Aburrido", en: "Boring / Bored", pro: "bo-rin / boord" },
                    { es: "Preocupado", en: "Worried", pro: "gua-rid" },
                    { es: "Nervioso", en: "Nervous", pro: "ner-vios" },
                    { es: "Orgulloso", en: "Proud", pro: "praud" },
                    { es: "Celoso", en: "Jealous", pro: "je-los" },
                    { es: "Agradecido", en: "Grateful / Thankful", pro: "greit-ful / zenk-ful" },
                    { es: "Emocionado", en: "Excited", pro: "ek-sai-ted" },
                    { es: "Confundido", en: "Confused", pro: "con-fiuusd" },
                    { es: "Avergonzado", en: "Embarrassed", pro: "im-ba-rast" },
                    { es: "Enamorado", en: "In love", pro: "in lav" },
                    { es: "Tranquilo / Calmado", en: "Calm", pro: "calm" },
                    { es: "Estresado", en: "Stressed", pro: "es-trest" },
                    { es: "Ansioso", en: "Anxious", pro: "ank-shos" },
                    { es: "Frustrado", en: "Frustrated", pro: "fros-trei-ted" },
                    { es: "Decepcionado", en: "Disappointed", pro: "dis-a-poin-ted" },
                    { es: "Culpable", en: "Guilty", pro: "guil-ti" },
                    { es: "Inseguro", en: "Insecure", pro: "in-si-kiuur" },
                    { es: "Seguro de sí mismo", en: "Confident", pro: "con-fi-dent" },
                    { es: "Esperanzado", en: "Hopeful", pro: "joup-ful" },
                    { es: "Solitario", en: "Lonely", pro: "loun-li" },
                    { es: "Agotado", en: "Exhausted", pro: "ek-sos-ted" },
                    { es: "Asqueado", en: "Disgusted", pro: "dis-gas-ted" },
                    { es: "Curioso", en: "Curious", pro: "kiu-rios" },
                    { es: "Serio", en: "Serious", pro: "si-rios" },
                    { es: "Tímido", en: "Shy", pro: "shai" },
                    { es: "Optimista", en: "Optimistic", pro: "op-ti-mis-tik" },
                    { es: "Pesimista", en: "Pessimistic", pro: "pe-si-mis-tik" },
                    { es: "Cómodo", en: "Comfortable", pro: "kam-for-ta-bol" },
                    { es: "Incómodo", en: "Uncomfortable", pro: "an-kam-for-ta-bol" },
                    { es: "Satisfecho", en: "Satisfied", pro: "sa-tis-faid" },
                    { es: "Insatisfecho", en: "Dissatisfied", pro: "dis-sa-tis-faid" },
                    { es: "Alegre", en: "Cheerful", pro: "chiar-ful" },
                    { es: "Amargado / Malhumorado", en: "Grumpy", pro: "gram-pi" },
                    { es: "Impaciente", en: "Impatient", pro: "im-pei-shent" },
                    { es: "Paciente", en: "Patient", pro: "pei-shent" },
                    { es: "Ofendido", en: "Offended", pro: "o-fen-ded" },
                    { es: "Aliviado", en: "Relieved", pro: "ri-liivd" },
                    { es: "Sospechoso", en: "Suspicious", pro: "sas-pi-shos" },
                    { es: "Herido (Emocionalmente)", en: "Hurt", pro: "jert" },
                    { es: "Asombrado", en: "Amazed", pro: "a-meisd" },
                    { es: "Aterrado", en: "Terrified", pro: "te-ri-faid" },
                    { es: "Inquieto / Agitado", en: "Restless", pro: "rest-les" },
                    { es: "Me siento feliz hoy.", en: "I feel happy today.", pro: "ai fiil ja-pi tu-dei" },
                    { es: "No estés triste.", en: "Don't be sad.", pro: "dount bi sad" },
                    { es: "Él está muy enojado.", en: "He is very angry.", pro: "ji is ve-ri an-gri" },
                    { es: "Estoy cansado del trabajo.", en: "I'm tired of work.", pro: "aim tai-ard of uerk" },
                    { es: "Espero que te sientas mejor.", en: "I hope you feel better.", pro: "ai joup iu fiil be-ter" },
                    { es: "Tengo miedo de la oscuridad.", en: "I'm afraid of the dark.", pro: "aim a-freid of de dark" },
                    { es: "Fue una gran sorpresa.", en: "That was a big surprise.", pro: "dat guas a big ser-prais" },
                    { es: "Estoy aburrido en casa.", en: "I'm bored at home.", pro: "aim boord at joum" },
                    { es: "No te preocupes por eso.", en: "Don't worry about it.", pro: "dount gua-ri a-baut it" },
                    { es: "Estoy un poco nervioso.", en: "I'm a little nervous.", pro: "aim a li-tol ner-vios" },
                    { es: "Estoy orgulloso de ti.", en: "I'm proud of you.", pro: "aim praud of iu" },
                    { es: "No tengas celos.", en: "Don't be jealous.", pro: "dount bi je-los" },
                    { es: "Estoy muy agradecido.", en: "I'm very grateful.", pro: "aim ve-ri greit-ful" },
                    { es: "Estamos emocionados por el viaje.", en: "We are excited about the trip.", pro: "gui ar ek-sai-ted a-baut de trip" },
                    { es: "Estoy confundido con las direcciones.", en: "I'm confused with the directions.", pro: "aim con-fiuusd guiz de di-rek-shons" },
                    { es: "Me dio mucha vergüenza.", en: "I was so embarrassed.", pro: "ai guas sou im-ba-rast" },
                    { es: "Ellos están muy enamorados.", en: "They are deeply in love.", pro: "dei ar diip-li in lav" },
                    { es: "Por favor, mantén la calma.", en: "Please, keep calm.", pro: "pliis kiip calm" },
                    { es: "Tengo mucho estrés hoy.", en: "I have a lot of stress today.", pro: "ai jaf a lot of es-tres tu-dei" },
                    { es: "La espera me da ansiedad.", en: "The wait gives me anxiety.", pro: "de ueit guivs mi ank-sai-ti" },
                    { es: "Me siento frustrado.", en: "I feel frustrated.", pro: "ai fiil fros-trei-ted" },
                    { es: "No me decepciones.", en: "Don't disappoint me.", pro: "dount dis-a-point mi" },
                    { es: "Él no tiene la culpa.", en: "He is not guilty.", pro: "ji is not guil-ti" },
                    { es: "Me siento seguro de mí mismo.", en: "I feel confident.", pro: "ai fiil con-fi-dent" },
                    { es: "Tengo esperanzas de ganar.", en: "I am hopeful about winning.", pro: "ai am joup-ful a-baut gui-nin" },
                    { es: "A veces me siento solo.", en: "Sometimes I feel lonely.", pro: "sam-taims ai fiil loun-li" },
                    { es: "Estoy completamente agotado.", en: "I am completely exhausted.", pro: "ai am com-pliit-li ek-sos-ted" },
                    { es: "Esa comida se ve asquerosa.", en: "That food looks disgusting.", pro: "dat fuud luks dis-gas-tin" },
                    { es: "Tengo curiosidad por saber.", en: "I'm curious to know.", pro: "aim kiu-rios tu nou" },
                    { es: "Esto es un asunto serio.", en: "This is a serious matter.", pro: "dis is a si-rios ma-ter" },
                    { es: "Mi hijo es muy tímido.", en: "My son is very shy.", pro: "mai san is ve-ri shai" },
                    { es: "Hay que ser optimistas.", en: "We must be optimistic.", pro: "gui mast bi op-ti-mis-tik" },
                    { es: "Este sofá es muy cómodo.", en: "This couch is very comfortable.", pro: "dis cauch is ve-ri kam-for-ta-bol" },
                    { es: "Me siento incómodo aquí.", en: "I feel uncomfortable here.", pro: "ai fiil an-kam-for-ta-bol jiar" },
                    { es: "Estoy satisfecho con el trabajo.", en: "I'm satisfied with the work.", pro: "aim sa-tis-faid guiz de uerk" },
                    { es: "Ella siempre está alegre.", en: "She is always cheerful.", pro: "shi is ol-gueis chiar-ful" },
                    { es: "Hoy amanecí de mal genio.", en: "I woke up grumpy today.", pro: "ai uouk ap gram-pi tu-dei" },
                    { es: "No seas impaciente.", en: "Don't be impatient.", pro: "dount bi im-pei-shent" },
                    { es: "Sé paciente, por favor.", en: "Be patient, please.", pro: "bi pei-shent pliiz" },
                    { es: "Espero que no te ofendas.", en: "I hope you don't get offended.", pro: "ai joup iu dount guet o-fen-ded" },
                    { es: "Qué alivio escuchar eso.", en: "What a relief to hear that.", pro: "uat a ri-liif tu jiar dat" },
                    { es: "Eso se ve muy sospechoso.", en: "That looks very suspicious.", pro: "dat luks ve-ri sas-pi-shos" },
                    { es: "Me dolieron tus palabras.", en: "Your words hurt my feelings.", pro: "ior uerds jert mai fii-lins" },
                    { es: "Estoy asombrado con el resultado.", en: "I'm amazed with the result.", pro: "aim a-meisd guiz de ri-sal-tat" },
                    { es: "Estoy aterrado con esa película.", en: "I'm terrified of that movie.", pro: "aim te-ri-faid of dat muu-vi" },
                    { es: "Estás muy inquieto hoy.", en: "You are very restless today.", pro: "iu ar ve-ri rest-les tu-dei" },
                    { es: "Controla tus emociones.", en: "Control your emotions.", pro: "con-troul ior i-mou-shons" },
                    { es: "El amor lo cambia todo.", en: "Love changes everything.", pro: "lav chein-jis ev-ri-zin" },
                    { es: "Mañana será un mejor día.", en: "Tomorrow will be a better day.", pro: "tu-ma-rou guil bi a be-ter dei" }
                ],
                "Frases: Agencia de Viajes": [
                    { es: "Bienvenidos a Magic Travel.", en: "Welcome to Magic Travel.", pro: "guel-kam tu ma-yik tra-vel" },
                    { es: "¿Cuál es su destino?", en: "What is your destination?", pro: "uat is ior des-ti-nei-shon" },
                    { es: "Tengo una oferta excelente.", en: "I have an excellent deal.", pro: "ai jaf an ek-se-lent diil" },
                    { es: "¿Prefiere hotel todo incluido?", en: "Do you prefer an all-inclusive hotel?", pro: "du iu pri-fer an ol in-cluu-siv jo-tel" },
                    { es: "Su vuelo está confirmado.", en: "Your flight is confirmed.", pro: "ior flait is con-fermd" },
                    { es: "Necesito su pasaporte.", en: "I need your passport.", pro: "ai niid ior pas-port" },
                    { es: "El paquete incluye entradas a los parques.", en: "The package includes theme park tickets.", pro: "de pa-kich in-cluds ziim park ti-kets" },
                    { es: "¿Cuáles son las fechas de su viaje?", en: "What are your travel dates?", pro: "uat ar ior tra-vel deits" },
                    { es: "Le enviaré la cotización por correo.", en: "I will email you the quote.", pro: "ai guil ii-meil iu de cuout" },
                    { es: "Este precio es por persona.", en: "This price is per person.", pro: "dis prais is per per-son" },
                    { es: "El pago se puede hacer en cuotas.", en: "The payment can be made in installments.", pro: "de pei-ment can bi meid in in-stol-ments" },
                    { es: "Tenemos alquiler de autos disponible.", en: "We have car rentals available.", pro: "gui jaf car ren-tals a-vei-la-bol" },
                    { es: "La reserva está a su nombre.", en: "The reservation is under your name.", pro: "de re-ser-vei-shon is an-der ior neim" },
                    { es: "No incluye seguro de viaje.", en: "It does not include travel insurance.", pro: "it das not in-clud tra-vel in-shoo-rans" },
                    { es: "El crucero sale desde Miami.", en: "The cruise departs from Miami.", pro: "de cruus di-parts rom mai-a-mi" },
                    { es: "¿Desea un asiento de pasillo o ventana?", en: "Do you want an aisle or window seat?", pro: "du iu uant an ail or guin-dou siit" },
                    { es: "La hora del check-in es a las tres.", en: "Check-in time is at three p.m.", pro: "chek-in taim is at zrii pi-em" },
                    { es: "¡Que tenga un excelente viaje!", en: "Have a great trip!", pro: "jaf a greit trip" },
                    { es: "La oferta expira hoy.", en: "The offer expires today.", pro: "di o-fer eks-pai-ars tu-dei" },
                    { es: "Gracias por elegirnos.", en: "Thank you for choosing us.", pro: "zenk iu for chu-sin as" },
                    { es: "¿Necesita ayuda con las visas?", en: "Do you need help with visas?", pro: "du iu niid jelp guiz vi-sas" },
                    { es: "El vuelo tiene una escala corta.", en: "The flight has a short layover.", pro: "de flait jas a short lei-ou-ver" },
                    { es: "La política de cancelación es flexible.", en: "The cancellation policy is flexible.", pro: "de can-se-lei-shon po-li-si is flek-si-bol" },
                    { es: "El equipaje de mano es gratis.", en: "Carry-on luggage is free.", pro: "ca-ri on la-guich is frii" },
                    { es: "Debe pagar por la maleta documentada.", en: "You must pay for checked baggage.", pro: "iu mast pei for chekt ba-guich" },
                    { es: "Este hotel es apto para familias.", en: "This hotel is family friendly.", pro: "dis jo-tel is fa-mi-li frend-li" },
                    { es: "Tenemos resorts de lujo en Orlando.", en: "We have luxury resorts in Orlando.", pro: "gui jaf lak-shu-ri ri-sorts in or-lan-dou" },
                    { es: "¿Quiere agregar un seguro de cancelación?", en: "Do you want to add cancellation insurance?", pro: "du iu uant tu ad can-se-lei-shon in-shoo-rans" },
                    { es: "Su itinerario completo está listo.", en: "Your full itinerary is ready.", pro: "ior ful ai-ti-ne-re-ri is re-di" },
                    { es: "El hotel incluye desayuno gratuito.", en: "The hotel includes free breakfast.", pro: "de jo-tel in-cluds frii brek-fast" },
                    { es: "Le recomiendo reservar con tiempo.", en: "I recommend booking in advance.", pro: "ai re-co-miend bu-kin in ad-vans" },
                    { es: "¿Prefiere un auto económico o una minivan?", en: "Do you prefer an economy car or a minivan?", pro: "du iu pri-fer an i-co-no-mi car or a mi-ni-van" },
                    { es: "La capacidad del hotel está al límite.", en: "The hotel capacity is fully booked.", pro: "de jo-tel ka-pa-si-ti is ful-i bukt" },
                    { es: "Las entradas a Disney Springs son libres.", en: "Admission to Disney Springs is free.", pro: "ad-mi-shon tu dis-ni es-prins is frii" },
                    { es: "Aquí están sus pases digitales.", en: "Here are your digital passes.", pro: "jiar ar ior di-yi-tal pa-ses" },
                    { es: "No se permiten cambios de fecha.", en: "Date changes are not allowed.", pro: "deit chein-jis ar not a-laud" },
                    { es: "Esta es la temporada baja.", en: "This is the low season.", pro: "dis is de lou sii-son" },
                    { es: "La temporada alta es más costosa.", en: "High season is more expensive.", pro: "jai sii-son is mor eks-pen-siv" },
                    { es: "El check-out es a las once de la mañana.", en: "Check-out is at eleven a.m.", pro: "chek-aut is at i-le-ven ei-em" },
                    { es: "¿Tiene alguna petición especial?", en: "Do you have any special requests?", pro: "du iu jaf e-ni es-pe-shal ri-kuests" },
                    { es: "El tour tiene un guía bilingüe.", en: "The tour has a bilingual guide.", pro: "de tuur jas a bai-lin-gual gaid" },
                    { es: "Podemos organizar traslados privados.", en: "We can arrange private transfers.", pro: "gui can a-reinch prai-vat trans-fers" },
                    { es: "El vuelo directo dura cuatro horas.", en: "The direct flight takes four hours.", pro: "de di-rekt flait teiks for au-ars" },
                    { es: "Su tarjeta fue declinada, intente otra.", en: "Your card was declined, try another.", pro: "ior card guas di-claind, trai a-na-der" },
                    { es: "El depósito no es reembolsable.", en: "The deposit is non-refundable.", pro: "de di-po-sit is non ri-fan-da-bol" },
                    { es: "Recibirá la confirmación en cinco minutos.", en: "You will get the confirmation in five minutes.", pro: "iu guil guet de con-fer-mei-shon in faiv mi-nits" },
                    { es: "Su hotel queda frente a la playa.", en: "Your hotel is right in front of the beach.", pro: "ior jo-tel is rait in front of de biich" },
                    { es: "Podemos incluir renta de Jeep Cherokee.", en: "We can include a Jeep Cherokee rental.", pro: "gui can in-clud a yiip che-ro-kii ren-tal" },
                    { es: "Los impuestos ya están incluidos.", en: "Taxes are already included.", pro: "tak-ses ar ol-re-di in-cluu-ded" },
                    { es: "¡Prepárese para las mejores vacaciones!", en: "Get ready for the best vacation!", pro: "guet re-di for de best vei-kei-shon" }
                ],
                "Frases: Cerrajería": [
                    { es: "Me quedé por fuera de mi casa.", en: "I'm locked out of my house.", pro: "aim lokt aut of mai jaus" },
                    { es: "Perdí las llaves de mi carro.", en: "I lost my car keys.", pro: "ai lost mai car kiis" },
                    { es: "Necesito cambiar la cerradura.", en: "I need to change the lock.", pro: "ai niid tu cheinch de lok" },
                    { es: "¿Cuánto cuesta abrir una puerta?", en: "How much to open a door?", pro: "jau mach tu ou-pen a door" },
                    { es: "La llave se rompió adentro.", en: "The key broke inside.", pro: "de kii brouk in-said" },
                    { es: "Necesito una copia de esta llave.", en: "I need a duplicate of this key.", pro: "ai niid a diu-pli-keit of dis kii" },
                    { es: "Esta cerradura está rota / trabada.", en: "This lock is broken / jammed.", pro: "dis lok is brou-ken / jamd" },
                    { es: "¿Puede venir de inmediato?", en: "Can you come right away?", pro: "can iu kam rait a-guei" },
                    { es: "Es una emergencia de cerrajería.", en: "It's a locksmith emergency.", pro: "its a lok-smiz i-mer-yen-si" },
                    { es: "Necesito instalar un cerrojo de seguridad.", en: "I need to install a deadbolt.", pro: "ai niid tu in-estol a ded-bolt" },
                    { es: "La cerradura digital no tiene batería.", en: "The smart lock is out of battery.", pro: "de es-mart lok is aut of ba-te-ri" },
                    { es: "Tengo que reconfigurar los pines.", en: "I need to rekey the lock.", pro: "ai niid tu rii-kii de lok" },
                    { es: "Muéstrame una prueba de propiedad.", en: "Show me proof of ownership.", pro: "shou mi pruuf of ou-ner-ship" },
                    { es: "Necesito abrir este candado.", en: "I need to open this padlock.", pro: "ai niid tu ou-pen dis pad-lok" },
                    { es: "La llave no gira.", en: "The key doesn't turn.", pro: "de kii da-sent tern" },
                    { es: "Voy en camino, llego en veinte minutos.", en: "I'm on my way, I'll be there in twenty minutes.", pro: "aim on mai uei, ail bi der in tuen-ti mi-nits" },
                    { es: "El trabajo está garantizado.", en: "The work is guaranteed.", pro: "de uerk is ga-ran-tiid" },
                    { es: "Aceptamos efectivo y tarjeta.", en: "We accept cash and card.", pro: "gui ak-sept kash and card" },
                    { es: "Aquí tiene su recibo.", en: "Here is your receipt.", pro: "jiar is ior re-siit" },
                    { es: "Gracias por su servicio.", en: "Thank you for your service.", pro: "zenk iu for ior ser-vis" },
                    { es: "Necesito una ganzúa.", en: "I need a lock pick.", pro: "ai niid a lok pik" },
                    { es: "Esta es una llave de alta seguridad.", en: "This is a high-security key.", pro: "dis is a jai si-kiu-ri-ti kii" },
                    { es: "El cilindro está dañado.", en: "The cylinder is damaged.", pro: "de si-lin-der is da-micht" },
                    { es: "¿Tiene una llave de repuesto?", en: "Do you have a spare key?", pro: "du iu jaf a es-pear kii" },
                    { es: "El sistema de encendido está bloqueado.", en: "The ignition is locked.", pro: "di ig-ni-shon is lokt" },
                    { es: "Puedo programar llaves con chip.", en: "I can program transponder keys.", pro: "ai can prou-gram trans-pon-der kiis" },
                    { es: "El pestillo no entra bien.", en: "The latch doesn't click into place.", pro: "de lach da-sent clik in-tu pleis" },
                    { es: "Necesito reparar el marco de la puerta.", en: "I need to repair the door frame.", pro: "ai niid tu ri-pear de door freim" },
                    { es: "Esta llave es para un candado maestro.", en: "This key is for a master lock.", pro: "dis kii is for a mas-ter lok" },
                    { es: "El precio incluye la nueva cerradura.", en: "The price includes the new lock.", pro: "de prais in-cluds de niu lok" },
                    { es: "La puerta se abrió sin daños.", en: "The door opened without damage.", pro: "de door ou-pend gui-daut da-mish" },
                    { es: "Por favor, firme la orden de trabajo.", en: "Please sign the work order.", pro: "pliis sain de uerk or-der" },
                    { es: "¿Cuál es el año y modelo de su carro?", en: "What is the year and model of your car?", pro: "uat is de iar and mo-del of ior car" },
                    { es: "Se requiere identificación antes de abrir.", en: "ID is required before opening.", pro: "ai-dii is ri-kuai-ard bi-for ou-pe-nin" },
                    { es: "La chapa de la maleta está rota.", en: "The trunk lock is broken.", pro: "de trank lok is brou-ken" },
                    { es: "Tengo un kit de herramientas completo.", en: "I have a full tool kit.", pro: "ai jaf a ful tuul kit" },
                    { es: "Esa cerradura es muy antigua.", en: "That lock is very old.", pro: "dat lok is ve-ri ould" },
                    { es: "Le sugiero actualizar a una cerradura inteligente.", en: "I suggest upgrading to a smart lock.", pro: "ai sag-yest ap-grei-din tu a es-mart lok" },
                    { es: "El teclado digital no responde.", en: "The keypad is not responding.", pro: "de kii-pad is not ris-pon-din" },
                    { es: "Los tornillos están flojos.", en: "The screws are loose.", pro: "de escruus ar luus" },
                    { es: "Hay que lubricar el mecanismo.", en: "The mechanism needs lubrication.", pro: "de me-ka-nis-om niids lu-bri-kei-shon" },
                    { es: "La llave se quedó pegada.", en: "The key is stuck.", pro: "de kii is estac" },
                    { es: "Hice una llave desde cero.", en: "I made a key from scratch.", pro: "ai meid a kii rom escrach" },
                    { es: "La manija de la puerta está suelta.", en: "The door handle is loose.", pro: "de door jan-dol is luus" },
                    { es: "El cliente canceló el servicio.", en: "The customer canceled the service.", pro: "de cas-to-mer can-seld de ser-vis" },
                    { es: "La tarifa nocturna tiene un recargo.", en: "The night rate has an extra fee.", pro: "de nait reit jas an eks-tra fii" },
                    { es: "El perno está atascado.", en: "The bolt is jammed.", pro: "de boult is jamd" },
                    { es: "Ya quedó resuelto el problema.", en: "The problem is now solved.", pro: "de pro-blem is nau solvd" },
                    { es: "Pruebe la nueva llave usted mismo.", en: "Try the new key yourself.", pro: "trai de niu kii ior-self" },
                    { es: "Que tenga un día seguro.", en: "Have a safe day.", pro: "jaf a seif dei" }
                ],
                "Frases: Delivery & Instacart": [
                    { es: "Dejé el paquete en la puerta.", en: "I left the package at the door.", pro: "ai left de pa-kich at de door" },
                    { es: "Tu pedido está afuera.", en: "Your order is outside.", pro: "ior or-der is aut-said" },
                    { es: "Estoy buscando un reemplazo para este artículo.", en: "I'm looking for a replacement for this item.", pro: "aim lu-kin for a ri-pleis-ment for dis ai-tem" },
                    { es: "No tienen este producto, ¿quieres un reembolso?", en: "They don't have this product, do you want a refund?", pro: "dei dount jaf dis pro-dakt, du iu uant a ri-fand" },
                    { es: "Ya voy en camino a tu dirección.", en: "I'm on my way to your address.", pro: "aim on mai uei tu ior a-dres" },
                    { es: "Por favor, déjame una calificación de cinco estrellas.", en: "Please leave me a five-star rating.", pro: "pliis liiv mi a faiv es-tar rei-tin" },
                    { es: "Necesito tu firma para entregar esto.", en: "I need your signature to deliver this.", pro: "ai niid ior sig-na-chur tu di-li-ver dis" },
                    { es: "Por favor, escanea tu identificación.", en: "Please scan your ID.", pro: "pliis es-kan ior ai-dii" },
                    { es: "El supermercado está muy lleno hoy.", en: "The grocery store is very crowded today.", pro: "de grou-se-ri estoor is ve-ri crau-ded tu-dei" },
                    { es: "Ya terminé de comprar, voy a pagar.", en: "I'm done shopping, I'm checking out now.", pro: "aim dan sho-pin, aim che-kin aut nau" },
                    { es: "¿Puedes darme el código de acceso al edificio?", en: "Can you give me the building access code?", pro: "can iu guiv mi de bil-din ak-ses coud" },
                    { es: "Dejé las bolsas en el lobby.", en: "I left the bags in the lobby.", pro: "ai left de bags in de lo-bi" },
                    { es: "El cliente canceló la orden.", en: "The customer canceled the order.", pro: "de cas-to-mer can-seld di or-der" },
                    { es: "Por favor, prende la luz de afuera.", en: "Please turn on the outside light.", pro: "pliis tern on di aut-said lait" },
                    { es: "Hay un perro suelto afuera, ten cuidado.", en: "There is a dog loose outside, be careful.", pro: "der is a dog luus aut-said, bi ker-ful" },
                    { es: "Tu pedido contiene bebidas alcohólicas.", en: "Your order contains alcoholic beverages.", pro: "ior or-der con-teins al-co-jo-lik be-vre-yis" },
                    { es: "Disculpa la demora, el tráfico está pesado.", en: "Sorry for the delay, traffic is heavy.", pro: "so-ri for de di-lei, tra-fik is je-vi" },
                    { es: "Gracias por la propina.", en: "Thank you for the tip.", pro: "zenk iu for de tip" },
                    { es: "¡Que disfrutes tu comida!", en: "Enjoy your food!", pro: "in-joi ior fuud" },
                    { es: "Tu repartidor de confianza.", en: "Your trusted delivery driver.", pro: "ior tras-ted di-li-ve-ri drai-ver" },
                    { es: "Necesito un código de confirmación.", en: "I need a confirmation code.", pro: "ai niid a con-fer-mei-shon coud" },
                    { es: "No encuentro el número de apartamento.", en: "I can't find the apartment number.", pro: "ai kant faind de a-part-ment nam-ber" },
                    { es: "Dejé las cosas en la entrada para autos.", en: "I left the items in the driveway.", pro: "ai left di ai-tems in de draiv-uei" },
                    { es: "El cliente no responde las llamadas.", en: "The customer is not answering calls.", pro: "de cas-to-mer is not an-ser-in cols" },
                    { es: "Voy a tener que devolver los artículos.", en: "I will have to return the items.", pro: "ai guil jaf tu ri-tern di ai-tems" },
                    { es: "¿Me puedes abrir la reja, por favor?", en: "Can you open the gate for me, please?", pro: "can iu ou-pen de gueit for mi pliiz" },
                    { es: "El pedido está empacado en cajas.", en: "The order is packed in boxes.", pro: "di or-der is pakt in bok-ses" },
                    { es: "Esta es una entrega sin contacto.", en: "This is a contactless delivery.", pro: "dis is a con-tact-les di-li-ve-ri" },
                    { es: "Tomé una foto como prueba de entrega.", en: "I took a photo as proof of delivery.", pro: "ai tuk a fou-tou as pruuf of di-li-ve-ri" },
                    { es: "Tus productos congelados están en bolsas térmicas.", en: "Your frozen items are in thermal bags.", pro: "ior frou-sen ai-tems ar in zer-mal bags" },
                    { es: "Disculpa, este producto está agotado.", en: "Sorry, this item is out of stock.", pro: "so-ri, dis ai-tem is aut of estoc" },
                    { es: "¿Te sirve esta otra marca?", en: "Does this other brand work for you?", pro: "das dis o-der brand uerk for iu" },
                    { es: "El precio cambió un poco.", en: "The price changed a little bit.", pro: "de prais cheinchd a li-tol bit" },
                    { es: "Ya agregué el nuevo artículo al carrito.", en: "I already added the new item to the cart.", pro: "ai ol-re-di a-ded de niu ai-tem tu de cart" },
                    { es: "Estoy escaneando los códigos de barras.", en: "I'm scanning the barcodes.", pro: "aim es-ka-nin de bar-couds" },
                    { es: "Tu pedido está listo para ser entregado.", en: "Your order is ready to be delivered.", pro: "ior or-der is re-di tu bi di-li-verd" },
                    { es: "Estoy subiendo las escaleras.", en: "I'm walking up the stairs.", pro: "aim uo-kin ap de es-te-ars" },
                    { es: "Usa el ascensor si está disponible.", en: "Use the elevator if available.", pro: "iuus di e-le-vei-tor if a-vei-la-bol" },
                    { es: "Puse los huevos encima para que no se rompan.", en: "I put the eggs on top so they don't break.", pro: "ai put di egus on top sou dei dount breik" },
                    { es: "Las frutas y verduras están frescas.", en: "The fruits and vegetables are fresh.", pro: "de fruts and vech-ta-bols ar fresh" },
                    { es: "Tengo un pedido doble hoy.", en: "I have a double order today.", pro: "ai jaf a da-bol or-der tu-dei" },
                    { es: "Soporte de la aplicación está resolviendo el lío.", en: "App support is solving the issue.", pro: "ap sa-port is sol-vin di i-shuu" },
                    { es: "El cliente dejó una buena propina en efectivo.", en: "The customer left a good cash tip.", pro: "de cas-to-mer left a gud kash tip" },
                    { es: "Completa la entrega en la aplicación.", en: "Complete the delivery in the app.", pro: "com-pliit de di-li-ve-ri in di ap" },
                    { es: "Tu cuenta ha sido actualizada.", en: "Your account has been updated.", pro: "ior a-caunt jas biin ap-dei-ted" },
                    { es: "Revisa las instrucciones de entrega.", en: "Check the delivery instructions.", pro: "chek de di-li-ve-ri in-strak-shons" },
                    { es: "El cliente quiere que toque el timbre.", en: "The customer wants me to ring the doorbell.", pro: "de cas-to-mer uants mi tu rin de door-bel" },
                    { es: "No hagas ruido, el bebé está durmiendo.", en: "Don't make noise, the baby is sleeping.", pro: "dount meik nois, de bei-bi is es-lii-pin" },
                    { es: "¡Muchas gracias por elegirnos hoy!", en: "Thank you so much for choosing us today!", pro: "zenk iu sou mach for chu-sin as tu-dei" },
                    { es: "Que tengas una excelente noche.", en: "Have an excellent night.", pro: "jaf an ek-se-lent nait" }
                ],
                "Frases: Publicidad & Ventas": [
                    { es: "Esta es una oferta por tiempo limitado.", en: "This is a limited-time offer.", pro: "dis is a li-mi-ted taim o-fer" },
                    { es: "Compra uno y llévate el segundo gratis.", en: "Buy one, get one free.", pro: "bai uan, guet uan frii" },
                    { es: "Tenemos el mejor precio del mercado.", en: "We have the best price on the market.", pro: "gui jaf de best prais on de mar-ket" },
                    { es: "Garantía de devolución de dinero.", en: "Money-back guarantee.", pro: "ma-ni bak ga-ran-tii" },
                    { es: "Prueba nuestro servicio sin compromiso.", en: "Try our service with no obligation.", pro: "trai au-ar ser-vis guiz nou ob-li-guei-shon" },
                    { es: "Nuestros clientes nos recomiendan.", en: "Our customers recommend us.", pro: "au-ar cas-to-mers re-co-miend as" },
                    { es: "Aumenta tus ventas de inmediato.", en: "Increase your sales right away.", pro: "in-criis ior seils rait a-guei" },
                    { es: "Esta es la solución que estabas buscando.", en: "This is the solution you were looking for.", pro: "dis is de so-luu-shon iu guer lu-kin for" },
                    { es: "Haz clic aquí para más información.", en: "Click here for more information.", pro: "clik jiar for mor in-for-mei-shon" },
                    { es: "Cupón de descuento exclusivo hoy.", en: "Exclusive discount coupon today.", pro: "eks-cluu-siv dis-kaunt kuu-pon tu-dei" },
                    { es: "No dejes pasar esta oportunidad.", en: "Don't miss this opportunity.", pro: "dount mis dis o-por-tuu-ni-di" },
                    { es: "Tu negocio necesita esta estrategia.", en: "Your business needs this strategy.", pro: "ior bis-nes niids dis es-tra-te-yi" },
                    { es: "Nuestros productos son de alta calidad.", en: "Our products are high quality.", pro: "au-ar pro-dakts ar jai cua-li-ti" },
                    { es: "Tenemos testimonios de éxito reales.", en: "We have real success stories.", pro: "gui jaf rial sak-ses es-to-ris" },
                    { es: "El envío es completamente gratis.", en: "Shipping is completely free.", pro: "shi-pin is com-pliit-li frii" },
                    { es: "¿Quieres duplicar tus ingresos?", en: "Do you want to double your income?", pro: "du iu uant tu da-bol ior in-kam" },
                    { es: "Suscríbete a nuestro boletín mensual.", en: "Subscribe to our monthly newsletter.", pro: "sab-scraib tu au-ar manz-li nius-le-ter" },
                    { es: "El inventario se está agotando rápido.", en: "Stock is running out fast.", pro: "estoc is ra-nin aut fast" },
                    { es: "Obtén una asesoría gratuita hoy mismo.", en: "Get a free consultation today.", pro: "guet a frii con-sal-tei-shon tu-dei" },
                    { es: "¡Lleva tu marca al siguiente nivel!", en: "Take your brand to the next level!", pro: "teik ior brand tu de nekst le-vol" },
                    { es: "Este plan se adapta a tu presupuesto.", en: "This plan fits your budget.", pro: "dis plan fits ior ba-jet" },
                    { es: "Nuestra campaña publicitaria fue un éxito.", en: "Our ad campaign was a success.", pro: "au-ar ad cam-pein guas a sak-ses" },
                    { es: "Necesitamos atraer más clientes potenciales.", en: "We need to attract more leads.", pro: "gui niid tu a-trakt mor liids" },
                    { es: "El marketing digital lo cambia todo.", en: "Digital marketing changes everything.", pro: "di-yi-tal mar-ke-tin chein-jis ev-ri-zin" },
                    { es: "Revisa las estadísticas de conversión.", en: "Check the conversion rates.", pro: "chek de con-ver-shon reits" },
                    { es: "Tenemos un descuento especial para clientes nuevos.", en: "We have a special discount for new customers.", pro: "gui jaf a es-pe-shal dis-kaunt for niu cas-to-mers" },
                    { es: "Cierra el trato hoy y ahorra un veinte por ciento.", en: "Close the deal today and save twenty percent.", pro: "clous de diil tu-dei and seiv tuen-ti per-sent" },
                    { es: "Nuestra marca es reconocida a nivel mundial.", en: "Our brand is globally recognized.", pro: "au-ar brand is glou-ba-li re-coog-naisd" },
                    { es: "Haz una inversión segura para tu futuro.", en: "Make a safe investment for your future.", pro: "meik a seif in-vest-ment for ior fiu-chur" },
                    { es: "El soporte técnico está disponible veinticuatro siete.", en: "Technical support is available twenty-four seven.", pro: "tek-ni-kol sa-port is a-vei-la-bol tuen-ti for se-ven" },
                    { es: "Esta oferta expira a la medianoche.", en: "This offer expires at midnight.", pro: "dis o-fer eks-pai-ars at mid-nait" },
                    { es: "No compres imitaciones baratas.", en: "Don't buy cheap imitations.", pro: "dount bai chiip i-mi-tei-shons" },
                    { es: "Nuestra prioridad es tu satisfacción.", en: "Our priority is your satisfaction.", pro: "au-ar praio-ri-ti is ior sa-tis-fak-shon" },
                    { es: "El producto viene con un manual de instrucciones.", en: "The product comes with an instruction manual.", pro: "de pro-dakt kams guiz an in-strak-shon ma-nual" },
                    { es: "Puedes pagar con cualquier método de pago.", en: "You can pay with any payment method.", pro: "iu can pei guiz e-ni pei-ment me-zod" },
                    { es: "Tu compra está protegida por encriptación.", en: "Your purchase is protected by encryption.", pro: "ior per-chas is pro-tek-ted bai en-crip-shon" },
                    { es: "Somos líderes en innovación tecnológica.", en: "We are leaders in technological innovation.", pro: "gui ar lii-ders in tek-no-lo-yi-kol in-nou-vei-shon" },
                    { es: "Agenda una demostración en vivo ahora.", en: "Schedule a live demo now.", pro: "es-ke-diuul a laiv de-mou nau" },
                    { es: "El valor real es mucho mayor que el precio.", en: "The real value is much higher than the price.", pro: "de rial va-liu is mach jai-er dan de prais" },
                    { es: "No dejes que tu competencia te gane.", en: "Don't let your competition beat you.", pro: "dount let ior com-pe-ti-shon biit iu" },
                    { es: "Nuestros servicios están garantizados bajo contrato.", en: "Our services are guaranteed under contract.", pro: "au-ar ser-vi-ses ar ga-ran-tiid an-der con-trato" },
                    { es: "Consigue más seguidores en tus redes sociales.", en: "Get more followers on your social media.", pro: "guet mor fo-lou-ers on ior sou-shal mii-dia" },
                    { es: "Optimiza tu sitio web para motores de búsqueda.", en: "Optimize your website for search engines.", pro: "op-ti-mais ior ueb-said for serch en-yins" },
                    { es: "Crea contenido de alto impacto visual.", en: "Create content with high visual impact.", pro: "creit con-te-nid guiz jai vi-shual im-pacto" },
                    { es: "La confianza es la clave de toda venta.", en: "Trust is the key to every sale.", pro: "trast is de kii tu ev-ri seil" },
                    { es: "Tenemos oficinas en las principales ciudades.", en: "We have offices in the main cities.", pro: "gui jaf o-fi-ses in de mein si-tis" },
                    { es: "Tu opinión es muy valiosa para nosotros.", en: "Your opinion is very valuable to us.", pro: "ior o-pi-nion is ve-ri va-liu-a-bol tu as" },
                    { es: "¡Únete a miles de usuarios satisfechos!", en: "Join thousands of satisfied users!", pro: "ioin zau-sands of sa-tis-faid iu-su-ars" },
                    { es: "La oferta se activará automáticamente.", en: "The offer will be activated automatically.", pro: "di o-fer guil bi ak-ti-vei-ted o-to-ma-ti-cal-i" },
                    { es: "Gracias por confiar en nuestro equipo.", en: "Thank you for trusting our team.", pro: "zenk iu for tras-tin au-ar tiim" }
                ],
                "Frases: Royal Prestige": [
                    { es: "Este sistema de cocina cuida la salud de tu familia.", en: "This cooking system takes care of your family's health.", pro: "dis cu-kin sis-tem teiks ker of ior fa-mi-lis jelz" },
                    { es: "Puedes cocinar sin usar aceite ni agua.", en: "You can cook without using oil or water.", pro: "iu can cuk gui-daut iu-sin oil or ua-ter" },
                    { es: "El acero quirúrgico no contamina la comida.", en: "Surgical stainless steel does not contaminate food.", pro: "ser-yi-kol stein-les stil das not con-ta-mi-neit fuud" },
                    { es: "Tiene una garantía de cincuenta años.", en: "It has a fifty-year warranty.", pro: "it jas a fif-ti iar gua-ran-tii" },
                    { es: "Te ofrezco una demostración de cocina gratis en tu casa.", en: "I offer you a free cooking demo at your house.", pro: "ai o-fer iu a frii cu-kin de-mou at ior jaus" },
                    { es: "Las ollas distribuyen el calor de manera uniforme.", en: "The pots distribute heat evenly.", pro: "de pots dis-tri-biuut jiit ii-ven-li" },
                    { es: "La comida mantiene todos sus nutrientes y sabores.", en: "The food retains all its nutrients and flavors.", pro: "de fuud ri-teins ol its niu-trients and flei-vors" },
                    { es: "Tenemos planes de financiamiento muy cómodos.", en: "We have very comfortable financing plans.", pro: "gui jaf ve-ri kam-for-ta-bol fai-nan-sin plans" },
                    { es: "¿Prefieres pagar con tarjeta o en cuotas mensuales?", en: "Do you prefer to pay by card or in monthly installments?", pro: "du iu pri-fer tu pei bai card or in manz-li in-stol-ments" },
                    { es: "La válvula inteligente te avisa cuando está listo.", en: "The smart valve alerts you when it's ready.", pro: "de es-mart valv a-lerts iu guen its re-di" },
                    { es: "Esta es una inversión de por vida para tu cocina.", en: "This is a lifetime investment for your kitchen.", pro: "dis is a laif-taim in-vest-ment for ior kit-chen" },
                    { es: "El juego de cuchillos es de alta resistencia.", en: "The knife set is high resistance.", pro: "de naif set is jai ri-sis-tans" },
                    { es: "El extractor de jugos aprovecha toda la fruta.", en: "The juicer gets the most out of the fruit.", pro: "de juu-ser guets de moust aut of de frut" },
                    { es: "No necesitas usar fuego alto para cocinar.", en: "You don't need to use high heat to cook.", pro: "iu dount niid tu iuus jai jiit tu cuk" },
                    { es: "Las tapas sellan al vacío perfectamente.", en: "The lids vacuum seal perfectly.", pro: "de lids va-kium siil per-fekt-li" },
                    { es: "Es muy fácil de limpiar y no se ralla.", en: "It's very easy to clean and doesn't scratch.", pro: "its ve-ri ii-si tu kliin and da-sent escrach" },
                    { es: "Este material evita la acumulación de bacterias.", en: "This material prevents bacteria buildup.", pro: "dis ma-ti-rial pri-vents bak-tii-ria bil-dap" },
                    { es: "El sartén eléctrico es digital y programable.", en: "The electric skillet is digital and programmable.", pro: "di i-lek-trik es-ki-let is di-yi-tal and prou-gra-ma-bol" },
                    { es: "Tu compra incluye un recetario exclusivo.", en: "Your purchase includes an exclusive recipe book.", pro: "ior per-chas in-cluds an eks-cluu-siv re-si-pi buk" },
                    { es: "Felicidades por elegir la máxima calidad.", en: "Congratulations on choosing the highest quality.", pro: "con-gra-tu-lei-shons on chu-sin de jai-est cua-li-ti" },
                    { es: "El sistema de filtración de agua purifica al instante.", en: "The water filtration system purifies instantly.", pro: "de ua-ter fil-trei-shon sis-tem piu-ri-fais in-stant-li" },
                    { es: "Puedes cocinar carnes congeladas directamente.", en: "You can cook frozen meats directly.", pro: "iu can cuk frou-sen miits di-rekt-li" },
                    { es: "Ahorras gas y energía gracias al diseño térmico.", en: "You save gas and energy thanks to the thermal design.", pro: "iu seiv gas and e-ner-yi zenks tu de zer-mal di-sain" },
                    { es: "La demostración toma solo cuarenta y cinco minutos.", en: "The demo takes only forty-five minutes.", pro: "de de-mou teiks oun-li for-ti faiv mi-nits" },
                    { es: "Voy a preparar una receta deliciosa para ti.", en: "I'm going to prepare a delicious recipe for you.", pro: "aim gou-in tu pri-pear a di-li-shos re-si-pi for iu" },
                    { es: "La aprobación del crédito es inmediata.", en: "Credit approval is immediate.", pro: "cre-dit a-pruu-val is i-mii-diat" },
                    { es: "No requiere un pago inicial alto.", en: "It doesn't require a high down payment.", pro: "it da-sent ri-kuai-ar a jai daun pei-ment" },
                    { es: "Las asas de las ollas no se calientan.", en: "The pot handles do not get hot.", pro: "de pot jan-dols du not guet jot" },
                    { es: "Puedes hornear un pastel sobre la estufa.", en: "You can bake a cake on the stove.", pro: "iu can beik a keik on de estouf" },
                    { es: "El acero quirúrgico mantiene el brillo original.", en: "Surgical steel maintains its original shine.", pro: "ser-yi-kol stiil mein-teins its o-ri-yi-nal shain" },
                    { es: "Esta marca tiene más de cincuenta años en el mercado.", en: "This brand has over fifty years on the market.", pro: "dis brand jas ou-ver fif-ti iars on de mar-ket" },
                    { es: "Te dejaré mi tarjeta de presentación.", en: "I'll leave you my business card.", pro: "ail liiv iu mai bis-nes card" },
                    { es: "Si me recomiendas con tres amigos, te doy un regalo.", en: "If you recommend me to three friends, I'll give you a gift.", pro: "if iu re-co-miendas mi tu zrii frends, ail guiv iu a guift" },
                    { es: "El mantenimiento de las piezas es mínimo.", en: "Maintenance of the pieces is minimal.", pro: "mein-te-nans of de pii-ses is mi-ni-mal" },
                    { es: "Es resistente a golpes y altas temperaturas.", en: "It is resistant to impacts and high temperatures.", pro: "it is ri-sis-tant tu im-pakt-es and jai tem-pre-churs" },
                    { es: "La base de cinco capas distribuye el calor.", en: "The five-ply base distributes the heat.", pro: "de faiv-plai beis dis-tri-biuuts de jiit" },
                    { es: "Nuestros productos tienen certificación internacional.", en: "Our products have international certification.", pro: "au-ar pro-dakts jaf in-ter-na-sho-nal cer-ti-fi-kei-shon" },
                    { es: "La entrega a domicilio tarda tres días laborables.", en: "Home delivery takes three business days.", pro: "joum di-li-ve-ri teiks zrii bis-nes deits" },
                    { es: "¿A qué hora te queda bien recibirme mañana?", en: "What time works best for me to visit tomorrow?", pro: "uat taim uerks best for mi tu vi-sit tu-ma-rou" },
                    { es: "Tu salud no tiene precio, invierte en lo mejor.", en: "Your health is priceless, invest in the best.", pro: "ior jelz is prais-les, in-vert in de best" },
                    { es: "El juego de cubiertos de lujo está incluido en este paquete.", en: "The luxury silverware set is included in this package.", pro: "de lak-shu-ri sil-ver-guer set is in-cluu-ded in dis pa-kich" },
                    { es: "Puedes cancelar tu saldo antes sin penalización.", en: "You can pay off your balance early without penalty.", pro: "iu can pei of ior ba-lans er-li gui-daut pe-nal-ti" },
                    { es: "El diseño elegante combina con cualquier cocina.", en: "The elegant design matches any kitchen.", pro: "di e-le-gant di-sain mach-es e-ni kit-chen" },
                    { es: "Te enseñaré cómo usar la válvula Redi-Temp.", en: "I will show you how to use the Redi-Temp valve.", pro: "ai guil shou iu jau tu iuus de re-di-temp valv" },
                    { es: "No desprende sustancias tóxicas al cocinar.", en: "It does not release toxic substances when cooking.", pro: "it das not ri-liis tok-sik sab-stan-ses guen cu-kin" },
                    { es: "La comida no se pega si controlas la temperatura.", en: "Food won't stick if you control the temperature.", pro: "fuud guont estic if iu con-troul de tem-pre-chur" },
                    { es: "Puedes hacer pizzas sin usar horno.", en: "You can make pizzas without using an oven.", pro: "iu can meik piit-sas gui-daut iu-sin an o-ven" },
                    { es: "Soy tu asesor autorizado de la marca.", en: "I am your authorized brand advisor.", pro: "ai am ior o-to-raisd brand ad-vai-sor" },
                    { es: "Cualquier duda que tengas, puedes llamarme directamente.", en: "Any questions you have, you can call me directly.", pro: "e-ni kues-shons iu jaf, iu can col mi di-rekt-li" },
                    { es: "Gracias por abrirme las puertas de tu hogar.", en: "Thank you for opening the doors of your home.", pro: "zenk iu for ou-pe-nin de doors of ior joum" }
                ],
                "Frases: Tienda de Ropa": [
                    { es: "¿Puedo medirme esto?", en: "Can I try this on?", pro: "can ai trai dis on" },
                    { es: "¿Dónde están los probadores?", en: "Where are the fitting rooms?", pro: "guer ar de fi-tin ruums" },
                    { es: "Busco esto en una talla más grande.", en: "I'm looking for this in a larger size.", pro: "aim lu-kin for dis in a lar-yer sais" },
                    { es: "Busco esto en una talla más pequeña.", en: "I'm looking for this in a smaller size.", pro: "aim lu-kin for dis in a es-mo-ler sais" },
                    { es: "¿Tienes esta camisa en otro color?", en: "Do you have this shirt in another color?", pro: "du iu jaf dis shert in a-na-der co-lor" },
                    { es: "Me queda muy apretado.", en: "It's too tight for me.", pro: "its tuu tait for mi" },
                    { es: "Me queda muy suelto / flojo.", en: "It's too loose for me.", pro: "its tuu luus for mi" },
                    { es: "Este pantalón me queda perfecto.", en: "These pants fit me perfectly.", pro: "ziis pants fit mi per-fekt-li" },
                    { es: "¿Está esto en descuento?", en: "Is this on sale?", pro: "is dis on seil" },
                    { es: "Quiero devolver esta chaqueta.", en: "I want to return this jacket.", pro: "ai uant tu ri-tern dis ja-ket" },
                    { es: "Solo estoy mirando, gracias.", en: "I'm just looking, thank you.", pro: "aim jast lu-kin zenk iu" },
                    { es: "¿Dónde pago?", en: "Where do I pay?", pro: "guer du ai pei" },
                    { es: "¿Aceptan devoluciones sin recibo?", en: "Do you accept returns without a receipt?", pro: "du iu ak-sept ri-terns gui-daut a re-siit" },
                    { es: "La tela es de muy buena calidad.", en: "The fabric is very high quality.", pro: "de fa-brik is ve-ri jai cua-li-ti" },
                    { es: "El maniquí tiene el conjunto que busco.", en: "The mannequin has the outfit I'm looking for.", pro: "de ma-ne-kin jas di aut-fit aim lu-kin for" },
                    { es: "Necesito un cinturón que combine.", en: "I need a belt that matches.", pro: "ai niid a belt dat mach-es" },
                    { es: "Los zapatos están en liquidación.", en: "The shoes are on clearance.", pro: "de shuus ar on cliar-ans" },
                    { es: "¿Tienen chaquetas impermeables?", en: "Do you have waterproof jackets?", pro: "du iu jaf ua-ter-pruuf ja-kets" },
                    { es: "Quiero cambiar esto por otra talla.", en: "I want to exchange this for another size.", pro: "ai uant tu eks-cheinch dis for a-na-der sais" },
                    { es: "Gracias por tu ayuda, me llevo esto.", en: "Thanks for your help, I'll take this.", pro: "zenks for ior jelp, ail teik dis" },
                    { es: "La caja registradora está al fondo.", en: "The checkout counter is in the back.", pro: "de chek-aut caun-ter is in de bak" },
                    { es: "¿Tiene una sección de liquidación?", en: "Do you have a clearance section?", pro: "du iu jaf a cliar-ans sek-shon" },
                    { es: "Este color no me favorece.", en: "This color doesn't look good on me.", pro: "dis co-lor da-sent luk gud on mi" },
                    { es: "El material se siente muy suave.", en: "The material feels very soft.", pro: "de ma-tii-rial fiils ve-ri soft" },
                    { es: "Se encogió en la lavadora.", en: "It shrank in the washing machine.", pro: "it shrank in de ua-shin ma-shiin" },
                    { es: "Estas mangas están muy largas.", en: "These sleeves are too long.", pro: "ziis es-liivs ar tuu long" },
                    { es: "¿Dónde puedo encontrar vestidos formales?", en: "Where can I find formal dresses?", pro: "guer can ai faind for-mal dre-ses" },
                    { es: "El descuento se aplica en la caja.", en: "The discount is applied at the register.", pro: "de dis-kaunt is a-plaid at de re-yis-ter" },
                    { es: "Esta prenda requiere lavado en seco.", en: "This garment requires dry cleaning.", pro: "dis gar-ment ri-kuai-ars drai clii-nin" },
                    { es: "El cierre / la cremallera está rota.", en: "The zipper is broken.", pro: "de si-per is brou-ken" },
                    { es: "Le falta un botón a esta camisa.", en: "This shirt is missing a button.", pro: "dis shert is mi-sin a ba-ton" },
                    { es: "¿Tienen sombreros o gorras?", en: "Do you have hats or caps?", pro: "du iu jaf jats or kaps" },
                    { es: "Los jeans están en el segundo pasillo.", en: "The jeans are in the second aisle.", pro: "de yiins ar in de se-kond ail" },
                    { es: "Esta falda está de moda.", en: "This skirt is in style.", pro: "dis es-kert is in estail" },
                    { es: "La ropa de invierno tiene descuento.", en: "Winter clothing is discounted.", pro: "guin-ter clou-zin is dis-kaun-ted" },
                    { es: "No encuentro ropa de mi talla.", en: "I can't find clothes in my size.", pro: "ai kant faind clous in mai sais" },
                    { es: "¿Tienen espejos de cuerpo entero?", en: "Do you have full-length mirrors?", pro: "du iu jaf ful lenz mi-rors" },
                    { es: "Este abrigo me cubre bien del frío.", en: "This coat protects me well from the cold.", pro: "dis cout pro-tekts mi guel rom de could" },
                    { es: "Me gustaría comprar un suéter ligero.", en: "I would like to buy a light sweater.", pro: "ai guuld laik tu bai a lait sue-ter" },
                    { es: "La tienda cierra en diez minutos.", en: "The store closes in ten minutes.", pro: "de es-toor clou-ses in ten mi-nits" },
                    { es: "Tenemos calcetines en oferta hoy.", en: "We have socks on sale today.", pro: "gui jaf soks on seil tu-dei" },
                    { es: "La sección de ropa interior está a la derecha.", en: "The underwear section is to the right.", pro: "di an-der-guer sek-shon is tu de rait" },
                    { es: "Esa sudadera tiene capucha.", en: "That sweatshirt has a hoodie.", pro: "dat suet-shert jas a ju-dii" },
                    { es: "¿Ofrecen envoltura para regalo?", en: "Do you offer gift wrapping?", pro: "du iu o-fer guift ra-pin" },
                    { es: "El precio final incluye los impuestos.", en: "The final price includes taxes.", pro: "de fai-nal prais in-cluds tak-ses" },
                    { es: "Este traje necesita ajustes.", en: "This suit needs alterations.", pro: "dis suut niids ol-te-rei-shons" },
                    { es: "El estilo es muy moderno.", en: "The style is very modern.", pro: "de es-tail is ve-ri mo-dern" },
                    { es: "No me gusta el diseño de este estampado.", en: "I don't like the pattern of this print.", pro: "ai dount laik de pa-tern of dis print" },
                    { es: "Paga aquí para evitar la fila.", en: "Pay here to avoid the line.", pro: "pei jiar tu a-void de lain" },
                    { es: "¡Disfruta tus nuevas prendas!", en: "Enjoy your new clothes!", pro: "in-joi ior niu clous" }
                ],
                "Frases: Transportes y Viajes": [
                    { es: "¿A qué hora sale el próximo autobús?", en: "What time does the next bus leave?", pro: "uat taim das de nekst bas liiv" },
                    { es: "Necesito comprar un boleto de ida y vuelta.", en: "I need to buy a round-trip ticket.", pro: "ai niid tu bai a raund trip ti-ket" },
                    { es: "¿Dónde se toma el taxi?", en: "Where do I catch a taxi?", pro: "guer du ai kach a tak-si" },
                    { es: "Por favor, lléveme a esta dirección.", en: "Please take me to this address.", pro: "pliis teik mi tu dis a-dres" },
                    { es: "¿Cuánto dura el viaje en tren?", en: "How long is the train ride?", pro: "jau long is de trein raid" },
                    { es: "El vuelo tiene un retraso de dos horas.", en: "The flight has a two-hour delay.", pro: "de flait jas a tuu au-ar di-lei" },
                    { es: "¿Dónde puedo recoger mi equipaje?", en: "Where can I pick up my luggage?", pro: "guer can ai pik ap mai la-guich" },
                    { es: "Perdí mi pase de abordar.", en: "I lost my boarding pass.", pro: "ai lost mai boor-din pas" },
                    { es: "¿Hay una estación de metro cerca?", en: "Is there a subway station nearby?", pro: "is der a sab-guei estei-shon niar-bai" },
                    { es: "Tengo que rentar un carro por una semana.", en: "I need to rent a car for a week.", pro: "ai niid tu rent a car for a guiik" },
                    { es: "El tanque de gasolina está lleno.", en: "The gas tank is full.", pro: "de gas tank is ful" },
                    { es: "Siga directo y luego doble a la izquierda.", en: "Go straight and then turn left.", pro: "gou estreit and zen tern left" },
                    { es: "La autopista tiene mucho tráfico ahora.", en: "The highway has a lot of traffic now.", pro: "de jai-uei jas a lot of tra-fik nau" },
                    { es: "¿Cuánto es la tarifa del peaje?", en: "How much is the toll fee?", pro: "jau mach is de tol fii" },
                    { es: "Tengo mi reserva de hotel lista.", en: "I have my hotel reservation ready.", pro: "ai jaf mai jo-tel re-ser-vei-shon re-di" },
                    { es: "El Uber llegará en tres minutos.", en: "The Uber will arrive in three minutes.", pro: "di uu-ber guil a-raiv in zrii mi-nits" },
                    { es: "Por favor, ponga mis maletas en el baúl.", en: "Please put my bags in the trunk.", pro: "pliis put mai bags in de trank" },
                    { es: "Mi vuelo sale de la terminal dos.", en: "My flight departs from terminal two.", pro: "mai flait di-parts rom ter-mi-nal tuu" },
                    { es: "¿Me puede dar un mapa de la ciudad?", en: "Can you give me a city map?", pro: "can iu guiv mi a si-ti map" },
                    { es: "¡Buen viaje a todos!", en: "Have a safe trip everyone!", pro: "jaf a seif trip ev-ri-uan" },
                    { es: "La puerta de embarque cambió a última hora.", en: "The boarding gate changed at the last minute.", pro: "de boor-din gueit cheinchd at de last mi-nit" },
                    { es: "El tren exprés es más rápido que el autobús.", en: "The express train is faster than the bus.", pro: "di eks-pres trein is fas-ter dan de bas" },
                    { es: "Necesito verificar el horario de vuelos.", en: "I need to check the flight schedule.", pro: "ai niid tu chek de flait es-ke-diuul" },
                    { es: "Mi asiento está en la fila quince.", en: "My seat is in row fifteen.", pro: "mai siit is in rou fif-tiin" },
                    { es: "Ponga los artículos pesados abajo.", en: "Put the heavy items on the bottom.", pro: "put de je-vi ai-tems on de bo-tom" },
                    { es: "¿Dónde se encuentra la parada de autobús oficial?", en: "Where is the official bus stop located?", pro: "guer is di o-fi-shal bas estop lou-kei-ted" },
                    { es: "El conductor del autobús fue muy amable.", en: "The bus driver was very kind.", pro: "de bas drai-ver guas ve-ri kaind" },
                    { es: "La aplicación muestra la ruta más corta.", en: "The app shows the shortest route.", pro: "di ap shous de shor-test ruut" },
                    { es: "Tenemos que pasar por la zona de aduanas.", en: "We have to go through customs.", pro: "gui jaf tu gou zruu cas-toms" },
                    { es: "Tome la salida veinticuatro de la autopista.", en: "Take exit twenty-four from the highway.", pro: "teik ek-sit tuen-ti for rom de jai-uei" },
                    { es: "El viaje por carretera fue largo pero divertido.", en: "The road trip was long but fun.", pro: "de roud trip guas long bat fan" },
                    { es: "No olvide abrochar su cinturón de seguridad.", en: "Don't forget to fasten your seatbelt.", pro: "dount for-guet tu fas-sen ior siit-belt" },
                    { es: "El crucero se detendrá en tres islas.", en: "The cruise will stop at three islands.", pro: "de cruus guil estop at zrii ai-lands" },
                    { es: "Quiero cancelar mi pasaje por emergencia.", en: "I want to cancel my ticket due to an emergency.", pro: "ai uant tu can-sel mai ti-ket diuu tu an i-mer-yen-si" },
                    { es: "El check-in se puede hacer en línea.", en: "Check-in can be done online.", pro: "chek-in can bi dan on-lain" },
                    { es: "La aerolínea perdió mi equipaje documentado.", en: "The airline lost my checked baggage.", pro: "di er-lain lost mai chekt ba-guich" },
                    { es: "Estamos cruzando la frontera del estado.", en: "We are crossing the state border.", pro: "gui ar cro-sin de esteit boor-der" },
                    { es: "El sistema GPS perdió la señal.", en: "The GPS system lost its signal.", pro: "de yii-pii-es sis-tem lost its sig-nal" },
                    { es: "El tren viaja a alta velocidad.", en: "The train travels at high speed.", pro: "de trein tra-vels at jai es-piid" },
                    { es: "Prefiero viajar ligero sin maletas grandes.", en: "I prefer traveling light without large bags.", pro: "ai pri-fer tra-ve-lin lait gui-daut larch bags" },
                    { es: "La tarifa de estacionamiento es por hora.", en: "The parking fee is per hour.", pro: "de par-kin fii is per au-ar" },
                    { es: "El hotel ofrece transporte gratuito al aeropuerto.", en: "The hotel offers free airport shuttle.", pro: "de jo-tel o-fers frii er-port sha-tol" },
                    { es: "Hay que validar el boleto antes de entrar.", en: "You must validate the ticket before entering.", pro: "iu mast va-li-deit de ti-ket bi-for en-trin" },
                    { es: "La tarjeta de transporte no tiene saldo.", en: "The transit card has no balance.", pro: "de trans-it card jas nou ba-lans" },
                    { es: "El conductor tomó un desvío por accidente.", en: "The driver took a detour by accident.", pro: "de drai-ver tuk a dii-tuur bai ak-si-dent" },
                    { es: "Mantenga sus pertenencias seguras en el viaje.", en: "Keep your belongings safe during the trip.", pro: "kiip ior bi-lon-gins seif diu-rin de trip" },
                    { es: "El avión aterrizó antes de tiempo.", en: "The plane landed early.", pro: "de plein lan-ded er-li" },
                    { es: "La tripulación de cabina fue muy atenta.", en: "The cabin crew was very attentive.", pro: "de ka-bin cruu guas ve-ri a-ten-tiv" },
                    { es: "Guarde el recibo del alquiler del auto.", en: "Keep the car rental receipt.", pro: "kiip de car ren-tal re-siit" },
                    { es: "¡Bienvenidos a su destino final!", en: "Welcome to your final destination!", pro: "guel-kam tu ior fai-nal des-ti-nei-shon" }
                ],
                "Frases: Venta de Chorizos": [
                    { es: "Tenemos chorizos artesanales listos.", en: "We have artisan chorizos ready.", pro: "gui jaf ar-ti-san cho-ri-sos re-di" },
                    { es: "¿Cuántos chorizos vas a llevar hoy?", en: "How many chorizos are you taking today?", pro: "jau me-ni cho-ri-sos ar iu tei-kin tu-dei" },
                    { es: "Están hechos con carne de cerdo seleccionada.", en: "They are made with selected pork meat.", pro: "dei ar meid guiz se-lek-ted pork miit" },
                    { es: "Nuestra receta es cien por ciento colombiana.", en: "Our recipe is one hundred percent Colombian.", pro: "au-ar re-se-pi is uan jan-dred per-sent co-lom-bian" },
                    { es: "Están empacados al vacío para mayor frescura.", en: "They are vacuum packed for maximum freshness.", pro: "dei ar va-kium pakt for mak-si-mom fresh-nes" },
                    { es: "¿Los quieres frescos o ya cocinados?", en: "Do you want them fresh or already cooked?", pro: "du iu uant zem fresh or ol-re-di cukt" },
                    { es: "El paquete de cinco unidades cuesta quince dólares.", en: "The five-pack costs fifteen dollars.", pro: "de faiv pak costs fif-tiin do-lars" },
                    { es: "No tienen conservantes químicos.", en: "They have no chemical preservatives.", pro: "dei jaf nou ke-mi-kol pre-ser-va-tivs" },
                    { es: "Quedan espectaculares a la parrilla o al sartén.", en: "They are amazing on the grill or in the skillet.", pro: "dei ar a-mei-zin on de gril or in de es-ki-let" },
                    { es: "Hacemos entregas a domicilio en Kissimmee.", en: "We deliver to your home in Kissimmee.", pro: "gui di-li-ver tu ior joum in ki-si-mii" },
                    { es: "Prueba un pedazo sin compromiso, te va a encantar.", en: "Try a piece with no obligation, you will love it.", pro: "trai a piis guiz nou ob-li-guei-shon, iu guil lav it" },
                    { es: "Puedes hacer tu pedido por WhatsApp.", en: "You can place your order through WhatsApp.", pro: "iu can pleis ior or-der zruu guats-ap" },
                    { es: "Aceptamos pagos por Zelle y efectivo.", en: "We accept payments via Zelle and cash.", pro: "gui ak-sept pei-ments vai-a sel and kash" },
                    { es: "Huele delicioso desde que se están asando.", en: "It smells delicious as soon as they start grilling.", pro: "it es-mels di-li-shos as suun as dei es-tart gril-in" },
                    { es: "Vienen con una porción de arepa gratis.", en: "They come with a free portion of arepa.", pro: "dei cam guiz a frii por-shon of a-re-pa" },
                    { es: "Son perfectos para una parrillada familiar.", en: "They are perfect for a family barbecue.", pro: "dei ar per-fekt for a fa-mi-li bar-bi-kiu" },
                    { es: "Tenemos una opción picante y una tradicional.", en: "We have a spicy option and a traditional one.", pro: "gui jaf a es-pai-si op-shon and a tra-di-sho-nal uan" },
                    { es: "Nuestros clientes siempre vuelven a comprar.", en: "Our customers always come back for more.", pro: "au-ar cas-to-mers ol-gueis cam bak for mor" },
                    { es: "Gracias por apoyar nuestro negocio familiar.", en: "Thank you for supporting our family business.", pro: "zenk iu for sa-por-tin au-ar fa-mi-li bis-nes" },
                    { es: "¡Buen provecho, que los disfrutes!", en: "Enjoy your meal, have a great time!", pro: "in-joi ior miil, jaf a greit taim" },
                    { es: "La grasa es natural, son muy magros.", en: "The fat is natural, they are very lean.", pro: "de fat is na-chural, dei ar ve-ri liin" },
                    { es: "Los preparamos frescos cada semana.", en: "We prepare them fresh every week.", pro: "gui pri-pear zem fresh ev-ri guiik" },
                    { es: "Puedes guardarlos en el congelador por tres meses.", en: "You can keep them in the freezer for three months.", pro: "iu can kiip zem in de frii-ser for zrii manzs" },
                    { es: "¿Quieres agregar salsa de la casa?", en: "Do you want to add our house sauce?", pro: "du iu uant tu ad au-ar jaus sos" },
                    { es: "Hacemos descuentos para eventos grandes.", en: "We offer discounts for large events.", pro: "gui o-fer dis-kaunts for larch i-vents" },
                    { es: "Están sazonados con hierbas naturales.", en: "They are seasoned with natural herbs.", pro: "dei ar sii-sond guiz na-chural erbs" },
                    { es: "El producto tiene control de calidad casero.", en: "The product has homemade quality control.", pro: "de pro-dakt jas joum-meid cua-li-ti con-troul" },
                    { es: "La tripa que usamos es natural.", en: "The casing we use is natural.", pro: "de kei-sin gui iuus is na-chural" },
                    { es: "Ya saqué tu pedido de la nevera.", en: "I already took your order out of the fridge.", pro: "ai ol-re-di tuk ior or-der aut of de frich" },
                    { es: "Llegó el repartidor con tus chorizos.", en: "The delivery driver arrived with your chorizos.", pro: "de di-li-ve-ri drai-ver a-raivd guiz ior cho-ri-sos" },
                    { es: "Están amarrados a mano uno por uno.", en: "They are hand-tied one by one.", pro: "dei ar jand taid uan bai uan" },
                    { es: "El sabor ahumado es exquisito.", en: "The smoky flavor is exquisite.", pro: "de es-mou-ki flei-vor is eks-qui-si-to" },
                    { es: "Esta es la receta secreta de la abuela.", en: "This is grandma's secret recipe.", pro: "dis is grand-mas sii-cret re-se-pi" },
                    { es: "Son ideales para el desayuno con huevo.", en: "They are ideal for breakfast with eggs.", pro: "dei ar ai-dial for brek-fast guiz egus" },
                    { es: "El precio incluye los condimentos.", en: "The price includes the seasonings.", pro: "de prais in-cluds de sii-son-ins" },
                    { es: "Hacemos envíos refrigerados a otras ciudades.", en: "We do refrigerated shipping to other cities.", pro: "gui du ri-fri-ye-rei-ted shi-pin tu o-der si-tis" },
                    { es: "La textura es firme y no se desarman.", en: "The texture is firm and they don't fall apart.", pro: "de teks-chur is ferm and dei dount fol a-part" },
                    { es: "No usamos harina para rellenarlos.", en: "We don't use flour to stuff them.", pro: "gui dount iuus flau-ar tu estaf zem" },
                    { es: "¿A qué hora te queda bien el delivery?", en: "What time works best for your delivery?", pro: "uat taim uerks best for ior di-li-ve-ri" },
                    { es: "La carne se muele justo antes de prepararlos.", en: "The meat is ground right before preparation.", pro: "de miit is graund rait bi-for pre-pa-rei-shon" },
                    { es: "Son bajos en sodio comparados con los comerciales.", en: "They are low in sodium compared to commercial ones.", pro: "dei ar lou in sou-diom com-perd tu co-mer-shals" },
                    { es: "Tienen el toque perfecto de ajo y comino.", en: "They have the perfect touch of garlic and cumin.", pro: "dei jaf de per-fekt tach of gar-lik and cui-min" },
                    { es: "Puedes cocinarlos en la freidora de aire.", en: "You can cook them in the air fryer.", pro: "iu can cuk zem in di er frai-er" },
                    { es: "Se cocinan en su propia grasa, no agregues más.", en: "They cook in their own fat, don't add more.", pro: "dei cuk in der oun fat, dount ad mor" },
                    { es: "Son un éxito total en las fiestas.", en: "They are a total hit at parties.", pro: "dei ar a tou-tal jit at par-tis" },
                    { es: "El pedido mínimo para delivery gratis son tres paquetes.", en: "The minimum order for free delivery is three packs.", pro: "de mi-ni-mom or-der for frii di-li-ve-ri is zrii paks" },
                    { es: "Ya tenemos listos los del fin de semana.", en: "We already have the weekend ones ready.", pro: "gui ol-re-di jaf de guiik-end uans re-di" },
                    { es: "Disculpa la demora, la producción toma tiempo.", en: "Sorry for the delay, production takes time.", pro: "so-ri for de di-lei, pro-dak-shon teiks taim" },
                    { es: "Cualquier comentario nos ayuda a mejorar.", en: "Any feedback helps us improve.", pro: "e-ni fiid-bak jelps as im-pruuv" },
                    { es: "¡Muchas gracias por tu compra de corazón!", en: "Thank you so much for your purchase from the heart!", pro: "zenk iu sou mach for ior per-chas rom de jart" }
                ],
                "Frases: Warehouse (Bodega)": [
                    { es: "Mueve este pallet al fondo.", en: "Move this pallet to the back.", pro: "muuv dis pa-let tu de bak" },
                    { es: "Necesitas usar las botas con punta de acero.", en: "You need to wear steel-toe boots.", pro: "iu niid tu guer es-tiil tou buuts" },
                    { es: "El montacargas está viniendo por el pasillo.", en: "The forklift is coming down the aisle.", pro: "de fork-lift is ca-min daun de ail" },
                    { es: "Hay que escanear todas estas cajas primero.", en: "We need to scan all these boxes first.", pro: "gui niid tu es-kan ol ziis bok-ses ferst" },
                    { es: "Pon la etiqueta de envío aquí.", en: "Put the shipping label here.", pro: "put de shi-pin lei-bol jiar" },
                    { es: "Este producto está fuera de inventario.", en: "This item is out of stock.", pro: "dis ai-tem is aut of estoc" },
                    { es: "El camión está esperando en la rampa de carga.", en: "The truck is waiting at the loading dock.", pro: "de trac is guei-tin at de lou-din doc" },
                    { es: "Ten cuidado con la carga pesada.", en: "Be careful with the heavy load.", pro: "bi ker-ful guiz de je-vi loud" },
                    { es: "Tenemos que organizar el inventario mensual.", en: "We have to organize the monthly inventory.", pro: "gui jaf tu or-ga-nais de manz-li in-ven-to-ri" },
                    { es: "Esta caja está rota, ponla a un lado.", en: "This box is broken, put it aside.", pro: "dis boks is brou-ken, put it a-said" },
                    { es: "Asegúrate de envolver bien el pallet con plástico.", en: "Make sure to wrap the pallet tightly with plastic.", pro: "meik shoor tu rap de pa-let tait-li guiz plas-tik" },
                    { es: "El supervisor está revisando las órdenes.", en: "The supervisor is checking the orders.", pro: "de su-per-vai-sor is che-kin di or-ders" },
                    { es: "La cinta de embalaje se terminó.", en: "The packing tape is gone.", pro: "de pa-kin teip is gon" },
                    { es: "El contenedor llegó retrasado hoy.", en: "The container arrived late today.", pro: "de con-tei-ner a-raivd leit tu-dei" },
                    { es: "Usa el gato hidráulico manual.", en: "Use the manual pallet jack.", pro: "iuus de ma-nual pa-let jack" },
                    { es: "Esta es la zona de mercancía peligrosa.", en: "This is the hazardous materials zone.", pro: "dis is de ja-sar-dos ma-tii-rials zoun" },
                    { es: "Hay que limpiar el pasillo cuatro.", en: "We need to clean aisle four.", pro: "gui niid tu kliin ail for" },
                    { es: "Firma el manifiesto de carga.", en: "Sign the cargo shipping manifest.", pro: "sain de car-gou shi-pin ma-ni-fest" },
                    { es: "El turno de la noche empieza a las ocho.", en: "The night shift starts at eight.", pro: "de nait shif es-tarts at eit" },
                    { es: "Buen trabajo en equipo hoy.", en: "Great teamwork today.", pro: "greit tiim-guerk tu-dei" },
                    { es: "¿Dónde está el cortador de cajas?", en: "Where is the box cutter?", pro: "guer is de boks ca-ter" },
                    { es: "Esta mercancía es muy frágil.", en: "This merchandise is very fragile.", pro: "dis mer-chan-dais is ve-ri fra-yil" },
                    { es: "No bloquees la salida de emergencia.", en: "Do not block the emergency exit.", pro: "du not blok di i-mer-yen-si ek-sit" },
                    { es: "El inventario del sistema no coincide.", en: "The system inventory doesn't match.", pro: "de sis-tem in-ven-to-ri da-sent mach" },
                    { es: "Hay que descargar este contenedor ahora.", en: "We need to unload this container now.", pro: "gui niid tu an-loud dis con-tei-ner nau" },
                    { es: "Pon los códigos de barras hacia arriba.", en: "Put the barcodes facing up.", pro: "put de bar-couds fei-sin ap" },
                    { es: "El chaleco reflectivo es obligatorio.", en: "The safety vest is mandatory.", pro: "de seif-ti vest is man-da-to-ri" },
                    { es: "La mercancía fue dañada en el camino.", en: "The goods were damaged on the way.", pro: "de guds guer da-micht on de uei" },
                    { es: "Revisa la lista de empaque.", en: "Check the packing list.", pro: "chek de pa-kin list" },
                    { es: "Hay un derrame de líquido en el pasillo.", en: "There is a liquid spill in the aisle.", pro: "der is a li-kuid espil in de ail" },
                    { es: "Sube este paquete al estante de arriba.", en: "Put this package on the top shelf.", pro: "put dis pa-kich on de top shelf" },
                    { es: "Usa las piernas para levantar, no la espalda.", en: "Lift with your legs, not your back.", pro: "lift guiz ior legs, not ior bak" },
                    { es: "El camión ya terminó de cargar.", en: "The truck is done loading.", pro: "de trac is dan lou-din" },
                    { es: "Necesitamos más paletas vacías.", en: "We need more empty pallets.", pro: "gui niid mor emp-ti pa-lets" },
                    { es: "El número de lote está borroso.", en: "The batch number is blurry.", pro: "de bach nam-ber is blar-i" },
                    { es: "Esta sección es para devoluciones.", en: "This section is for returns.", pro: "dis sek-shon is for ri-terns" },
                    { es: "El pedido está listo para despacho.", en: "The order is ready for dispatch.", pro: "di or-der is re-di for dis-pach" },
                    { es: "El escáner no tiene batería.", en: "The scanner has no battery.", pro: "de es-ka-ner jas nou ba-te-ri" },
                    { es: "La cinta métrica está en la oficina.", en: "The tape measure is in the office.", pro: "de teip me-shur is in de o-fis" },
                    { es: "El muelle de carga número cinco está libre.", en: "Loading dock number five is free.", pro: "lou-din doc nam-ber faiv is frii" },
                    { es: "La carga debe estar balanceada.", en: "The cargo must be balanced.", pro: "de car-gou mast bi ba-lanst" },
                    { es: "Pon el sello de seguridad en la puerta.", en: "Put the safety seal on the door.", pro: "put de seif-ti siil on de door" },
                    { es: "El reporte de daños fue enviado.", en: "The damage report was sent.", pro: "de da-mish ri-port guas sent" },
                    { es: "No uses el celular mientras manejas el equipo.", en: "Don't use your phone while operating equipment.", pro: "dount iuus ior foun guail o-pe-rei-tin i-quip-ment" },
                    { es: "Mantén el área de trabajo limpia.", en: "Keep your work area clean.", pro: "kiip ior uerk e-ria kliin" },
                    { es: "El camión de Fedex acaba de llegar.", en: "The Fedex truck just arrived.", pro: "de fe-deks trac jast a-raivd" },
                    { es: "Verifica el peso total de la carga.", en: "Verify the total weight of the load.", pro: "ve-ri-fai de tou-tal gueit of de loud" },
                    { es: "Esta zona es de acceso restringido.", en: "This area is restricted access.", pro: "dis e-ria is ri-strik-ted ak-ses" },
                    { es: "La alarma de reversa no funciona.", en: "The backup alarm is not working.", pro: "de bak-ap a-larm is not uer-kin" },
                    { es: "¡Buen turno, nos vemos mañana!", en: "Good shift, see you tomorrow!", pro: "gud shif, sii iu tu-ma-rou" }
                ],
                "Familia y Relaciones 👨👩👧": [
                    { es: "Familia", en: "Family", pro: "fa-mi-li" },
                    { es: "Madre / Mamá", en: "Mother / Mom", pro: "ma-der / mam" },
                    { es: "Padre / Papá", en: "Father / Dad", pro: "fa-der / dad" },
                    { es: "Padres (Papá y Mamá)", en: "Parents", pro: "pa-rents" },
                    { es: "Hijo", en: "Son", pro: "san" },
                    { es: "Hija", en: "Daughter", pro: "do-ter" },
                    { es: "Hermano", en: "Brother", pro: "bra-der" },
                    { es: "Hermana", en: "Sister", pro: "sis-ter" },
                    { es: "Abuelo", en: "Grandfather / Grandpa", pro: "grand-fa-der / grand-pa" },
                    { es: "Abuela", en: "Grandmother / Grandma", pro: "grand-ma-der / grand-ma" },
                    { es: "Esposo / Marido", en: "Husband", pro: "jas-band" },
                    { es: "Esposa / Mujer", en: "Wife", pro: "uaif" },
                    { es: "Pareja / Compañero", en: "Partner", pro: "part-ner" },
                    { es: "Tío", en: "Uncle", pro: "an-col" },
                    { es: "Tía", en: "Aunt", pro: "ant" },
                    { es: "Primo / Prima", en: "Cousin", pro: "ca-sin" },
                    { es: "Sobrino", en: "Nephew", pro: "ne-fiuu" },
                    { es: "Sobrina", en: "Niece", pro: "niis" },
                    { es: "Novio (Relación)", en: "Boyfriend", pro: "boi-frend" },
                    { es: "Novia (Relación)", en: "Girlfriend", pro: "guerl-frend" },
                    { es: "Amigo / Amiga", en: "Friend", pro: "frend" },
                    { es: "Mejor amigo", en: "Best friend", pro: "best frend" },
                    { es: "Compañero de trabajo", en: "Coworker", pro: "cou-uer-ker" },
                    { es: "Jefe", en: "Boss", pro: "bos" },
                    { es: "Suegro", en: "Father-in-law", pro: "fa-der in lo" },
                    { es: "Suegra", en: "Mother-in-law", pro: "ma-der in lo" },
                    { es: "Cuñado", en: "Brother-in-law", pro: "bra-der in lo" },
                    { es: "Cuñada", en: "Sister-in-law", pro: "sis-ter in lo" },
                    { es: "Yerno", en: "Son-in-law", pro: "san in lo" },
                    { es: "Nuera", en: "Daughter-in-law", pro: "do-ter in lo" },
                    { es: "Padrastro", en: "Stepfather", pro: "estep-fa-der" },
                    { es: "Madrastra", en: "Stepmother", pro: "estep-ma-der" },
                    { es: "Hijastro", en: "Stepson", pro: "estep-san" },
                    { es: "Hijastra", en: "Stepdaughter", pro: "estep-do-ter" },
                    { es: "Nieto", en: "Grandson", pro: "grand-san" },
                    { es: "Nieta", en: "Granddaughter", pro: "grand-do-ter" },
                    { es: "Bebé", en: "Baby", pro: "bei-bi" },
                    { es: "Niño", en: "Child / Boy", pro: "chaild / boi" },
                    { es: "Niña", en: "Girl", pro: "guerl" },
                    { es: "Adolescente", en: "Teenager", pro: "tii-nei-yer" },
                    { es: "Adulto", en: "Adult", pro: "a-dalt" },
                    { es: "Casado", en: "Married", pro: "ma-rid" },
                    { es: "Soltero", en: "Single", pro: "sin-gol" },
                    { es: "Divorciado", en: "Divorced", pro: "di-voost" },
                    { es: "Viudo / Viuda", en: "Widower / Widow", pro: "gui-dou-er / gui-dou" },
                    { es: "Comprometido", en: "Engaged", pro: "in-gueicht" },
                    { es: "Conocer a alguien", en: "To meet someone", pro: "tu miit sam-uan" },
                    { es: "Llevarse bien", en: "To get along", pro: "tu guet a-long" },
                    { es: "Discutir / Pelear", en: "To argue / fight", pro: "tu ar-guiu / fait" },
                    { es: "Amo a mi familia.", en: "I love my family.", pro: "ai lav mai fa-mi-li" }
                ],
                "Farmacia 💊": [
                    { es: "Farmacia / Botica", en: "Pharmacy / Drugstore", pro: "far-ma-si / drag-estoor" },
                    { es: "Medicamento / Medicina", en: "Medicine / Medication", pro: "me-di-sin / me-di-kei-shon" },
                    { es: "Receta médica / Prescripción", en: "Prescription", pro: "pri-scrip-shon" },
                    { es: "Pastillas / Píldoras", en: "Pills / Tablets", pro: "pils / ta-blets" },
                    { es: "Cápsulas", en: "Capsules", pro: "kap-suls" },
                    { es: "Jarabe (para la tos)", en: "Syrup (cough syrup)", pro: "si-rap (cof si-rap)" },
                    { es: "Crema / Pomada", en: "Cream / Ointment", pro: "criim / oint-ment" },
                    { es: "Gotas (para ojos/oídos)", en: "Drops", pro: "drops" },
                    { es: "Inyección", en: "Injection", pro: "in-jek-shon" },
                    { es: "Antibiótico", en: "Antibiotic", pro: "an-ti-bai-o-tik" },
                    { es: "Analgésico / Para el dolor", en: "Painkiller", pro: "pein-ki-ler" },
                    { es: "Aspirina", en: "Aspirin", pro: "as-pi-rin" },
                    { es: "Antiácido", en: "Antacid", pro: "ant-a-sid" },
                    { es: "Vitaminas", en: "Vitamins", pro: "vai-ta-mins" },
                    { es: "Efectos secundarios", en: "Side effects", pro: "said i-fekts" },
                    { es: "Dosis", en: "Dosage", pro: "dou-sich" },
                    { es: "Farmacéutico (Persona)", en: "Pharmacist", pro: "far-ma-sist" },
                    { es: "Venta libre (Sin receta)", en: "Over the counter / OTC", pro: "ou-ver de caun-ter / ou-tii-sii" },
                    { es: "Termómetro", en: "Thermometer", pro: "zer-mo-mi-ter" },
                    { es: "Vendaje / Gasa / Curita", en: "Bandage / Band-Aid", pro: "ban-dich / band eid" },
                    { es: "Alcohol antiséptico", en: "Rubbing alcohol", pro: "ra-bin al-co-jol" },
                    { es: "Algodón", en: "Cotton balls", pro: "co-ton bols" },
                    { es: "Mascarilla / Tapabocas", en: "Face mask", pro: "feis mask" },
                    { es: "Desinfectante de manos", en: "Hand sanitizer", pro: "jand sa-ni-tai-ser" },
                    { es: "Suplemento alimenticio", en: "Dietary supplement", pro: "daie-te-ri sa-ple-ment" },
                    { es: "Somnífero / Para dormir", en: "Sleeping pill", pro: "es-lii-pin pil" },
                    { es: "Laxante", en: "Laxative", pro: "lak-sa-tiv" },
                    { es: "Antihistamínico / Alergias", en: "Antihistamine", pro: "an-ti-jis-ta-miin" },
                    { es: "Inhalador", en: "Inhaler", pro: "in-jei-ler" },
                    { es: "Genérico (Medicamento)", en: "Generic", pro: "ye-ne-rik" },
                    { es: "Marca comercial", en: "Brand name", pro: "brand neim" },
                    { es: "Fecha de expiración", en: "Expiration date", pro: "eks-pi-rei-shon deit" },
                    { es: "Número de seguro médico", en: "Insurance number", pro: "in-shoo-rans nam-ber" },
                    { es: "Copago", en: "Copay", pro: "cou-pei" },
                    { es: "Deducible", en: "Deductible", pro: "di-dac-ti-bol" },
                    { es: "Tomar con comida", en: "Take with food", pro: "teik guiz fuud" },
                    { es: "Tomar con el estómago vacío", en: "Take on an empty stomach", pro: "teik on an emp-ti es-to-mak" },
                    { es: "Cada ocho horas", en: "Every eight hours", pro: "ev-ri eit au-ars" },
                    { es: "Dos veces al día", en: "Twice a day", pro: "tuais a dei" },
                    { es: "Mantener fuera del alcance de niños", en: "Keep out of reach of children", pro: "kiip aut of riich of chil-dren" },
                    { es: "Uso externo únicamente", en: "For external use only", pro: "for eks-ter-nal iuuss oun-li" },
                    { es: "No conduzca después de tomar esto", en: "Do not drive after taking this", pro: "du not draiv af-ter tei-kin dis" },
                    { es: "Puede causar somnolencia", en: "May cause drowsiness", pro: "mei cos drau-si-nes" },
                    { es: "Guardar en un lugar fresco", en: "Store in a cool place", pro: "estoor in a kuul pleis" },
                    { es: "Mantener refrigerado", en: "Keep refrigerated", pro: "kiip ri-fri-ye-rei-ted" },
                    { es: "Necesito surtir esta receta.", en: "I need to fill this prescription.", pro: "ai niid tu fil dis pri-scrip-shon" },
                    { es: "¿Tiene esto en una versión genérica?", en: "Do you have this in a generic version?", pro: "du iu jaf dis in a ye-ne-rik ver-shon" },
                    { es: "¿Cuál es la dosis para adultos?", en: "What is the dosage for adults?", pro: "uat is de dou-sich for a-dalts" },
                    { es: "Este medicamento requiere receta.", en: "This medication requires a prescription.", pro: "dis me-di-kei-shon ri-kuai-ars a pri-scrip-shon" },
                    { es: "Gracias por la información.", en: "Thank you for the information.", pro: "zenk iu for de in-for-mei-shon" }
                ],
                "Horas y Tiempo ⏱️": [
                    { es: "¿Qué hora es?", en: "What time is it?", pro: "uat taim is it" },
                    { es: "Es la una en punto.", en: "It's one o'clock.", pro: "its uan o-clok" },
                    { es: "Son las tres y media.", en: "It's half past three.", pro: "its jaf past zrii" },
                    { es: "Son las cuatro y cuarto.", en: "It's a quarter past four.", pro: "its a cuor-ter past for" },
                    { es: "Un cuarto para las cinco.", en: "It's a quarter to five.", pro: "its a cuor-ter tu faiv" },
                    { es: "En la mañana (AM)", en: "In the morning / AM", pro: "in de mor-nin / ei-em" },
                    { es: "En la tarde / noche (PM)", en: "In the afternoon / PM", pro: "in de af-ter-nuun / pi-em" },
                    { es: "Hora", en: "Hour", pro: "au-ar" },
                    { es: "Minuto", en: "Minute", pro: "mi-nit" },
                    { es: "Segundo", en: "Second", pro: "se-kond" },
                    { es: "Reloj (de pared)", en: "Clock", pro: "clok" },
                    { es: "Reloj (de pulsera)", en: "Watch", pro: "uach" },
                    { es: "Alarma", en: "Alarm", pro: "a-larm" },
                    { es: "Cronómetro", en: "Stopwatch", pro: "estop-uach" },
                    { es: "Temprano", en: "Early", pro: "er-li" },
                    { es: "Tarde", en: "Late", pro: "leit" },
                    { es: "A tiempo", en: "On time", pro: "on taim" },
                    { es: "Casi tiempo", en: "Almost time", pro: "ol-moust taim" },
                    { es: "Se acabó el tiempo.", en: "Time is up.", pro: "taim is ap" },
                    { es: "Tómate tu tiempo.", en: "Take your time.", pro: "teik ior taim" },
                    { es: "Falta una hora.", en: "One hour left.", pro: "uan au-ar left" },
                    { es: "Llegas retrasado.", en: "You are running late.", pro: "iu ar ra-nin leit" },
                    { es: "El tiempo vuela.", en: "Time flies.", pro: "taim flais" },
                    { es: "A la medianoche", en: "At midnight", pro: "at mid-nait" },
                    { es: "Al mediodía", en: "At noon", pro: "at nuun" },
                    { es: "Es muy temprano.", en: "It's too early.", pro: "its tuu er-li" },
                    { es: "Es muy tarde.", en: "It's too late.", pro: "its tuu leit" },
                    { es: "Espera un momento.", en: "Wait a moment.", pro: "ueit a mou-ment" },
                    { es: "Dame diez minutos.", en: "Give me ten minutes.", pro: "guiv mi ten mi-nits" },
                    { es: "Aproximadamente a las seis", en: "Around six o'clock", pro: "a-raund siks o-clok" },
                    { es: "Exactamente a las ocho", en: "Exactly at eight", pro: "ek-sact-li at eit" },
                    { es: "Antes de tiempo", en: "Ahead of time", pro: "a-jed of taim" },
                    { es: "A la misma hora", en: "At the same time", pro: "at de seim taim" },
                    { es: "Cada hora", en: "Every hour", pro: "ev-ri au-ar" },
                    { es: "Media hora", en: "Half an hour", pro: "jaf an au-ar" },
                    { es: "Quince minutos", en: "Fifteen minutes", pro: "fif-tiin mi-nits" },
                    { es: "Cinco minutos más", en: "Five more minutes", pro: "faiv mor mi-nits" },
                    { es: "El tiempo es dinero.", en: "Time is money.", pro: "taim is ma-ni" },
                    { es: "Perder el tiempo", en: "To waste time", pro: "tu ueist taim" },
                    { es: "Ahorrar tiempo", en: "To save time", pro: "tu seiv taim" },
                    { es: "Matar el tiempo", en: "To kill time", pro: "tu kil taim" },
                    { es: "Huso horario", en: "Time zone", pro: "taim zoun" },
                    { es: "Formato de doce horas", en: "Twelve-hour format", pro: "tuelf au-ar for-mat" },
                    { es: "Formato de veinticuatro horas", en: "Twenty-four-hour format", pro: "tuen-ti for au-ar for-mat" },
                    { es: "El reloj se detuvo.", en: "The clock stopped.", pro: "de clok estopt" },
                    { es: "Ajusta la hora.", en: "Set the time.", pro: "set de taim" },
                    { es: "Cambio de horario", en: "Time change", pro: "taim cheinch" },
                    { es: "Es la hora del descanso.", en: "It's break time.", pro: "its breik taim" },
                    { es: "Ya casi es la hora.", en: "It's almost time.", pro: "its ol-moust taim" },
                    { es: "Que tengas un buen día.", en: "Have a good time.", pro: "jaf a gud taim" }
                ],
                "Meses y Fechas 📅": [
                    { es: "Enero", en: "January", pro: "ya-niu-e-ri" },
                    { es: "Febrero", en: "February", pro: "fe-bru-e-ri" },
                    { es: "Marzo", en: "March", pro: "march" },
                    { es: "Abril", en: "April", pro: "ei-pril" },
                    { es: "Mayo", en: "May", pro: "mei" },
                    { es: "Junio", en: "June", pro: "juun" },
                    { es: "Julio", en: "July", pro: "ju-lai" },
                    { es: "Agosto", en: "August", pro: "o-gost" },
                    { es: "Septiembre", en: "September", pro: "sep-tem-ber" },
                    { es: "Octubre", en: "October", pro: "oc-tou-ber" },
                    { es: "Noviembre", en: "November", pro: "nou-vem-ber" },
                    { es: "Diciembre", en: "December", pro: "di-sem-ber" },
                    { es: "Mes", en: "Month", pro: "manz" },
                    { es: "Año", en: "Year", pro: "ii-ar" },
                    { es: "Fecha", en: "Date", pro: "deit" },
                    { es: "Día", en: "Day", pro: "dei" },
                    { es: "Fecha de nacimiento", en: "Date of birth", pro: "deit of berz" },
                    { es: "Fecha de vencimiento", en: "Expiration date / Due date", pro: "eks-pi-rei-shon deit / diuu deit" },
                    { es: "Este mes", en: "This month", pro: "dis manz" },
                    { es: "El mes pasado", en: "Last month", pro: "last manz" },
                    { es: "El próximo mes", en: "Next month", pro: "nekst manz" },
                    { es: "Este año", en: "This year", pro: "dis ii-ar" },
                    { es: "El año pasado", en: "Last year", pro: "last ii-ar" },
                    { es: "El próximo año", en: "Next year", pro: "nekst ii-ar" },
                    { es: "Primero de enero", en: "January first", pro: "ya-niu-e-ri ferst" },
                    { es: "Dos de febrero", en: "February second", pro: "fe-bru-e-ri se-kond" },
                    { es: "Tres de marzo", en: "March third", pro: "march zerd" },
                    { es: "Cuatro de abril", en: "April fourth", pro: "ei-pril forz" },
                    { es: "Cinco de mayo", en: "May fifth", pro: "mei fifz" },
                    { es: "Día festivo / Feriado", en: "Holiday", pro: "jo-li-dei" },
                    { es: "Fin de semana", en: "Weekend", pro: "guiik-end" },
                    { es: "Días de la semana", en: "Weekdays", pro: "guiik-deis" },
                    { es: "Calendario", en: "Calendar", pro: "ka-len-dar" },
                    { es: "A principios de mes", en: "At the beginning of the month", pro: "at de bi-gui-nin of de manz" },
                    { es: "A mediados de mes", en: "In the middle of the month", pro: "in de mi-dol of de manz" },
                    { es: "A finales de mes", en: "At the end of the month", pro: "at de end of de manz" },
                    { es: "Cada dos meses", en: "Every two months", pro: "ev-ri tuu manzs" },
                    { es: "Dos veces al año", en: "Twice a year", pro: "tuais a ii-ar" },
                    { es: "Año bisiesto", en: "Leap year", pro: "liip ii-ar" },
                    { es: "Estaciones del año", en: "Seasons of the year", pro: "sii-sons of de ii-ar" },
                    { es: "¿Cuál es la fecha de hoy?", en: "What is today's date?", pro: "uat is tu-deis deit" },
                    { es: "Hoy es tres de junio.", en: "Today is June third.", pro: "tu-dei is juun zerd" },
                    { es: "El evento es en octubre.", en: "The event is in October.", pro: "di i-vent is in oc-tou-ber" },
                    { es: "La fecha está mal escrita.", en: "The date is written wrong.", pro: "de deit is ri-ten rong" },
                    { es: "Por favor, escribe la fecha.", en: "Please write the date down.", pro: "pliis rait de deit daun" },
                    { es: "Falta un mes para el viaje.", en: "One month left for the trip.", pro: "uan manz left for de trip" },
                    { es: "La oferta es válida hasta diciembre.", en: "The offer is valid until December.", pro: "di o-fer is va-lid an-til di-sem-ber" },
                    { es: "Revisa el calendario.", en: "Check the calendar.", pro: "chek de ka-len-dar" },
                    { es: "Guarda la fecha.", en: "Save the date.", pro: "seiv de deit" },
                    { es: "¡Feliz año nuevo!", en: "Happy New Year!", pro: "ja-pi niu ii-ar" }
                ],
                "Números Pro 🔥": [
                    { es: "Uno", en: "One", pro: "uan" },
                    { es: "Dos", en: "Two", pro: "tuu" },
                    { es: "Tres", en: "Three", pro: "zrii" },
                    { es: "Cuatro", en: "Four", pro: "for" },
                    { es: "Cinco", en: "Five", pro: "faiv" },
                    { es: "Seis", en: "Six", pro: "siks" },
                    { es: "Siete", en: "Seven", pro: "se-ven" },
                    { es: "Ocho", en: "Eight", pro: "eit" },
                    { es: "Nueve", en: "Nine", pro: "nain" },
                    { es: "Diez", en: "Ten", pro: "ten" },
                    { es: "Once", en: "Eleven", pro: "i-le-ven" },
                    { es: "Doce", en: "Twelve", pro: "tuelf" },
                    { es: "Trece", en: "Thirteen", pro: "zer-tiin" },
                    { es: "Catorce", en: "Fourteen", pro: "for-tiin" },
                    { es: "Quince", en: "Fifteen", pro: "fif-tiin" },
                    { es: "Dieciséis", en: "Sixteen", pro: "siks-tiin" },
                    { es: "Diecisiete", en: "Seventeen", pro: "se-ven-tiin" },
                    { es: "Dieciocho", en: "Eightteen", pro: "ei-tiin" },
                    { es: "Diecinueve", en: "Nineteen", pro: "nain-tiin" },
                    { es: "Veinte", en: "Twenty", pro: "tuen-ti" },
                    { es: "Veintiuno", en: "Twenty-one", pro: "tuen-ti uan" },
                    { es: "Treinta", en: "Thirty", pro: "zer-ti" },
                    { es: "Cuarenta", en: "Forty", pro: "for-ti" },
                    { es: "Cincuenta", en: "Fifty", pro: "fif-ti" },
                    { es: "Sesenta", en: "Sixty", pro: "siks-ti" },
                    { es: "Setenta", en: "Seventy", pro: "se-ven-ti" },
                    { es: "Ochenta", en: "Eighty", pro: "ei-ti" },
                    { es: "Noventa", en: "Ninety", pro: "nain-ti" },
                    { es: "Cien", en: "One hundred", pro: "uan jan-dred" },
                    { es: "Ciento cincuenta", en: "One hundred and fifty", pro: "uan jan-dred and fif-ti" },
                    { es: "Doscientos", en: "Two hundred", pro: "tuu jan-dred" },
                    { es: "Quinientos", en: "Five hundred", pro: "faiv jan-dred" },
                    { es: "Mil", en: "One thousand", pro: "uan zau-sand" },
                    { es: "Cinco mil", en: "Five thousand", pro: "faiv zau-sand" },
                    { es: "Diez mil", en: "Ten thousand", pro: "ten zau-sand" },
                    { es: "Cien mil", en: "One hundred thousand", pro: "uan jan-dred zau-sand" },
                    { es: "Un millón", en: "One million", pro: "uan mi-lion" },
                    { es: "Primero", en: "First", pro: "ferst" },
                    { es: "Segundo", en: "Second", pro: "se-kond" },
                    { es: "Tercero", en: "Third", pro: "zerd" },
                    { es: "Cuarto (Orden)", en: "Fourth", pro: "forz" },
                    { es: "Quinto", en: "Fifth", pro: "fifz" },
                    { es: "La mitad", en: "Half", pro: "jaf" },
                    { es: "Un cuarto / Una cuarta parte", en: "A quarter", pro: "a cuor-ter" },
                    { es: "Doble", en: "Double", pro: "da-bol" },
                    { es: "Triple", en: "Triple", pro: "tri-pol" },
                    { es: "Cero", en: "Zero / Oh", pro: "sii-rou / ou" },
                    { es: "Número de teléfono", en: "Phone number", pro: "foun nam-ber" },
                    { es: "Cuenta de uno a diez.", en: "Count from one to ten.", pro: "caunt rom uan tu ten" },
                    { es: "El número total es cien.", en: "The total number is one hundred.", pro: "de tou-tal nam-ber is uan jan-dred" }
                ],
                "Oficina y Tecnología 💻": [
                    { es: "Computadora / Ordenador", en: "Computer", pro: "com-piu-ter" },
                    { es: "Computadora portátil / Laptop", en: "Laptop", pro: "lap-top" },
                    { es: "Pantalla / Monitor", en: "Screen / Monitor", pro: "es-criin / mo-ni-tor" },
                    { es: "Teclado", en: "Keyboard", pro: "kii-boord" },
                    { es: "Ratón / Mouse", en: "Mouse", pro: "maus" },
                    { es: "Impresora", en: "Printer", pro: "prin-ter" },
                    { es: "Imprimir", en: "To print", pro: "tu print" },
                    { es: "Archivo / Documento", en: "File / Document", pro: "fail / do-kiu-ment" },
                    { es: "Carpeta", en: "Folder", pro: "foul-der" },
                    { es: "Correo electrónico / Email", en: "Email", pro: "ii-meil" },
                    { es: "Contraseña", en: "Password", pro: "pas-guerd" },
                    { es: "Usuario", en: "Username", pro: "iuu-ser-neim" },
                    { es: "Sitio web", en: "Website", pro: "ueb-said" },
                    { es: "Enlace / Link", en: "Link", pro: "link" },
                    { es: "Red de internet / Wifi", en: "Wi-Fi / Internet", pro: "uai-fai / in-ter-net" },
                    { es: "Conexión", en: "Connection", pro: "co-nek-shon" },
                    { es: "Descargar / Bajar", en: "To download", pro: "tu daun-loud" },
                    { es: "Subir / Cargar un archivo", en: "To upload", pro: "tu ap-loud" },
                    { es: "Guardar", en: "To save", pro: "tu seiv" },
                    { es: "Borrar / Eliminar", en: "To delete", pro: "tu di-liit" },
                    { es: "Enviar", en: "To send", pro: "tu send" },
                    { es: "Recibir", en: "To receive", pro: "tu ri-siiv" },
                    { es: "Compartir", en: "To share", pro: "tu she-ar" },
                    { es: "Reiniciar", en: "To restart", pro: "tu ri-es-tart" },
                    { es: "Apagar", en: "To turn off", pro: "tu tern of" },
                    { es: "Prender / Encender", en: "To turn on", pro: "tu tern on" },
                    { es: "Escritorio (Mueble)", en: "Desk", pro: "desk" },
                    { es: "Silla de oficina", en: "Office chair", pro: "o-fis che-ar" },
                    { es: "Teléfono de la oficina", en: "Office phone", pro: "o-fis foun" },
                    { es: "Reunión / Junta", en: "Meeting", pro: "mii-tin" },
                    { es: "Llamada de negocios / Conferencia", en: "Conference call", pro: "con-fe-rens col" },
                    { es: "Mensaje de texto", en: "Text message", pro: "tekst me-sich" },
                    { es: "Aplicación / App", en: "Application / App", pro: "a-pli-kei-shon / ap" },
                    { es: "Software / Programa", en: "Software", pro: "soft-guer" },
                    { es: "Hardware / Equipos", en: "Hardware", pro: "jard-guer" },
                    { es: "Error del sistema / Bug", en: "System error / Bug", pro: "sis-tem e-ror / bag" },
                    { es: "Pantalla táctil", en: "Touchscreen", pro: "tach-es-criin" },
                    { es: "Cargador", en: "Charger", pro: "char-ier" },
                    { es: "Batería", en: "Battery", pro: "ba-te-ri" },
                    { es: "Auriculares / Audífonos", en: "Headphones", pro: "jed-founs" },
                    { es: "Altavoz / Parlante", en: "Speaker", pro: "es-pii-ker" },
                    { es: "Cámara web", en: "Webcam", pro: "ueb-kam" },
                    { es: "Micrófono", en: "Microphone", pro: "mai-cro-foun" },
                    { es: "Almacenamiento en la nube", en: "Cloud storage", pro: "claud es-to-rich" },
                    { es: "Disco duro", en: "Hard drive", pro: "jard draiv" },
                    { es: "Memoria USB / Pendrive", en: "USB drive / Flash drive", pro: "iu-es-bii draiv / flash draiv" },
                    { es: "No funciona el internet.", en: "The internet is not working.", pro: "de in-ter-net is not uer-kin" },
                    { es: "Olvidé mi contraseña.", en: "I forgot my password.", pro: "ai for-got mai pas-guerd" },
                    { es: "Envíame el enlace, por favor.", en: "Send me the link, please.", pro: "send mi de link pliiz" },
                    { es: "El sistema está lento hoy.", en: "The system is slow today.", pro: "de sis-tem is slou tu-dei" }
                ],
                "Preguntas Básicas ❓": [
                    { es: "¿Qué?", en: "What?", pro: "uat" },
                    { es: "¿Quién?", en: "Who?", pro: "ju" },
                    { es: "¿Dónde?", en: "Where?", pro: "guer" },
                    { es: "¿Cuándo?", en: "When?", pro: "guen" },
                    { es: "¿Por qué?", en: "Why?", pro: "uai" },
                    { es: "¿Cómo?", en: "How?", pro: "jau" },
                    { es: "¿Cuál?", en: "Which?", pro: "guich" },
                    { es: "¿Cuánto cuesta?", en: "How much is it?", pro: "jau mach is it" },
                    { es: "¿Cuántos hay?", en: "How many are there?", pro: "jau me-ni ar der" },
                    { es: "¿A qué hora?", en: "What time?", pro: "uat taim" },
                    { es: "¿Qué es esto?", en: "What is this?", pro: "uat is dis" },
                    { es: "¿Quién es él?", en: "Who is he?", pro: "ju is ji" },
                    { es: "¿Quién es ella?", en: "Who is she?", pro: "ju is shi" },
                    { es: "¿Dónde estás?", en: "Where are you?", pro: "guer ar iu" },
                    { es: "¿Dónde queda el baño?", en: "Where is the restroom?", pro: "guer is de rest-ruum" },
                    { es: "¿Cuándo es tu cumpleaños?", en: "When is your birthday?", pro: "guen is ior berz-dei" },
                    { es: "¿Por qué estás tarde?", en: "Why are you late?", pro: "uai ar iu leit" },
                    { es: "¿Cómo te sientes?", en: "How do you feel?", pro: "jau du iu fiil" },
                    { es: "¿Cómo te llamas?", en: "What is your name?", pro: "uat is ior neim" },
                    { es: "¿Cuál es tu número?", en: "What is your number?", pro: "uat is ior nam-ber" },
                    { es: "¿Me puedes ayudar?", en: "Can you help me?", pro: "can iu jelp mi" },
                    { es: "¿Hablas español?", en: "Do you speak Spanish?", pro: "du iu es-piik es-pa-nish" },
                    { es: "¿Entiendes esto?", en: "Do you understand this?", pro: "du iu an-der-es-tand dis" },
                    { es: "¿Qué necesitas?", en: "What do you need?", pro: "uat du iu niid" },
                    { es: "¿A dónde vas?", en: "Where are you going?", pro: "guer ar iu gou-in" },
                    { es: "¿De dónde eres?", en: "Where are you from?", pro: "guer ar iu rom" },
                    { es: "¿Qué hora tienes?", en: "Do you have the time?", pro: "du iu jaf de taim" },
                    { es: "¿Está abierto?", en: "Is it open?", pro: "is it ou-pen" },
                    { es: "¿Está cerrado?", en: "Is it closed?", pro: "is it clousd" },
                    { es: "¿Cuánto tiempo toma?", en: "How long does it take?", pro: "jau long das it teik" },
                    { es: "¿Estás listo?", en: "Are you ready?", pro: "ar iu re-di" },
                    { es: "¿Qué pasó?", en: "What happened?", pro: "uat ja-pend" },
                    { es: "¿Estás seguro?", en: "Are you sure?", pro: "ar iu shoor" },
                    { es: "¿Qué significa esto?", en: "What does this mean?", pro: "uat das dis miin" },
                    { es: "¿Cómo se dice esto en inglés?", en: "How do you say this in English?", pro: "jau du iu sei dis in in-glish" },
                    { es: "¿Me escuchas?", en: "Can you hear me?", pro: "can iu jiar mi" },
                    { es: "¿Me ves?", en: "Can you see me?", pro: "can iu sii mi" },
                    { es: "¿Todo bien?", en: "Is everything okay?", pro: "is ev-ri-zin o-kei" },
                    { es: "¿Qué quieres hacer?", en: "What do you want to do?", pro: "uat du iu uant tu du" },
                    { es: "¿Puedo pasar?", en: "May I come in?", pro: "mei ai kam in" },
                    { es: "¿Puedo usar esto?", en: "Can I use this?", pro: "can ai iuus dis" },
                    { es: "¿Aceptan tarjetas?", en: "Do you accept cards?", pro: "du iu ak-sept cards" },
                    { es: "¿Tienes cambio?", en: "Do you have change?", pro: "du iu jaf cheinch" },
                    { es: "¿Hay wifi aquí?", en: "Is there Wi-Fi here?", pro: "is der uai-fai jiar" },
                    { es: "¿Cuál es la contraseña?", en: "What is the password?", pro: "uat is de pas-guerd" },
                    { es: "¿A qué distancia queda?", en: "How far is it?", pro: "jau far is it" },
                    { es: "¿Viene el camión?", en: "Is the truck coming?", pro: "is de trac ca-min" },
                    { es: "¿Terminaste el trabajo?", en: "Are you done with work?", pro: "ar iu dan guiz uerk" },
                    { es: "¿Verdad?", en: "Right?", pro: "rait" },
                    { es: "¿Algo más?", en: "Anything else?", pro: "e-ni-zin els" }
                ],
                "Preposiciones y Ubicación 😵💫🌀": [
                    { es: "En / Dentro de (un lugar cerrado)", en: "In", pro: "in" },
                    { es: "Sobre / Encima de (tocando la superficie)", en: "On", pro: "on" },
                    { es: "En (un punto específico)", en: "At", pro: "at" },
                    { es: "Debajo de", en: "Under", pro: "an-der" },
                    { es: "Arriba de / Por encima (sin tocar)", en: "Above", pro: "a-bav" },
                    { es: "Detrás de", en: "Behind", pro: "bi-jaind" },
                    { es: "En frente de", en: "In front of", pro: "in front of" },
                    { es: "Al lado de / Junto a", en: "Next to / Beside", pro: "nekst tu / bi-said" },
                    { es: "Cerca de", en: "Near / Close to", pro: "niar / clous tu" },
                    { es: "Lejos de", en: "Far from", pro: "far rom" },
                    { es: "Entre (dos cosas)", en: "Between", pro: "bi-tuiin" },
                    { es: "Entre / En medio de (muchas cosas)", en: "Among", pro: "a-mang" },
                    { es: "Dentro (hacia el interior)", en: "Inside", pro: "in-said" },
                    { es: "Afuera (hacia el exterior)", en: "Outside", pro: "aut-said" },
                    { es: "A la derecha de", en: "To the right of", pro: "tu de rait of" },
                    { es: "A la izquierda de", en: "To the left of", pro: "tu de left of" },
                    { es: "Arriba (Dirección)", en: "Up", pro: "ap" },
                    { es: "Abajo (Dirección)", en: "Down", pro: "daun" },
                    { es: "Hacia adelante", en: "Forward", pro: "for-uard" },
                    { es: "Hacia atrás", en: "Backward", pro: "bak-uard" },
                    { es: "A través de", en: "Through", pro: "zruu" },
                    { es: "Alrededor de", en: "Around", pro: "a-raund" },
                    { es: "Frente a frente", en: "Across from", pro: "a-cros rom" },
                    { es: "Contra / Apoyado en", en: "Against", pro: "a-gueinst" },
                    { es: "Hacia", en: "Towards", pro: "tu-uards" },
                    { es: "Más allá de", en: "Beyond", pro: "bi-iond" },
                    { es: "En la parte superior / Arriba de todo", en: "On top of", pro: "on top of" },
                    { es: "En la parte inferior / Abajo de todo", en: "At the bottom of", pro: "at de bo-tom of" },
                    { es: "En la esquina", en: "On the corner", pro: "on de cor-ner" },
                    { es: "En el medio / centro", en: "In the middle / center", pro: "in de mi-dol / sen-ter" },
                    { es: "El paquete está en la puerta.", en: "The package is at the door.", pro: "de pa-kich is at de door" },
                    { es: "Las llaves están sobre la mesa.", en: "The keys are on the table.", pro: "de kiis ar on de tei-bol" },
                    { es: "El gato está debajo de la cama.", en: "The cat is under the bed.", pro: "de kat is an-der de bed" },
                    { es: "Párate en frente de mí.", en: "Stand in front of me.", pro: "estand in front of mi" },
                    { es: "El carro está detrás del camión.", en: "The car is behind the truck.", pro: "de car is bi-jaind de trac" },
                    { es: "Camina a través del pasillo.", en: "Walk through the aisle.", pro: "uolk zruu de ail" },
                    { es: "El hotel queda cerca del parque.", en: "The hotel is near the park.", pro: "de jo-tel is niar de park" },
                    { es: "La ferretería queda lejos de aquí.", en: "The hardware store is far from here.", pro: "de jard-guer estoor is far rom jiar" },
                    { es: "Dobla a la derecha en la esquina.", en: "Turn right on the corner.", pro: "tern rait on de cor-ner" },
                    { es: "El montacargas está afuera.", en: "The forklift is outside.", pro: "de fork-lift is aut-said" },
                    { es: "Estamos dentro de la bodega.", en: "We are inside the warehouse.", pro: "gui ar in-said de guer-jaus" },
                    { es: "Pon la caja encima del estante.", en: "Put the box on top of the shelf.", pro: "put de boks on top of de shelf" },
                    { es: "Mira hacia arriba.", en: "Look up.", pro: "luk ap" },
                    { es: "Mira hacia abajo.", en: "Look down.", pro: "luk daun" },
                    { es: "El billete está dentro de la billetera.", en: "The bill is inside the wallet.", pro: "de bil is in-said de ua-let" },
                    { es: "Mi casa queda al lado del supermercado.", en: "My house is next to the supermarket.", pro: "mai jaus is nekst tu de su-per-mar-ket" },
                    { es: "El destino está entre dos ciudades.", en: "The destination is between two cities.", pro: "de des-ti-nei-shon is bi-tuiin tuu si-tis" },
                    { es: "Apoya la escalera contra la pared.", en: "Lean the ladder against the wall.", pro: "liin de la-der a-gueinst de uol" },
                    { es: "Ve hacia la salida.", en: "Go towards the exit.", pro: "gou tu-uards di ek-sit" },
                    { es: "Ubicación confirmed.", en: "Location confirmed.", pro: "lou-kei-shon con-fermd" }
                ],
                "Presentaciones Personales 👋": [
                    { es: "Hola, mi nombre es Jovancito.", en: "Hello, my name is Jovancito.", pro: "je-lou, mai neim is io-van-si-tou" },
                    { es: "¿Cómo te llamas tú?", en: "What is your name?", pro: "uat is ior neim" },
                    { es: "Mucho gusto en conocerte.", en: "Nice to meet you.", pro: "nais tu miit iu" },
                    { es: "El gusto es mío.", en: "The pleasure is mine.", pro: "de ple-shur is main" },
                    { es: "¿De dónde eres?", en: "Where are you from?", pro: "guer ar iu rom" },
                    { es: "Yo soy de Colombia.", en: "I am from Colombia.", pro: "ai am rom co-lom-bia" },
                    { es: "¿Dónde vives ahora?", en: "Where do you live now?", pro: "guer du iu liv nau" },
                    { es: "Yo vivo en Florida.", en: "I live in Florida.", pro: "ai liv in flo-ri-da" },
                    { es: "¿A qué te dedicas? / ¿Cuál es tu trabajo?", en: "What do you do for a living?", pro: "uat du iu du for a li-vin" },
                    { es: "Yo soy desarrollador de aplicaciones.", en: "I am an app developer.", pro: "ai am an ap di-ve-lo-per" },
                    { es: "Yo trabajo en mantenimiento y construcción.", en: "I work in maintenance and construction.", pro: "ai uerk in mein-te-nans and con-estrak-shon" },
                    { es: "También soy chef profesional.", en: "I am also a professional chef.", pro: "ai am ol-sou a pro-fe-sho-nal shef" },
                    { es: "¿Cuántos años tienes?", en: "How old are you?", pro: "jau ould ar iu" },
                    { es: "Tengo cuarenta y tres años.", en: "I am forty-three years old.", pro: "ai am for-ti zrii iars ould" },
                    { es: "¿Eres casado o soltero?", en: "Are you married or single?", pro: "ar iu ma-rid or sin-gol" },
                    { es: "Soy casado, ella es mi esposa.", en: "I am married, she is my wife.", pro: "ai am ma-rid, shi is mai uaif" },
                    { es: "Tengo un hijo de diecinueve años.", en: "I have a nineteen-year-old son.", pro: "ai jaf a nain-tiin iar ould san" },
                    { es: "Este es mi número de teléfono.", en: "This is my phone number.", pro: "dis is mai foun nam-ber" },
                    { es: "Háblame un poco de ti.", en: "Tell me a little bit about yourself.", pro: "tel mi a li-tol bit a-baut ior-self" },
                    { es: "Gracias por presentarte.", en: "Thank you for introducing yourself.", pro: "zenk iu for in-tro-diu-sin ior-self" },
                    { es: "¿Cuál es tu pasatiempo favorito?", en: "What is your favorite hobby?", pro: "uat is ior fei-vo-rit jo-bi" },
                    { es: "Me gusta jugar billar en mi tiempo libre.", en: "I like playing billiards in my free time.", pro: "ai laik plei-in bi-liards in mai frii taim" },
                    { es: "Me encanta coleccionar monedas de veinticinco centavos.", en: "I love collecting quarters.", pro: "ai lav co-lek-tin cuor-ters" },
                    { es: "También disfruto ir a caminar por la naturaleza.", en: "I also enjoy going for nature walks.", pro: "ai ol-sou in-joi gou-in for nei-chur uolks" },
                    { es: "Me gusta visitar los parques temáticos de Disney.", en: "I like visiting Disney theme parks.", pro: "ai laik vi-si-tin dis-ni ziim parks" },
                    { es: "¿Cuál es tu correo electrónico?", en: "What is your email address?", pro: "uat is ior ii-meil a-dres" },
                    { es: "Mucho gusto en conocer a tu familia.", en: "Nice to meet your family.", pro: "nais tu miit ior fa-mi-li" },
                    { es: "¿Tienes hermanos o hermanas?", en: "Do you have brothers or sisters?", pro: "du iu jaf bra-ders or sis-ters" },
                    { es: "Mi lengua materna es el español.", en: "My native language is Spanish.", pro: "mai nei-tiv lan-guich is es-pa-nish" },
                    { es: "Estoy estudiando inglés todos los días.", en: "I am studying English every day.", pro: "ai am es-ta-di-in in-glish ev-ri dei" },
                    { es: "¿Cómo se deletrea tu nombre?", en: "How do you spell your name?", pro: "jau du iu es-pel ior neim" },
                    { es: "Disculpa, no entendí bien tu apellido.", en: "Sorry, I didn't catch your last name.", pro: "so-ri, ai di-dent kach ior last neim" },
                    { es: "Tengo un grupo de amigos desde hace ocho años.", en: "I have a group of friends for eight years now.", pro: "ai jaf a grup of frends for eit iars nau" },
                    { es: "Me considero una persona muy trabajadora.", en: "I consider myself a very hard-working person.", pro: "ai con-si-der mai-self a ve-ri jard uer-kin per-son" },
                    { es: "Mi cumpleaños es el siete de agosto.", en: "My birthday is on August seventh.", pro: "mai berz-dei is on o-gost se-venz" },
                    { es: "Tengo mi propio negocio independiente.", en: "I have my own independent business.", pro: "ai jaf mai oun in-di-pen-dent bis-nes" },
                    { es: "Manejo una agencia de viajes llamada Magic Travel.", en: "I run a travel agency called Magic Travel.", pro: "ai ran a jei-yen-si of tra-vel cald ma-yik tra-vel" },
                    { es: "Es un placer hacer negocios contigo.", en: "It's a pleasure doing business with you.", pro: "its a ple-shur du-in bis-nes guiz iu" },
                    { es: "Espero que podamos ser buenos amigos.", en: "I hope we can be good friends.", pro: "ai joup gui can bi gud frends" },
                    { es: "Pasa adelante, estás en tu casa.", en: "Come in, make yourself at home.", pro: "cam in, meik ior-self at joum" },
                    { es: "Disculpa la molestia.", en: "Sorry for the bother.", pro: "so-ri for de ba-der" },
                    { es: "No te preocupes, no hay problema.", en: "Don't worry, no problem.", pro: "dount gua-ri, nou pro-blem" },
                    { es: "¿Me puedes dar tu tarjeta de presentación?", en: "Can you give me your business card?", pro: "can iu guiv mi ior bis-nes card" },
                    { es: "Te presento a mi socio de negocios.", en: "This is my business partner.", pro: "dis is mai bis-nes part-ner" },
                    { es: "Él es un amigo muy cercano.", en: "He is a very close friend.", pro: "ji is a ve-ri clous frend" },
                    { es: "Nos conocemos desde hace mucho tiempo.", en: "We have known each other for a long time.", pro: "gui jaf noun iich o-der for a long taim" },
                    { es: "Tengo que irme ahora, fue un gusto.", en: "I must go now, it was a pleasure.", pro: "ai mast gou nau, it guas a ple-shur" },
                    { es: "Mantengamos el contacto.", en: "Let's keep in touch.", pro: "lets kiip in tach" },
                    { es: "Que tengas un excelente día.", en: "Have an excellent day.", pro: "jaf an ek-se-lent dei" },
                    { es: "¡Hasta la próxima!", en: "Until next time!", pro: "an-til nekst taim" }
                ],
                "Profesiones y Oficios 👷": [
                    { es: "Profesor / Maestro", en: "Teacher", pro: "tii-cher" },
                    { es: "Médico / Doctor", en: "Doctor", pro: "dok-tor" },
                    { es: "Enfermero / Enfermera", en: "Nurse", pro: "ners" },
                    { es: "Ingeniero", en: "Engineer", pro: "en-yi-niar" },
                    { es: "Desarrollador / Programador", en: "Developer / Programmer", pro: "di-ve-lo-per / prou-gra-mer" },
                    { es: "Cocinero / Chef", en: "Cook / Chef", pro: "cuk / shef" },
                    { es: "Mesero / Camarero", en: "Waiter / Server", pro: "uei-ter / ser-ver" },
                    { es: "Conductor / Repartidor", en: "Driver / Delivery driver", pro: "drai-ver / di-li-ve-ri drai-ver" },
                    { es: "Carpintero", en: "Carpenter", pro: "car-pin-ter" },
                    { es: "Electricista", en: "Electrician", pro: "i-lek-tri-shon" },
                    { es: "Plomero / Fontanero", en: "Plumber", pro: "pla-mer" },
                    { es: "Cerrajero", en: "Locksmith", pro: "lok-smiz" },
                    { es: "Trabajador de construcción", en: "Construction worker", pro: "con-estrak-shon uer-ker" },
                    { es: "Personal de mantenimiento", en: "Maintenance worker", pro: "mein-te-nans uer-ker" },
                    { es: "Mecánico", en: "Mechanic", pro: "me-ka-nik" },
                    { es: "Pintor", en: "Painter", pro: "pein-ter" },
                    { es: "Barbero / Estilista", en: "Barber / Hairstylist", pro: "bar-ber / jer-es-tai-list" },
                    { es: "Cajero", en: "Cashier", pro: "ka-shiar" },
                    { es: "Gerente / Manager", en: "Manager", pro: "ma-na-yer" },
                    { es: "Supervisor", en: "Supervisor", pro: "su-per-vai-sor" },
                    { es: "Abogado", en: "Lawyer", pro: "lo-iar" },
                    { es: "Contador", en: "Accountant", pro: "a-caun-tant" },
                    { es: "Agente de policía", en: "Police officer", pro: "po-liis o-fi-ser" },
                    { es: "Bombero", en: "Firefighter", pro: "fai-ar-fai-ter" },
                    { es: "Guardia de seguridad", en: "Security guard", pro: "si-kiu-ri-ti gard" },
                    { es: "Trabajador de almacén / bodega", en: "Warehouse worker", pro: "guer-jaus uer-ker" },
                    { es: "Operador de montacargas", en: "Forklift operator", pro: "fork-lift o-pe-rei-tor" },
                    { es: "Agente de viajes", en: "Travel agent", pro: "tra-vel ei-yent" },
                    { es: "Vendedor / Agente de ventas", en: "Salesperson / Sales agent", pro: "seils-per-son / seils ei-yent" },
                    { es: "Diseñador gráfico", en: "Graphic designer", pro: "gra-fik di-sai-ner" },
                    { es: "Fotógrafo", en: "Photographer", pro: "fo-to-graf-er" },
                    { es: "Dentista", en: "Dentist", pro: "den-tist" },
                    { es: "Farmacéutico", en: "Pharmacist", pro: "far-ma-sist" },
                    { es: "Veterinario", en: "Veterinarian / Vet", pro: "ve-te-ri-ne-rian / vet" },
                    { es: "Arquitecto", en: "Architect", pro: "ar-ki-tekt" },
                    { es: "Periodista / Reportero", en: "Journalist / Reporter", pro: "yer-na-list / ri-por-ter" },
                    { es: "Músico", en: "Musician", pro: "miu-si-shon" },
                    { es: "Actor / Actriz", en: "Actor / Actress", pro: "ak-tor / ak-tres" },
                    { es: "Piloto", en: "Pilot", pro: "pai-lot" },
                    { es: "Asistente de vuelo / Azafata", en: "Flight attendant", pro: "flait a-ten-dans" },
                    { es: "Conserje / Limpiador", en: "Janitor / Cleaner", pro: "ja-ni-tor / clii-ner" },
                    { es: "Jardinero", en: "Gardener", pro: "gar-de-ner" },
                    { es: "Carnicero", en: "Butcher", pro: "bu-cher" },
                    { es: "Panadero", en: "Baker", pro: "bei-ker" },
                    { es: "Sastre / Costurera", en: "Tailor / Seamstress", pro: "tei-lor / siim-stres" },
                    { es: "Peluquero de mascotas", en: "Pet groomer", pro: "pet gruu-mer" },
                    { es: "Entrenador personal", en: "Personal trainer", pro: "per-so-nal trei-ner" },
                    { es: "Trabajador independiente", en: "Freelancer / Self-employed", pro: "frii-lan-ser / self im-ploid" },
                    { es: "Empresario / Dueño de negocio", en: "Business owner / Entrepreneur", pro: "bis-nes ou-ner / an-tre-pre-ner" },
                    { es: "Jubilado / Retirado", en: "Retired", pro: "ri-tai-ard" }
                ],
                "Ropa y Accesorios 🕶️": [
                    { es: "Camisa", en: "Shirt", pro: "shert" },
                    { es: "Camiseta / Playera", en: "T-shirt", pro: "tii-shert" },
                    { es: "Pantalones", en: "Pants", pro: "pants" },
                    { es: "Pantalones de mezclilla / Jeans", en: "Jeans", pro: "yiins" },
                    { es: "Chaqueta / Chamarra", en: "Jacket", pro: "ja-ket" },
                    { es: "Abrigo", en: "Coat", pro: "cout" },
                    { es: "Suéter / Buso", en: "Sweater", pro: "sue-ter" },
                    { es: "Sudadera con capucha / Hoodie", en: "Hoodie", pro: "ju-dii" },
                    { es: "Pantalón corto / Shorts", en: "Shorts", pro: "shorts" },
                    { es: "Vestido", en: "Dress", pro: "dres" },
                    { es: "Falda", en: "Skirt", pro: "eskert" },
                    { es: "Traje formal", en: "Suit", pro: "suut" },
                    { es: "Ropa interior", en: "Underwear", pro: "an-der-guer" },
                    { es: "Calcetines / Medias", en: "Socks", pro: "soks" },
                    { es: "Zapatos", en: "Shoes", pro: "shuus" },
                    { es: "Zapatos deportivos / Tenis", en: "Sneakers", pro: "snii-kers" },
                    { es: "Botas", en: "Boots", pro: "buuts" },
                    { es: "Sandalias / Chanclas", en: "Sandals / Flip-flops", pro: "san-dals / flip-flops" },
                    { es: "Sombrero", en: "Hat", pro: "jat" },
                    { es: "Gorra", en: "Cap", pro: "kap" },
                    { es: "Cinturón / Correa", en: "Belt", pro: "belt" },
                    { es: "Gafas / Lentes", en: "Glasses", pro: "gla-ses" },
                    { es: "Gafas de sol", en: "Sunglasses", pro: "san-gla-ses" },
                    { es: "Reloj de pulsera", en: "Watch", pro: "uach" },
                    { es: "Billetera / Cartera de hombre", en: "Wallet", pro: "ua-let" },
                    { es: "Bolso / Cartera de mujer", en: "Purse / Handbag", pro: "pers / jand-bag" },
                    { es: "Mochila / Morral", en: "Backpack", pro: "bak-pak" },
                    { es: "Maleta / Equipaje", en: "Suitcase / Luggage", pro: "suut-keis / la-guich" },
                    { es: "Bufanda", en: "Scarf", pro: "es-karf" },
                    { es: "Guantes", en: "Gloves", pro: "glavs" },
                    { es: "Corbata", en: "Tie", pro: "tai" },
                    { es: "Pijama", en: "Pajamas", pro: "pa-ya-mas" },
                    { es: "Traje de baño", en: "Swimsuit", pro: "suim-suut" },
                    { es: "Anillo", en: "Ring", pro: "ring" },
                    { es: "Collar / Cadena", en: "Necklace / Chain", pro: "nek-les / chein" },
                    { es: "Pulsera", en: "Bracelet", pro: "breis-let" },
                    { es: "Aretes / Zarcillos", en: "Earrings", pro: "iar-rins" },
                    { es: "Paraguas", en: "Umbrella", pro: "am-bre-la" },
                    { es: "Impermeable / Capa de lluvia", en: "Raincoat", pro: "rein-kout" },
                    { es: "Talla grande", en: "Large size", pro: "larch sais" },
                    { es: "Talla mediana", en: "Medium size", pro: "mii-diom sais" },
                    { es: "Talla pequeña", en: "Small size", pro: "es-mol sais" },
                    { es: "Ropa de trabajo", en: "Work clothes", pro: "uerk clous" },
                    { es: "Botas con punta de acero", en: "Steel-toe boots", pro: "es-tiil tou buuts" },
                    { es: "Chaleco de seguridad", en: "Safety vest", pro: "seif-ti vest" },
                    { es: "Uniforme", en: "Uniform", pro: "iu-ni-form" },
                    { es: "Esta camisa te queda muy bien.", en: "This shirt looks great on you.", pro: "dis shert luks greit on iu" },
                    { es: "Necesito cambiarme de ropa.", en: "I need to change my clothes.", pro: "ai niid tu cheinch mai clous" },
                    { es: "Me voy a poner los tenis.", en: "I'm going to put on my sneakers.", pro: "aim gou-in tu put on mai snii-kers" },
                    { es: "Quítate los zapatos mojados.", en: "Take off your wet shoes.", pro: "teik of ior uet shuus" }
                ],
                "Salud y Medicina 🏥": [
                    { es: "Me siento enfermo.", en: "I feel sick.", pro: "ai fiil sik" },
                    { es: "Necesito ver a un doctor.", en: "I need to see a doctor.", pro: "ai niid tu sii a dok-tor" },
                    { es: "Tengo una cita médica.", en: "I have a medical appointment.", pro: "ai jaf a me-di-kol a-point-ment" },
                    { es: "Me duele la cabeza.", en: "I have a headache.", pro: "ai jaf a jed-eik" },
                    { es: "Tengo fiebre alta.", en: "I have a high fever.", pro: "ai jaf a jai fii-ver" },
                    { es: "Tengo tos y dolor de garganta.", en: "I have a cough and a sore throat.", pro: "ai jaf a cof and a sor zrout" },
                    { es: "Me duele mucho el estómago.", en: "My stomach hurts a lot.", pro: "mai es-to-mak jerts a lot" },
                    { es: "Tengo alergia a este medicamento.", en: "I am allergic to this medication.", pro: "ai am a-ler-yik tu dis me-di-kei-shon" },
                    { es: "Por favor, llame a una ambulancia.", en: "Please, call an ambulance.", pro: "pliis col an am-biu-lans" },
                    { es: "Esta es una emergencia médica.", en: "This is a medical emergency.", pro: "dis is a me-di-kol i-mer-yen-si" },
                    { es: "Hospital", en: "Hospital", pro: "jos-pi-tal" },
                    { es: "Clínica de urgencias", en: "Urgent care", pro: "er-yent ker" },
                    { es: "Sala de emergencias", en: "Emergency room / ER", pro: "i-mer-yen-si ruum / ii-ar" },
                    { es: "Paciente", en: "Patient", pro: "plei-shent" },
                    { es: "Presión arterial", en: "Blood pressure", pro: "blad pre-shur" },
                    { es: "Dolor", en: "Pain / Ache", pro: "pein / eik" },
                    { es: "Mareo", en: "Dizziness", pro: "di-si-nes" },
                    { es: "Náuseas", en: "Nausea", pro: "no-shia" },
                    { es: "Resfriado / Gripe", en: "Cold / Flu", pro: "could / fluu" },
                    { es: "Infección", en: "Infection", pro: "in-fek-shon" },
                    { es: "Inflamación / Hinchazón", en: "Swelling", pro: "suel-in" },
                    { es: "Herida / Cortada", en: "Wound / Cut", pro: "guund / cat" },
                    { es: "Quemadura", en: "Burn", pro: "bern" },
                    { es: "Fractura / Hueso roto", en: "Fracture / Broken bone", pro: "frak-chur / brou-ken boun" },
                    { es: "Seguro médico", en: "Health insurance", pro: "jelz in-shoo-rans" },
                    { es: "Tarjeta de seguro", en: "Insurance card", pro: "in-shoo-rans card" },
                    { es: "Análisis de sangre", en: "Blood test", pro: "blad test" },
                    { es: "Radiografía", en: "X-ray", pro: "eks-rei" },
                    { es: "Receta médica", en: "Prescription", pro: "pri-scrip-shon" },
                    { es: "Tome este medicamento con agua.", en: "Take this medicine with water.", pro: "teik dis me-di-sin guiz ua-ter" },
                    { es: "Descanse por un par de días.", en: "Rest for a couple of days.", pro: "rest for a ca-pol of deis" },
                    { es: "Beba muchos líquidos.", en: "Drink plenty of fluids.", pro: "drink plen-ti of fluu-ids" },
                    { es: "Me duele el pecho.", en: "I have chest pain.", pro: "ai jaf chest pein" },
                    { es: "No puedo respirar bien.", en: "I can't breathe well.", pro: "ai kant briiz guel" },
                    { es: "Tengo un esguince en el tobillo.", en: "I have a sprained ankle.", pro: "ai jaf a es-preind an-kol" },
                    { es: "Me picó un insecto.", en: "An insect bit me.", pro: "an in-sekt bit mi" },
                    { es: "Tengo la piel irritada.", en: "My skin is irritated.", pro: "mai skin is i-ri-tei-ted" },
                    { es: "El dolor empezó ayer.", en: "The pain started yesterday.", pro: "de pein es-tar-ted ies-ter-dei" },
                    { es: "¿Dónde le duele?", en: "Where does it hurt?", pro: "guer das it jert" },
                    { es: "Póngase hielo en la herida.", en: "Put ice on the injury.", pro: "put ais on di in-joo-ri" },
                    { es: "Limpie la herida con alcohol.", en: "Clean the wound with alcohol.", pro: "kliin de guund guiz al-co-jol" },
                    { es: "Use una curita.", en: "Use a Band-Aid.", pro: "iuus a band-eid" },
                    { es: "Tengo escalofríos.", en: "I have chills.", pro: "ai jaf chils" },
                    { es: "Estoy perdiendo sangre.", en: "I'm bleeding.", pro: "aim blii-din" },
                    { es: "¿Tiene alguna enfermedad crónica?", en: "Do you have any chronic illness?", pro: "du iu jaf e-ni cro-nik il-nes" },
                    { es: "Tengo la presión alta.", en: "I have high blood pressure.", pro: "ai jaf jai blad pre-shur" },
                    { es: "Soy diabético.", en: "I am diabetic.", pro: "ai am dai-a-be-tik" },
                    { es: "Me siento mucho mejor hoy.", en: "I feel much better today.", pro: "ai fiil mach be-ter tu-dei" },
                    { es: "Gracias por cuidarme.", en: "Thank you for taking care of me.", pro: "zenk iu for tei-kin ker of mi" },
                    { es: "¡Cuida tu salud!", en: "Take care of your health!", pro: "teik ker of ior jelz" }
                ],
                "Saludos y Despedidas ✨": [
                    { es: "Hola", en: "Hello / Hi", pro: "je-lou / jai" },
                    { es: "Buenos días", en: "Good morning", pro: "gud mor-nin" },
                    { es: "Buenas tardes", en: "Good afternoon", pro: "gud af-ter-nuun" },
                    { es: "Buenas noches (Al llegar)", en: "Good evening", pro: "gud iiv-nin" },
                    { es: "Buenas noches (Al despedirse / dormir)", en: "Good night", pro: "gud nait" },
                    { es: "¿Cómo estás?", en: "How are you?", pro: "jau ar iu" },
                    { es: "¿Cómo va todo?", en: "How is everything going?", pro: "jau is ev-ri-zin gou-in" },
                    { es: "¿Qué hay de nuevo? / ¿Qué pasa?", en: "What's up?", pro: "uats ap" },
                    { es: "Estoy bien, gracias.", en: "I'm doing well, thank you.", pro: "aim du-in guel zenk iu" },
                    { es: "Todo excelente.", en: "Everything is great.", pro: "ev-ri-zin is greit" },
                    { es: "Más o menos / Así así", en: "So-so", pro: "sou sou" },
                    { es: "No muy bien.", en: "Not too good.", pro: "not tuu gud" },
                    { es: "¿Y tú?", en: "And you?", pro: "and iu" },
                    { es: "Mucho gusto.", en: "Nice to meet you.", pro: "nais tu miit iu" },
                    { es: "Bienvenido", en: "Welcome", pro: "guel-kam" },
                    { es: "Adiós", en: "Goodbye / Bye", pro: "gud-bai / bai" },
                    { es: "Nos vemos.", en: "See you.", pro: "sii iu" },
                    { es: "Nos vemos más tarde.", en: "See you later.", pro: "sii iu lei-ter" },
                    { es: "Nos vemos mañana.", en: "See you tomorrow.", pro: "sii iu tu-ma-rou" },
                    { es: "Nos vemos pronto.", en: "See you soon.", pro: "sii iu suun" },
                    { es: "Cuídate.", en: "Take care.", pro: "teik ker" },
                    { es: "Que tengas un buen día.", en: "Have a nice day.", pro: "jaf a nais dei" },
                    { es: "Que tengas un buen fin de semana.", en: "Have a great weekend.", pro: "jaf a greit guiik-end" },
                    { es: "Buen viaje.", en: "Have a safe trip.", pro: "jaf a seif trip" },
                    { es: "Saludos a tu familia.", en: "Give my regards to your family.", pro: "guiv mai ri-gards tu ior fa-mi-li" },
                    { es: "Fue un placer verte.", en: "It was nice seeing you.", pro: "it guas nais sii-in iu" },
                    { es: "Igualmente", en: "Likewise / You too", pro: "laik-uais / iu tuu" },
                    { es: "Por favor", en: "Please", pro: "pliiz" },
                    { es: "Muchas gracias.", en: "Thank you so much.", pro: "zenk iu sou mach" },
                    { es: "De nada / Con gusto", en: "You're welcome / My pleasure", pro: "ior guel-kam / mai ple-shur" },
                    { es: "Disculpa / Con permiso", en: "Excuse me", pro: "eks-kiuus mi" },
                    { es: "Lo siento mucho / Disculpa", en: "I'm so sorry.", pro: "aim sou so-ri" },
                    { es: "No hay problema.", en: "No problem.", pro: "nou pro-blem" },
                    { es: "No te preocupes.", en: "Don't worry.", pro: "dount gua-ri" },
                    { es: "Está bien.", en: "It's okay / All right", pro: "its o-kei / ol rait" },
                    { es: "Pasa adelante.", en: "Come in.", pro: "kam in" },
                    { es: "Toma asiento.", en: "Have a seat.", pro: "jaf a siit" },
                    { es: "¡Buena suerte!", en: "Good luck!", pro: "gud lak" },
                    { es: "¡Felicidades!", en: "Congratulations!", pro: "con-gra-tu-lei-shons" },
                    { es: "¡Feliz cumpleaños!", en: "Happy birthday!", pro: "ja-pi berz-dei" },
                    { es: "¡Buen provecho!", en: "Enjoy your meal!", pro: "in-joi ior miil" },
                    { es: "Hola a todos.", en: "Hello everyone.", pro: "je-lou ev-ri-uan" },
                    { es: "¿Cómo estuvo tu día?", en: "How was your day?", pro: "jau guas ior deit" },
                    { es: "Un gusto hablar contigo.", en: "Nice talking to you.", pro: "nais tol-kin tu iu" },
                    { es: "Tengo que irme.", en: "I have to go.", pro: "ai jaf tu gou" },
                    { es: "Escríbeme más tarde.", en: "Text me later.", pro: "tekst mi lei-ter" },
                    { es: "Llámame cuando puedas.", en: "Call me when you can.", pro: "col mi guen iu can" },
                    { es: "Que pases buenas noches.", en: "Have a good night.", pro: "jaf a gud nait" },
                    { es: "¡Hasta luego!", en: "See you around!", pro: "sii iu a-raund" },
                    { es: "¡Chao de pana!", en: "Bye, take it easy!", pro: "bai teik it ii-si" }
                ],
                "Salón de Belleza ✨": [
                    { es: "Necesito un corte de cabello.", en: "I need a haircut.", pro: "ai niid a jer-cat" },
                    { es: "Solo un corte de puntas, por favor.", en: "Just a trim, please.", pro: "jast a trim pliiz" },
                    { es: "Quiero lavarme el cabello.", en: "I want to wash my hair.", pro: "ai uant tu uash mai jer" },
                    { es: "Me gustaría teñirme el cabello.", en: "I would like to dye my hair.", pro: "ai guuld laik tu dai mai jer" },
                    { es: "¿Qué color me recomiendas?", en: "What color do you recommend?", pro: "uat co-lor du iu re-co-miend" },
                    { es: "Quiero hacerme reflejos / rayitos.", en: "I want to get highlights.", pro: "ai uant tu guet jai-laits" },
                    { es: "Por favor, sécame el cabello con secador.", en: "Please, blow-dry my hair.", pro: "pliis blou drai mai jer" },
                    { es: "Quiero un alisado de cabello.", en: "I want hair straightening.", pro: "ai uant jer estreit-nin" },
                    { es: "Quiero hacerme la manicura.", en: "I want to get a manicure.", pro: "ai uant tu guet a ma-ni-kiur" },
                    { es: "Quiero hacerme la pedicura.", en: "I want to get a pedicure.", pro: "ai uant tu guet a pe-di-kiur" },
                    { es: "Corte de barba", en: "Beard trim", pro: "biard trim" },
                    { es: "Afeitado completo", en: "Clean shave", pro: "kliin sheiv" },
                    { es: "Champú", en: "Shampoo", pro: "sham-puu" },
                    { es: "Acondicionador", en: "Conditioner", pro: "con-di-sho-ner" },
                    { es: "Tinte para el cabello", en: "Hair dye", pro: "jer dai" },
                    { es: "Tijeras", en: "Scissors", pro: "si-sors" },
                    { es: "Máquina de afeitar / Rasuradora", en: "Clipper / Razor", pro: "cli-per / rei-sor" },
                    { es: "Peine / Cepillo", en: "Comb / Brush", pro: "coum / brash" },
                    { es: "Secador de cabello", en: "Hairdryer", pro: "jer-drai-er" },
                    { es: "Plancha para el cabello", en: "Flat iron / Straightener", pro: "flat ai-ron / estreit-ner" },
                    { es: "Espejo", en: "Mirror", pro: "mi-ror" },
                    { es: "Esmalte de uñas", en: "Nail polish", pro: "neil po-lish" },
                    { es: "Uñas de gel / acrílicas", en: "Gel / Acrylic nails", pro: "yel / a-cri-lik neils" },
                    { es: "Limpieza facial", en: "Facial cleaning", pro: "fei-shal clii-nin" },
                    { es: "Depilación con cera", en: "Waxing", pro: "uak-sin" },
                    { es: "Depilación de cejas", en: "Eyebrow shaping", pro: "ai-brau shei-pin" },
                    { es: "Tratamiento capilar", en: "Hair treatment", pro: "jer triit-ment" },
                    { es: "Estilista / Peluquero", en: "Hairstylist / Barber", pro: "jer-es-tai-list / bar-ber" },
                    { es: "Manicurista", en: "Manicurist", pro: "ma-ni-kiu-rist" },
                    { es: "¿Tiene citas disponibles hoy?", en: "Do you have any openings today?", pro: "du iu jaf e-ni ou-pe-nins tu-dei" },
                    { es: "Tengo una cita a las cuatro.", en: "I have an appointment at four.", pro: "ai jaf an a-point-ment at for" },
                    { es: "Por favor, espere en la sala.", en: "Please wait in the lounge area.", pro: "pliis ueit in de launch e-ria" },
                    { es: "¿Cuánto cuesta este servicio?", en: "How much is this service?", pro: "jau mach is dis ser-vis" },
                    { es: "Me gusta mucho el resultado.", en: "I really like the result.", pro: "ai ria-li laik de ri-sal-tat" },
                    { es: "No me gusta cómo quedó.", en: "I don't like how it turned out.", pro: "ai dount laik jau it ternd aut" },
                    { es: "El agua está muy caliente.", en: "The water is too hot.", pro: "de ua-ter is tuu jot" },
                    { es: "El agua está fría.", en: "The water is cold.", pro: "de ua-ter is could" },
                    { es: "Por favor, corta un poco más arriba.", en: "Please cut a little higher.", pro: "pliis cat a li-tol jai-er" },
                    { es: "No uses laca / spray, gracias.", en: "No hairspray, thank you.", pro: "nou jer-es-prei zenk iu" },
                    { es: "Quiero un estilo moderno.", en: "I want a modern style.", pro: "ai uant a mo-dern es-tail" },
                    { es: "Muéstrame una foto del diseño.", en: "Show me a photo of the design.", pro: "shou mi a fou-tou of de di-sain" },
                    { es: "Usa aceite para la barba.", en: "Use beard oil.", pro: "iuus biard oil" },
                    { es: "La manicura incluye masaje.", en: "The manicure includes a massage.", pro: "de ma-ni-kiur in-cluds a ma-sach" },
                    { es: "El esmalte se está secando.", en: "The polish is drying.", pro: "de po-lish is drai-in" },
                    { es: "Necesito remover este acrílico.", en: "I need to remove this acrylic.", pro: "ai niid tu ri-muuv dis a-cri-lik" },
                    { es: "Por favor, limpia las herramientas.", en: "Please sanitize the tools.", pro: "pliis sa-ni-tais de tuuls" },
                    { es: "Guarda el cambio como propina.", en: "Keep the change as a tip.", pro: "kiip de cheinch as a tip" },
                    { es: "Muchas gracias, quedó excelente.", en: "Thank you so much, it looks excellent.", pro: "zenk iu sou mach, it luks ek-se-lent" },
                    { es: "Nos vemos en un mes.", en: "See you in a month.", pro: "sii iu in a manz" },
                    { es: "¡Quedaste espectacular!", en: "You look amazing!", pro: "iu luk a-mei-zin" }
                ],
                "Transportes y Viajes 🚀": [
                    { es: "Tengo mi pasaporte listo.", en: "I have my passport ready.", pro: "ai jaf mai pas-port re-di" },
                    { es: "Necesitamos pasar por seguridad.", en: "We need to go through security.", pro: "gui jaf tu gou zruu si-kiu-ri-ti" },
                    { es: "¿Dónde queda la puerta de embarque?", en: "Where is the boarding gate?", pro: "guer is de boor-din gueit" },
                    { es: "El equipaje está muy pesado.", en: "The luggage is too heavy.", pro: "de la-guich is tuu je-vi" },
                    { es: "Necesito una etiqueta para mi maleta.", en: "I need a bag tag for my suitcase.", pro: "ai niid a bag tag for mai suut-keis" },
                    { es: "El vuelo directo fue cancelado.", en: "The direct flight was canceled.", pro: "de di-rekt flait guas can-seld" },
                    { es: "Tenemos una escala en Atlanta.", en: "We have a layover in Atlanta.", pro: "gui jaf a lei-ou-ver in at-lan-ta" },
                    { es: "Quiero un asiento al lado de la ventana.", en: "I want a window seat.", pro: "ai uant a guin-dou siit" },
                    { es: "Prefiero el asiento del pasillo.", en: "I prefer the aisle seat.", pro: "ai pri-fer di ail siit" },
                    { es: "La turbulencia fue un poco fuerte.", en: "The turbulence was a bit rough.", pro: "de ter-biu-lens guas a bit raf" },
                    { es: "Pasaporte", en: "Passport", pro: "pas-port" },
                    { es: "Boleto de avión / Pasaje", en: "Flight ticket", pro: "flait ti-ket" },
                    { es: "Pase de abordar", en: "Boarding pass", pro: "boor-din pas" },
                    { es: "Maleta / Equipaje", en: "Suitcase / Luggage", pro: "suut-keis / la-guich" },
                    { es: "Equipaje de mano", en: "Carry-on luggage", pro: "ca-ri on la-guich" },
                    { es: "Control de aduanas", en: "Customs control", pro: "cas-toms con-troul" },
                    { es: "Terminal del aeropuerto", en: "Airport terminal", pro: "er-port ter-mi-nal" },
                    { es: "Avión", en: "Airplane / Plane", pro: "er-plein / plein" },
                    { es: "Crucero (Barco)", en: "Cruise ship", pro: "cruus ship" },
                    { es: "Alquiler de autos / Dealer", en: "Car rental", pro: "car ren-tal" },
                    { es: "Agencia de viajes", en: "Travel agency", pro: "tra-vel ei-yen-si" },
                    { es: "Destino turístico", en: "Tourist destination", pro: "tuu-rist des-ti-nei-shon" },
                    { es: "Reserva de hotel", en: "Hotel reservation", pro: "jo-tel re-ser-vei-shon" },
                    { es: "Itinerario de viaje", en: "Travel itinerary", pro: "tra-vel ai-ti-ne-re-ri" },
                    { es: "Guía turístico", en: "Tour guide", pro: "tuur gaid" },
                    { es: "Seguro de viaje", en: "Travel insurance", pro: "tra-vel in-shoo-rans" },
                    { es: "Cambio de divisas / Moneda", en: "Currency exchange", pro: "ca-ren-si eks-cheinch" },
                    { es: "Paseo en bote / barco", en: "Boat ride", pro: "bout raid" },
                    { es: "Estación de abordaje", en: "Boarding station", pro: "boor-din estei-shon" },
                    { es: "Llegamos a tiempo para el embarque.", en: "We arrived on time for boarding.", pro: "gui a-raivd on taim for boor-din" },
                    { es: "El avión va a despegar pronto.", en: "The plane will take off soon.", pro: "de plein guil teik of suun" },
                    { es: "El aterrizaje fue perfecto.", en: "The landing was perfect.", pro: "de lan-din guas per-fekt" },
                    { es: "Reclame su equipaje en la banda tres.", en: "Claim your luggage at carousel three.", pro: "cleim ior la-guich at ca-rou-sel zrii" },
                    { es: "El hotel queda frente a Disney Springs.", en: "The hotel is right in front of Disney Springs.", pro: "de jo-tel is rait in front of dis-ni es-prins" },
                    { es: "Tenemos pases oficiales para los parques.", en: "We have official theme park passes.", pro: "gui jaf o-fi-shals ziim park pa-ses" },
                    { es: "Manejar en la autopista de Florida es rápido.", en: "Driving on the Florida highway is fast.", pro: "drai-vin on de flo-ri-da jai-uei is fast" },
                    { es: "Rentamos una minivan para toda la familia.", en: "We rented a minivan for the whole family.", pro: "gui ren-ted a mi-ni-van for de joul fa-mi-li" },
                    { es: "El GPS nos dio la ruta más corta.", en: "The GPS gave us the shortest route.", pro: "de yii-pii-es guiv us de shor-test ruut" },
                    { es: "Hay un peaje electrónico en esta vía.", en: "There is an electronic toll on this road.", pro: "der is an i-lek-tro-nik tol on dis roud" },
                    { es: "Guarde sus pases digitales en el celular.", en: "Save your digital passes on your phone.", pro: "seiv ior di-yi-tal pa-ses on ior foun" },
                    { es: "El crucero sale desde el puerto de Miami.", en: "The cruise departs from the port of Miami.", pro: "de cruus di-parts rom de port of mai-a-mi" },
                    { es: "Disfrute las playas de la costa.", en: "Enjoy the beaches on the coast.", pro: "in-joi de bii-ches on de coust" },
                    { es: "El clima está ideal para viajar.", en: "The weather is ideal for traveling.", pro: "de gue-der is ai-dial for tra-ve-lin" },
                    { es: "Haga el check-in veinticuatro horas antes.", en: "Do the check-in twenty-four hours before.", pro: "du de chek-in tuen-ti for au-ars bi-for" },
                    { es: "Su vuelo no incluye maleta pesada.", en: "Your flight doesn't include a heavy suitcase.", pro: "ior flait da-sent in-clud a je-vi suut-keis" },
                    { es: "La cotización tiene un precio excelente.", en: "The quote has an excellent price.", pro: "de cuout jas an ek-se-lent prais" },
                    { es: "Gracias por planear el viaje con Magic Travel.", en: "Thank you for planning the trip with Magic Travel.", pro: "zenk iu for plan-in de trip guiz ma-yik tra-vel" },
                    { es: "Tome fotos de sus pases por seguridad.", en: "Take pictures of your passes for safety.", pro: "teik pik-churs of ior pa-ses for seif-ti" },
                    { es: "¡Bienvenidos a bordo de las vacaciones!", en: "Welcome aboard the vacation!", pro: "guel-kam a-boord de vei-kei-shon" },
                    { es: "¡Que tengan un viaje inolvidable!", en: "Have an unforgettable trip!", pro: "jaf an an-for-guet-a-bol trip" }
                ],
                "Verbos de Acción 🏃": [
                    { es: "Correr", en: "To run", pro: "tu ran" },
                    { es: "Caminar", en: "To walk", pro: "tu uolk" },
                    { es: "Trabajar", en: "To work", pro: "tu uerk" },
                    { es: "Aprender", en: "To learn", pro: "tu lern" },
                    { es: "Estudiar", en: "To study", pro: "tu es-ta-di" },
                    { es: "Cocinar", en: "To cook", pro: "tu cuk" },
                    { es: "Comprar", en: "To buy", pro: "tu bai" },
                    { es: "Pagar", en: "To pay", pro: "tu pei" },
                    { es: "Escanear", en: "To scan", pro: "tu es-kan" },
                    { es: "Entregar", en: "To deliver", pro: "tu di-li-ver" },
                    { es: "Mover", en: "To move", pro: "tu muuv" },
                    { es: "Limpiar", en: "To clean", pro: "tu kliin" },
                    { es: "Reparar / Arreglar", en: "To repair / fix", pro: "tu ri-pear / fiks" },
                    { es: "Abrir", en: "To open", pro: "tu ou-pen" },
                    { es: "Cerrar", en: "To close", pro: "tu clous" },
                    { es: "Manejar / Conducir", en: "To drive", pro: "tu draiv" },
                    { es: "Viajar", en: "To travel", pro: "tu tra-vel" },
                    { es: "Jugar", en: "To play", pro: "tu plei" },
                    { es: "Ganar", en: "To win", pro: "tu guin" },
                    { es: "Perder", en: "To lose", pro: "tu luus" },
                    { es: "Escribir", en: "To write", pro: "tu rait" },
                    { es: "Leer", en: "To read", pro: "tu riid" },
                    { es: "Escuchar", en: "To listen", pro: "tu lis-sen" },
                    { es: "Hablar", en: "To speak / talk", pro: "tu es-piik / tolk" },
                    { es: "Comer", en: "To eat", pro: "tu iit" },
                    { es: "Beber / Tomar", en: "To drink", pro: "tu drink" },
                    { es: "Dormir", en: "To sleep", pro: "tu es-liip" },
                    { es: "Despertarse", en: "To wake up", pro: "tu uouk ap" },
                    { es: "Llamar", en: "To call", pro: "tu col" },
                    { es: "Enviar / Mandar", en: "To send", pro: "tu send" },
                    { es: "Recibir", en: "To receive", pro: "tu ri-siiv" },
                    { es: "Traer", en: "To bring", pro: "tu bring" },
                    { es: "Llevar / Tomar", en: "To take", pro: "tu teik" },
                    { es: "Poner", en: "To put", pro: "tu put" },
                    { es: "Hacer", en: "To do / make", pro: "tu du / meik" },
                    { es: "Ayudar", en: "To help", pro: "tu jelp" },
                    { es: "Buscar", en: "To look for", pro: "tu luk for" },
                    { es: "Encontrar", en: "To find", pro: "tu faind" },
                    { es: "Esperar (Tiempo)", en: "To wait", pro: "tu ueit" },
                    { es: "Llegar", en: "To arrive", pro: "tu a-raiv" },
                    { es: "Salir / Dejar un lugar", en: "To leave", pro: "tu liiv" },
                    { es: "Prender / Encender", en: "To turn on", pro: "tu tern on" },
                    { es: "Apagar", en: "To turn off", pro: "tu tern of" },
                    { es: "Subir / Escalar", en: "To go up / climb", pro: "tu gou ap / claim" },
                    { es: "Bajar", en: "To go down", pro: "tu gou daun" },
                    { es: "Detenerse / Parar", en: "To stop", pro: "tu estop" },
                    { es: "Empezar / Comenzar", en: "To start / begin", pro: "tu es-tart / bi-guin" },
                    { es: "Terminar / Acabar", en: "To finish / end", pro: "tu fi-nish / end" },
                    { es: "Pensar", en: "To think", pro: "tu zink" },
                    { es: "Saber / Conocer", en: "To know", pro: "tu nou" }
                ]
            };

            let isPlayingCategory = false;
            let currentCategoryItems = [];
            
            let targetLang = localStorage.getItem('arlingo_targetLang') || "{{ app()->getLocale() }}";
            let currentScreen = localStorage.getItem('arlingo_currentScreen') || 'languageScreen';

            document.addEventListener('DOMContentLoaded', () => {
                showScreen(currentScreen, false);
            });

            const categoryTranslations = {
                "01. MUNDIAL FIFA 2026 🏆": "{{ __('01. MUNDIAL FIFA 2026 🏆') }}",
                "Abecedario 🔤": "{{ __('Abecedario 🔤') }}",
                "Adjetivos Comunes 💡": "{{ __('Adjetivos Comunes 💡') }}",
                "Alimentos y Bebidas 🍕": "{{ __('Alimentos y Bebidas 🍕') }}",
                "Animales y Naturaleza 🦁": "{{ __('Animales y Naturaleza 🦁') }}",
                "Casa y el Hogar 🏠": "{{ __('Casa y el Hogar 🏠') }}",
                "Ciudad y Lugares 🏙️": "{{ __('Ciudad y Lugares 🏙️') }}",
                "Clima y Estaciones ☁️": "{{ __('Clima y Estaciones ☁️') }}",
                "Colores Básicos 🎨": "{{ __('Colores Básicos 🎨') }}",
                "Compras y Dinero 💰": "{{ __('Compras y Dinero 💰') }}",
                "Deportes ⚽": "{{ __('Deportes ⚽') }}",
                "Días y Tiempo ⏰": "{{ __('Días y Tiempo ⏰') }}",
                "Educación y Escuela 📚": "{{ __('Educación y Escuela 📚') }}",
                "El Cuerpo Humano 🧠": "{{ __('El Cuerpo Humano 🧠') }}",
                "Emociones y Sentimientos 😊": "{{ __('Emociones y Sentimientos 😊') }}",
                "Frases: Agencia de Viajes": "{{ __('Frases: Agencia de Viajes') }}",
                "Frases: Cerrajería": "{{ __('Frases: Cerrajería') }}",
                "Frases: Delivery & Instacart": "{{ __('Frases: Delivery & Instacart') }}",
                "Frases: Publicidad & Ventas": "{{ __('Frases: Publicidad & Ventas') }}",
                "Frases: Royal Prestige": "{{ __('Frases: Royal Prestige') }}",
                "Frases: Tienda de Ropa": "{{ __('Frases: Tienda de Ropa') }}",
                "Frases: Transportes y Viajes": "{{ __('Frases: Transportes y Viajes') }}",
                "Frases: Venta de Chorizos": "{{ __('Frases: Venta de Chorizos') }}",
                "Frases: Warehouse (Bodega)": "{{ __('Frases: Warehouse (Bodega)') }}",
                "Familia y Relaciones 👨👩👧": "{{ __('Familia y Relaciones 👨👩👧') }}",
                "Farmacia 💊": "{{ __('Farmacia 💊') }}",
                "Horas y Tiempo ⏱️": "{{ __('Horas y Tiempo ⏱️') }}",
                "Meses y Fechas 📅": "{{ __('Meses y Fechas 📅') }}",
                "Números Pro 🔥": "{{ __('Números Pro 🔥') }}",
                "Oficina y Tecnología 💻": "{{ __('Oficina y Tecnología 💻') }}",
                "Preguntas Básicas ❓": "{{ __('Preguntas Básicas ❓') }}",
                "Preposiciones y Ubicación 😵💫🌀": "{{ __('Preposiciones y Ubicación 😵💫🌀') }}",
                "Presentaciones Personales 👋": "{{ __('Presentaciones Personales 👋') }}",
                "Profesiones y Oficios 👷": "{{ __('Profesiones y Oficios 👷') }}",
                "Ropa y Accesorios 🕶️": "{{ __('Ropa y Accesorios 🕶️') }}",
                "Salud y Medicina 🏥": "{{ __('Salud y Medicina 🏥') }}",
                "Saludos y Despedidas ✨": "{{ __('Saludos y Despedidas ✨') }}",
                "Salón de Belleza ✨": "{{ __('Salón de Belleza ✨') }}",
                "Transportes y Viajes 🚀": "{{ __('Transportes y Viajes 🚀') }}",
                "Verbos de Acción 🏃": "{{ __('Verbos de Acción 🏃') }}"
            };

            function chooseLanguage(lang) {
                targetLang = lang;
                localStorage.setItem('arlingo_targetLang', lang);
                showScreen('welcomeScreen');
            }

            function showScreen(id, save = true) {
                if (save) localStorage.setItem('arlingo_currentScreen', id);
                document.querySelectorAll('.screen').forEach(s => s.classList.remove('active-screen'));
                document.getElementById(id).classList.add('active-screen');
                if (id === 'lobbyScreen') initLobby();
            }

            function initLobby() {
                const container = document.getElementById('tabs');
                container.innerHTML = '';
                Object.keys(data).forEach(cat => {
                    const btn = document.createElement('button');
                    btn.className = 'tab-btn';
                    btn.innerHTML = categoryTranslations[cat] || cat;
                    btn.onclick = () => openCategory(cat);
                    container.appendChild(btn);
                });
            }

            function openCategory(cat) {
                const modal = document.getElementById('categoryModal');
                const body = document.getElementById('modalBody');
                document.getElementById('modalTitle').innerText = categoryTranslations[cat] || cat;
                currentCategoryItems = data[cat];
                document.getElementById('itemCount').innerText = `${currentCategoryItems.length} palabras`;
                
                const flagDiv = document.getElementById('modalTargetFlag');
                const labelDiv = document.getElementById('learningLabel');
                if (targetLang === 'en') {
                    flagDiv.innerHTML = `<img src="https://flagcdn.com/w80/us.png" alt="English" class="w-16 sm:w-20 rounded-lg shadow-xl border-2 border-slate-700/50">`;
                    labelDiv.innerText = "{{ __('APRENDIENDO INGLÉS') }}";
                } else {
                    flagDiv.innerHTML = `<img src="https://flagcdn.com/w80/es.png" alt="Spanish" class="w-16 sm:w-20 rounded-lg shadow-xl border-2 border-slate-700/50">`;
                    labelDiv.innerText = "{{ __('APRENDIENDO ESPAÑOL') }}";
                }
                
                body.innerHTML = '';
                currentCategoryItems.forEach((item, index) => {
                    const div = document.createElement('div');
                    div.className = 'card-word';
                    div.id = `card-${index}`;
                    
                    let smallText, bigText, proText, playLang;
                    if (targetLang === 'en') {
                        smallText = item.es;
                        bigText = item.en;
                        proText = `<div class="text-gold text-sm mt-1">🗣️ ${item.pro}</div>`;
                        playLang = 'en-US';
                    } else {
                        smallText = item.en;
                        bigText = item.es;
                        proText = ''; // Spanish doesn't have phonetics in data
                        playLang = 'es-ES';
                    }

                    div.innerHTML = `
                        <div class="flex flex-col text-left">
                            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">${smallText}</div>
                            <strong class="text-white text-xl font-outfit uppercase tracking-wide">${bigText}</strong>
                            ${proText}
                        </div>
                        <button class="play-btn" onclick="speakBoth('${item.es}', '${item.en}', '${targetLang}')">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                    `;
                    body.appendChild(div);
                });
                
                isPlayingCategory = false;
                document.getElementById('btnPlayCategory').innerHTML = "▶ {{ __('REPRODUCIR TODO') }}";
                modal.style.display = 'flex';
            }

            async function speakBoth(esText, enText, langMode) {
                window.speechSynthesis.cancel();
                if (langMode === 'en') {
                    await new Promise(resolve => speak(esText, 'es-ES', resolve));
                    await new Promise(resolve => setTimeout(resolve, 600));
                    speak(enText, 'en-US');
                } else {
                    await new Promise(resolve => speak(enText, 'en-US', resolve));
                    await new Promise(resolve => setTimeout(resolve, 600));
                    speak(esText, 'es-ES');
                }
            }

            async function playFullCategory() {
                if (isPlayingCategory) {
                    window.speechSynthesis.cancel();
                    isPlayingCategory = false;
                    document.getElementById('btnPlayCategory').innerHTML = "▶ {{ __('REPRODUCIR TODO') }}";
                    document.querySelectorAll('.card-word').forEach(c => c.classList.remove('playing-card'));
                    return;
                }

                isPlayingCategory = true;
                document.getElementById('btnPlayCategory').innerHTML = "⏹ {{ __('DETENER') }}";

                for (let i = 0; i < currentCategoryItems.length; i++) {
                    if (!isPlayingCategory) break;
                    const item = currentCategoryItems[i];
                    const card = document.getElementById(`card-${i}`);
                    
                    document.querySelectorAll('.card-word').forEach(c => c.classList.remove('playing-card'));
                    card.classList.add('playing-card');
                    card.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    if (targetLang === 'en') {
                        // English learner: Spanish -> English
                        await new Promise(resolve => speak(item.es, 'es-ES', resolve));
                        await new Promise(resolve => setTimeout(resolve, 600));
                        await new Promise(resolve => speak(item.en, 'en-US', resolve));
                    } else {
                        // Spanish learner: English -> Spanish
                        await new Promise(resolve => speak(item.en, 'en-US', resolve));
                        await new Promise(resolve => setTimeout(resolve, 600));
                        await new Promise(resolve => speak(item.es, 'es-ES', resolve));
                    }
                    await new Promise(resolve => setTimeout(resolve, 1200));
                }

                isPlayingCategory = false;
                document.getElementById('btnPlayCategory').innerHTML = "▶ {{ __('REPRODUCIR TODO') }}";
            }

            // SLEEP MODE LOGIC
            let isSleepMode = false;
            let wakeLock = null;
            let sleepModeStartTime = 0;
            let sleepModePhrases = [];
            
            async function requestWakeLock() {
                try {
                    if ('wakeLock' in navigator) {
                        wakeLock = await navigator.wakeLock.request('screen');
                        wakeLock.addEventListener('release', () => {
                            console.log('Wake Lock released');
                        });
                        console.log('Wake Lock active');
                    }
                } catch (err) {
                    console.warn(`Wake Lock error: ${err.name}, ${err.message}`);
                }
            }
            
            function releaseWakeLock() {
                if (wakeLock !== null) {
                    wakeLock.release();
                    wakeLock = null;
                }
            }

            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
            }

            async function openSleepMode() {
                // Flatten all phrases
                sleepModePhrases = [];
                Object.values(data).forEach(categoryArray => {
                    sleepModePhrases = sleepModePhrases.concat(categoryArray);
                });
                
                if (sleepModePhrases.length === 0) {
                    alert('No hay frases disponibles para reproducir.');
                    return;
                }
                
                shuffleArray(sleepModePhrases);
                
                // Show UI
                document.getElementById('sleepModeModal').style.display = 'flex';
                isSleepMode = true;
                sleepModeStartTime = Date.now();
                
                // Request Wake Lock
                await requestWakeLock();
                
                // Start playback loop
                playSleepLoop();
            }
            
            async function playSleepLoop() {
                let currentIndex = 0;
                
                while (isSleepMode) {
                    // Check if 1 hour (3,600,000 ms) has passed
                    const elapsed = Date.now() - sleepModeStartTime;
                    const duration = 3600000;
                    
                    if (elapsed >= duration) {
                        stopSleepMode();
                        break;
                    }
                    
                    // Update progress bar
                    const percent = (elapsed / duration) * 100;
                    document.getElementById('sleepModeProgress').style.width = `${percent}%`;
                    
                    // If we reached the end of the shuffled list, reshuffle and restart index
                    if (currentIndex >= sleepModePhrases.length) {
                        shuffleArray(sleepModePhrases);
                        currentIndex = 0;
                    }
                    
                    const item = sleepModePhrases[currentIndex];
                    
                    // Update UI text
                    document.getElementById('sleepModePhraseEs').innerText = item.es;
                    document.getElementById('sleepModePhraseEn').innerText = item.en;
                    
                    // Play logic depending on target lang
                    if (targetLang === 'en') {
                        await new Promise(resolve => speak(item.es, 'es-ES', resolve));
                        await new Promise(resolve => setTimeout(resolve, 800));
                        if(!isSleepMode) break;
                        await new Promise(resolve => speak(item.en, 'en-US', resolve));
                    } else {
                        await new Promise(resolve => speak(item.en, 'en-US', resolve));
                        await new Promise(resolve => setTimeout(resolve, 800));
                        if(!isSleepMode) break;
                        await new Promise(resolve => speak(item.es, 'es-ES', resolve));
                    }
                    
                    if(!isSleepMode) break;
                    await new Promise(resolve => setTimeout(resolve, 1500)); // gap between phrases
                    currentIndex++;
                }
            }
            
            function stopSleepMode() {
                isSleepMode = false;
                window.speechSynthesis.cancel();
                releaseWakeLock();
                document.getElementById('sleepModeModal').style.display = 'none';
            }

            function speak(text, lang, callback) {
                window.speechSynthesis.cancel();
                const msg = new SpeechSynthesisUtterance(text.replace(/\|/g, '...'));
                msg.lang = lang;
                msg.rate = 0.9;
                if(callback) msg.onend = callback;
                window.speechSynthesis.speak(msg);
            }

            function closeModal() {
                isPlayingCategory = false;
                window.speechSynthesis.cancel();
                document.getElementById('categoryModal').style.display = 'none';
            }
        </script>
    </body>
</html>
