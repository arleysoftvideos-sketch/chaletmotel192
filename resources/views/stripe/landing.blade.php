<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tutorial TikTok Pro - Monetiza tu Contenido</title>

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
                        tiktokPink: '#FE2C55',
                        tiktokCyan: '#25F4EE',
                        darkBg: '#090115',
                        darkCard: '#120726',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #090115;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(254, 44, 85, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(37, 244, 238, 0.15) 0%, transparent 40%);
            background-attachment: fixed;
        }
        .glow-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .glow-button::after {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s;
        }
        .glow-button:hover::after {
            left: 100%;
        }
        .glow-button:hover {
            box-shadow: 0 0 25px rgba(254, 44, 85, 0.6);
            transform: scale(1.03);
        }
        .neon-border {
            box-shadow: 0 0 15px rgba(37, 244, 238, 0.2);
            border: 1px solid rgba(37, 244, 238, 0.3);
        }
        .neon-border-pink {
            box-shadow: 0 0 15px rgba(254, 44, 85, 0.2);
            border: 1px solid rgba(254, 44, 85, 0.3);
        }
    </style>
</head>
<body class="text-slate-100 font-sans min-h-screen flex flex-col justify-between selection:bg-tiktokPink selection:text-white antialiased">

    <!-- Top Info / Developer Warning -->
    @if(!$hasKeys)
        <div class="bg-yellow-500/10 border-b border-yellow-500/30 backdrop-blur-md sticky top-0 z-50 py-3 px-4">
            <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-yellow-300">
                <div class="flex items-center gap-2">
                    <span class="text-base">⚠️</span>
                    <p><strong>Modo Desarrollador:</strong> No se han detectado las claves de Stripe en el archivo <code>.env</code>.</p>
                </div>
                <div class="text-xs bg-yellow-500/20 px-3 py-1 rounded-full border border-yellow-500/30">
                    Añade <code>STRIPE_KEY</code> y <code>STRIPE_SECRET</code> en tu archivo de configuración para activar el botón.
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/20 border-b border-red-500/30 backdrop-blur-md sticky top-0 z-50 py-3 px-4 text-center text-red-200 text-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    <!-- Header Navigation -->
    <header class="w-full py-6 px-6 max-w-7xl mx-auto flex justify-between items-center relative z-10">
        <div class="flex items-center gap-2">
            <span class="text-2xl font-black font-outfit tracking-tighter bg-gradient-to-r from-tiktokCyan via-white to-tiktokPink bg-clip-text text-transparent">
                TIKTOK VIRAL LAB
            </span>
        </div>
        <div>
            <span class="text-xs bg-darkCard/80 border border-purple-950 px-3 py-1.5 rounded-full text-slate-400">
                ⚡ videotutorial premium
            </span>
        </div>
    </header>

    <!-- Main Content (Hero Section) -->
    <main class="max-w-7xl mx-auto px-6 py-8 sm:py-16 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10 flex-grow">
        
        <!-- Left Column: Copy / Sales pitch -->
        <div class="lg:col-span-7 flex flex-col space-y-6">
            <span class="w-fit text-xs font-bold uppercase tracking-widest bg-gradient-to-r from-tiktokPink to-tiktokCyan text-white px-3 py-1 rounded-md shadow-lg">
                oferta de lanzamiento limitada
            </span>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-outfit leading-tight tracking-tight text-white">
                Fórmula Viral: De <span class="text-tiktokCyan">Cero</span> a Monetizado en <span class="text-tiktokPink">TikTok</span>
            </h1>

            <p class="text-lg text-slate-300 leading-relaxed max-w-2xl">
                ¿Quieres cobrar por tu conocimiento y crear una comunidad viral en TikTok? En este videocurso intensivo de <strong>1 hora y 45 minutos</strong>, te enseño el mismo método paso a paso que yo uso para generar ingresos automáticos. Sin rodeos, directo a la práctica.
            </p>

            <!-- Key Features Badges -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div class="flex items-center gap-3 bg-darkCard/50 p-3 rounded-xl border border-purple-900/30">
                    <span class="text-2xl text-tiktokPink">🚀</span>
                    <span class="text-sm font-medium text-slate-200">Algoritmo hackeado: Hooks de 3s</span>
                </div>
                <div class="flex items-center gap-3 bg-darkCard/50 p-3 rounded-xl border border-purple-900/30">
                    <span class="text-2xl text-tiktokCyan">💵</span>
                    <span class="text-sm font-medium text-slate-200">Estrategias de monetización real</span>
                </div>
                <div class="flex items-center gap-3 bg-darkCard/50 p-3 rounded-xl border border-purple-900/30">
                    <span class="text-2xl text-tiktokPink">🎨</span>
                    <span class="text-sm font-medium text-slate-200">Edición ultra-rápida y viral</span>
                </div>
                <div class="flex items-center gap-3 bg-darkCard/50 p-3 rounded-xl border border-purple-900/30">
                    <span class="text-2xl text-tiktokCyan">📦</span>
                    <span class="text-sm font-medium text-slate-200">Material y plantillas descargables</span>
                </div>
            </div>

            <!-- Price & CTA -->
            <div class="bg-gradient-to-r from-tiktokPink/10 via-darkCard to-tiktokCyan/10 p-6 rounded-2xl border border-purple-900/40 mt-4 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400 line-through text-sm">$197 USD</span>
                        <span class="text-xs bg-tiktokPink/20 text-tiktokPink px-2 py-0.5 rounded font-bold">86% DESCUENTO</span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black font-outfit text-white flex items-baseline gap-1 mt-1">
                        $27 <span class="text-sm text-slate-300 font-normal">USD</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Pago único. Acceso de por vida.</p>
                </div>

                <div class="w-full sm:w-auto">
                    <form action="{{ route('tutorial.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                @if(!$hasKeys) disabled @endif
                                class="glow-button w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-tiktokPink to-purple-600 rounded-xl text-white font-extrabold text-lg flex items-center justify-center gap-2 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            Comprar Tutorial Ahora
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </form>
                    @if(!$hasKeys)
                        <p class="text-[10px] text-center text-yellow-400 mt-2">Configura tus claves .env para comprar</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Visual Mockup / Video Player Preview -->
        <div class="lg:col-span-5 flex justify-center">
            <div class="w-full max-w-md bg-darkCard/80 p-5 rounded-3xl border border-purple-900/60 shadow-2xl relative">
                <!-- Glowing effect in background -->
                <div class="absolute -inset-1 bg-gradient-to-r from-tiktokPink to-tiktokCyan rounded-3xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                
                <div class="relative bg-[#0b0617] rounded-2xl overflow-hidden shadow-inner">
                    <!-- Video Cover image placeholder style -->
                    <div class="h-64 sm:h-72 w-full bg-slate-900 flex flex-col justify-center items-center relative group cursor-pointer border-b border-purple-900/40">
                        <!-- Neon gradient background preview -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-tiktokPink/20 via-purple-900/30 to-tiktokCyan/20 z-0"></div>
                        
                        <!-- Floating TikTok Mock Icon -->
                        <div class="w-16 h-16 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 z-10 transition duration-300 transform group-hover:scale-110 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-tiktokPink">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs font-bold text-slate-300 tracking-wider z-10 group-hover:text-white uppercase transition-colors">
                            Ver Introducción (2 Min)
                        </span>

                        <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-md px-3 py-1 rounded-md text-[10px] font-semibold text-slate-300 z-10 border border-white/10">
                            ⏱️ 1h 45m de Contenido
                        </div>
                    </div>

                    <!-- Info text below video mockup -->
                    <div class="p-5 space-y-4">
                        <h3 class="font-outfit font-bold text-white text-lg leading-tight">
                            ¿Qué incluye este videocurso?
                        </h3>
                        <ul class="space-y-2.5 text-sm text-slate-300">
                            <li class="flex items-start gap-2.5">
                                <span class="text-tiktokCyan">✓</span>
                                <span>Clase completa en video HD (Acceso inmediato)</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-tiktokCyan">✓</span>
                                <span>Guía en PDF: Guiones Listos para Usar</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-tiktokCyan">✓</span>
                                <span>Plantilla de Excel para Analizar Métricas</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-tiktokCyan">✓</span>
                                <span>Acceso de por vida a futuras actualizaciones</span>
                            </li>
                        </ul>

                        <div class="pt-3 border-t border-purple-900/30 flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" alt="User 1" class="w-7 h-7 rounded-full border border-darkCard object-cover">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100" alt="User 2" class="w-7 h-7 rounded-full border border-darkCard object-cover">
                                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=100" alt="User 3" class="w-7 h-7 rounded-full border border-darkCard object-cover">
                            </div>
                            <span class="text-xs text-slate-400 font-medium">
                                Más de <strong class="text-slate-200">120 creadores</strong> ya lo compraron
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Testimonials Section -->
    <section class="w-full py-16 px-6 border-t border-purple-950 bg-darkCard/20">
        <div class="max-w-6xl mx-auto space-y-12">
            <div class="text-center space-y-2">
                <h2 class="text-3xl font-black font-outfit text-white">Casos de Éxito de Alumnos</h2>
                <p class="text-slate-400 text-sm max-w-md mx-auto">Mira lo que opinan creadores reales que ya aplicaron esta fórmula.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="bg-darkCard/40 p-6 rounded-2xl border border-purple-900/20 space-y-4">
                    <p class="text-sm text-slate-300 italic leading-relaxed">
                        "Llevaba 6 meses atascado en 1,000 seguidores en TikTok. Apliqué la regla de los 3 segundos del tutorial y en 2 semanas subí a 15,000 seguidores. ¡Y ya cerré mi primer patrocinio por $150!"
                    </p>
                    <div class="flex items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=100" alt="Carlos" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="text-xs font-bold text-white">Carlos M.</h4>
                            <span class="text-[10px] text-tiktokCyan">Creador Finanzas Personales</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-darkCard/40 p-6 rounded-2xl border border-purple-900/20 space-y-4">
                    <p class="text-sm text-slate-300 italic leading-relaxed">
                        "Compré el tutorial dudando si valía los $27. La explicación de cómo automatizar la pasarela de pagos vale 10 veces más. Monté mi tienda el fin de semana y ya vendí 4 copias de mi propio ebook."
                    </p>
                    <div class="flex items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="Laura" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="text-xs font-bold text-white">Laura G.</h4>
                            <span class="text-[10px] text-tiktokPink">Diseñadora de Modas</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-darkCard/40 p-6 rounded-2xl border border-purple-900/20 space-y-4">
                    <p class="text-sm text-slate-300 italic leading-relaxed">
                        "Las plantillas de guiones virales me ahorran horas de planeación. El video es súper claro y te da ideas exactas que funcionan. Si quieres tomártelo en serio en TikTok, esto es un regalo."
                    </p>
                    <div class="flex items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?auto=format&fit=crop&q=80&w=100" alt="Andrés" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="text-xs font-bold text-white">Andrés R.</h4>
                            <span class="text-[10px] text-tiktokCyan">Consultor de Marketing</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full py-8 border-t border-purple-950/60 bg-darkBg text-center text-xs text-slate-500 relative z-10">
        <div class="max-w-6xl mx-auto px-6 space-y-2">
            <p>© 2026 TikTok Viral Lab. Todos los derechos reservados.</p>
            <p class="text-[10px]">Stripe es una marca registrada de Stripe, Inc. Este sitio no está afiliado ni patrocinado por TikTok Inc.</p>
        </div>
    </footer>

</body>
</html>
