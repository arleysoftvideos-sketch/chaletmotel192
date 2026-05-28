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
            max-width: 1000px; 
            margin: 0 auto; 
            background: var(--box-bg); 
            padding: 30px; 
            border-radius: 16px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid var(--border);
            position: relative;
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
    
    
    <div class="room-nav-title" data-i18n="floor1">Piso 1 (101 - 114)</div>
    <div class="room-grid" id="nav-piso1"></div>
    
    <div class="room-nav-title" data-i18n="floor2">Piso 2 (201 - 214)</div>
    <div class="room-grid" id="nav-piso2"></div>

    <h2 style="margin-top: 20px; color: var(--text-color); display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
        <span>
            <span data-i18n="selectedRoom">Habitación Seleccionada:</span> 
            <span id="lbl-room" style="color: var(--primary);">101</span>
        </span>
        <button type="button" class="btn-cloud-load" onclick="loadCurrentRoomFromGoogleSheets()" id="btn-load-sheets" style="background: #14274c; border: 1px solid #1e293b; color: #cbd5e1; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: bold; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 5px;">
            ☁️ <span data-i18n="btnLoadSheets">Cargar desde Google Sheets</span>
        </button>
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

        <div class="section">
            <h3 data-i18n="roomAreaTitle">🛏️ Área de la Habitación</h3>
            <div class="radio-group">
                <span data-i18n="bedSetup">Configuración:</span> 
                <label><input type="radio" name="camas" value="1" onchange="toggleMesaSilla()"> <span data-i18n="oneBed">1 Cama</span></label>
                <label><input type="radio" name="camas" value="2" onchange="toggleMesaSilla()"> <span data-i18n="twoBeds">2 Camas</span></label>
            </div>
            <div class="checkbox-group"><label><input type="checkbox" id="chk_cortina"> <span data-i18n="chk_cortina">Cortina instalada y en buen estado</span></label></div>
            
            <div class="checkbox-group" id="div_mesa"><label><input type="checkbox" id="chk_mesa"> <span data-i18n="chk_mesa">Mesa</span></label></div>
            <div class="checkbox-group" id="div_silla"><label><input type="checkbox" id="chk_silla"> <span data-i18n="chk_silla">Silla (con la mesa)</span></label></div>
            
            <div class="checkbox-group"><label><input type="checkbox" id="chk_nevera"> <span data-i18n="chk_nevera">Nevera (Refrigerador)</span></label></div>
            <div class="checkbox-group"><label><input type="checkbox" id="chk_parrilla"> <span data-i18n="chk_parrilla">Parrilla para recoger (portaequipajes)</span></label></div>
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
            bedSetup: "Configuración:", oneBed: "1 Cama", twoBeds: "2 Camas",
            acTitle: "🔌 Electricidad, Climatización y Seguridad", acStatus: "Aire acondicionado (A/C):", works: "Sí trabaja", noworks: "No trabaja",
            doorTitle: "🚪 Puertas y Paredes", bathTitle: "🛁 Área del Baño", bathType: "Tipo de baño:", tub: "Bañera", showerOnly: "Ducha sola",
            maintTitle: "🛠️ Mantenimiento Pendiente", notesTitle: "➕ Notas Adicionales",
            btnViewSummary: "Ver Resumen en Pantalla", btnPrintRoom: "Imprimir Hab. Actual", btnPrintReport: "Imprimir Consolidado Faltantes", btnClose: "Cerrar",
            btnSyncSheets: "Guardar en Google Sheets", btnSyncing: "Guardando...",
            btnLoadSheets: "Cargar desde Google Sheets", btnLoadingSheets: "Cargando...",
            maintPh: "Describe los daños o pinturas necesarias...", notesPh: "Observaciones extra, anexos...",
            
            // Textos largos para la pantalla principal
            chk_cortina: "Cortina instalada y en buen estado", chk_mesa: "Mesa", 
            chk_silla: "Silla (con la mesa)", chk_nevera: "Nevera (Refrigerador)",
            chk_parrilla: "Parrilla para recoger (portaequipajes)",
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
                chk_parrilla: "Parrilla", chk_lamparas_hab: "Lámparas hab.", chk_outlet_ac: "Enchufe A/C",
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
            bedSetup: "Bed Setup:", oneBed: "1 Bed", twoBeds: "2 Beds",
            acTitle: "🔌 Electricity, A/C & Security", acStatus: "Air Conditioning (A/C):", works: "Working", noworks: "Not working",
            doorTitle: "🚪 Doors & Walls", bathTitle: "🛁 Bathroom Area", bathType: "Bath Type:", tub: "Bathtub", showerOnly: "Shower Only",
            maintTitle: "🛠️ Pending Maintenance", notesTitle: "➕ Additional Notes",
            btnViewSummary: "View On-Screen Summary", btnPrintRoom: "Print Current Room", btnPrintReport: "Print Consolidated Report", btnClose: "Close",
            btnSyncSheets: "Save to Google Sheets", btnSyncing: "Saving...",
            btnLoadSheets: "Load from Google Sheets", btnLoadingSheets: "Loading...",
            maintPh: "Describe damages or paint needed...", notesPh: "Extra observations, attachments...",
            
            chk_cortina: "Curtain installed and in good condition", chk_mesa: "Table", 
            chk_silla: "Chair (with the table)", chk_nevera: "Refrigerator",
            chk_parrilla: "Luggage rack",
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
                chk_parrilla: "Luggage rack", chk_lamparas_hab: "Room lamps", chk_outlet_ac: "A/C outlet",
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

    const rooms1 = Array.from({length: 14}, (_, i) => 101 + i);
    const rooms2 = Array.from({length: 14}, (_, i) => 201 + i);
    const allRooms = [...rooms1, ...rooms2];
    
    let hotelData = JSON.parse(localStorage.getItem('hotelControlData')) || {};
    let currentRoom = parseInt(localStorage.getItem('hotelControlCurrentRoom')) || 101;

    allRooms.forEach(r => { if (!hotelData[r]) hotelData[r] = {}; });

    const navPiso1 = document.getElementById('nav-piso1');
    const navPiso2 = document.getElementById('nav-piso2');
    const lblRoom = document.getElementById('lbl-room');
    const form = document.getElementById('checklist-form');
    
    const requiredItems = [
        "chk_cortina", "chk_mesa", "chk_silla", "chk_nevera", "chk_parrilla", "chk_lamparas_hab", "chk_outlet_ac", 
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
            
            if (data.camas === '2' && (key === 'chk_mesa' || key === 'chk_silla')) {
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
        
        // Auto-cargar datos desde Google Sheets en segundo plano al cambiar de habitación
        loadCurrentRoomFromGoogleSheetsSilently();
    }

    function toggleMesaSilla() {
        const camas = document.querySelector('input[name="camas"]:checked')?.value;
        const divMesa = document.getElementById('div_mesa');
        const divSilla = document.getElementById('div_silla');
        
        if (camas === '2') {
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
        Array.from(form.elements).forEach(el => {
            if(el.type === 'checkbox') el.checked = data[el.id] || false;
            else if(el.type === 'radio') { if(data[el.name] === el.value) el.checked = true; }
            else if(el.id) el.value = data[el.id] || '';
        });
        
        toggleMesaSilla(); 
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
    }

    form.addEventListener('change', saveCurrentRoom);
    form.addEventListener('keyup', saveCurrentRoom);

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

    async function loadCurrentRoomFromGoogleSheets() {
        const btn = document.getElementById('btn-load-sheets');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '⏳ <span data-i18n="btnLoadingSheets">Cargando...</span>';

        try {
            const response = await fetch(`/api/load-room/${currentRoom}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                if (result.exists && result.data) {
                    // Actualizar base de datos local y almacenamiento
                    hotelData[currentRoom] = result.data;
                    localStorage.setItem('hotelControlData', JSON.stringify(hotelData));
                    
                    // Cargar datos en el formulario
                    loadRoomData(currentRoom);
                    renderNav();
                    
                    alert('✓ ' + (currentLang === 'es' ? 'Datos cargados desde Google Sheets correctamente.' : 'Data loaded from Google Sheets successfully.'));
                } else {
                    alert((currentLang === 'es' 
                        ? 'No se encontraron datos registrados para esta habitación en Google Sheets.' 
                        : 'No inspection records found for this room in Google Sheets.'));
                }
            } else {
                alert('Error: ' + result.message);
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

    async function loadCurrentRoomFromGoogleSheetsSilently() {
        const btn = document.getElementById('btn-load-sheets');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '⏳ <span data-i18n="btnLoadingSheets">Cargando...</span>';

        try {
            const response = await fetch(`/api/load-room/${currentRoom}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success && result.exists && result.data) {
                // Actualizar almacenamiento local
                hotelData[currentRoom] = result.data;
                localStorage.setItem('hotelControlData', JSON.stringify(hotelData));
                
                // Refrescar formulario y navegación
                loadRoomData(currentRoom);
                renderNav();
            }
        } catch (error) {
            console.error('Error al precargar desde Google Sheets:', error);
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

    // Cargar todas las habitaciones al iniciar y configurar sondeo cada 15 segundos
    syncAllRoomsFromGoogleSheets();
    setInterval(syncAllRoomsFromGoogleSheets, 15000);

</script>
</body>
</html>
