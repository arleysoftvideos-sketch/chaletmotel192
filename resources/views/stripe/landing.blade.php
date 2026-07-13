<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fórmula POV: Grabación para Entrenamiento de Robots e IA</title>

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
                        neonGreen: '#39FF14',
                        neonBlue: '#00F0FF',
                        darkBg: '#050B14',
                        darkCard: '#0D1B2A',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #050B14;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(0, 240, 255, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(57, 255, 20, 0.1) 0%, transparent 40%);
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
            box-shadow: 0 0 25px rgba(0, 240, 255, 0.6);
            transform: scale(1.03);
        }
        .neon-border {
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.2);
            border: 1px solid rgba(0, 240, 255, 0.3);
        }
    </style>
</head>
<body class="text-slate-100 font-sans min-h-screen flex flex-col justify-between selection:bg-neonBlue selection:text-black antialiased">

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
            <span class="text-2xl font-black font-outfit tracking-tighter bg-gradient-to-r from-neonBlue via-white to-neonGreen bg-clip-text text-transparent">
                POV ROBOTICS ACADEMY
            </span>
        </div>
        <div>
            <span class="text-xs bg-darkCard/80 border border-blue-950 px-3 py-1.5 rounded-full text-slate-400">
                🤖 Inteligencia Artificial & Robótica
            </span>
        </div>
    </header>

    <!-- Main Content (Hero Section) -->
    <main class="max-w-7xl mx-auto px-6 py-8 sm:py-16 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10 flex-grow">
        
        <!-- Left Column: Copy / Sales pitch -->
        <div class="lg:col-span-7 flex flex-col space-y-6">
            <span class="w-fit text-xs font-bold uppercase tracking-widest bg-gradient-to-r from-neonBlue to-neonGreen text-black px-3 py-1 rounded-md shadow-lg font-outfit">
                nicho de alta demanda
            </span>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-outfit leading-tight tracking-tight text-white">
                Fórmula POV: Gana dinero grabando <span class="text-neonBlue">tareas del hogar</span> para entrenar <span class="text-neonGreen">Robots e IA</span>
            </h1>

            <p class="text-lg text-slate-300 leading-relaxed max-w-2xl">
                Las grandes empresas tecnológicas necesitan millones de horas de video en primera persona (POV) arreglando la casa, doblando ropa, limpiando u organizando para entrenar a la próxima generación de robots del hogar. En este videocurso de <strong>1h 45m</strong>, aprenderás los estándares técnicos exactos para grabar y comercializar tus videos.
            </p>

            <!-- Key Features Badges -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div class="flex items-center gap-3 bg-darkCard/50 p-3 rounded-xl border border-blue-900/30">
                    <span class="text-2xl">📹</span>
                    <span class="text-sm font-medium text-slate-200">Requisitos Técnicos (Ángulos, Iluminación y FPS)</span>
                </div>
                <div class="flex items-center gap-3 bg-darkCard/50 p-3 rounded-xl border border-blue-900/30">
                    <span class="text-2xl">🏠</span>
                    <span class="text-sm font-medium text-slate-200">Guía de Tareas del Hogar más demandadas</span>
                </div>
                <div class="flex items-center gap-3 bg-darkCard/50 p-3 rounded-xl border border-blue-900/30">
                    <span class="text-2xl">💼</span>
                    <span class="text-sm font-medium text-slate-200">Directorio de Plataformas que compran datasets</span>
                </div>
                <div class="flex items-center gap-3 bg-darkCard/50 p-3 rounded-xl border border-blue-900/30">
                    <span class="text-2xl">📄</span>
                    <span class="text-sm font-medium text-slate-200">Plantilla de Licencias y Derechos de Autor</span>
                </div>
            </div>

            <!-- Price & CTA -->
            <div class="bg-gradient-to-r from-neonBlue/10 via-darkCard to-neonGreen/10 p-6 rounded-2xl border border-blue-900/40 mt-4 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400 line-through text-sm">$149 USD</span>
                        <span class="text-xs bg-neonBlue/20 text-neonBlue px-2 py-0.5 rounded font-bold">81% DESCUENTO</span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black font-outfit text-white flex items-baseline gap-1 mt-1">
                        $27 <span class="text-sm text-slate-300 font-normal">USD</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Pago único. Acceso de por vida a futuras actualizaciones.</p>
                </div>

                <div class="w-full sm:w-auto">
                    <form action="{{ route('tutorial.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                @if(!$hasKeys) disabled @endif
                                class="glow-button w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-neonBlue to-blue-700 rounded-xl text-black font-black text-lg flex items-center justify-center gap-2 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            Adquirir Tutorial Ahora
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
            <div class="w-full max-w-md bg-darkCard/80 p-5 rounded-3xl border border-blue-900/60 shadow-2xl relative">
                <!-- Glowing effect in background -->
                <div class="absolute -inset-1 bg-gradient-to-r from-neonBlue to-neonGreen rounded-3xl blur opacity-25"></div>
                
                <div class="relative bg-[#020712] rounded-2xl overflow-hidden shadow-inner">
                    <!-- Video Cover image placeholder style -->
                    <div class="h-64 sm:h-72 w-full bg-slate-900 flex flex-col justify-center items-center relative group cursor-pointer border-b border-blue-900/40">
                        <div class="absolute inset-0 bg-gradient-to-tr from-neonBlue/10 via-darkCard/50 to-neonGreen/10 z-0"></div>
                        
                        <!-- Floating play icon -->
                        <div class="w-16 h-16 rounded-full bg-white/5 backdrop-blur-md flex items-center justify-center border border-white/10 z-10 transition duration-300 transform group-hover:scale-110 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-neonBlue">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs font-bold text-slate-300 tracking-wider z-10 group-hover:text-white uppercase transition-colors">
                            Ver Trailer del Videocurso
                        </span>

                        <div class="absolute bottom-3 left-3 bg-black/70 backdrop-blur-md px-3 py-1 rounded-md text-[10px] font-semibold text-slate-300 z-10 border border-white/10">
                            ⏱️ 1h 45m de Contenido
                        </div>
                    </div>

                    <!-- Info text below video mockup -->
                    <div class="p-5 space-y-4">
                        <h3 class="font-outfit font-bold text-white text-lg leading-tight">
                            ¿Qué aprenderás en el curso?
                        </h3>
                        <ul class="space-y-2.5 text-sm text-slate-300">
                            <li class="flex items-start gap-2.5">
                                <span class="text-neonBlue">✓</span>
                                <span>Configuración de cámara de pecho/cabeza (POV real)</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-neonBlue">✓</span>
                                <span>Cómo grabar interacciones manuales (mano-objeto)</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-neonBlue">✓</span>
                                <span>Formatos de metadata requeridos por laboratorios de IA</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-neonBlue">✓</span>
                                <span>Estrategia para contactar y vender tus videos a empresas</span>
                            </li>
                        </ul>

                        <div class="pt-3 border-t border-blue-900/30 flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" alt="User 1" class="w-7 h-7 rounded-full border border-darkCard object-cover">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100" alt="User 2" class="w-7 h-7 rounded-full border border-darkCard object-cover">
                                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=100" alt="User 3" class="w-7 h-7 rounded-full border border-darkCard object-cover">
                            </div>
                            <span class="text-xs text-slate-400 font-medium">
                                Únete a más de <strong class="text-slate-200">140 grabadores</strong> activos
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Testimonials Section -->
    <section class="w-full py-16 px-6 border-t border-blue-950/40 bg-darkCard/10">
        <div class="max-w-6xl mx-auto space-y-12">
            <div class="text-center space-y-2">
                <h2 class="text-3xl font-black font-outfit text-white">Creadores que ya Venden sus Datasets</h2>
                <p class="text-slate-400 text-sm max-w-md mx-auto">Conoce la experiencia de otros creadores en esta industria.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="bg-darkCard/40 p-6 rounded-2xl border border-blue-900/10 space-y-4">
                    <p class="text-sm text-slate-300 italic leading-relaxed">
                        "Llevaba tiempo buscando cómo monetizar mis videos POV arreglando cosas. Este tutorial me enseñó cómo estructurar el dataset para que lo acepte una firma de IA. ¡Ya vendí mi primer lote de 20 videos por $400 USD!"
                    </p>
                    <div class="flex items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=100" alt="Carlos" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="text-xs font-bold text-white">Felipe C.</h4>
                            <span class="text-[10px] text-neonBlue">Creador de Contenido POV</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-darkCard/40 p-6 rounded-2xl border border-blue-900/10 space-y-4">
                    <p class="text-sm text-slate-300 italic leading-relaxed">
                        "La guía técnica es excelente. Explica con peras y manzanas qué tipo de iluminación y ángulos de cámara buscan los desarrolladores de robots. Me ahorró semanas de rechazos."
                    </p>
                    <div class="flex items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="Laura" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="text-xs font-bold text-white">Diana G.</h4>
                            <span class="text-[10px] text-neonGreen">Ingeniera en Robótica & Creadora</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-darkCard/40 p-6 rounded-2xl border border-blue-900/10 space-y-4">
                    <p class="text-sm text-slate-300 italic leading-relaxed">
                        "El costo del curso se paga solo con las plantillas de licencias de derechos de autor. Te da la tranquilidad de vender tus videos a empresas internacionales sin problemas legales."
                    </p>
                    <div class="flex items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?auto=format&fit=crop&q=80&w=100" alt="Andrés" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="text-xs font-bold text-white">Alberto R.</h4>
                            <span class="text-[10px] text-neonBlue">Consultor de Datos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full py-8 border-t border-blue-950/40 bg-[#02050a] text-center text-xs text-slate-500 relative z-10">
        <div class="max-w-6xl mx-auto px-6 space-y-2">
            <p>© 2026 POV Robotics Academy. Todos los derechos reservados.</p>
            <p class="text-[10px]">Stripe es una marca registrada de Stripe, Inc. Todos los logos y marcas son propiedad de sus respectivos dueños.</p>
        </div>
    </footer>

</body>
</html>
