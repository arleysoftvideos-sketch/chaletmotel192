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

    <!-- Interactive script for calculator -->
    <script>
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

        // Run calculation once on load
        window.addEventListener('DOMContentLoaded', calculateBets);
    </script>
</body>
</html>
