<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App Hotel Control - Inventario</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CDN with disabled preflight to prevent CSS resets from breaking existing custom styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false,
            },
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
        :root {
            --primary: #ffb703;
            --primary-hover: #fbc02d;
            --bg-color: #040a17;
            --box-bg: #0a1831;
            --border: #14274c;
            --text-color: #cbd5e1;
        }
        *, ::before, ::after {
            box-sizing: border-box;
        }
        .clip-ribbon {
            clip-path: polygon(5% 0%, 95% 0%, 100% 50%, 95% 100%, 5% 100%, 0% 50%);
        }
        .hero-banner-contained {
            background-image: linear-gradient(to right, rgba(6, 16, 33, 0.95) 0%, rgba(6, 16, 33, 0.9) 35%, rgba(6, 16, 33, 0.4) 100%), url('/images/motel_banner.png');
            background-size: cover;
            background-position: center;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; padding: 20px; 
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        .container {
            max-width: 1300px; 
            margin: 0 auto; 
            background: var(--box-bg); 
            padding: 30px; 
            border-radius: 16px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid var(--border);
            position: relative;
            transition: max-width 0.3s;
        }
        
        /* Navigation and Back Link */
        .header-nav {
            margin-bottom: 20px;
        }
        .back-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .back-link:hover {
            color: var(--primary-hover);
            transform: translateX(-3px);
        }

        /* Selector de Idiomas */
        .lang-toggle {
            position: absolute;
            top: 30px;
            right: 30px;
            display: flex;
            gap: 6px;
        }
        .lang-btn {
            background: #14274c;
            border: 1px solid #1e293b;
            color: #94a3b8;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s ease;
        }
        .lang-btn:hover {
            background: #1e293b;
            color: #f8fafc;
        }
        .lang-btn.active {
            background: var(--primary);
            color: #0a1831;
            border-color: var(--primary-hover);
            box-shadow: 0 0 12px rgba(255, 183, 3, 0.2);
        }

        h1[data-i18n="appTitle"] {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 2.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: linear-gradient(to right, #ffffff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 25px;
            text-align: center;
            margin-top: 0;
        }
        
        /* Navegación de Habitaciones y Semáforo */
        .room-nav-title { margin-bottom: 8px; font-weight: 700; color: #94a3b8; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 8px;
            margin-bottom: 20px;
        }
        .room-btn {
            padding: 12px 0;
            background-color: #14274c;
            border: 1px solid #1e293b;
            color: #cbd5e1;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }
        .room-btn:hover {
            background-color: #1e293b;
            color: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.25);
        }
        
        /* Habitación Activa (Azul por defecto) */
        .room-btn.active {
            background-color: var(--primary) !important;
            color: #0a1831 !important;
            border-color: var(--primary-hover) !important;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.3), 0 4px 12px rgba(255, 183, 3, 0.3) !important;
            transform: translateY(-2px);
        }
        
        /* Incompleta / Con Daños (Línea Amarilla) */
        .room-btn.has-data { border-bottom: 4px solid #ffc107; } 
        
        /* Habitación Perfecta (Verde Sólido) */
        .room-btn.perfect-room {
            background-color: #10b981 !important;
            color: white !important;
            border-color: #059669 !important;
        }
        .room-btn.perfect-room.active {
            background-color: #059669 !important;
            box-shadow: inset 0 3px 6px rgba(0,0,0,0.3), 0 4px 12px rgba(16, 185, 129, 0.3) !important;
        }

        /* Formulario */
        .header-info { 
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap; 
            gap: 20px;
            margin-top: 15px;
            margin-bottom: 25px;
            border-bottom: 2px solid var(--border);
            padding: 20px;
            background: #081326;
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        .header-info div {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 0;
        }
        .header-info input[type="text"], .header-info input[type="date"] {
            margin-top: 0;
        }
        
        .section { 
            margin-bottom: 20px;
            padding: 20px; 
            border: 1px solid var(--border);
            border-radius: 12px;
            background-color: #0d1e3d;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .section h3 {
            margin-top: 0;
            color: var(--primary);
            border-bottom: 1px solid var(--border);
            padding-bottom: 8px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .checkbox-group {
            margin-bottom: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            background-color: #081326;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }
        .checkbox-group:hover {
            border-color: var(--border);
            background-color: #102244;
        }
        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 14px;
            user-select: none;
            color: #e2e8f0;
        }
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
            margin: 0;
        }
        
        label { cursor: pointer; }
        input[type="text"], input[type="date"], textarea { 
            padding: 10px 14px; margin-top: 5px; box-sizing: border-box; 
            background-color: #081326;
            color: #f8fafc;
            border: 1px solid var(--border); border-radius: 8px; width: 100%;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        input[type="text"]:focus, input[type="date"]:focus, textarea:focus {
            border-color: var(--primary);
            outline: none;
        }
        .inline-input { width: auto !important; display: inline-block; }
        textarea { resize: vertical; }
        
        .radio-group {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .radio-group span {
            color: #94a3b8;
            margin-right: 5px;
        }
        .radio-group label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #081326;
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            cursor: pointer;
            font-weight: normal;
            color: #cbd5e1;
            transition: all 0.2s ease;
        }
        .radio-group label:hover {
            border-color: var(--primary);
            background-color: #102244;
            color: #f8fafc;
        }
        .radio-group input[type="radio"] {
            accent-color: var(--primary);
            cursor: pointer;
            width: 16px;
            height: 16px;
            margin: 0;
        }

        /* Botones de Acción */
        .actions { display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap; }
        .btn {
            flex: 1; min-width: 250px; padding: 16px; color: white; border: none; border-radius: 8px;
            cursor: pointer; font-size: 16px; font-weight: bold; text-align: center;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.15);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.25);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn-summary { background-color: #6f42c1; } 
        .btn-summary:hover { background-color: #59339d; }
        .btn-print { background-color: #17a2b8; }
        .btn-print:hover { background-color: #138496; }
        .btn-report { background-color: #28a745; }
        .btn-report:hover { background-color: #218838; }
        .btn-sync { background-color: #10b981; }
        .btn-sync:hover { background-color: #059669; }
        .btn-cloud-load:hover {
            background-color: #1e293b !important;
            color: #f8fafc !important;
            border-color: #ffb703 !important;
            box-shadow: 0 0 10px rgba(255, 183, 3, 0.2) !important;
        }

        /* Pantalla de Reporte y Modal */
        #consolidated-view { display: none; }
        .report-room-card { border: 2px solid #dc3545; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #1a0f12; color: #f8fafc; }
        .report-room-card h3 { margin-top: 0; color: #f43f5e; }
        .report-item { color: #cbd5e1; margin-bottom: 5px; line-height: 1.4; }
        .report-item strong { color: #f43f5e; }

        /* Estilos del Modal */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center; padding: 20px; box-sizing: border-box;
        }
        .modal-content {
            background: #0a1831; width: 100%; max-width: 800px; max-height: 90vh;
            border-radius: 12px; border: 1px solid var(--border); overflow-y: auto; padding: 30px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            color: var(--text-color);
        }
        .modal-close {
            position: absolute; top: 15px; right: 20px; background: #dc3545; color: white; border: none; padding: 8px 15px;
            border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 14px;
        }
        .modal-close:hover { background: #c82333; }

        @media print {
            body { background: white; color: #333; padding: 0; }
            .container { box-shadow: none; border: none; max-width: 100%; background: white; }
            .lang-toggle, .no-print, .modal-overlay { display: none !important; }
            #consolidated-view { display: block; color: #333; }
            .print-only { display: block !important; }
            .report-room-card { background: #fffafb; color: #333; border: 2px solid #dc3545; }
            .report-item { color: #555; }
            .report-item strong { color: #d32f2f; }
        }

        /* Two column layout for Interactive Blueprint */
        .main-layout-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            margin-top: 15px;
        }
        @media (min-width: 1024px) {
            .main-layout-grid {
                grid-template-columns: 1.15fr 0.85fr;
            }
        }
        .blueprint-column {
            position: relative;
        }
        .blueprint-panel {
            background: #081326;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
            position: sticky;
            top: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .blueprint-title {
            font-family: 'Outfit', sans-serif;
            font-size: 17px;
            font-weight: 800;
            margin-top: 0;
            margin-bottom: 15px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            align-self: flex-start;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            border-bottom: 1px solid var(--border);
            padding-bottom: 10px;
        }
        .blueprint-svg-container {
            width: 100%;
            background: #040a17;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 10px;
            box-sizing: border-box;
        }
        
        /* Interactive SVG styles */
        .interactive-svg-item {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            color: #475569; /* Neutral slate color */
        }
        .interactive-svg-item:hover {
            color: var(--primary-hover);
            filter: drop-shadow(0 0 4px var(--primary));
        }
        .interactive-svg-item.status-ok {
            color: #10b981 !important; /* Green */
        }
        .interactive-svg-item.status-ok:hover {
            color: #34d399 !important;
            filter: drop-shadow(0 0 5px #10b981);
        }
        .interactive-svg-item.status-error {
            color: #ef4444 !important; /* Red */
        }
        .interactive-svg-item.status-error:hover {
            color: #f87171 !important;
            filter: drop-shadow(0 0 5px #ef4444);
        }
        
        /* Walls specific */
        #svg-walls {
            stroke: var(--border);
            fill: none;
            transition: stroke 0.2s;
        }
        #svg-walls.status-ok {
            stroke: #10b981;
        }
        #svg-walls.status-error {
            stroke: #ef4444;
        }
        
        /* Legends in blueprint */
        .blueprint-legend {
            display: flex;
            gap: 12px;
            margin-top: 15px;
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            justify-content: center;
            width: 100%;
            flex-wrap: wrap;
        }
        
        @media (max-width: 1023px) {
            .blueprint-panel {
                position: relative;
                top: 0;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

<div class="modal-overlay no-print" id="summary-modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeSummaryModal()">X <span data-i18n="btnClose">Cerrar</span></button>
        <div id="modal-body"></div>
    </div>
</div>

<div class="container no-print" id="app-view">
    <div class="header-nav">
        <a href="/" class="back-link">← <span data-i18n="backToHome">Volver a Inicio</span></a>
    </div>
    
    <div class="lang-toggle">
        <button id="btn-es" class="lang-btn active" onclick="setLanguage('es')">🇪🇸 ES</button>
        <button id="btn-en" class="lang-btn" onclick="setLanguage('en')">🇺🇸 EN</button>
    </div>

    <h1 data-i18n="appTitle">🏨 App Hotel Control</h1>
    
    <!-- Under Construction Fun Banner -->
    <div class="relative overflow-hidden w-full rounded-[2rem] bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 p-[2px] mb-8 shadow-[0_0_40px_rgba(249,115,22,0.2)] group no-print transform transition-transform hover:scale-[1.01] duration-300">
        <!-- Animated striped background (caution tape style) -->
        <div class="absolute inset-0 opacity-20 bg-[repeating-linear-gradient(45deg,transparent,transparent_10px,rgba(0,0,0,1)_10px,rgba(0,0,0,1)_20px)] animate-[pulse_4s_ease-in-out_infinite]"></div>
        
        <div class="relative bg-[#061021] rounded-[calc(2rem-2px)] px-6 py-8 md:px-10 flex flex-col md:flex-row items-center justify-between overflow-hidden">
            <!-- Glow effect -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl group-hover:bg-orange-500/20 transition-all duration-700"></div>
            <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-yellow-500/10 rounded-full blur-3xl group-hover:bg-yellow-500/20 transition-all duration-700"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-6 z-10 text-center md:text-left">
                <!-- Bouncing Icon -->
                <div class="flex-shrink-0 w-20 h-20 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-600 flex items-center justify-center shadow-lg shadow-orange-500/30 animate-[bounce_2s_infinite] border-2 border-white/20 relative">
                    <span class="text-4xl">🚧</span>
                    <div class="absolute -bottom-2 w-12 h-2 bg-black/30 blur-sm rounded-full"></div>
                </div>
                
                <div>
                    <h2 data-i18n="bannerTitle" class="text-2xl md:text-3xl font-outfit font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-400 mb-2 tracking-wide uppercase">
                        ¡Zona en Construcción! 🛠️
                    </h2>
                    <p data-i18n="bannerDesc" class="text-slate-300 font-medium text-sm md:text-base max-w-xl leading-relaxed">
                        Ponte el casco de seguridad. Estamos programando y martillando código para traer nuevas e increíbles funciones a esta sección de Inventario. 
                    </p>
                </div>
            </div>
            
            <div class="mt-6 md:mt-0 z-10 flex-shrink-0">
                <div class="group-hover:animate-pulse px-6 py-3 rounded-xl border border-yellow-500/30 bg-gradient-to-r from-yellow-500/10 to-orange-500/10 text-yellow-400 font-bold text-sm backdrop-blur-md flex items-center gap-3 shadow-inner">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                    </span>
                    <span data-i18n="bannerBadge">¡Pronto Novedades!</span>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="room-nav-title" data-i18n="floor1">Piso 1 (101 - 114)</div>
    <div class="room-grid" id="nav-piso1"></div>
    
    <div class="room-nav-title" data-i18n="floor2">Piso 2 (201 - 214)</div>
    <div class="room-grid" id="nav-piso2"></div>

    <h2 style="margin-top: 20px; color: var(--text-color); display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
        <span>
            <span data-i18n="selectedRoom">Habitación Seleccionada:</span> 
            <span id="lbl-room" style="color: var(--primary);">101</span>
        </span>
    </h2>

    <form id="checklist-form">
        <div class="header-info">
            <div>
                <strong data-i18n="status">Estado:</strong> 
                <label><input type="radio" name="estado" value="limpio"> <span data-i18n="clean">Limpio</span></label>
                <label><input type="radio" name="estado" value="sucio"> <span data-i18n="dirty">Sucio</span></label>
            </div>
            <div><strong data-i18n="inspectedBy">Inspeccionado por:</strong> <input type="text" id="inspector" class="inline-input" style="width: 150px;"></div>
            <div><strong data-i18n="date">Fecha:</strong> <input type="date" id="fecha" class="inline-input"></div>
        </div>

        <div class="main-layout-grid">
            <!-- Columna Izquierda: Secciones del Formulario -->
            <div>
                <div class="section">
                    <h3 data-i18n="roomAreaTitle">🛏️ Área de la Habitación</h3>
                    <div class="radio-group">
                        <span data-i18n="bedSetup">Configuración:</span> 
                        <label><input type="radio" name="camas" value="1_king" onchange="toggleMesaSilla()"> <span data-i18n="bedKing">1 King</span></label>
                        <label><input type="radio" name="camas" value="1_queen" onchange="toggleMesaSilla()"> <span data-i18n="bedQueen">1 Queen</span></label>
                        <label><input type="radio" name="camas" value="2_queen" onchange="toggleMesaSilla()"> <span data-i18n="bed2Queen">2 Queen</span></label>
                    </div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_cortina"> <span data-i18n="chk_cortina">Cortina instalada y en buen estado</span></label></div>
                    
                    <div class="checkbox-group" id="div_mesa"><label><input type="checkbox" id="chk_mesa"> <span data-i18n="chk_mesa">Mesa</span></label></div>
                    <div class="checkbox-group" id="div_silla"><label><input type="checkbox" id="chk_silla"> <span data-i18n="chk_silla">Silla (con la mesa)</span></label></div>
                    
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_nevera"> <span data-i18n="chk_nevera">Nevera (Refrigerador)</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_microondas"> <span data-i18n="chk_microondas">Microondas</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_parrilla"> <span data-i18n="chk_parrilla">Parrilla para recoger (portaequipajes)</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_colchon"> <span data-i18n="chk_colchon">Colchón en buen estado</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_nochero"> <span data-i18n="chk_nochero">Mesa de noche (Nochero)</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_lamparas_hab"> <span data-i18n="chk_lamparas_hab">Lámparas de la habitación</span></label></div>
                </div>

                <div class="section">
                    <h3 data-i18n="acTitle">🔌 Electricidad, Climatización y Seguridad</h3>
                    <div class="radio-group">
                        <span data-i18n="acStatus">Aire acondicionado (A/C):</span> 
                        <label><input type="radio" name="ac" value="si"> <span data-i18n="works">Sí trabaja</span></label>
                        <label><input type="radio" name="ac" value="no"> <span data-i18n="noworks">No trabaja</span></label>
                    </div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_outlet_ac"> <span data-i18n="chk_outlet_ac">Outlet (enchufe) del A/C en buen estado</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_tv"> <span data-i18n="chk_tv">Televisor</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_tapas_emergencia"> <span data-i18n="chk_tapas_emergencia">Tapas de emergencia blancas (energía)</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_covers_outlets"> <span data-i18n="chk_covers_outlets">Covers de los outlets completos y sanos</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_covers_luces"> <span data-i18n="chk_covers_luces">Covers de las luces completos y sanos</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_extractor"> <span data-i18n="chk_extractor">Extractor de humo / Detector de humo</span></label></div>
                </div>

                <div class="section">
                    <h3 data-i18n="doorTitle">🚪 Puertas y Paredes</h3>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_puerta"> <span data-i18n="chk_puerta">Puerta principal (Mecanismo bien)</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_stop_door"> <span data-i18n="chk_stop_door">Stop door instalado y funcionando</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_paredes"> <span data-i18n="chk_paredes">Paredes (Sin rayones graves ni daños)</span></label></div>
                </div>

                <div class="section">
                    <h3 data-i18n="bathTitle">🛁 Área del Baño</h3>
                    <div class="radio-group">
                        <span data-i18n="bathType">Tipo de baño:</span> 
                        <label><input type="radio" name="bano" value="banera"> <span data-i18n="tub">Bañera</span></label>
                        <label><input type="radio" name="bano" value="ducha"> <span data-i18n="showerOnly">Ducha sola</span></label>
                    </div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_griferia"> <span data-i18n="chk_griferia">Grifería de la ducha en buen estado</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_lavamanos"> <span data-i18n="chk_lavamanos">Lavamanos</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_espejo"> <span data-i18n="chk_espejo">Espejo (en el área del lavamanos)</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_toilet"> <span data-i18n="chk_toilet">Toilet (Inodoro)</span></label></div>
                    
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_coso_papel"> <span data-i18n="chk_coso_papel">Set de baño</span></label></div>
                    
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_lampara_bano"> <span data-i18n="chk_lampara_bano">Lámpara del baño</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_cover_extractor"> <span data-i18n="chk_cover_extractor">Cover del extractor de aire del baño</span></label></div>
                </div>

                <div class="section" style="border-color: #ffc107;">
                    <h3 style="color: #d39e00;" data-i18n="maintTitle">🛠️ Mantenimiento Pendiente (Problemas)</h3>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_remiendo"> <span data-i18n="chk_remiendo">Falta algún remiendo o parche en la pared</span></label></div>
                    <div class="checkbox-group"><label><input type="checkbox" id="chk_pintura"> <span data-i18n="chk_pintura">Requiere retoque de pintura</span></label></div>
                    <textarea id="txt_mantenimiento" rows="2" placeholder="Describe los daños o pinturas necesarias..." data-i18n-ph="maintPh"></textarea>
                </div>

                <div class="section">
                    <h3 data-i18n="notesTitle">➕ Notas Adicionales</h3>
                    <textarea id="txt_notas" rows="2" placeholder="Observaciones extra, anexos..." data-i18n-ph="notesPh"></textarea>
                </div>
            </div>

            <!-- Columna Derecha: Plano Interactivo -->
            <div class="blueprint-column">
                <div class="blueprint-panel">
                    <h3 class="blueprint-title">
                        <span>🗺️</span>
                        <span data-i18n="blueprintTitle">Plano Interactivo - Habitación</span>
                    </h3>
                    
                    <div class="blueprint-svg-container">
                        <svg viewBox="0 0 400 300" width="100%" height="100%">
                            <!-- Custom Styles inside SVG for animations -->
                            <style>
                                @keyframes pulse-warning {
                                    0% { opacity: 0.4; }
                                    50% { opacity: 1; }
                                    100% { opacity: 0.4; }
                                }
                                .maint-pulse {
                                    animation: pulse-warning 2s infinite ease-in-out;
                                }
                            </style>

                            <!-- Background Room Floor -->
                            <rect x="10" y="10" width="380" height="280" rx="8" ry="8" fill="#040d1a" />

                            <!-- Cleanliness Indicator -->
                            <g class="interactive-svg-item" data-target-radio="estado" data-target-value="sucio" id="svg-clean-indicator">
                                <circle cx="45" cy="35" r="12" fill="currentColor" opacity="0.15" />
                                <path d="M 40 35 L 43 38 L 49 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <text x="63" y="38" fill="currentColor" font-size="9" font-weight="bold" font-family="'Inter', sans-serif" id="svg-clean-text">LIMPIO</text>
                            </g>

                            <!-- General Maintenance Warning Triangle -->
                            <g id="svg-maint-alert" class="interactive-svg-item maint-pulse" data-target="chk_remiendo" style="display:none;">
                                <path d="M 200 20 L 212 40 L 188 40 Z" fill="rgba(245, 158, 11, 0.15)" stroke="currentColor" stroke-width="1.5" />
                                <text x="200" y="36" fill="currentColor" font-size="12" font-weight="900" font-family="'Inter', sans-serif" text-anchor="middle">!</text>
                                <text x="200" y="52" fill="currentColor" font-size="7" font-weight="bold" font-family="'Inter', sans-serif" text-anchor="middle">MAINT</text>
                            </g>

                            <!-- Window & Curtain -->
                            <g class="interactive-svg-item" data-target="chk_cortina" id="svg-cortina">
                                <!-- Window Frame on top wall -->
                                <line x1="120" y1="10" x2="180" y2="10" stroke="#0284c7" stroke-width="4" />
                                <!-- Curtain Rod & Folds -->
                                <rect x="115" y="12" width="70" height="6" rx="2" fill="currentColor" />
                                <path d="M 120 18 L 125 14 L 130 18 L 135 14 L 140 18 L 145 14 L 150 18 L 155 14 L 160 18 L 165 14 L 170 18 L 175 14 L 180 18" fill="none" stroke="currentColor" stroke-width="1" />
                            </g>

                            <!-- AC Unit & Outlet -->
                            <g class="interactive-svg-item" data-target-radio="ac" data-target-value="no" id="svg-ac">
                                <rect x="10" y="115" width="8" height="50" rx="2" fill="currentColor" stroke="currentColor" stroke-width="1" />
                                <line x1="14" y1="123" x2="14" y2="157" stroke="#040a17" stroke-width="1.5" stroke-dasharray="2,2" />
                                <text x="23" y="140" fill="currentColor" font-size="8" font-family="'Inter', sans-serif" transform="rotate(-90 23 140)" text-anchor="middle" font-weight="bold">A/C</text>
                            </g>
                            <g class="interactive-svg-item" data-target="chk_outlet_ac" id="svg-outlet-ac">
                                <circle cx="28" cy="140" r="5" fill="none" stroke="currentColor" stroke-width="1.5" />
                                <circle cx="26" cy="140" r="0.8" fill="currentColor" />
                                <circle cx="30" cy="140" r="0.8" fill="currentColor" />
                            </g>

                            <!-- Main Bedroom Walls (Outer Frame) -->
                            <rect x="10" y="10" width="380" height="280" rx="8" ry="8" fill="none" stroke="currentColor" stroke-width="5" id="svg-walls" class="interactive-svg-item" data-target="chk_paredes" />
                            
                            <!-- Bathroom Partition Wall -->
                            <path d="M 260 10 L 260 110 M 260 145 L 260 170 L 390 170" fill="none" stroke="#14274c" stroke-width="5" />

                            <!-- Main Entrance Door -->
                            <g class="interactive-svg-item" data-target="chk_puerta" id="svg-puerta">
                                <line x1="40" y1="290" x2="40" y2="250" stroke="currentColor" stroke-width="3.5" />
                                <path d="M 40 250 A 40 40 0 0 1 80 290" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3,3" />
                            </g>
                            
                            <!-- Door Stop -->
                            <g class="interactive-svg-item" data-target="chk_stop_door" id="svg-stop-door">
                                <circle cx="20" cy="265" r="4" fill="none" stroke="currentColor" stroke-width="1.5" />
                                <line x1="15" y1="265" x2="20" y2="265" stroke="currentColor" stroke-width="1.5" />
                            </g>

                            <!-- Smoke Detector / Extractor -->
                            <g class="interactive-svg-item" data-target="chk_extractor" id="svg-extractor">
                                <circle cx="205" cy="85" r="9" fill="none" stroke="currentColor" stroke-width="1.5" />
                                <circle cx="205" cy="85" r="4" fill="currentColor" />
                            </g>

                            <!-- Group 1 Bed (Queen/King) -->
                            <g id="group-1-cama" class="interactive-svg-item" data-target-radio="camas" data-target-value="2_queen">
                                <rect x="25" y="85" width="105" height="110" rx="8" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="2" />
                                <rect x="33" y="100" width="20" height="32" rx="3" fill="none" stroke="currentColor" stroke-width="1.5" />
                                <rect x="33" y="148" width="20" height="32" rx="3" fill="none" stroke="currentColor" stroke-width="1.5" />
                                <path d="M 85 85 L 85 195" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,2" />
                                <text id="svg-bed-label" x="78" y="140" fill="currentColor" font-size="10" font-weight="900" font-family="'Outfit', sans-serif" text-anchor="middle">QUEEN BED</text>
                                
                                <!-- Nightstand & Lamp (linked to chk_lamparas_hab inside group) -->
                                <g class="interactive-svg-item" data-target="chk_lamparas_hab" style="color: inherit;">
                                    <rect x="25" y="47" width="28" height="28" rx="4" fill="#040d1a" stroke="currentColor" stroke-width="1.5" />
                                    <!-- Lamp -->
                                    <circle cx="39" cy="61" r="6" fill="currentColor" opacity="0.8" />
                                    <circle cx="39" cy="61" r="2.5" fill="#040d1a" />
                                </g>
                            </g>

                            <!-- Group 2 Beds (Twin/Doble) -->
                            <g id="group-2-camas" class="interactive-svg-item" data-target-radio="camas" data-target-value="1_queen">
                                <!-- Bed 1 (Top) -->
                                <rect x="25" y="32" width="95" height="78" rx="6" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="2" />
                                <rect x="33" y="42" width="18" height="24" rx="2" fill="none" stroke="currentColor" stroke-width="1.5" />
                                <rect x="33" y="74" width="18" height="24" rx="2" fill="none" stroke="currentColor" stroke-width="1.5" />
                                <path d="M 80 32 L 80 110" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,2" />
                                
                                <!-- Bed 2 (Bottom) -->
                                <rect x="25" y="172" width="95" height="78" rx="6" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="2" />
                                <rect x="33" y="182" width="18" height="24" rx="2" fill="none" stroke="currentColor" stroke-width="1.5" />
                                <rect x="33" y="214" width="18" height="24" rx="2" fill="none" stroke="currentColor" stroke-width="1.5" />
                                <path d="M 80 172 L 80 250" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,2" />

                                <text id="svg-beds-label" x="70" y="145" fill="currentColor" font-size="9" font-weight="900" font-family="'Outfit', sans-serif" text-anchor="middle">2 BEDS</text>
                                
                                <!-- Nightstand & Lamp in the middle -->
                                <g class="interactive-svg-item" data-target="chk_lamparas_hab" style="color: inherit;">
                                    <rect x="25" y="126" width="28" height="28" rx="4" fill="#040d1a" stroke="currentColor" stroke-width="1.5" />
                                    <!-- Lamp -->
                                    <circle cx="39" cy="140" r="6" fill="currentColor" opacity="0.8" />
                                    <circle cx="39" cy="140" r="2.5" fill="#040d1a" />
                                </g>
                            </g>

                            <!-- Wall Mounted TV -->
                            <g class="interactive-svg-item" data-target="chk_tv" id="svg-tv">
                                <line x1="257" y1="70" x2="257" y2="130" stroke="currentColor" stroke-width="3" />
                                <rect x="252" y="75" width="4" height="40" rx="1" fill="currentColor" />
                                <text x="245" y="98" fill="currentColor" font-size="8" font-family="'Inter', sans-serif" text-anchor="end" font-weight="bold">TV</text>
                            </g>

                            <!-- Table & Chair (Mesa y Silla) -->
                            <g id="group-mesa-silla">
                                <g class="interactive-svg-item" data-target="chk_mesa" id="svg-mesa">
                                    <rect x="180" y="210" width="45" height="35" rx="5" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="2" />
                                    <text x="202" y="231" fill="currentColor" font-size="8" font-family="'Inter', sans-serif" text-anchor="middle" font-weight="bold">Mesa</text>
                                </g>
                                <g class="interactive-svg-item" data-target="chk_silla" id="svg-silla">
                                    <rect x="233" y="222" width="12" height="11" rx="2" fill="#040d1a" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M 235 220 L 243 220 M 235 220 L 235 233 L 243 233" fill="none" stroke="currentColor" stroke-width="1.5" />
                                </g>
                            </g>

                            <!-- Luggage Rack (Parrilla) -->
                            <g class="interactive-svg-item" data-target="chk_parrilla" id="svg-parrilla">
                                <rect x="205" y="125" width="40" height="25" rx="3" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="1.5" />
                                <line x1="210" y1="130" x2="240" y2="130" stroke="currentColor" stroke-width="1" />
                                <line x1="210" y1="135" x2="240" y2="135" stroke="currentColor" stroke-width="1" />
                                <line x1="210" y1="140" x2="240" y2="140" stroke="currentColor" stroke-width="1" />
                                <text x="225" y="148" fill="currentColor" font-size="6.5" font-family="'Inter', sans-serif" text-anchor="middle">Parrilla</text>
                            </g>

                            <!-- Refrigerator (Nevera) -->
                            <g class="interactive-svg-item" data-target="chk_nevera" id="svg-nevera">
                                <rect x="145" y="225" width="28" height="28" rx="3" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="2" />
                                <line x1="170" y1="228" x2="170" y2="238" stroke="currentColor" stroke-width="2" />
                                <text x="159" y="241" fill="currentColor" font-size="7.5" font-family="'Inter', sans-serif" text-anchor="middle" font-weight="bold">Refri</text>
                            </g>

                            <!-- Microwave (Microondas) -->
                            <g class="interactive-svg-item" data-target="chk_microondas" id="svg-microondas">
                                <rect x="145" y="195" width="28" height="22" rx="2" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="1.5" />
                                <rect x="148" y="199" width="16" height="14" fill="none" stroke="currentColor" stroke-width="1" />
                                <line x1="168" y1="200" x2="170" y2="200" stroke="currentColor" stroke-width="1" />
                                <line x1="168" y1="203" x2="170" y2="203" stroke="currentColor" stroke-width="1" />
                                <text x="159" y="213" fill="currentColor" font-size="7" font-family="'Inter', sans-serif" text-anchor="middle" font-weight="bold">Micro</text>
                            </g>

                            <!-- BATHROOM AREA -->
                            <!-- Bathroom Door Swing -->
                            <path d="M 260 110 A 35 35 0 0 0 295 145" fill="none" stroke="#64748b" stroke-width="1.5" stroke-dasharray="3,3" />
                            <line x1="260" y1="110" x2="295" y2="110" stroke="#14274c" stroke-width="3" />

                            <!-- Bathroom Exhaust Cover -->
                            <g class="interactive-svg-item" data-target="chk_cover_extractor" id="svg-cover-extractor">
                                <circle cx="310" cy="95" r="7" fill="none" stroke="currentColor" stroke-width="1.2" />
                                <line x1="310" y1="88" x2="310" y2="102" stroke="currentColor" stroke-width="1" />
                                <line x1="303" y1="95" x2="317" y2="95" stroke="currentColor" stroke-width="1" />
                            </g>

                            <!-- Bathroom Lamp -->
                            <g class="interactive-svg-item" data-target="chk_lampara_bano" id="svg-lampara-bano">
                                <circle cx="342" cy="95" r="6" fill="none" stroke="currentColor" stroke-width="1.2" />
                                <line x1="338" y1="91" x2="346" y2="99" stroke="currentColor" stroke-width="1" />
                                <line x1="346" y1="91" x2="338" y2="99" stroke="currentColor" stroke-width="1" />
                            </g>

                            <!-- Toilet & paper holder -->
                            <g class="interactive-svg-item" data-target="chk_toilet" id="svg-toilet">
                                <rect x="270" y="20" width="28" height="12" rx="2" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="1.5" />
                                <ellipse cx="284" cy="42" rx="10" ry="13" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="1.5" />
                                <ellipse cx="284" cy="40" rx="7" ry="10" fill="none" stroke="currentColor" stroke-width="1" />
                            </g>
                            <g class="interactive-svg-item" data-target="chk_coso_papel" id="svg-coso-papel">
                                <rect x="303" y="24" width="6" height="10" rx="1" fill="none" stroke="currentColor" stroke-width="1" />
                                <circle cx="306" cy="29" r="2.2" fill="currentColor" />
                            </g>

                            <!-- Bathtub -->
                            <g id="group-banera" class="interactive-svg-item" data-target-radio="bano" data-target-value="ducha">
                                <rect x="325" y="20" width="55" height="100" rx="8" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="2" />
                                <rect x="331" y="26" width="43" height="88" rx="6" fill="none" stroke="currentColor" stroke-width="1.2" />
                                <circle cx="352" cy="100" r="3.5" fill="none" stroke="currentColor" stroke-width="1" />
                                <!-- Ducha griferia inside bathtub -->
                                <g class="interactive-svg-item" data-target="chk_griferia" id="svg-griferia-banera" style="color: inherit;">
                                    <circle cx="352" cy="38" r="4.5" fill="currentColor" />
                                    <line x1="352" y1="33" x2="352" y2="38" stroke="currentColor" stroke-width="1.5" />
                                </g>
                            </g>

                            <!-- Shower Cabin -->
                            <g id="group-ducha" class="interactive-svg-item" data-target-radio="bano" data-target-value="banera" style="display:none;">
                                <rect x="325" y="20" width="55" height="55" rx="5" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="2" />
                                <line x1="325" y1="75" x2="380" y2="75" stroke="currentColor" stroke-width="1.5" />
                                <circle cx="352" cy="47" r="3.5" fill="none" stroke="currentColor" stroke-width="1" />
                                <!-- Ducha griferia inside shower cabin -->
                                <g class="interactive-svg-item" data-target="chk_griferia" id="svg-griferia-ducha" style="color: inherit;">
                                    <circle cx="352" cy="28" r="4.5" fill="currentColor" />
                                    <line x1="352" y1="23" x2="352" y2="28" stroke="currentColor" stroke-width="1.5" />
                                </g>
                            </g>

                            <!-- Vanity (Counter, Sink, Mirror) -->
                            <g id="group-vanity">
                                <rect x="270" y="125" width="85" height="35" rx="4" fill="none" stroke="#14274c" stroke-width="1.5" />
                                <!-- Sink (Lavamanos) -->
                                <g class="interactive-svg-item" data-target="chk_lavamanos" id="svg-lavamanos">
                                    <ellipse cx="312" cy="142" rx="16" ry="11" fill="rgba(148, 163, 184, 0.03)" stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="312" cy="142" r="2" fill="currentColor" />
                                    <path d="M 312 131 L 312 136" fill="none" stroke="currentColor" stroke-width="2" />
                                    <line x1="309" y1="133" x2="315" y2="133" stroke="currentColor" stroke-width="1.5" />
                                </g>
                                <!-- Mirror (Espejo) -->
                                <g class="interactive-svg-item" data-target="chk_espejo" id="svg-espejo">
                                    <rect x="275" y="116" width="75" height="5" rx="1" fill="currentColor" />
                                    <line x1="285" y1="118" x2="289" y2="118" stroke="#040a17" stroke-width="1" />
                                    <line x1="320" y1="118" x2="324" y2="118" stroke="#040a17" stroke-width="1" />
                                </g>
                            </g>
                        </svg>
                    </div>

                    <!-- Legends -->
                    <div class="blueprint-legend">
                        <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#10b981;margin-right:4px;"></span><span data-i18n="legendOk">Excelente</span></span>
                        <span><span style="display:inline-block;width:10px;height:10px;border-radius:2px;background:#ef4444;margin-right:4px;"></span><span data-i18n="legendMissing">Dañado / Faltante</span></span>
                    </div>
                    <div style="font-size:10px; color:#64748b; margin-top:8px; text-align:center;" data-i18n="legendInteractive">
                        Haz clic en los objetos del plano para marcar/desmarcar.
                    </div>
                </div>
            </div>
        </div>

        <div class="actions">
            <button type="button" class="btn btn-summary" onclick="showSummaryModal()">📊 <span data-i18n="btnViewSummary">Ver Resumen en Pantalla</span></button>
            <button type="button" class="btn btn-print" onclick="printCurrentRoom()">🖨️ <span data-i18n="btnPrintRoom">Imprimir Hab. Actual</span></button>
            <button type="button" class="btn btn-report" onclick="printConsolidatedReport()">📑 <span data-i18n="btnPrintReport">Imprimir Consolidado Faltantes</span></button>
            <button type="button" class="btn btn-sync" onclick="syncCurrentRoomToGoogleSheets()" id="btn-sync-sheets">🟢 <span data-i18n="btnSyncSheets">Guardar en Google Sheets</span></button>
        </div>
    </form>
</div>

<div id="consolidated-view"></div>

<script>
    // --- DICCIONARIO DE IDIOMAS Y PALABRAS CORTAS PARA EL REPORTE ---
    const dict = {
        es: {
            appTitle: "🏨 App Hotel Control", floor1: "Piso 1 (101 - 114)", floor2: "Piso 2 (201 - 214)",
            selectedRoom: "Habitación Seleccionada:", status: "Estado:", clean: "Limpio", dirty: "Sucio",
            inspectedBy: "Inspeccionado por:", date: "Fecha:", roomAreaTitle: "🛏️ Área de la Habitación",
            backToHome: "Volver a Inicio",
            bedSetup: "Configuración:", bedKing: "1 King", bedQueen: "1 Queen", bed2Queen: "2 Queen",
            acTitle: "🔌 Electricidad, Climatización y Seguridad", acStatus: "Aire acondicionado (A/C):", works: "Sí trabaja", noworks: "No trabaja",
            doorTitle: "🚪 Puertas y Paredes", bathTitle: "🛁 Área del Baño", bathType: "Tipo de baño:", tub: "Bañera", showerOnly: "Ducha sola",
            maintTitle: "🛠️ Mantenimiento Pendiente", notesTitle: "➕ Notas Adicionales",
            btnViewSummary: "Ver Resumen en Pantalla", btnPrintRoom: "Imprimir Hab. Actual", btnPrintReport: "Imprimir Consolidado Faltantes", btnClose: "Cerrar",
            btnSyncSheets: "Guardar en Google Sheets", btnSyncing: "Guardando...",
            btnLoadSheets: "Cargar desde Google Sheets", btnLoadingSheets: "Cargando...",
            maintPh: "Describe los daños o pinturas necesarias...", notesPh: "Observaciones extra, anexos...",
            bannerTitle: "¡Zona en Construcción! 🛠️", bannerDesc: "Ponte el casco de seguridad. Estamos programando y martillando código para traer nuevas e increíbles funciones a esta sección de Inventario.", bannerBadge: "¡Pronto Novedades!",
            blueprintTitle: "Plano Interactivo - Habitación",
            legendOk: "Excelente / Presente", legendMissing: "Dañado / Faltante",
            legendInteractive: "Haz clic en los objetos del plano para marcar/desmarcar.",
            
            // Textos largos para la pantalla principal
            chk_cortina: "Cortina instalada y en buen estado", chk_mesa: "Mesa", 
            chk_silla: "Silla (con la mesa)", chk_nevera: "Nevera (Refrigerador)",
            chk_microondas: "Microondas",
            chk_parrilla: "Parrilla para recoger (portaequipajes)",
            chk_colchon: "Colchón en buen estado",
            chk_nochero: "Mesa de noche (Nochero)",
            chk_lamparas_hab: "Lámparas de la habitación", chk_outlet_ac: "Outlet (enchufe) del A/C en buen estado",
            chk_tv: "Televisor", chk_tapas_emergencia: "Tapas de emergencia blancas", chk_covers_outlets: "Covers de los outlets completos y sanos",
            chk_covers_luces: "Covers de las luces completos y sanos", chk_extractor: "Extractor de humo / Detector de humo",
            chk_puerta: "Puerta principal (Mecanismo bien)", chk_stop_door: "Stop door instalado y funcionando",
            chk_paredes: "Paredes (Sin rayones graves ni daños)", chk_griferia: "Grifería de la ducha en buen estado",
            chk_lavamanos: "Lavamanos", chk_espejo: "Espejo (en el área del lavamanos)", chk_toilet: "Toilet (Inodoro)",
            chk_coso_papel: "Set de baño", chk_lampara_bano: "Lámpara del baño", chk_cover_extractor: "Cover del extractor de aire",
            chk_remiendo: "Falta algún remiendo o parche en la pared", chk_pintura: "Requiere retoque de pintura",
            
            // Textos CORTOS exclusivamente para el Resumen/Reporte final
            shortNames: {
                chk_cortina: "Cortina", chk_mesa: "Mesa", chk_silla: "Silla", chk_nevera: "Nevera",
                chk_microondas: "Microondas",
                chk_parrilla: "Parrilla", chk_colchon: "Colchón", chk_nochero: "Mesa de noche",
                chk_lamparas_hab: "Lámparas hab.", chk_outlet_ac: "Enchufe A/C",
                chk_tv: "Televisor", chk_tapas_emergencia: "Tapas emergencia", chk_covers_outlets: "Tapas enchufes",
                chk_covers_luces: "Tapas luces", chk_extractor: "Extractor", chk_puerta: "Puerta",
                chk_stop_door: "Tope puerta", chk_paredes: "Paredes", chk_griferia: "Grifería",
                chk_lavamanos: "Lavamanos", chk_espejo: "Espejo", chk_toilet: "Toilet",
                chk_coso_papel: "Set de baño", chk_lampara_bano: "Lámpara baño", chk_cover_extractor: "Tapa extractor"
            },

            repTitle: "Reporte de Faltantes y Notas", repDate: "Generado el:",
            repRoom: "Habitación", repStatusDirty: "Estado: SUCIO", repAcBad: "A/C: Dañado/No trabaja",
            repMissing: "Faltantes:", repPatch: "Pared: Falta parche.", repPaint: "Pintura: Requiere retoque.",
            repMaintDetail: "Mantenimiento:", repNotes: "Notas:"
        },
        en: {
            appTitle: "🏨 Hotel Control App", floor1: "Floor 1 (101 - 114)", floor2: "Floor 2 (201 - 214)",
            selectedRoom: "Selected Room:", status: "Status:", clean: "Clean", dirty: "Dirty",
            inspectedBy: "Inspected by:", date: "Date:", roomAreaTitle: "🛏️ Room Area",
            backToHome: "Back to Home",
            bedSetup: "Bed Setup:", bedKing: "1 King", bedQueen: "1 Queen", bed2Queen: "2 Queen",
            acTitle: "🔌 Electricity, A/C & Security", acStatus: "Air Conditioning (A/C):", works: "Working", noworks: "Not working",
            doorTitle: "🚪 Doors & Walls", bathTitle: "🛁 Bathroom Area", bathType: "Bath Type:", tub: "Bathtub", showerOnly: "Shower Only",
            maintTitle: "🛠️ Pending Maintenance", notesTitle: "➕ Additional Notes",
            btnViewSummary: "View On-Screen Summary", btnPrintRoom: "Print Current Room", btnPrintReport: "Print Consolidated Report", btnClose: "Close",
            btnSyncSheets: "Save to Google Sheets", btnSyncing: "Saving...",
            btnLoadSheets: "Load from Google Sheets", btnLoadingSheets: "Loading...",
            maintPh: "Describe damages or paint needed...", notesPh: "Extra observations, attachments...",
            bannerTitle: "Under Construction! 🛠️", bannerDesc: "Put on your hard hat. We're coding and hammering away to bring amazing new features to this Inventory section.", bannerBadge: "Coming Soon!",
            blueprintTitle: "Interactive Blueprint - Room",
            legendOk: "Perfect / Present", legendMissing: "Missing / Damaged",
            legendInteractive: "Click on blueprint objects to check/uncheck.",
            
            chk_cortina: "Curtain installed and in good condition", chk_mesa: "Table", 
            chk_silla: "Chair (with the table)", chk_nevera: "Refrigerator",
            chk_microondas: "Microwave",
            chk_parrilla: "Luggage rack",
            chk_colchon: "Mattress in good condition",
            chk_nochero: "Nightstand",
            chk_lamparas_hab: "Room lamps", chk_outlet_ac: "A/C outlet in good condition",
            chk_tv: "Television", chk_tapas_emergencia: "White emergency power covers", chk_covers_outlets: "Outlet covers complete/intact",
            chk_covers_luces: "Light switch covers complete/intact", chk_extractor: "Smoke detector / Exhaust",
            chk_puerta: "Main door (Mechanism works)", chk_stop_door: "Door stop installed and working",
            chk_paredes: "Walls (No major scratches or damage)", chk_griferia: "Shower fixtures in good condition",
            chk_lavamanos: "Sink", chk_espejo: "Mirror (in sink area)", chk_toilet: "Toilet",
            chk_coso_papel: "Bathroom set", chk_lampara_bano: "Bathroom lamp", chk_cover_extractor: "Exhaust fan cover",
            chk_remiendo: "Wall patch needed", chk_pintura: "Paint touch-up needed",

            shortNames: {
                chk_cortina: "Curtain", chk_mesa: "Table", chk_silla: "Chair", chk_nevera: "Fridge",
                chk_microondas: "Microwave",
                chk_parrilla: "Luggage rack", chk_colchon: "Mattress", chk_nochero: "Nightstand",
                chk_lamparas_hab: "Room lamps", chk_outlet_ac: "A/C outlet",
                chk_tv: "TV", chk_tapas_emergencia: "Emergency covers", chk_covers_outlets: "Outlet covers",
                chk_covers_luces: "Light covers", chk_extractor: "Exhaust/Smoke", chk_puerta: "Door",
                chk_stop_door: "Door stop", chk_paredes: "Walls", chk_griferia: "Fixtures",
                chk_lavamanos: "Sink", chk_espejo: "Mirror", chk_toilet: "Toilet",
                chk_coso_papel: "Bath set", chk_lampara_bano: "Bath lamp", chk_cover_extractor: "Exhaust cover"
            },

            repTitle: "Missing Items & Notes Summary", repDate: "Generated on:",
            repRoom: "Room", repStatusDirty: "Status: DIRTY", repAcBad: "A/C: Not working",
            repMissing: "Missing:", repPatch: "Wall: Patch needed.", repPaint: "Paint: Touch-up needed.",
            repMaintDetail: "Maintenance:", repNotes: "Notes:"
        }
    };

    let currentLang = '{{ app()->getLocale() }}';

    function setLanguage(lang) {
        currentLang = lang;
        
        // Sincronizar idioma con la sesion del servidor de forma silenciosa
        fetch('?lang=' + lang).catch(err => console.error(err));
        
        document.getElementById('btn-es').classList.toggle('active', lang === 'es');
        document.getElementById('btn-en').classList.toggle('active', lang === 'en');

        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if(dict[lang][key]) el.innerText = dict[lang][key];
        });

        document.querySelectorAll('[data-i18n-ph]').forEach(el => {
            const key = el.getAttribute('data-i18n-ph');
            if(dict[lang][key]) el.placeholder = dict[lang][key];
        });
    }

    const roomConfigs = {
        // Piso 1
        101: { camas: '1_queen', type: 'Queen' },
        102: { camas: '1_queen', type: 'Queen' },
        103: { camas: '1_king', type: 'King' },
        104: { camas: '1_king', type: 'King' },
        105: { camas: '1_king', type: 'King' },
        106: { camas: '2_queen', type: 'Queen' },
        107: { camas: '1_king', type: 'King' },
        108: { camas: '2_queen', type: 'Queen' },
        109: { camas: '1_queen', type: 'Queen' },
        110: { camas: '1_king', type: 'King' },
        111: { camas: '1_king', type: 'King' },
        112: { camas: '1_king', type: 'King' },
        113: { camas: '1_queen', type: 'Queen' },
        114: { camas: '1_queen', type: 'Queen' },
        // Piso 2
        201: { camas: '1_king', type: 'King' },
        202: { camas: '1_king', type: 'King' },
        203: { camas: '2_queen', type: 'Queen' },
        204: { camas: '2_queen', type: 'Queen' },
        205: { camas: '2_queen', type: 'Queen' },
        206: { camas: '2_queen', type: 'Queen' },
        207: { camas: '2_queen', type: 'Queen' },
        208: { camas: '2_queen', type: 'Queen' },
        209: { camas: '2_queen', type: 'Queen' },
        210: { camas: '2_queen', type: 'Queen' },
        211: { camas: '2_queen', type: 'Queen' },
        212: { camas: '2_queen', type: 'Queen' },
        213: { camas: '1_king', type: 'King' },
        214: { camas: '1_king', type: 'King' }
    };

    const rooms1 = Array.from({length: 14}, (_, i) => 101 + i);
    const rooms2 = Array.from({length: 14}, (_, i) => 201 + i);
    const allRooms = [...rooms1, ...rooms2];
    
    let hotelData = JSON.parse(localStorage.getItem('hotelControlData')) || {};
    let currentRoom = parseInt(localStorage.getItem('hotelControlCurrentRoom')) || 101;

    allRooms.forEach(r => {
        if (!hotelData[r]) hotelData[r] = {};
        if (!hotelData[r].camas && roomConfigs[r]) {
            hotelData[r].camas = roomConfigs[r].camas;
        }
    });

    const navPiso1 = document.getElementById('nav-piso1');
    const navPiso2 = document.getElementById('nav-piso2');
    const lblRoom = document.getElementById('lbl-room');
    const form = document.getElementById('checklist-form');
    
    const requiredItems = [
        "chk_cortina", "chk_mesa", "chk_silla", "chk_nevera", "chk_microondas", "chk_parrilla",
        "chk_colchon", "chk_nochero", "chk_lamparas_hab", "chk_outlet_ac", 
        "chk_tv", "chk_tapas_emergencia", "chk_covers_outlets", "chk_covers_luces", 
        "chk_extractor", "chk_puerta", "chk_stop_door", "chk_paredes", "chk_griferia", 
        "chk_lavamanos", "chk_espejo", "chk_toilet", "chk_coso_papel", "chk_lampara_bano", "chk_cover_extractor"
    ];

    // --- FUNCIÓN DEL SEMÁFORO (Verifica si está PERFECTA) ---
    function isRoomPerfect(data) {
        if (!data || Object.keys(data).length === 0) return false; 
        
        if (!data.camas) return false;
        if (!data.bano) return false;
        if (data.estado !== 'limpio') return false;
        if (data.ac !== 'si') return false;
        if (data.chk_remiendo || data.chk_pintura) return false;
        if (data.txt_mantenimiento && data.txt_mantenimiento.trim() !== '') return false;

        for (let i = 0; i < requiredItems.length; i++) {
            let key = requiredItems[i];
            
            if (data.camas === '2_queen' && (key === 'chk_mesa' || key === 'chk_silla')) {
                continue; 
            }
            
            if (!data[key]) return false; 
        }
        
        return true; 
    }

    function renderNav() {
        navPiso1.innerHTML = ''; navPiso2.innerHTML = '';
        allRooms.forEach(room => {
            const btn = document.createElement('button');
            btn.className = `room-btn ${room === currentRoom ? 'active' : ''}`;
            
            const data = hotelData[room];
            if(Object.keys(data).length > 0) {
                if (isRoomPerfect(data)) {
                    btn.classList.add('perfect-room'); 
                } else {
                    btn.classList.add('has-data'); 
                }
            }
            
            btn.innerText = room;
            btn.onclick = () => selectRoom(room);
            if(room < 200) navPiso1.appendChild(btn); else navPiso2.appendChild(btn);
        });
    }

    function selectRoom(room) {
        saveCurrentRoom();
        currentRoom = room;
        localStorage.setItem('hotelControlCurrentRoom', currentRoom);
        lblRoom.innerText = room;
        renderNav();
        loadRoomData(room);
    }

    function toggleMesaSilla() {
        const camas = document.querySelector('input[name="camas"]:checked')?.value;
        const divMesa = document.getElementById('div_mesa');
        const divSilla = document.getElementById('div_silla');
        
        if (camas === '2_queen') {
            divMesa.style.display = 'none';
            divSilla.style.display = 'none';
        } else {
            divMesa.style.display = 'block';
            divSilla.style.display = 'block';
        }
    }

    function loadRoomData(room) {
        const data = hotelData[room];
        form.reset();
        
        // Establecer valores por defecto si no están definidos
        if (data.estado === undefined) data.estado = 'limpio';
        if (data.ac === undefined) data.ac = 'si';
        if (data.bano === undefined) data.bano = 'banera';
        if (data.camas === undefined && roomConfigs[room]) data.camas = roomConfigs[room].camas;
        
        // Si la habitación tiene datos guardados, los campos desconocidos (nuevos)
        // deben aparecer sin marcar para que el personal los verifique.
        // Solo si la hab. nunca tuvo datos, los items obligatorios aparecen en verde.
        const hasExistingData = Object.keys(data).filter(k => k.startsWith('chk_')).length > 0;

        Array.from(form.elements).forEach(el => {
            if(el.type === 'checkbox') {
                if (el.id && el.id.startsWith('chk_')) {
                    if (el.id === 'chk_remiendo' || el.id === 'chk_pintura') {
                        el.checked = data[el.id] === true;
                    } else {
                        if (data[el.id] === undefined) {
                            // Campo nuevo: si hab. ya tenía data, aparece desmarcado para verificar.
                            // Si la hab. es nueva (sin data), aparece marcado por defecto.
                            el.checked = !hasExistingData;
                        } else {
                            el.checked = data[el.id] !== false;
                        }
                    }
                } else {
                    el.checked = !!data[el.id];
                }
            }
            else if(el.type === 'radio') { if(data[el.name] === el.value) el.checked = true; }
            else if(el.id) el.value = data[el.id] || '';
        });
        
        toggleMesaSilla(); 
        updateBlueprint();
    }

    function saveCurrentRoom() {
        const data = {};
        Array.from(form.elements).forEach(el => {
            if(el.type === 'checkbox') data[el.id] = el.checked;
            else if(el.type === 'radio') { if(el.checked) data[el.name] = el.value; }
            else if(el.id) data[el.id] = el.value;
        });
        
        if(Object.values(data).some(v => v !== false && v !== '')) hotelData[currentRoom] = data;
        else hotelData[currentRoom] = {};
        
        localStorage.setItem('hotelControlData', JSON.stringify(hotelData));
        renderNav(); 
        updateBlueprint();
    }

    form.addEventListener('change', saveCurrentRoom);
    form.addEventListener('keyup', saveCurrentRoom);

    // --- BLUEPRINT SYNCHRONIZATION AND INTERACTION ---
    function updateBlueprint() {
        const data = hotelData[currentRoom] || {};
        
        // 1. Checkboxes mapping
        requiredItems.forEach(key => {
            const svgEl = document.getElementById('svg-' + key.replace('chk_', '').replace(/_/g, '-'));
            if (svgEl) {
                const isChecked = !!data[key];
                if (isChecked) {
                    svgEl.classList.remove('status-error');
                    svgEl.classList.add('status-ok');
                } else {
                    svgEl.classList.remove('status-ok');
                    svgEl.classList.add('status-error');
                }
            }
        });
        
        // 2. Door swing condition
        const doorEl = document.getElementById('svg-puerta');
        if (doorEl) {
            if (data['chk_puerta']) {
                doorEl.classList.remove('status-error');
                doorEl.classList.add('status-ok');
            } else {
                doorEl.classList.remove('status-ok');
                doorEl.classList.add('status-error');
            }
        }
        
        // 3. Walls condition
        const wallsEl = document.getElementById('svg-walls');
        if (wallsEl) {
            if (data['chk_paredes']) {
                wallsEl.classList.remove('status-error');
                wallsEl.classList.add('status-ok');
            } else {
                wallsEl.classList.remove('status-ok');
                wallsEl.classList.add('status-error');
            }
        }
        
        // 4. A/C unit condition
        const acEl = document.getElementById('svg-ac');
        if (acEl) {
            const acVal = data['ac'] || 'no';
            if (acVal === 'si') {
                acEl.classList.remove('status-error');
                acEl.classList.add('status-ok');
                acEl.setAttribute('data-target-value', 'no');
            } else {
                acEl.classList.remove('status-ok');
                acEl.classList.add('status-error');
                acEl.setAttribute('data-target-value', 'si');
            }
        }
        
        // 5. Beds toggling (1 King vs 1 Queen vs 2 Queen)
        const camasVal = data['camas'] || (roomConfigs[currentRoom] ? roomConfigs[currentRoom].camas : '1_queen');
        
        const group1Cama = document.getElementById('group-1-cama');
        const group2Camas = document.getElementById('group-2-camas');
        const bedLabel = document.getElementById('svg-bed-label');
        const bedsLabel = document.getElementById('svg-beds-label');
        const groupMesaSilla = document.getElementById('group-mesa-silla');
        
        if (camasVal === '2_queen') {
            if (group1Cama) group1Cama.style.display = 'none';
            if (groupMesaSilla) groupMesaSilla.style.display = 'none';
            if (group2Camas) {
                group2Camas.style.display = 'block';
                if (bedsLabel) {
                    bedsLabel.textContent = '2 QUEEN BEDS';
                }
                if (data['estado'] === 'limpio') {
                    group2Camas.classList.remove('status-error');
                    group2Camas.classList.add('status-ok');
                } else {
                    group2Camas.classList.remove('status-ok');
                    group2Camas.classList.add('status-error');
                }
            }
        } else {
            if (group2Camas) group2Camas.style.display = 'none';
            if (groupMesaSilla) groupMesaSilla.style.display = 'block';
            if (group1Cama) {
                group1Cama.style.display = 'block';
                if (bedLabel) {
                    bedLabel.textContent = camasVal === '1_king' ? 'KING BED' : 'QUEEN BED';
                }
                if (data['estado'] === 'limpio') {
                    group1Cama.classList.remove('status-error');
                    group1Cama.classList.add('status-ok');
                } else {
                    group1Cama.classList.remove('status-ok');
                    group1Cama.classList.add('status-error');
                }
            }
        }
        
        // 6. Bath toggling (Bathtub vs Shower Only)
        const banoVal = data['bano'] || 'banera';
        const groupBanera = document.getElementById('group-banera');
        const groupDucha = document.getElementById('group-ducha');
        
        const isGriferiaOk = !!data['chk_griferia'];
        const svgGriferiaBanera = document.getElementById('svg-griferia-banera');
        const svgGriferiaDucha = document.getElementById('svg-griferia-ducha');
        
        if (isGriferiaOk) {
            if (svgGriferiaBanera) { svgGriferiaBanera.classList.remove('status-error'); svgGriferiaBanera.classList.add('status-ok'); }
            if (svgGriferiaDucha) { svgGriferiaDucha.classList.remove('status-error'); svgGriferiaDucha.classList.add('status-ok'); }
        } else {
            if (svgGriferiaBanera) { svgGriferiaBanera.classList.remove('status-ok'); svgGriferiaBanera.classList.add('status-error'); }
            if (svgGriferiaDucha) { svgGriferiaDucha.classList.remove('status-ok'); svgGriferiaDucha.classList.add('status-error'); }
        }
        
        if (banoVal === 'ducha') {
            if (groupBanera) groupBanera.style.display = 'none';
            if (groupDucha) {
                groupDucha.style.display = 'block';
                if (isGriferiaOk) {
                    groupDucha.classList.remove('status-error');
                    groupDucha.classList.add('status-ok');
                } else {
                    groupDucha.classList.remove('status-ok');
                    groupDucha.classList.add('status-error');
                }
            }
        } else {
            if (groupDucha) groupDucha.style.display = 'none';
            if (groupBanera) {
                groupBanera.style.display = 'block';
                if (isGriferiaOk) {
                    groupBanera.classList.remove('status-error');
                    groupBanera.classList.add('status-ok');
                } else {
                    groupBanera.classList.remove('status-ok');
                    groupBanera.classList.add('status-error');
                }
            }
        }
        
        // 7. General Maintenance Alert (Warning Triangle)
        const maintAlert = document.getElementById('svg-maint-alert');
        if (maintAlert) {
            const hasMaint = !!data['chk_remiendo'] || !!data['chk_pintura'] || (data['txt_mantenimiento'] && data['txt_mantenimiento'].trim() !== '');
            if (hasMaint) {
                maintAlert.style.display = 'block';
                maintAlert.classList.add('status-error');
                maintAlert.classList.remove('status-ok');
            } else {
                maintAlert.style.display = 'none';
            }
        }

        // 8. Cleanliness status badge inside blueprint
        const cleanIndicator = document.getElementById('svg-clean-indicator');
        const cleanText = document.getElementById('svg-clean-text');
        if (cleanIndicator && cleanText) {
            const cleanVal = data['estado'] || 'sucio';
            if (cleanVal === 'limpio') {
                cleanIndicator.classList.remove('status-error');
                cleanIndicator.classList.add('status-ok');
                cleanIndicator.setAttribute('data-target-value', 'sucio');
                cleanText.textContent = currentLang === 'es' ? 'LIMPIO' : 'CLEAN';
            } else {
                cleanIndicator.classList.remove('status-ok');
                cleanIndicator.classList.add('status-error');
                cleanIndicator.setAttribute('data-target-value', 'limpio');
                cleanText.textContent = currentLang === 'es' ? 'SUCIO' : 'DIRTY';
            }
        }
    }

    // Interactive Blueprint Clicks Event Delegation
    document.addEventListener('click', function(e) {
        const item = e.target.closest('.interactive-svg-item');
        if (!item) return;

        // Toggles a checkbox
        const targetId = item.getAttribute('data-target');
        if (targetId) {
            const checkbox = document.getElementById(targetId);
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }

        // Toggles a radio group
        const radioName = item.getAttribute('data-target-radio');
        if (radioName) {
            const value = item.getAttribute('data-target-value');
            const radio = document.querySelector(`input[name="${radioName}"][value="${value}"]`);
            if (radio) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    });

    function generateReportHTML() {
        saveCurrentRoom();
        const t = dict[currentLang];
        let html = `<h2 style="text-align: center; color: #dc3545; margin-top:0;">📊 ${t.repTitle}</h2>`;
        html += `<p style="text-align: center; color: #555;">${t.repDate} ${new Date().toLocaleDateString()}</p><hr>`;

        let hasIssues = false;

        allRooms.forEach(room => {
            const data = hotelData[room];
            if(Object.keys(data).length === 0) return;

            let issues = [];

            if(data.estado === 'sucio') issues.push(`<strong>${t.repStatusDirty}</strong>`);
            if(data.ac === 'no') issues.push(`<strong>${t.repAcBad}</strong>`);
            
            let missingItems = [];
            requiredItems.forEach(key => {
                if (data.camas === '2' && (key === 'chk_mesa' || key === 'chk_silla')) {
                    return; 
                }
                
                if(!data[key]) {
                    missingItems.push(t.shortNames[key]);
                }
            });
            
            if(missingItems.length > 0) {
                issues.push(`<strong>${t.repMissing}</strong> ${missingItems.join(', ')}`);
            }

            if(data.chk_remiendo) issues.push(`<strong>${t.repPatch}</strong>`);
            if(data.chk_pintura) issues.push(`<strong>${t.repPaint}</strong>`);
            if(data.txt_mantenimiento && data.txt_mantenimiento.trim() !== "") {
                issues.push(`<strong>${t.repMaintDetail}</strong> ${data.txt_mantenimiento}`);
            }
            if(data.txt_notas && data.txt_notas.trim() !== "") {
                issues.push(`<strong>${t.repNotes}</strong> ${data.txt_notas}`);
            }

            if(issues.length > 0) {
                hasIssues = true;
                html += `
                    <div class="report-room-card">
                        <h3>${t.repRoom} ${room}</h3>
                        ${issues.map(iss => `<div class="report-item">- ${iss}</div>`).join('')}
                    </div>
                `;
            }
        });

        if(!hasIssues) {
            html += `<h3 style="text-align:center; color: #28a745; margin-top: 20px;">🎉 Todo en orden. No hay faltantes.</h3>`;
        }
        
        return html;
    }

    function showSummaryModal() {
        const htmlContent = generateReportHTML();
        document.getElementById('modal-body').innerHTML = htmlContent;
        document.getElementById('summary-modal').style.display = 'flex';
    }

    function closeSummaryModal() {
        document.getElementById('summary-modal').style.display = 'none';
    }

    function printCurrentRoom() {
        document.getElementById('app-view').classList.remove('no-print');
        document.getElementById('consolidated-view').style.display = 'none';
        window.print();
        document.getElementById('consolidated-view').style.display = '';
    }

    function printConsolidatedReport() {
        const reportDiv = document.getElementById('consolidated-view');
        reportDiv.innerHTML = `<div style="padding: 20px;">${generateReportHTML()}</div>`;

        document.getElementById('app-view').classList.add('no-print');
        reportDiv.classList.add('print-only');
        reportDiv.style.display = 'block';
        
        window.print();
        
        document.getElementById('app-view').classList.remove('no-print');
        reportDiv.classList.remove('print-only');
        reportDiv.style.display = 'none';
    }

    async function syncCurrentRoomToGoogleSheets() {
        const btn = document.getElementById('btn-sync-sheets');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '⏳ <span data-i18n="btnSyncing">Guardando...</span>';

        saveCurrentRoom();
        const data = hotelData[currentRoom] || {};

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/api/sync-room', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    room: currentRoom,
                    data: data
                })
            });

            const result = await response.json();

            if (result.success) {
                alert('✓ ' + (currentLang === 'es' ? 'Sincronizado correctamente con Google Sheets.' : 'Successfully synced with Google Sheets.'));
            } else {
                if (result.error_type === 'api_disabled') {
                    if (confirm((currentLang === 'es' 
                        ? 'La API de Google Sheets no está habilitada en tu Consola de Google Cloud. ¿Deseas abrir la consola para habilitarla?' 
                        : 'Google Sheets API is not enabled. Do you want to go and enable it now?'))) {
                        window.open('https://console.developers.google.com/apis/api/sheets.googleapis.com/overview?project=jovan-gprh', '_blank');
                    }
                } else {
                    alert('Error: ' + result.message);
                }
            }
        } catch (error) {
            console.error(error);
            alert((currentLang === 'es' ? 'Error de red al conectar con el servidor.' : 'Network error connecting to the server.'));
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
            setLanguage(currentLang);
        }
    }

    async function syncAllRoomsFromGoogleSheets() {
        try {
            const response = await fetch('/api/load-all-rooms', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            if (result.success && result.data) {
                const activeElement = document.activeElement;
                const isFormFocused = activeElement && form.contains(activeElement);
                
                allRooms.forEach(room => {
                    if (room === currentRoom && isFormFocused) {
                        return;
                    }
                    if (result.data[room] && Object.keys(result.data[room]).length > 0) {
                        hotelData[room] = result.data[room];
                    } else {
                        hotelData[room] = {};
                    }
                });
                localStorage.setItem('hotelControlData', JSON.stringify(hotelData));
                
                if (!isFormFocused) {
                    loadRoomData(currentRoom);
                }
                renderNav();
            }
        } catch (error) {
            console.error('Error al sincronizar habitaciones desde la nube:', error);
        }
    }

    // --- INICIALIZACIÓN ---
    setLanguage('{{ app()->getLocale() }}');
    lblRoom.innerText = currentRoom; 
    renderNav();
    loadRoomData(currentRoom);

    // Cargar todas las habitaciones al iniciar (solo 1 vez, sin setInterval)
    syncAllRoomsFromGoogleSheets();

</script>
</body>
</html>
