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
                    <img src="{{ asset('images/arlingo-logo.png') }}?v={{ time() }}" alt="Arlingo Mascot" class="w-24 h-24 mb-2 drop-shadow-[0_0_20px_rgba(57,255,20,0.4)] rounded-2xl">
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

                <button class="mode-card border-red-900/30 hover:border-red-500/50" onclick="alert('{{ __('Modo descanso próximamente...') }}')">
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

        <!-- ARLINGO JAVASCRIPT -->
        <script>
            const data = {
                "01. FRASES 🏆 MUNDIAL FIFA 2026": [
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
                "01. MUNDIAL FIFA 2026 🏆": [
                    { es: "¿Cuál es el marcador?", en: "What is the score?", pro: "uat is de es-kor" },
                    { es: "Estadio", en: "Stadium", pro: "estei-diom" }
                ],
                "ABECEDARIO 🔤": [
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
                "Animales y Naturaleza 🦁": [],
                "Casa y el Hogar 🏠": [],
                "Ciudad y Lugares 🏙️": [],
                "Clima y Estaciones ☁️": [],
                "Colores Básicos 🎨": [],
                "Compras y Dinero 💰": [],
                "Deportes ⚽": [],
                "Días y Tiempo ⏰": [],
                "Educación y Escuela 📚": [],
                "El Cuerpo Humano 🧠": [],
                "Emociones y Sentimientos 😊": [],
                "FRASES: Agencia de Viajes": [
                    { es: "Bienvenidos a Magic Travel.", en: "Welcome to Magic Travel.", pro: "guel-kam tu ma-yik tra-vel" }
                ],
                "FRASES: Cerrajería": [
                    { es: "Necesito cambiar la cerradura.", en: "I need to change the lock.", pro: "ai niid tu cheinch de lok" }
                ],
                "FRASES: Delivery & Instacart": [
                    { es: "Dejé el paquete en la puerta.", en: "I left the package at the door.", pro: "ai left de pa-kich at de door" }
                ],
                "FRASES: Publicidad & Ventas": [],
                "FRASES: Royal Prestige": [],
                "FRASES: Tienda de Ropa": [],
                "FRASES: Transportes y Viajes": [],
                "FRASES: Venta de Chorizos": [
                    { es: "Tenemos chorizos artesanales listos.", en: "We have artisan chorizos ready.", pro: "gui jaf ar-ti-san cho-ri-sos re-di" }
                ],
                "FRASES: Warehouse (Bodega)": [
                    { es: "Mueve este pallet al fondo.", en: "Move this pallet to the back.", pro: "muuv dis pa-let tu de bak" }
                ],
                "Familia y Relaciones 👨👩👧": [],
                "Farmacia 💊": [],
                "Horas y Tiempo ⏱️": [],
                "Meses y Fechas 📅": [],
                "Números Pro 🔥": [],
                "Oficina y Tecnología 💻": [],
                "Preguntas Básicas ❓": [],
                "Preposiciones y Ubicación 😵💫🌀": [],
                "Presentaciones Personales 👋": [],
                "Profesiones y Oficios 👷": [],
                "Ropa y Accesorios 🕶️": [],
                "Salud y Medicina 🏥": [],
                "Saludos y Despedidas ✨": [],
                "Salón de Belleza ✨": [],
                "Transportes y Viajes 🚀": [],
                "Verbos de Acción 🏃": []
            };

            let isPlayingCategory = false;
            let currentCategoryItems = [];
            
            let targetLang = localStorage.getItem('arlingo_targetLang') || "{{ app()->getLocale() }}";
            let currentScreen = localStorage.getItem('arlingo_currentScreen') || 'languageScreen';

            document.addEventListener('DOMContentLoaded', () => {
                showScreen(currentScreen, false);
            });

            const categoryTranslations = {
                "01. FRASES 🏆 MUNDIAL FIFA 2026": "{{ __('01. FRASES 🏆 MUNDIAL FIFA 2026') }}",
                "01. MUNDIAL FIFA 2026 🏆": "{{ __('01. MUNDIAL FIFA 2026 🏆') }}",
                "ABECEDARIO 🔤": "{{ __('ABECEDARIO 🔤') }}",
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
                "FRASES: Agencia de Viajes": "{{ __('FRASES: Agencia de Viajes') }}",
                "FRASES: Cerrajería": "{{ __('FRASES: Cerrajería') }}",
                "FRASES: Delivery & Instacart": "{{ __('FRASES: Delivery & Instacart') }}",
                "FRASES: Publicidad & Ventas": "{{ __('FRASES: Publicidad & Ventas') }}",
                "FRASES: Royal Prestige": "{{ __('FRASES: Royal Prestige') }}",
                "FRASES: Tienda de Ropa": "{{ __('FRASES: Tienda de Ropa') }}",
                "FRASES: Transportes y Viajes": "{{ __('FRASES: Transportes y Viajes') }}",
                "FRASES: Venta de Chorizos": "{{ __('FRASES: Venta de Chorizos') }}",
                "FRASES: Warehouse (Bodega)": "{{ __('FRASES: Warehouse (Bodega)') }}",
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
