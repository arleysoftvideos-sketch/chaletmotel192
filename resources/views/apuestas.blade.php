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
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl w-full mx-auto px-6 py-8 flex-grow space-y-12 relative z-10">
        
        <!-- Hero Banner -->
        <section class="hero-banner w-full rounded-[2.5rem] border border-blue-950 p-8 sm:p-12 min-h-[280px] flex items-center shadow-2xl relative overflow-hidden">
            <div class="max-w-xl flex flex-col space-y-4 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="h-[1px] w-8 bg-gold"></span>
                    <span class="text-gold font-extrabold text-xs uppercase tracking-widest">
                        {{ __('Entretenimiento y Deportes') }}
                    </span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black font-outfit text-white uppercase tracking-tight">
                    {{ __('Apuestas') }} <span class="text-gold">{{ __('Deportivas') }}</span>
                </h1>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    {{ __('Consulta las mejores plataformas de apuestas deportivas de la región, calcula tus cuotas de forma instantánea y sigue tus partidos favoritos.') }}
                </p>
            </div>
        </section>

        <!-- World Cup 2026 Predictor Section -->
        <section class="bg-[#061021]/60 border border-blue-950 rounded-[2.5rem] p-6 sm:p-8 shadow-xl space-y-6">
            <div class="border-b border-blue-950 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black font-outfit text-white uppercase tracking-tight flex items-center gap-2">
                        <span>⚽</span> <span>{{ __('Polla Mundialista 2026') }}</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">
                        {{ __('Fase de Grupos (16 - 27 de junio). Ingresa tus pronósticos de marcador de cada partido y guárdalos.') }}
                    </p>
                </div>
                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <button type="button" onclick="clearAllPredictions()" class="px-4 py-2 border border-blue-950 hover:border-red-950 text-slate-400 hover:text-red-400 font-bold rounded-xl text-xs uppercase tracking-wider transition-all duration-300">
                        🗑️ {{ __('Borrar Todo') }}
                    </button>
                    <button type="button" onclick="saveAllPredictions()" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-[#061021] font-black rounded-xl text-xs uppercase tracking-wider transition-all duration-300 shadow-md shadow-emerald-500/10">
                        💾 {{ __('Guardar Marcadores') }}
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
        </section>

        <!-- Dynamic Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Side: Betting Portals & Matches (7 cols) -->
            <div class="lg:col-span-7 space-y-8">
                <!-- Recommended Bookmakers -->
                <div class="bg-[#061021]/60 border border-blue-950 rounded-[2rem] p-6 shadow-xl space-y-6">
                    <div class="border-b border-blue-950 pb-3 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-black font-outfit text-white tracking-tight uppercase">{{ __('Casas de Apuestas Recomendadas') }}</h3>
                            <p class="text-xs text-slate-400">{{ __('Enlaces rápidos a las principales plataformas con mejores cuotas.') }}</p>
                        </div>
                        <span class="text-xs bg-gold/10 text-gold px-3 py-1 rounded-full font-bold uppercase tracking-wider">{{ __('Plataformas') }}</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Card 1: Wplay.co -->
                        <a href="https://www.wplay.co" target="_blank" class="block bg-navy border border-blue-900/40 hover:border-gold/60 p-5 rounded-2xl transition-all duration-300 group hover:-translate-y-1">
                            <div class="flex justify-between items-start">
                                <span class="text-2xl group-hover:scale-110 transition-transform">⚽</span>
                                <span class="text-xs font-bold text-gold bg-gold/15 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Top 1</span>
                            </div>
                            <h4 class="text-white font-black font-outfit mt-3 text-base">Wplay.co</h4>
                            <p class="text-xs text-slate-400 mt-1">La primera casa de apuestas autorizada en Colombia. Amplia variedad de eventos deportivos.</p>
                            <span class="inline-block text-xs font-bold text-gold mt-4 hover:underline">Ir a Wplay ↗</span>
                        </a>

                        <!-- Card 2: Betplay -->
                        <a href="https://betplay.com.co" target="_blank" class="block bg-navy border border-blue-900/40 hover:border-gold/60 p-5 rounded-2xl transition-all duration-300 group hover:-translate-y-1">
                            <div class="flex justify-between items-start">
                                <span class="text-2xl group-hover:scale-110 transition-transform">🏀</span>
                                <span class="text-xs font-bold text-slate-400 bg-slate-800 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Popular</span>
                            </div>
                            <h4 class="text-white font-black font-outfit mt-3 text-base">Betplay</h4>
                            <p class="text-xs text-slate-400 mt-1">Líder nacional en patrocinio deportivo. Apuestas en vivo muy fluidas y seguras.</p>
                            <span class="inline-block text-xs font-bold text-gold mt-4 hover:underline">Ir a Betplay ↗</span>
                        </a>

                        <!-- Card 3: Rushbet -->
                        <a href="https://www.rushbet.co" target="_blank" class="block bg-navy border border-blue-900/40 hover:border-gold/60 p-5 rounded-2xl transition-all duration-300 group hover:-translate-y-1">
                            <div class="flex justify-between items-start">
                                <span class="text-2xl group-hover:scale-110 transition-transform">🥎</span>
                                <span class="text-xs font-bold text-slate-400 bg-slate-800 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Rápido</span>
                            </div>
                            <h4 class="text-white font-black font-outfit mt-3 text-base">Rushbet</h4>
                            <p class="text-xs text-slate-400 mt-1">Excelente programa de lealtad y retiros rápidos. Ideal para apuestas de fútbol internacional.</p>
                            <span class="inline-block text-xs font-bold text-gold mt-4 hover:underline">Ir a Rushbet ↗</span>
                        </a>

                        <!-- Card 4: Codere -->
                        <a href="https://www.codere.com.co" target="_blank" class="block bg-navy border border-blue-900/40 hover:border-gold/60 p-5 rounded-2xl transition-all duration-300 group hover:-translate-y-1">
                            <div class="flex justify-between items-start">
                                <span class="text-2xl group-hover:scale-110 transition-transform">🏎️</span>
                                <span class="text-xs font-bold text-slate-400 bg-slate-800 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Internacional</span>
                            </div>
                            <h4 class="text-white font-black font-outfit mt-3 text-base">Codere</h4>
                            <p class="text-xs text-slate-400 mt-1">Casa oficial de apuestas del Real Madrid. Excelente cobertura de ligas europeas.</p>
                            <span class="inline-block text-xs font-bold text-gold mt-4 hover:underline">Ir a Codere ↗</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Odds Calculator (5 cols) -->
            <div class="lg:col-span-5 space-y-8">
                <!-- Odds Converter & Profit Calculator -->
                <div class="bg-[#061021]/60 border border-blue-950 rounded-[2rem] p-6 shadow-xl space-y-6">
                    <div class="border-b border-blue-950 pb-3 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-black font-outfit text-white tracking-tight uppercase">{{ __('Calculadora de Apuestas') }}</h3>
                            <p class="text-xs text-slate-400">{{ __('Calcula tus ganancias estimadas según la cuota y el monto.') }}</p>
                        </div>
                        <span class="text-xs bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full font-bold uppercase tracking-wider">{{ __('Herramienta') }}</span>
                    </div>

                    <div class="space-y-4">
                        <!-- Odds Input -->
                        <div class="flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Cuota (Decimal)') }}</label>
                            <input type="number" id="calc-odds" step="0.01" min="1.01" value="1.85" oninput="calculateBets()" class="w-full bg-[#040a17] border border-blue-950 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-gold transition-all">
                        </div>

                        <!-- Stake Input -->
                        <div class="flex flex-col space-y-2">
                            <label class="text-slate-400 font-bold text-xs uppercase tracking-wider">{{ __('Monto a Apostar ($)') }}</label>
                            <input type="number" id="calc-stake" step="1000" min="100" value="10000" oninput="calculateBets()" class="w-full bg-[#040a17] border border-blue-950 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-gold transition-all">
                        </div>

                        <!-- Results Card -->
                        <div class="bg-navy border border-blue-950 rounded-2xl p-5 space-y-3">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400 font-semibold uppercase tracking-wider">{{ __('Retorno Total') }}</span>
                                <span id="bet-return" class="text-base font-black font-outfit text-white">$18.500</span>
                            </div>
                            <div class="flex justify-between items-center text-xs border-t border-blue-950/60 pt-3">
                                <span class="text-slate-400 font-semibold uppercase tracking-wider">{{ __('Ganancia Neta') }}</span>
                                <span id="bet-profit" class="text-lg font-black font-outfit text-emerald-400">$8.500</span>
                            </div>
                        </div>

                        <!-- Info banner -->
                        <div class="bg-blue-950/20 border border-blue-900/30 p-4 rounded-xl text-xs text-slate-300 leading-relaxed">
                            💡 <strong>{{ __('Consejo:') }}</strong> {{ __('Apuesta de manera responsable. Compara siempre las cuotas en diferentes casas antes de colocar tu apuesta para maximizar tu retorno potencial.') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Footer Copyright Bar -->
    <footer class="w-full bg-[#061021] py-6 border-t border-blue-950 text-center text-xs text-slate-500 mt-12">
        <p>&copy; {{ date('Y') }} Chalet Motel 192. {{ __('Todos los derechos reservados.') }}</p>
    </footer>

    <!-- Interactive script for calculator & WC predictor -->
    <script>
        const currentLang = "{{ app()->getLocale() }}";

        function calculateBets() {
            const odds = parseFloat(document.getElementById('calc-odds').value) || 0;
            const stake = parseFloat(document.getElementById('calc-stake').value) || 0;

            let payout = 0;
            let profit = 0;

            if (odds > 0 && stake > 0) {
                payout = stake * odds;
                profit = payout - stake;
            }

            document.getElementById('bet-return').textContent = '$' + payout.toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 2 });
            document.getElementById('bet-profit').textContent = '$' + profit.toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 2 });
        }

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

        let predictions = JSON.parse(localStorage.getItem('wc_2026_predictions')) || {};
        let activeDateTab = '16 Jun';

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

            filteredMatches.forEach(m => {
                const predKey1 = `m_${m.id}_t1`;
                const predKey2 = `m_${m.id}_t2`;
                const val1 = predictions[predKey1] !== undefined ? predictions[predKey1] : '';
                const val2 = predictions[predKey2] !== undefined ? predictions[predKey2] : '';

                const card = document.createElement('div');
                card.className = "bg-navy border border-blue-900/40 rounded-3xl p-5 flex flex-col justify-between space-y-4 hover:border-blue-800/60 transition-all duration-200";

                card.innerHTML = `
                    <div class="flex justify-between items-center text-[10px] text-slate-400 border-b border-blue-950/60 pb-2">
                        <span class="font-bold uppercase tracking-wider">🗓️ ${m.date}</span>
                        <span class="bg-blue-950/80 px-2 py-0.5 rounded font-black border border-blue-900/40">${currentLang === 'es' ? 'Grupo' : 'Group'} ${m.group}</span>
                    </div>

                    <div class="flex items-center justify-between gap-4 py-2">
                        <!-- Team 1 -->
                        <div class="flex items-center gap-2 w-[40%] min-w-0">
                            <span class="text-2xl shrink-0">${m.flag1}</span>
                            <span class="text-xs font-bold text-white tracking-wide truncate" title="${m.team1}">${m.team1}</span>
                        </div>

                        <!-- Score Input Fields -->
                        <div class="flex items-center gap-1.5 justify-center w-[20%] shrink-0">
                            <input type="number" id="pred-${m.id}-1" min="0" value="${val1}" oninput="updateTempPrediction(${m.id}, 1, this.value)" class="w-8 h-8 bg-[#040a17] border border-blue-950 rounded-lg text-center font-black text-xs text-gold focus:outline-none focus:border-gold transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <span class="text-slate-500 font-bold text-xs">-</span>
                            <input type="number" id="pred-${m.id}-2" min="0" value="${val2}" oninput="updateTempPrediction(${m.id}, 2, this.value)" class="w-8 h-8 bg-[#040a17] border border-blue-950 rounded-lg text-center font-black text-xs text-gold focus:outline-none focus:border-gold transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>

                        <!-- Team 2 -->
                        <div class="flex items-center gap-2 justify-end w-[40%] text-right min-w-0">
                            <span class="text-xs font-bold text-white tracking-wide truncate" title="${m.team2}">${m.team2}</span>
                            <span class="text-2xl shrink-0">${m.flag2}</span>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function updateTempPrediction(matchId, teamIndex, value) {
            const key = `m_${matchId}_t${teamIndex}`;
            if (value === '') {
                delete predictions[key];
            } else {
                predictions[key] = parseInt(value);
            }
        }

        function saveAllPredictions() {
            localStorage.setItem('wc_2026_predictions', JSON.stringify(predictions));
            alert(currentLang === 'es' ? '¡Predicciones guardadas con éxito!' : 'Predictions saved successfully!');
        }

        function clearAllPredictions() {
            if (confirm(currentLang === 'es' ? '¿Estás seguro de que deseas borrar todas tus predicciones?' : 'Are you sure you want to clear all your predictions?')) {
                predictions = {};
                localStorage.removeItem('wc_2026_predictions');
                renderPredictorMatches();
            }
        }

        // Run calculations & predictor load once on load
        window.addEventListener('DOMContentLoaded', () => {
            calculateBets();
            renderPredictorTabs();
            renderPredictorMatches();
        });
    </script>
</body>
</html>
