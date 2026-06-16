<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Chalet Motel 192 - {{ __('Nuestras Redes Sociales') }}</title>

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

        <style>
            body {
                background-color: #040a17;
                background-image: 
                    radial-gradient(circle at 10% 20%, rgba(10, 24, 49, 0.6) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(20, 39, 76, 0.4) 0%, transparent 50%);
                font-family: 'Inter', sans-serif;
            }
            .glass-card {
                background: rgba(10, 24, 49, 0.75);
                backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 183, 3, 0.15);
            }
            .btn-glow-fb:hover {
                box-shadow: 0 0 20px rgba(24, 119, 242, 0.4);
                border-color: rgba(24, 119, 242, 0.6);
            }
            .btn-glow-ig:hover {
                box-shadow: 0 0 20px rgba(236, 72, 153, 0.4);
                border-color: rgba(236, 72, 153, 0.6);
            }
            .btn-glow-tt:hover {
                box-shadow: 0 0 20px rgba(37, 244, 238, 0.3), 0 0 20px rgba(254, 44, 85, 0.3);
                border-color: rgba(255, 255, 255, 0.4);
            }
            .btn-glow-web:hover {
                box-shadow: 0 0 20px rgba(255, 183, 3, 0.4);
                border-color: rgba(255, 183, 3, 0.6);
            }
            .btn-glow-wa:hover {
                box-shadow: 0 0 20px rgba(37, 211, 102, 0.4);
                border-color: rgba(37, 211, 102, 0.6);
            }
        </style>
    </head>
    <body class="text-slate-100 antialiased min-h-screen flex flex-col justify-between selection:bg-gold selection:text-navy">

        <!-- Navigation Header (Simple back to home header) -->
        <header class="w-full bg-[#061021]/80 backdrop-blur-md border-b border-blue-950/60 sticky top-0 z-50">
            <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 text-sm font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Volver al Inicio') }}
                </a>
                
                <div class="flex items-center gap-3">
                    <a href="?lang=es" class="hover:scale-110 transition-transform" title="Español">
                        <img src="https://flagcdn.com/w20/es.png" srcset="https://flagcdn.com/w40/es.png 2x" width="20" alt="Español" class="rounded-[2px] shadow-sm">
                    </a>
                    <a href="?lang=en" class="hover:scale-110 transition-transform" title="English">
                        <img src="https://flagcdn.com/w20/us.png" srcset="https://flagcdn.com/w40/us.png 2x" width="20" alt="English" class="rounded-[2px] shadow-sm">
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="w-full max-w-md mx-auto px-6 py-12 flex-grow flex flex-col justify-center items-center relative z-10">
            
            <!-- Glow background blob -->
            <div class="absolute -top-10 w-72 h-72 bg-blue-700/10 rounded-full filter blur-3xl pointer-events-none"></div>

            <div class="w-full glass-card rounded-[2.5rem] p-8 sm:p-10 shadow-2xl flex flex-col items-center text-center relative overflow-hidden">
                <!-- Golden Corner Highlights -->
                <div class="absolute -top-12 -left-12 w-24 h-24 bg-gold/5 rounded-full filter blur-xl"></div>
                <div class="absolute -bottom-12 -right-12 w-24 h-24 bg-blue-500/5 rounded-full filter blur-xl"></div>

                <!-- Avatar Profile -->
                <div class="w-24 h-24 rounded-full border-4 border-gold p-1 bg-navy-dark shadow-xl mb-6 relative group overflow-hidden">
                    <img src="{{ asset('images/aki_avatar.png') }}" alt="Chalet Motel 192 Logo" class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500">
                </div>

                <!-- Title & Tagline -->
                <div class="mb-8">
                    <h1 class="text-2xl sm:text-3xl font-black font-outfit text-white tracking-wide uppercase leading-tight">
                        Chalet Motel 192
                    </h1>
                    <div class="flex items-center justify-center gap-1.5 mt-2">
                        <span class="text-gold font-bold text-xs uppercase tracking-widest bg-gold/10 px-2.5 py-0.5 rounded-full">
                            {{ __('Alquileres de Largo Plazo') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-4 max-w-xs uppercase tracking-wider leading-relaxed">
                        {{ __('Conéctate con nosotros en todas nuestras redes sociales oficiales.') }}
                    </p>
                </div>

                <!-- Social Links Buttons List -->
                <div class="w-full space-y-4">

                    <!-- Web Oficial -->
                    <a href="https://chaletmotel192.com/" target="_blank" class="btn-glow-web w-full p-4 rounded-2xl bg-gold/5 text-slate-200 border border-gold/20 flex items-center justify-between hover:bg-gold/10 hover:text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 rounded-xl bg-gold text-[#0a1831] flex items-center justify-center text-lg font-bold shadow-md">
                                🌐
                            </span>
                            <div class="flex flex-col text-left">
                                <span class="font-bold font-outfit text-sm uppercase tracking-wider">{{ __('Sitio Web Oficial') }}</span>
                                <span class="text-[10px] text-slate-400 lowercase">chaletmotel192.com</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send/?phone=14077731461&text&type=phone_number&app_absent=0" target="_blank" class="btn-glow-wa w-full p-4 rounded-2xl bg-[#25D366]/5 text-slate-200 border border-[#25D366]/10 flex items-center justify-between hover:bg-[#25D366]/10 hover:text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 rounded-xl bg-[#25D366] text-white flex items-center justify-center text-lg font-bold shadow-md shadow-[#25D366]/10">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.888-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.88-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.876 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </span>
                            <div class="flex flex-col text-left">
                                <span class="font-bold font-outfit text-sm uppercase tracking-wider">WhatsApp</span>
                                <span class="text-[10px] text-slate-400">+1 (407) 773-1461</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <!-- TikTok -->
                    <a href="https://www.tiktok.com/@chalet.motel.192" target="_blank" class="btn-glow-tt w-full p-4 rounded-2xl bg-white/5 text-slate-200 border border-white/10 flex items-center justify-between hover:bg-white/10 hover:text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 rounded-xl bg-black text-white flex items-center justify-center text-lg font-bold shadow-md shadow-cyan-500/10">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 2.78-1.15 5.54-3.14 7.49-1.95 1.94-4.8 2.98-7.53 2.56-2.52-.39-4.8-1.93-6.1-4.14C-1.22 19.8-.3 16.48 1.48 14.1c1.6-2.12 4.31-3.35 6.94-3.23v4.06c-1.46-.06-2.98.54-3.9 1.68-.84 1.05-.98 2.54-.53 3.79.52 1.43 1.97 2.44 3.49 2.53 1.5.09 3.03-.52 3.96-1.66.86-1.05 1.16-2.45 1.12-3.8V.02z"/></svg>
                            </span>
                            <div class="flex flex-col text-left">
                                <span class="font-bold font-outfit text-sm uppercase tracking-wider">TikTok</span>
                                <span class="text-[10px] text-slate-400">@chalet.motel.192</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a href="https://www.instagram.com/kissmemotel192/" target="_blank" class="btn-glow-ig w-full p-4 rounded-2xl bg-pink-500/5 text-slate-200 border border-pink-500/10 flex items-center justify-between hover:bg-pink-500/10 hover:text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-yellow-500 via-pink-500 to-purple-500 text-white flex items-center justify-center text-lg font-bold shadow-md shadow-pink-500/10">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </span>
                            <div class="flex flex-col text-left">
                                <span class="font-bold font-outfit text-sm uppercase tracking-wider">Instagram</span>
                                <span class="text-[10px] text-slate-400">@kissmemotel192</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/profile.php?id=61590106737806" target="_blank" class="btn-glow-fb w-full p-4 rounded-2xl bg-[#1877F2]/5 text-slate-200 border border-[#1877F2]/10 flex items-center justify-between hover:bg-[#1877F2]/10 hover:text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 rounded-xl bg-[#1877F2] text-white flex items-center justify-center text-lg font-bold shadow-md">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </span>
                            <div class="flex flex-col text-left">
                                <span class="font-bold font-outfit text-sm uppercase tracking-wider">Facebook</span>
                                <span class="text-[10px] text-slate-400">Chalet Motel 192</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                </div>

                <!-- Footer details in Card -->
                <div class="mt-10 pt-6 border-t border-white/5 w-full text-center flex flex-col items-center">
                    <span class="text-[9px] text-slate-500 uppercase tracking-widest font-bold font-outfit">
                        © {{ date('Y') }} Chalet Motel 192. {{ __('Todos los derechos reservados.') }}
                    </span>
                </div>
            </div>

        </main>

        <!-- Small decorative footer -->
        <footer class="w-full py-6 text-center text-[10px] text-slate-600 relative z-10 border-t border-blue-950/20">
            <a href="/" class="hover:text-gold transition-colors">{{ __('Chalet Motel 192') }}</a>
        </footer>

    </body>
</html>
