<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chalet Motel 192 - {{ __('Apuestas Deportivas') }}</title>
    
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
        }
        .hero-banner {
            background-image: linear-gradient(to right, rgba(6, 16, 33, 0.98) 25%, rgba(6, 16, 33, 0.7) 60%, rgba(6, 16, 33, 0.2) 100%), url('https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=1200&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-[#040a17] text-slate-100 antialiased min-h-screen flex flex-col justify-between selection:bg-gold selection:text-navy">

    <!-- Navigation Header -->
    <header class="w-full bg-[#061021]/80 backdrop-blur-md sticky top-0 border-b border-blue-950 relative z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🏆</span>
                <span class="font-outfit font-black text-lg tracking-wider text-white uppercase">Chalet Motel <span class="text-gold">Bets</span></span>
            </div>
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
                    <a href="/recycling" class="px-4 py-2 text-slate-300 hover:text-emerald-400 font-semibold transition-all duration-300 text-sm">
                        {{ __('Reciclaje') }}
                    </a>
                </nav>
            </div>
    </header>
    <!-- Main Container -->
    <main class="max-w-7xl w-full mx-auto px-6 py-8 flex-grow space-y-12 relative z-10">
        
        <!-- Hero Banner -->
        <section class="hero-banner w-full rounded-[2.5rem] border border-blue-950 p-8 sm:p-12 min-h-[260px] flex items-center shadow-2xl relative overflow-hidden">
            <div class="max-w-xl flex flex-col space-y-4 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="h-[1px] w-8 bg-gold"></span>
                    <span class="text-gold font-extrabold text-xs uppercase tracking-widest">
                        {{ __('Entretenimiento y Deportes') }}
                    </span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black font-outfit text-white uppercase tracking-tight">
                    {{ __('Polla') }} <span class="text-gold">{{ __('Mundialista 2026') }}</span>
                </h1>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    {{ __('Registra los marcadores reales de la Fase de Grupos y los pronósticos de Pitufina, Tita, Chumilo y Precioso. ¡El ranking se calculará automáticamente en tiempo real!') }}
                </p>
            </div>
        </section>

        <!-- Main Tournament Layout (Two Columns) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Matches Predictor Grid (8 cols) -->
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-[#061021]/60 border border-blue-950 rounded-[2.5rem] p-6 sm:p-8 shadow-xl space-y-6">
                    <div class="border-b border-blue-950 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-black font-outfit text-white uppercase tracking-tight flex items-center gap-2">
                                <span>⚽</span> <span>{{ __('Partidos de Fase de Grupos') }}</span>
                            </h2>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ __('16 - 27 de Junio. Selecciona un día o "Ver Todos".') }}
                            </p>
                        </div>
                        <!-- Actions -->
                        <div class="flex items-center gap-2 shrink-0 font-outfit">
                            <button type="button" onclick="clearAllPredictions()" class="px-3 py-2 border border-blue-950 hover:border-red-955 text-slate-400 hover:text-red-400 font-bold rounded-xl text-[10px] uppercase tracking-wider transition-all duration-300">
                                🗑️ {{ __('Borrar') }}
                            </button>
                            <button type="button" onclick="saveAllPredictions()" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-[#061021] font-black rounded-xl text-[10px] uppercase tracking-wider transition-all duration-300 shadow-md shadow-emerald-500/10">
                                💾 {{ __('Guardar') }}
                            </button>
                        </div>
                    </div>

                    <!-- Date Selector Tabs -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-blue-950/45 no-scrollbar">
                        <div id="predictor-tabs" class="flex gap-2"></div>
                    </div>

                    <!-- Matches Prediction Grid -->
                    <div id="predictor-matches" class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                        <!-- Dynamic match cards go here -->
                    </div>
                </div>
            </div>

            <!-- Right Column: Standings / Leaderboard (4 cols) - Sticky -->
            <div class="lg:col-span-4 lg:sticky lg:top-24 space-y-6">
                <!-- Leaderboard Card -->
                <div class="bg-[#061021]/60 border border-blue-950 rounded-[2.5rem] p-6 shadow-xl space-y-6">
                    <div class="border-b border-blue-950 pb-3 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-black font-outfit text-white tracking-tight uppercase">{{ __('Tabla de Posiciones') }}</h3>
                            <p class="text-xs text-slate-400">{{ __('Ranking oficial del grupo de predicciones') }}</p>
                        </div>
                        <span class="text-xs bg-gold/10 text-gold px-3 py-1 rounded-full font-bold uppercase tracking-wider">{{ __('Polla') }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-blue-950/20 border-b border-blue-950 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                    <th class="px-4 py-3 font-bold">{{ __('Participante') }}</th>
                                    <th class="px-4 py-3 font-bold text-center" title="{{ __('Partidos Jugados (con resultado cargado)') }}">{{ __('PJ') }}</th>
                                    <th class="px-4 py-3 font-bold text-center" title="{{ __('Marcadores Exactos Adivinados (3 pts)') }}">{{ __('EX') }}</th>
                                    <th class="px-4 py-3 font-bold text-center" title="{{ __('Resultados Adivinados sin marcador exacto (1 pt)') }}">{{ __('RE') }}</th>
                                    <th class="px-4 py-3 font-bold text-right">{{ __('Pts') }}</th>
                                </tr>
                            </thead>
                            <tbody id="leaderboard-body" class="divide-y divide-blue-950/40 text-slate-300 font-medium">
                                <!-- Dynamic leaderboard rows populated by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Points Rule Explainer -->
                    <div class="bg-blue-950/20 border border-blue-900/30 p-4 rounded-xl text-[10px] text-slate-400 space-y-1.5 leading-relaxed">
                        <span class="font-bold text-slate-200 uppercase tracking-wider block">📏 Reglas de Puntuación:</span>
                        <p>🎯 <strong>3 Puntos (EX):</strong> Adivinar el marcador exacto (ej. pronóstico 2-1, resultado 2-1).</p>
                        <p>🔮 <strong>1 Punto (RE):</strong> Adivinar el ganador o empate pero no el marcador exacto (ej. pronóstico 2-1, resultado 3-1).</p>
                        <p>❌ <strong>0 Puntos:</strong> No acertar el resultado o falta de pronóstico.</p>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Footer Copyright Bar -->
    <footer class="w-full bg-[#061021] py-6 border-t border-blue-950 text-center text-xs text-slate-500 mt-12">
        <p>&copy; {{ date('Y') }} Chalet Motel 192. {{ __('Todos los derechos reservados.') }}</p>
    </footer>

    <!-- Interactive script for WC predictor -->
    <script>
        const currentLang = "{{ app()->getLocale() }}";

        // --- WORLD CUP 2026 PREDICTOR LOGIC ---
        const matches = [
            { id: 1, date: "16 Jun", team1: "Argentina", flag1: "🇦🇷", team2: "Argelia", flag2: "🇩🇿", group: "J" },
            { id: 2, date: "16 Jun", team1: "Austria", flag1: "🇦🇹", team2: "Jordania", flag2: "🇯🇴", group: "J" },
            { id: 3, date: "17 Jun", team1: "Portugal", flag1: "🇵🇹", team2: "RD Congo", flag2: "🇨🇩", group: "K" },
            { id: 4, date: "17 Jun", team1: "Inglaterra", flag1: "🏴\u200d󠁢󠁥󠁮󠁧󠁿", team2: "Croacia", flag2: "🇭🇷", group: "L" },
            { id: 5, date: "17 Jun", team1: "Ghana", flag1: "🇬🇭", team2: "Panamá", flag2: "🇵🇦", group: "L" },
            { id: 6, date: "17 Jun", team1: "Uzbekistán", flag1: "🇺🇿", team2: "Colombia", flag2: "🇨🇴", group: "K" },
            { id: 7, date: "18 Jun", team1: "Rep. Checa", flag1: "🇨🇿", team2: "Sudáfrica", flag2: "🇿🇦", group: "A" },
            { id: 8, date: "18 Jun", team1: "Suiza", flag1: "🇨🇭", team2: "Bosnia", flag2: "🇧🇦", group: "B" },
            { id: 9, date: "18 Jun", team1: "Canadá", flag1: "🇨🇦", team2: "Catar", flag2: "🇶🇦", group: "B" },
            { id: 10, date: "18 Jun", team1: "México", flag1: "🇲🇽", team2: "Rep. de Corea", flag2: "🇰🇷", group: "A" },
            { id: 11, date: "19 Jun", team1: "Escocia", flag1: "🏴\u200d󠁢󠁳󠁣󠁴󠁿", team2: "Nueva Zelanda", flag2: "🇳🇿", group: "C" },
            { id: 12, date: "19 Jun", team1: "España", flag1: "🇪🇸", team2: "Japón", flag2: "🇯🇵", group: "D" },
            { id: 13, date: "19 Jun", team1: "Chile", flag1: "🇨🇱", team2: "Camerún", flag2: "🇨🇲", group: "C" },
            { id: 14, date: "19 Jun", team1: "EE. UU.", flag1: "🇺🇸", team2: "Marruecos", flag2: "🇲🇦", group: "D" },
            { id: 15, date: "20 Jun", team1: "Italia", flag1: "🇮🇹", team2: "Nigeria", flag2: "🇳🇬", group: "E" },
            { id: 16, date: "20 Jun", team1: "Dinamarca", flag1: "🇩🇰", team2: "Irán", flag2: "🇮🇷", group: "F" },
            { id: 17, date: "20 Jun", team1: "Ecuador", flag1: "🇪🇨", team2: "Costa de Marfil", flag2: "🇨🇮", group: "E" },
            { id: 18, date: "20 Jun", team1: "Bélgica", flag1: "🇧🇪", team2: "Paraguay", flag2: "🇵🇾", group: "F" },
            { id: 19, date: "21 Jun", team1: "Países Bajos", flag1: "🇳🇱", team2: "Australia", flag2: "🇦🇺", group: "G" },
            { id: 20, date: "21 Jun", team1: "Brasil", flag1: "🇧🇷", team2: "Arabia Saudita", flag2: "🇸🇦", group: "H" },
            { id: 21, date: "21 Jun", team1: "Alemania", flag1: "🇩🇪", team2: "Honduras", flag2: "🇭🇳", group: "G" },
            { id: 22, date: "21 Jun", team1: "Uruguay", flag1: "🇺🇾", team2: "EE. UU.", flag2: "🇺🇸", group: "H" },
            { id: 23, date: "22 Jun", team1: "Sudáfrica", flag1: "🇿🇦", team2: "México", flag2: "🇲🇽", group: "A" },
            { id: 24, date: "22 Jun", team1: "Rep. de Corea", flag1: "🇰🇷", team2: "Rep. Checa", flag2: "🇨🇿", group: "A" },
            { id: 25, date: "22 Jun", team1: "Bosnia", flag1: "🇧🇦", team2: "Canadá", flag2: "🇨🇦", group: "B" },
            { id: 26, date: "22 Jun", team1: "Catar", flag1: "🇶🇦", team2: "Suiza", flag2: "🇨🇭", group: "B" },
            { id: 27, date: "23 Jun", team1: "Nueva Zelanda", flag1: "🇳🇿", team2: "Chile", flag2: "🇨🇱", group: "C" },
            { id: 28, date: "23 Jun", team1: "Camerún", flag1: "🇨🇲", team2: "Escocia", flag2: "🏴\u200d󠁢󠁳󠁣󠁴󠁿", group: "C" },
            { id: 29, date: "23 Jun", team1: "Japón", flag1: "🇯🇵", team2: "EE. UU.", flag2: "🇺🇸", group: "D" },
            { id: 30, date: "23 Jun", team1: "Marruecos", flag1: "🇲🇦", team2: "España", flag2: "🇪🇸", group: "D" },
            { id: 31, date: "24 Jun", team1: "Nigeria", flag1: "🇳🇬", team2: "Ecuador", flag2: "🇪🇨", group: "E" },
            { id: 32, date: "24 Jun", team1: "Costa de Marfil", flag1: "🇨🇮", team2: "Italia", flag2: "🇮🇹", group: "E" },
            { id: 33, date: "24 Jun", team1: "Irán", flag1: "🇮🇷", team2: "Bélgica", flag2: "🇧🇪", group: "F" },
            { id: 34, date: "24 Jun", team1: "Paraguay", flag1: "🇵🇾", team2: "Dinamarca", flag2: "🇩🇰", group: "F" },
            { id: 35, date: "25 Jun", team1: "Australia", flag1: "🇦🇺", team2: "Alemania", flag2: "🇩🇪", group: "G" },
            { id: 36, date: "25 Jun", team1: "Honduras", flag1: "🇭🇳", team2: "Países Bajos", flag2: "🇳🇱", group: "G" },
            { id: 37, date: "25 Jun", team1: "Arabia Saudita", flag1: "🇸🇦", team2: "Uruguay", flag2: "🇺🇾", group: "H" },
            { id: 38, date: "25 Jun", team1: "EE. UU.", flag1: "🇺🇸", team2: "Brasil", flag2: "🇧🇷", group: "H" },
            { id: 39, date: "26 Jun", team1: "Argelia", flag1: "🇩🇿", team2: "Austria", flag2: "🇦🇹", group: "J" },
            { id: 40, date: "26 Jun", team1: "Jordania", flag1: "🇯🇴", team2: "Argentina", flag2: "🇦🇷", group: "J" },
            { id: 41, date: "26 Jun", team1: "RD Congo", flag1: "🇨🇩", team2: "Uzbekistán", flag2: "🇺🇿", group: "K" },
            { id: 42, date: "26 Jun", team1: "Colombia", flag1: "🇨🇴", team2: "Portugal", flag2: "🇵🇹", group: "K" },
            { id: 43, date: "27 Jun", team1: "Croacia", flag1: "🇭🇷", team2: "Ghana", flag2: "🇬🇭", group: "L" },
            { id: 44, date: "27 Jun", team1: "Panamá", flag1: "🇵🇦", team2: "Inglaterra", flag2: "🏴\u200d󠁢󠁥󠁮󠁧󠁿", group: "L" }
        ];

        let tournamentData = JSON.parse(localStorage.getItem('wc_2026_tournament')) || {
            realResults: {},
            predictions: {}
        };

        let activeDateTab = '16 Jun';

        function calculatePoints(real, pred) {
            if (!real || real[0] === null || real[1] === null || real[0] === undefined || real[1] === undefined || real[0] === '' || real[1] === '') {
                return { pts: 0, status: 'pending' };
            }
            const r1 = parseInt(real[0]);
            const r2 = parseInt(real[1]);
            
            if (isNaN(r1) || isNaN(r2)) {
                return { pts: 0, status: 'pending' };
            }

            if (!pred || pred[0] === null || pred[1] === null || pred[0] === undefined || pred[1] === undefined || pred[0] === '' || pred[1] === '') {
                return { pts: 0, status: 'missing' };
            }
            const p1 = parseInt(pred[0]);
            const p2 = parseInt(pred[1]);
            
            if (isNaN(p1) || isNaN(p2)) {
                return { pts: 0, status: 'missing' };
            }

            // Guess exact score
            if (r1 === p1 && r2 === p2) {
                return { pts: 3, status: 'exact' };
            }

            // Guess correct outcome
            const realWinner = r1 > r2 ? 1 : (r1 < r2 ? 2 : 0);
            const predWinner = p1 > p2 ? 1 : (p1 < p2 ? 2 : 0);

            if (realWinner === predWinner) {
                return { pts: 1, status: 'outcome' };
            }

            return { pts: 0, status: 'wrong' };
        }

        function renderPredictorTabs() {
            const tabsContainer = document.getElementById('predictor-tabs');
            tabsContainer.innerHTML = '';

            const uniqueDates = [...new Set(matches.map(m => m.date))];
            
            // "Ver Todos" Tab
            const allBtn = document.createElement('button');
            allBtn.type = 'button';
            allBtn.className = `px-3.5 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-200 shrink-0 ${activeDateTab === 'all' ? 'bg-gold text-[#061021]' : 'bg-navy border border-blue-900/40 text-slate-400 hover:text-white'}`;
            allBtn.textContent = currentLang === 'es' ? 'Ver Todos' : 'Show All';
            allBtn.onclick = () => {
                activeDateTab = 'all';
                renderPredictorTabs();
                renderPredictorMatches();
            };
            tabsContainer.appendChild(allBtn);

            uniqueDates.forEach(date => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `px-3.5 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-200 shrink-0 ${activeDateTab === date ? 'bg-gold text-[#061021]' : 'bg-navy border border-blue-900/40 text-slate-400 hover:text-white'}`;
                btn.textContent = date;
                btn.onclick = () => {
                    activeDateTab = date;
                    renderPredictorTabs();
                    renderPredictorMatches();
                };
                tabsContainer.appendChild(btn);
            });
        }

        function renderPredictorMatches() {
            const container = document.getElementById('predictor-matches');
            container.innerHTML = '';

            const filteredMatches = activeDateTab === 'all' 
                ? matches 
                : matches.filter(m => m.date === activeDateTab);

            const participants = ['Pitufina', 'Tita', 'Chumilo', 'Precioso'];

            filteredMatches.forEach(m => {
                const real = tournamentData.realResults[m.id] || ['', ''];
                
                const card = document.createElement('div');
                card.className = "bg-navy border border-blue-900/40 rounded-3xl p-5 flex flex-col justify-between space-y-4 hover:border-blue-800/60 transition-all duration-200";

                let rowsHtml = '';
                participants.forEach(p => {
                    const pred = (tournamentData.predictions[m.id] && tournamentData.predictions[m.id][p]) || ['', ''];
                    const res = calculatePoints(real, pred);
                    
                    let badgeClass = 'text-slate-400 bg-slate-900/60 border border-slate-900/60';
                    let badgeText = '0';
                    
                    if (res.status === 'exact') {
                        badgeClass = 'text-gold bg-gold/15 border border-gold/30 font-black';
                        badgeText = '+3';
                    } else if (res.status === 'outcome') {
                        badgeClass = 'text-emerald-400 bg-emerald-950/40 border border-emerald-900/40 font-bold';
                        badgeText = '+1';
                    } else if (res.status === 'wrong') {
                        badgeClass = 'text-red-400 bg-red-900/40 border border-red-900/40 font-bold';
                        badgeText = '0';
                    } else if (res.status === 'missing') {
                        badgeClass = 'text-slate-500 bg-slate-900/20 font-normal border border-transparent';
                        badgeText = '-';
                    }

                    const pEmoji = p === 'Pitufina' || p === 'Tita' ? '👩' : '👦';

                    rowsHtml += `
                        <div class="grid grid-cols-12 gap-1 items-center hover:bg-blue-950/20 rounded-xl p-1 text-center">
                            <div class="col-span-5 text-left font-bold text-slate-300 truncate">${pEmoji} ${p}</div>
                            <div class="col-span-5 flex items-center justify-center gap-1">
                                <input type="number" min="0" placeholder="-" value="${pred[0]}" oninput="updatePredictionScore(${m.id}, '${p}', 0, this.value)" class="w-8 h-7 bg-[#040a17] border border-blue-950 rounded text-center font-bold text-white text-xs focus:outline-none focus:border-gold transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <span class="text-slate-500 font-bold text-[10px]">-</span>
                                <input type="number" min="0" placeholder="-" value="${pred[1]}" oninput="updatePredictionScore(${m.id}, '${p}', 1, this.value)" class="w-8 h-7 bg-[#040a17] border border-blue-950 rounded text-center font-bold text-white text-xs focus:outline-none focus:border-gold transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            <div class="col-span-2"><span class="px-1.5 py-0.5 rounded text-[10px] ${badgeClass}">${badgeText}</span></div>
                        </div>
                    `;
                });

                card.innerHTML = `
                    <div class="flex justify-between items-center text-[10px] text-slate-400 border-b border-blue-950/60 pb-2">
                        <span class="font-bold uppercase tracking-wider">🗓️ ${m.date}</span>
                        <span class="bg-blue-950/80 px-2 py-0.5 rounded font-black border border-blue-900/40">${currentLang === 'es' ? 'Grupo' : 'Group'} ${m.group}</span>
                    </div>

                    <div class="flex items-center justify-between gap-4 py-1.5 border-b border-blue-950/40 pb-2.5">
                        <!-- Team 1 -->
                        <div class="flex items-center gap-2 w-[45%] min-w-0">
                            <span class="text-2xl shrink-0">${m.flag1}</span>
                            <span class="text-xs font-black text-white tracking-wide truncate" title="${m.team1}">${m.team1}</span>
                        </div>

                        <div class="text-slate-500 font-black text-xs shrink-0">VS</div>

                        <!-- Team 2 -->
                        <div class="flex items-center gap-2 justify-end w-[45%] text-right min-w-0">
                            <span class="text-xs font-black text-white tracking-wide truncate" title="${m.team2}">${m.team2}</span>
                            <span class="text-2xl shrink-0">${m.flag2}</span>
                        </div>
                    </div>

                    <div class="space-y-1.5 text-xs">
                        <div class="grid grid-cols-12 gap-1 text-[9px] text-slate-500 font-black uppercase tracking-wider text-center">
                            <div class="col-span-5 text-left">${currentLang === 'es' ? 'Participante' : 'Participant'}</div>
                            <div class="col-span-5">${currentLang === 'es' ? 'Pronóstico' : 'Prediction'}</div>
                            <div class="col-span-2">Pts</div>
                        </div>

                        <!-- Real Result Row -->
                        <div class="grid grid-cols-12 gap-1 items-center bg-gold/10 border border-gold/25 rounded-xl p-1.5 text-center">
                            <div class="col-span-5 text-left font-black text-gold flex items-center gap-1">
                                <span>⭐</span> <span class="truncate">${currentLang === 'es' ? 'Resultado Real' : 'Real Result'}</span>
                            </div>
                            <div class="col-span-5 flex items-center justify-center gap-1">
                                <input type="number" min="0" placeholder="-" value="${real[0]}" oninput="updateRealScore(${m.id}, 0, this.value)" class="w-8 h-7 bg-[#040a17] border border-gold/45 rounded text-center font-black text-gold text-xs focus:outline-none focus:border-gold transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <span class="text-gold font-bold text-[10px]">-</span>
                                <input type="number" min="0" placeholder="-" value="${real[1]}" oninput="updateRealScore(${m.id}, 1, this.value)" class="w-8 h-7 bg-[#040a17] border border-gold/45 rounded text-center font-black text-gold text-xs focus:outline-none focus:border-gold transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            <div class="col-span-2 font-black text-gold">-</div>
                        </div>

                        <!-- Participants rows -->
                        ${rowsHtml}
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function updateRealScore(matchId, scoreIndex, value) {
            if (!tournamentData.realResults[matchId]) {
                tournamentData.realResults[matchId] = [null, null];
            }
            if (value === '') {
                tournamentData.realResults[matchId][scoreIndex] = null;
            } else {
                tournamentData.realResults[matchId][scoreIndex] = parseInt(value);
            }
            renderLeaderboard();
        }

        // Auto-save predictions in memory
        function updatePredictionScore(matchId, participant, scoreIndex, value) {
            if (!tournamentData.predictions[matchId]) {
                tournamentData.predictions[matchId] = {};
            }
            if (!tournamentData.predictions[matchId][participant]) {
                tournamentData.predictions[matchId][participant] = [null, null];
            }
            if (value === '') {
                tournamentData.predictions[matchId][participant][scoreIndex] = null;
            } else {
                tournamentData.predictions[matchId][participant][scoreIndex] = parseInt(value);
            }
            renderLeaderboard();
        }

        function renderLeaderboard() {
            const participants = ['Pitufina', 'Tita', 'Chumilo', 'Precioso'];
            const standings = participants.map(p => {
                return {
                    name: p,
                    emoji: p === 'Pitufina' || p === 'Tita' ? '👩' : '👦',
                    points: 0,
                    exact: 0,
                    outcome: 0,
                    played: 0
                };
            });

            matches.forEach(m => {
                const real = tournamentData.realResults[m.id];
                
                participants.forEach(p => {
                    const pred = tournamentData.predictions[m.id] ? tournamentData.predictions[m.id][p] : null;
                    const res = calculatePoints(real, pred);
                    
                    const standObj = standings.find(s => s.name === p);
                    if (res.status !== 'pending' && res.status !== 'missing') {
                        standObj.points += res.pts;
                        standObj.played++;
                        if (res.pts === 3) standObj.exact++;
                        else if (res.pts === 1) standObj.outcome++;
                    }
                });
            });

            standings.sort((a, b) => {
                if (b.points !== a.points) return b.points - a.points;
                if (b.exact !== a.exact) return b.exact - a.exact;
                if (b.outcome !== a.outcome) return b.outcome - a.outcome;
                return a.name.localeCompare(b.name);
            });

            const leaderboardBody = document.getElementById('leaderboard-body');
            leaderboardBody.innerHTML = '';

            standings.forEach((s, idx) => {
                const tr = document.createElement('tr');
                tr.className = "hover:bg-blue-950/20 transition-colors border-b border-blue-950/40 text-xs";
                
                let rankEmoji = '🔹';
                if (idx === 0) rankEmoji = '🥇';
                else if (idx === 1) rankEmoji = '🥈';
                else if (idx === 2) rankEmoji = '🥉';

                tr.innerHTML = `
                    <td class="px-4 py-3 font-black text-slate-300 flex items-center gap-1.5">
                        <span>${rankEmoji}</span>
                        <span>${s.emoji} ${s.name}</span>
                    </td>
                    <td class="px-4 py-3 text-center text-slate-400 font-bold">${s.played}</td>
                    <td class="px-4 py-3 text-center text-emerald-400 font-bold">${s.exact}</td>
                    <td class="px-4 py-3 text-center text-blue-400 font-bold">${s.outcome}</td>
                    <td class="px-4 py-3 text-right text-gold font-black text-sm">${s.points}</td>
                `;
                leaderboardBody.appendChild(tr);
            });
        }

        function saveAllPredictions() {
            localStorage.setItem('wc_2026_tournament', JSON.stringify(tournamentData));
            renderPredictorMatches();
            renderLeaderboard();
            alert(currentLang === 'es' ? '¡Datos y pronósticos guardados con éxito!' : 'Data and predictions saved successfully!');
        }

        function clearAllPredictions() {
            if (confirm(currentLang === 'es' ? '¿Estás seguro de que deseas borrar todos los marcadores y pronósticos?' : 'Are you sure you want to clear all scores and predictions?')) {
                tournamentData = { realResults: {}, predictions: {} };
                localStorage.removeItem('wc_2026_tournament');
                renderPredictorMatches();
                renderLeaderboard();
            }
        }

        // Initialize Page
        window.addEventListener('DOMContentLoaded', () => {
            renderPredictorTabs();
            renderPredictorMatches();
            renderLeaderboard();
        });
    </script>
</body>
</html>
