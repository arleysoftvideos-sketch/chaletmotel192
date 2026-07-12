<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>¡Acceso Concedido! - Tutorial TikTok Pro</title>

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
                radial-gradient(circle at 50% -20%, rgba(37, 244, 238, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 50% 120%, rgba(254, 44, 85, 0.15) 0%, transparent 50%);
            background-attachment: fixed;
        }
        .neon-glow {
            box-shadow: 0 0 30px rgba(37, 244, 238, 0.2);
            border: 1px solid rgba(37, 244, 238, 0.3);
        }
        .confetti-glow {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
    </style>
</head>
<body class="text-slate-100 font-sans min-h-screen flex flex-col justify-between selection:bg-tiktokPink selection:text-white antialiased">

    <!-- Header Navigation -->
    <header class="w-full py-6 px-6 max-w-7xl mx-auto flex justify-between items-center relative z-10 border-b border-purple-950/40">
        <div class="flex items-center gap-2">
            <span class="text-2xl font-black font-outfit tracking-tighter bg-gradient-to-r from-tiktokCyan via-white to-tiktokPink bg-clip-text text-transparent">
                TIKTOK VIRAL LAB
            </span>
        </div>
        <div>
            <span class="text-xs bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-3 py-1.5 rounded-full font-semibold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Pago Verificado
            </span>
        </div>
    </header>

    <!-- Success Content -->
    <main class="max-w-4xl mx-auto px-6 py-12 relative z-10 flex-grow w-full space-y-12">
        
        <!-- Header Success Message -->
        <div class="text-center space-y-4">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-tr from-tiktokCyan to-tiktokPink p-1 confetti-glow">
                <div class="w-full h-full bg-[#0b0617] rounded-full flex items-center justify-center text-3xl">
                    🎉
                </div>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black font-outfit text-white leading-tight">
                ¡Gracias por tu compra! Acceso Concedido
            </h1>
            <p class="text-slate-300 max-w-xl mx-auto text-base">
                Has adquirido con éxito <strong>TikTok Tutorial Pro: De Cero a Viral y Monetizado</strong>. A continuación tienes tu clase completa y material de descarga.
            </p>
        </div>

        <!-- Video Player Section -->
        <div class="bg-darkCard/80 rounded-3xl border border-purple-900/60 p-4 sm:p-6 shadow-2xl relative">
            <div class="absolute top-4 right-6 bg-tiktokPink/20 text-tiktokPink text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                Exclusivo para alumnos
            </div>
            
            <h2 class="font-outfit font-bold text-white text-xl sm:text-2xl mb-4 pr-24 flex items-center gap-2">
                🎬 Videocurso Principal
            </h2>

            <!-- Premium HTML5 Player Container (Replace src with real unlisted link) -->
            <div class="aspect-video w-full rounded-2xl overflow-hidden bg-black/90 border border-purple-950 shadow-inner relative group">
                
                <!-- IFRAME PLACEHOLDER: You can put YouTube, Vimeo, Wistia here. We put a beautifully customized mock placeholder. -->
                <iframe 
                    class="w-full h-full" 
                    src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ" 
                    title="TikTok Tutorial Pro Video" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
                
            </div>

            <!-- Video instructions -->
            <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs text-slate-400 pt-4 border-t border-purple-900/30">
                <p>💡 <em>Tip: Si tienes problemas de carga, recarga la página o intenta desde otro navegador.</em></p>
                <div class="flex items-center gap-3">
                    <span>⏱️ Duración: 1h 45m</span>
                    <span>HD 1080p</span>
                </div>
            </div>
        </div>

        <!-- Resources & Downloadables -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Downloadable Resource 1 -->
            <div class="bg-darkCard/40 p-6 rounded-2xl border border-purple-900/30 hover:border-tiktokCyan/50 transition duration-300 flex items-start gap-4">
                <div class="text-3xl p-3 bg-tiktokCyan/10 rounded-xl text-tiktokCyan">
                    📄
                </div>
                <div class="space-y-1">
                    <h3 class="font-outfit font-bold text-white text-base">Guía de Trabajo en PDF</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Incluye 30 ganchos de texto listos para copiar y pegar, estructuras de guiones virales y llamadas a la acción que convierten.
                    </p>
                    <a href="#" class="inline-flex items-center gap-1 text-xs text-tiktokCyan font-bold hover:underline pt-2">
                        Descargar PDF (4.2 MB)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Downloadable Resource 2 -->
            <div class="bg-darkCard/40 p-6 rounded-2xl border border-purple-900/30 hover:border-tiktokPink/50 transition duration-300 flex items-start gap-4">
                <div class="text-3xl p-3 bg-tiktokPink/10 rounded-xl text-tiktokPink">
                    📊
                </div>
                <div class="space-y-1">
                    <h3 class="font-outfit font-bold text-white text-base">Plantilla de Organización de Contenido</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Planifica tus publicaciones mensuales, haz seguimiento de tus estadísticas de retención y calcula tus comisiones en una hoja de Excel.
                    </p>
                    <a href="#" class="inline-flex items-center gap-1 text-xs text-tiktokPink font-bold hover:underline pt-2">
                        Descargar Planilla XLSX (1.1 MB)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </a>
                </div>
            </div>
            
        </div>

        <!-- Order Summary Details (Stripe metadata showcase) -->
        @if(isset($paymentDetails))
            <div class="bg-darkCard/25 p-5 rounded-2xl border border-purple-900/10 text-xs text-slate-400 space-y-2">
                <h4 class="font-bold text-slate-300 uppercase tracking-wider text-[10px]">Detalles del Recibo</h4>
                <div class="grid grid-cols-2 gap-1.5">
                    <div>ID de Transacción:</div>
                    <div class="text-slate-300 text-right select-all font-mono">{{ $paymentDetails['id'] }}</div>
                    
                    <div>Monto Cobrado:</div>
                    <div class="text-slate-300 text-right">${{ number_format($paymentDetails['amount_total'] / 100, 2) }} {{ strtoupper($paymentDetails['currency']) }}</div>
                    
                    @if(isset($paymentDetails['customer_details']['email']))
                        <div>Correo del Cliente:</div>
                        <div class="text-slate-300 text-right">{{ $paymentDetails['customer_details']['email'] }}</div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Customer Support section -->
        <div class="text-center py-6 border-t border-purple-900/20 text-xs text-slate-400 space-y-2">
            <p>¿Tienes dudas o problemas para acceder? Escríbenos directamente.</p>
            <p class="font-bold text-tiktokCyan select-all">soporte@tiktokvirallab.com</p>
            <div class="pt-4">
                <a href="{{ route('tutorial.landing') }}" class="px-5 py-2.5 bg-darkCard border border-purple-900/40 rounded-xl text-xs hover:text-white font-medium transition duration-300">
                    ← Volver a la página principal
                </a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full py-8 border-t border-purple-950/60 bg-darkBg text-center text-xs text-slate-500 relative z-10">
        <div class="max-w-6xl mx-auto px-6">
            <p>© 2026 TikTok Viral Lab. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>
