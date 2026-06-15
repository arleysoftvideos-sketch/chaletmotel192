<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App Hotel Control - Reservas</title>

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
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }
        *, ::before, ::after {
            box-sizing: border-box;
        }
        body { 
            font-family: 'Inter', sans-serif; 
            margin: 0; padding: 20px; 
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        .container {
            max-width: 1200px; 
            margin: 0 auto; 
            background: var(--box-bg); 
            padding: 30px; 
            border-radius: 20px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            border: 1px solid var(--border);
            position: relative;
        }
        
        /* Navigation and Back Link */
        .header-nav {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #081326;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 15px 20px;
            text-align: center;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 13px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Grid and Layout */
        .main-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
        }
        @media (min-width: 900px) {
            .main-layout {
                grid-template-columns: 1.2fr 0.8fr;
            }
        }

        .room-nav-title { 
            margin-bottom: 12px; 
            font-weight: 700; 
            color: #94a3b8; 
            font-size: 14px; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 10px;
            margin-bottom: 25px;
        }
        .room-btn {
            padding: 14px 0;
            background-color: #14274c;
            border: 1px solid #1e293b;
            color: #cbd5e1;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }
        .room-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
        }
        
        /* Room States */
        .room-btn.available {
            border-bottom: 4px solid var(--success);
        }
        .room-btn.occupied {
            background-color: #581c1c !important; /* Premium wine red background */
            border: 1px solid #991b1b !important;
            border-bottom: 4px solid var(--danger) !important;
            color: #fca5a5 !important; /* Soft rose text color */
        }
        .room-btn.occupied:hover {
            background-color: #7f1d1d !important;
            border-color: var(--danger) !important;
            box-shadow: 0 6px 15px rgba(239, 68, 68, 0.25) !important;
        }
        .room-btn.active {
            background-color: var(--primary) !important;
            color: #0a1831 !important;
            border-color: var(--primary-hover) !important;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.3), 0 4px 12px rgba(255, 183, 3, 0.3) !important;
        }


        .room-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .room-btn.available .room-status-dot { background-color: var(--success); }
        .room-btn.occupied .room-status-dot { background-color: var(--danger); }
        
        /* Details Sidepanel */
        .detail-panel {
            background: #081326;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 25px;
            position: sticky;
            top: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            min-height: 400px;
        }
        .detail-header {
            border-bottom: 2px solid var(--border);
            padding-bottom: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .detail-title {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 800;
            margin: 0;
            color: #ffffff;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-badge.available {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .status-badge.occupied {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .info-group {
            margin-bottom: 15px;
        }
        .info-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 14px;
            color: #cbd5e1;
            font-weight: 500;
        }
        .notes-box {
            background: #0a1831;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            font-size: 13px;
            color: #cbd5e1;
            margin-top: 15px;
            max-height: 120px;
            overflow-y: auto;
            white-space: pre-wrap;
        }

        /* Buttons and inputs */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            font-size: 14px;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn-primary {
            background-color: var(--primary);
            color: #0a1831;
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
        }
        .btn-secondary {
            background-color: #14274c;
            color: #cbd5e1;
            border: 1px solid #1e293b;
        }
        .btn-secondary:hover {
            background-color: #1e293b;
        }
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        .btn-success:hover {
            background-color: #059669;
        }
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        .btn-danger:hover {
            background-color: #dc2626;
        }
        .actions-stack {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 25px;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 6px;
        }
        input[type="text"], input[type="tel"], input[type="number"], input[type="date"], select, textarea {
            width: 100%;
            padding: 10px 14px;
            background-color: #081326;
            color: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        input[type="text"]:focus, input[type="tel"]:focus, input[type="number"]:focus, input[type="date"]:focus, select:focus, textarea:focus {
            border-color: var(--primary);
            outline: none;
        }
        textarea {
            resize: vertical;
        }

        /* Modal Overlay & Content */
        .modal-overlay {
            display: none; 
            position: fixed; 
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.85); 
            z-index: 1000; 
            justify-content: center; 
            align-items: center; 
            padding: 20px; 
            backdrop-filter: blur(4px);
        }
        .modal-content {
            background: #0a1831; 
            width: 100%; 
            max-width: 550px; 
            max-height: 90vh;
            border-radius: 16px; 
            border: 1px solid var(--border); 
            overflow-y: auto; 
            padding: 30px; 
            position: relative; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            color: var(--text-color);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 12px;
        }
        .modal-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
        }
        .modal-close-btn {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 24px;
            cursor: pointer;
            transition: color 0.2s;
        }
        .modal-close-btn:hover {
            color: var(--danger);
        }

        /* Loading Spinner */
        .spinner-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(4, 10, 23, 0.75);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 15px;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--border);
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</head>
<body>

<!-- Spinner Loader Overlay -->
<div class="spinner-overlay" id="loading-spinner">
    <div class="spinner"></div>
    <div style="font-weight: bold; color: var(--primary);" id="spinner-msg" data-i18n="loadingData">Cargando datos...</div>
</div>

<!-- Modal: Check-in (Add Reservation) -->
<div class="modal-overlay" id="checkin-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" data-i18n="checkinTitle">Registrar Check-In / Nueva Reserva</h3>
            <button class="modal-close-btn" onclick="closeModal('checkin-modal')">&times;</button>
        </div>
        <form id="checkin-form" onsubmit="handleCheckIn(event)">
            <div class="form-group">
                <label class="form-label" data-i18n="formRoom">Habitación</label>
                <select id="checkin-room" required>
                    <!-- JavaScript will load these dynamically based on selection or fallback -->
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="formClient">Nombre del Cliente</label>
                <input type="text" id="checkin-cliente" required>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="formPhone">Teléfono</label>
                <input type="tel" id="checkin-telefono">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label" data-i18n="formStartDate">Fecha Inicio</label>
                    <input type="date" id="checkin-start" required>
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="formEndDate">Fecha Salida</label>
                    <input type="date" id="checkin-end" required>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="form-group">
                    <label class="form-label" data-i18n="formCleaning">Tasa de Aseo</label>
                    <input type="number" id="checkin-aseo" min="0" step="0.01" value="0">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="formDeposit">Depósito</label>
                    <input type="number" id="checkin-deposito" min="0" step="0.01" value="0">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="formMonthly">Total Pagado</label>
                    <input type="number" id="checkin-total-pagado" min="0" step="0.01" value="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="formNotes">Notas</label>
                <textarea id="checkin-notas" rows="3"></textarea>
            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-primary" data-i18n="btnSubmitCheckin">Crear Reserva / Check-In</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Reservation -->
<div class="modal-overlay" id="edit-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" data-i18n="editTitle">Editar Reserva</h3>
            <button class="modal-close-btn" onclick="closeModal('edit-modal')">&times;</button>
        </div>
        <form id="edit-form" onsubmit="handleEditSubmit(event)">
            <input type="hidden" id="edit-row">
            <input type="hidden" id="edit-fecha-registro">
            <div class="form-group">
                <label class="form-label" data-i18n="formRoom">Habitación</label>
                <select id="edit-room" required>
                    <!-- JavaScript loaded -->
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="formClient">Nombre del Cliente</label>
                <input type="text" id="edit-cliente" required>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="formPhone">Teléfono</label>
                <input type="tel" id="edit-telefono">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label" data-i18n="formStartDate">Fecha Inicio</label>
                    <input type="date" id="edit-start" required>
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="formEndDate">Fecha Salida</label>
                    <input type="date" id="edit-end" required>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="form-group">
                    <label class="form-label" data-i18n="formCleaning">Tasa de Aseo</label>
                    <input type="number" id="edit-aseo" min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="formDeposit">Depósito</label>
                    <input type="number" id="edit-deposito" min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="formMonthly">Total Pagado</label>
                    <input type="number" id="edit-total-pagado" min="0" step="0.01">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="formStatus">Estado</label>
                <select id="edit-estado" required>
                    <option value="ABIERTO">ABIERTO</option>
                    <option value="CERRADO">CERRADO</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="formNotes">Notas</label>
                <textarea id="edit-notas" rows="3"></textarea>
            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-primary" data-i18n="btnSaveChange">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- Main App Layout Container -->
<div class="container" id="app-view">
    <div class="header-nav">
        <a href="/" class="back-link">← <span data-i18n="backToHome">Volver a Inicio</span></a>
        <div class="lang-toggle">
            <button id="btn-es" class="lang-btn active" onclick="setLanguage('es')">🇪🇸 ES</button>
            <button id="btn-en" class="lang-btn" onclick="setLanguage('en')">🇺🇸 EN</button>
        </div>
    </div>
    
    <h1 data-i18n="appTitle">🏨 Control de Habitaciones y Reservas</h1>

    <!-- Stats summary section -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number text-red-500" id="stat-occupied">0</div>
            <div class="stat-label" data-i18n="labelOccupied">Ocupadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number text-emerald-500" id="stat-available">28</div>
            <div class="stat-label" data-i18n="labelAvailable">Disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number text-slate-300">28</div>
            <div class="stat-label" data-i18n="labelTotal">Total</div>
        </div>
    </div>

    <div class="main-layout">
        <!-- Room Selector Grid Column -->
        <div>
            <div class="room-nav-title" data-i18n="floor1">Piso 1 (101 - 114)</div>
            <div class="room-grid" id="nav-piso1"></div>
            
            <div class="room-nav-title" data-i18n="floor2">Piso 2 (201 - 214)</div>
            <div class="room-grid" id="nav-piso2"></div>
        </div>

        <!-- Room Detail Sidebar Column -->
        <div class="detail-panel">
            <div class="detail-header">
                <span class="detail-title"><span data-i18n="roomLabel">Habitación</span> <span id="lbl-room">101</span></span>
                <span class="status-badge" id="lbl-status" data-i18n="statusAvailable">Disponible</span>
            </div>

            <!-- Empty Detail state -->
            <div id="room-detail-empty" class="text-center py-10">
                <div class="text-4xl mb-4">🔑</div>
                <p class="text-slate-400 font-semibold mb-6" data-i18n="noBookingText">No hay reserva activa registrada para esta habitación.</p>
                <button class="btn btn-primary" onclick="openCheckInModal()" data-i18n="btnCheckinAction">Realizar Check-In</button>
            </div>

            <!-- Populated Detail state -->
            <div id="room-detail-info" style="display: none;">
                <div class="info-group">
                    <div class="info-label" data-i18n="detailGuest">Cliente</div>
                    <div class="info-value text-white font-bold text-lg" id="detail-cliente">Juan Pérez</div>
                </div>
                <div class="info-group">
                    <div class="info-label" data-i18n="detailPhone">Teléfono</div>
                    <div class="info-value" id="detail-telefono">555-0199</div>
                </div>
                
                <div class="grid grid-cols-3 gap-2 my-4">
                    <div class="info-group">
                        <div class="info-label" data-i18n="detailStart">Fecha Entrada</div>
                        <div class="info-value font-semibold text-slate-200" id="detail-start">15/06/2026</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label" data-i18n="detailEnd">Fecha Salida</div>
                        <div class="info-value font-semibold text-slate-200" id="detail-end">18/06/2026</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label" data-i18n="detailDaysRemaining">Días Faltantes</div>
                        <div class="info-value font-bold text-amber-500" id="detail-days-remaining">-</div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 my-4 border-t border-b border-[#14274c] py-3">
                    <div class="info-group">
                        <div class="info-label" data-i18n="detailCleaning">Aseo</div>
                        <div class="info-value text-gold" id="detail-aseo">$0</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label" data-i18n="detailDeposit">Depósito</div>
                        <div class="info-value text-gold" id="detail-deposito">$0</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label" data-i18n="detailMonthly">Total Pagado</div>
                        <div class="info-value text-gold" id="detail-total-pagado">$0</div>
                    </div>
                </div>

                <div class="info-group">
                    <div class="info-label" data-i18n="detailRegistered">Registrado el</div>
                    <div class="info-value text-sm text-slate-400" id="detail-registered">15/06/2026 10:30:22</div>
                </div>

                <div class="info-group">
                    <div class="info-label" data-i18n="detailNotes">Notas</div>
                    <div class="notes-box" id="detail-notas">Sin notas adicionales.</div>
                </div>

                <div class="actions-stack">
                    <button class="btn btn-success" onclick="triggerCheckout()" data-i18n="btnCheckoutAction">
                        🚪 Realizar Check-Out (Cerrar)
                    </button>
                    <button class="btn btn-secondary" onclick="openEditModal()" data-i18n="btnEditAction">
                        ✏️ Editar Reserva
                    </button>
                    <button class="btn btn-danger" onclick="triggerDelete()" data-i18n="btnDeleteAction">
                        🗑️ Eliminar Registro
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Dictionary of strings for dynamic language support
    const dict = {
        es: {
            appTitle: "🏨 Control de Habitaciones y Reservas",
            floor1: "Piso 1 (101 - 114)",
            floor2: "Piso 2 (201 - 214)",
            backToHome: "Volver a Inicio",
            labelOccupied: "Ocupadas",
            labelAvailable: "Disponibles",
            labelTotal: "Total",
            roomLabel: "Habitación",
            statusAvailable: "Disponible",
            statusOccupied: "Ocupada",
            noBookingText: "No hay reserva activa registrada para esta habitación.",
            btnCheckinAction: "Realizar Check-In",
            detailGuest: "Cliente",
            detailPhone: "Teléfono",
            detailStart: "Fecha Entrada",
            detailEnd: "Fecha Salida",
            detailCleaning: "Aseo",
            detailDeposit: "Depósito",
            detailMonthly: "Total Pagado",
            detailDaysRemaining: "Días Faltantes",
            detailRegistered: "Registrado el",
            detailNotes: "Notas",
            btnCheckoutAction: "🚪 Realizar Check-Out (Cerrar)",
            btnEditAction: "✏️ Editar Reserva",
            btnDeleteAction: "🗑️ Eliminar Registro",
            
            // Modals
            checkinTitle: "Registrar Check-In / Nueva Reserva",
            editTitle: "Editar Reserva",
            formRoom: "Habitación",
            formClient: "Nombre del Cliente",
            formPhone: "Teléfono",
            formStartDate: "Fecha Inicio",
            formEndDate: "Fecha Salida",
            formCleaning: "Tasa de Aseo",
            formDeposit: "Depósito",
            formMonthly: "Total Pagado",
            formStatus: "Estado",
            formNotes: "Notas",
            btnSubmitCheckin: "Crear Reserva / Check-In",
            btnSaveChange: "Guardar Cambios",
            
            // Messages
            loadingData: "Cargando datos...",
            syncingData: "Sincronizando con Google Sheets...",
            savingData: "Guardando cambios...",
            checkoutConfirm: "¿Estás seguro de que deseas realizar el Check-out de esta habitación? El estado pasará a CERRADO.",
            deleteConfirm: "¡Atención! ¿Estás seguro de que deseas eliminar permanentemente esta reserva de Google Sheets? Esta acción no se puede deshacer.",
            msgCheckoutSuccess: "Check-out realizado exitosamente.",
            msgDeleteSuccess: "Reserva eliminada con éxito.",
            msgSaveSuccess: "Reserva creada con éxito.",
            msgEditSuccess: "Reserva actualizada con éxito.",
            msgErrorFetch: "Error al obtener reservas del servidor.",
            msgErrorAction: "Ocurrió un error al realizar la operación."
        },
        en: {
            appTitle: "🏨 Room Control & Reservations",
            floor1: "Floor 1 (101 - 114)",
            floor2: "Floor 2 (201 - 214)",
            backToHome: "Back to Home",
            labelOccupied: "Occupied",
            labelAvailable: "Available",
            labelTotal: "Total",
            roomLabel: "Room",
            statusAvailable: "Available",
            statusOccupied: "Occupied",
            noBookingText: "No active booking logged for this room.",
            btnCheckinAction: "Check-In Guest",
            detailGuest: "Guest",
            detailPhone: "Phone",
            detailStart: "Start Date",
            detailEnd: "End Date",
            detailCleaning: "Cleaning",
            detailDeposit: "Deposit",
            detailMonthly: "Total Paid",
            detailDaysRemaining: "Days Left",
            detailRegistered: "Registered On",
            detailNotes: "Notes",
            btnCheckoutAction: "🚪 Check-Out (Close State)",
            btnEditAction: "✏️ Edit Booking",
            btnDeleteAction: "🗑️ Delete Booking",
            
            // Modals
            checkinTitle: "Log Check-In / New Reservation",
            editTitle: "Edit Reservation",
            formRoom: "Room",
            formClient: "Guest Name",
            formPhone: "Phone Number",
            formStartDate: "Start Date",
            formEndDate: "End Date",
            formCleaning: "Cleaning Fee",
            formDeposit: "Security Deposit",
            formMonthly: "Total Paid",
            formStatus: "Status",
            formNotes: "Notes",
            btnSubmitCheckin: "Save Check-In / Booking",
            btnSaveChange: "Save Changes",
            
            // Messages
            loadingData: "Loading data...",
            syncingData: "Syncing with Google Sheets...",
            savingData: "Saving changes...",
            checkoutConfirm: "Are you sure you want to Check-out this room? Status will be changed to CLOSED (CERRADO).",
            deleteConfirm: "Warning! Are you sure you want to permanently delete this reservation from Google Sheets? This action cannot be undone.",
            msgCheckoutSuccess: "Check-out completed successfully.",
            msgDeleteSuccess: "Reservation deleted successfully.",
            msgSaveSuccess: "Reservation created successfully.",
            msgEditSuccess: "Reservation updated successfully.",
            msgErrorFetch: "Error loading reservations from server.",
            msgErrorAction: "An error occurred while performing the action."
        }
    };

    let currentLang = '{{ app()->getLocale() }}';
    let bookingsList = [];
    let currentRoom = 101;

    // Room IDs list
    const rooms1 = Array.from({length: 14}, (_, i) => 101 + i);
    const rooms2 = Array.from({length: 14}, (_, i) => 201 + i);
    const allRooms = [...rooms1, ...rooms2];

    // Language Toggle logic
    function setLanguage(lang) {
        currentLang = lang;
        
        // Sync language with server locale cookie/session silently
        fetch('?lang=' + lang).catch(err => console.error(err));
        
        document.getElementById('btn-es').classList.toggle('active', lang === 'es');
        document.getElementById('btn-en').classList.toggle('active', lang === 'en');

        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if(dict[lang][key]) el.innerText = dict[lang][key];
        });

        // Refresh detail panel labels and text based on current room selection
        if (bookingsList.length > 0) {
            updateRoomDetails(currentRoom);
        }
    }

    // Modal Control
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Loading overlay controls
    function showLoading(msgKey) {
        const text = dict[currentLang][msgKey] || 'Cargando...';
        document.getElementById('spinner-msg').innerText = text;
        document.getElementById('loading-spinner').style.display = 'flex';
    }
    function hideLoading() {
        document.getElementById('loading-spinner').style.display = 'none';
    }

    // Form Dropdown Initializer
    function initializeSelectOptions() {
        const checkinSelect = document.getElementById('checkin-room');
        const editSelect = document.getElementById('edit-room');
        
        checkinSelect.innerHTML = '';
        editSelect.innerHTML = '';

        allRooms.forEach(r => {
            const opt1 = document.createElement('option');
            opt1.value = r;
            opt1.innerText = r;
            checkinSelect.appendChild(opt1);

            const opt2 = document.createElement('option');
            opt2.value = r;
            opt2.innerText = r;
            editSelect.appendChild(opt2);
        });
    }

    // Load reservations from API
    async function loadBookings() {
        showLoading('loadingData');
        try {
            const response = await fetch('/api/rooms-control/bookings');
            const res = await response.json();
            if (res.success) {
                bookingsList = res.data || [];
                renderRoomGrid();
                updateRoomDetails(currentRoom);
                updateStats();
            } else {
                alert(dict[currentLang]['msgErrorFetch']);
            }
        } catch (err) {
            console.error(err);
            alert(dict[currentLang]['msgErrorFetch']);
        } finally {
            hideLoading();
        }
    }

    // Helper to get active booking for a room
    function getActiveBooking(room) {
        // Find the latest reservation with state ABIERTO or OCUPADA
        const roomReservations = bookingsList.filter(b => parseInt(b.room) === parseInt(room));
        if (roomReservations.length === 0) return null;

        // Sort descending by row number to find the latest
        roomReservations.sort((a, b) => b.row - a.row);
        
        const latest = roomReservations[0];
        if (latest.estado.toUpperCase() === 'ABIERTO' || latest.estado.toUpperCase() === 'OCUPADA') {
            return latest;
        }
        return null;
    }

    // Render Stats
    function updateStats() {
        let occupied = 0;
        allRooms.forEach(r => {
            if (getActiveBooking(r)) occupied++;
        });
        document.getElementById('stat-occupied').innerText = occupied;
        document.getElementById('stat-available').innerText = allRooms.length - occupied;
    }

    // Render Room grids
    function renderRoomGrid() {
        const navPiso1 = document.getElementById('nav-piso1');
        const navPiso2 = document.getElementById('nav-piso2');

        navPiso1.innerHTML = '';
        navPiso2.innerHTML = '';

        allRooms.forEach(room => {
            const btn = document.createElement('button');
            const activeBooking = getActiveBooking(room);
            
            btn.className = `room-btn ${room === currentRoom ? 'active' : ''} ${activeBooking ? 'occupied' : 'available'}`;
            
            const dot = document.createElement('span');
            dot.className = 'room-status-dot';
            btn.appendChild(dot);

            const numSpan = document.createElement('span');
            numSpan.innerText = room;
            btn.appendChild(numSpan);

            btn.onclick = () => selectRoom(room);

            if (room < 200) {
                navPiso1.appendChild(btn);
            } else {
                navPiso2.appendChild(btn);
            }
        });
    }

    // Room Selection
    function selectRoom(room) {
        currentRoom = room;
        // Update selection styles in grid
        document.querySelectorAll('.room-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        // Find clicked button
        const btns = document.querySelectorAll('.room-btn');
        btns.forEach(b => {
            if (b.innerText.includes(room.toString())) {
                b.classList.add('active');
            }
        });

          // Update Detail Panel content
    function updateRoomDetails(room) {
        const activeBooking = getActiveBooking(room);
        const emptyDiv = document.getElementById('room-detail-empty');
        const infoDiv = document.getElementById('room-detail-info');
        const statusBadge = document.getElementById('lbl-status');

        if (activeBooking) {
            // Occupied
            statusBadge.className = 'status-badge occupied';
            statusBadge.innerText = dict[currentLang]['statusOccupied'];

            document.getElementById('detail-cliente').innerText = activeBooking.cliente || 'N/A';
            document.getElementById('detail-telefono').innerText = activeBooking.telefono || 'N/A';
            document.getElementById('detail-start').innerText = formatDateString(activeBooking.fecha_inicio);
            document.getElementById('detail-end').innerText = formatDateString(activeBooking.fecha_salida);
            document.getElementById('detail-aseo').innerText = '$' + (parseFloat(activeBooking.tasa_aseo) || 0);
            document.getElementById('detail-deposito').innerText = '$' + (parseFloat(activeBooking.deposito) || 0);
            document.getElementById('detail-total-pagado').innerText = '$' + (parseFloat(activeBooking.total_pagado) || 0);
            document.getElementById('detail-registered').innerText = activeBooking.fecha_registro || 'N/A';
            document.getElementById('detail-notas').innerText = activeBooking.notas || 'Sin notas.';

            // Calculate days remaining dynamically
            const daysRemainingEl = document.getElementById('detail-days-remaining');
            if (activeBooking.fecha_salida) {
                const today = new Date();
                today.setHours(0,0,0,0);
                
                const parts = activeBooking.fecha_salida.split('-');
                let daysDiff = 0;
                if (parts.length === 3) {
                    // split values are YYYY-MM-DD
                    const endDate = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
                    endDate.setHours(0,0,0,0);
                    const diffTime = endDate - today;
                    daysDiff = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                }

                if (daysDiff > 0) {
                    daysRemainingEl.innerText = daysDiff + (currentLang === 'es' ? ' días' : ' days');
                    daysRemainingEl.className = 'info-value font-bold text-amber-500';
                } else if (daysDiff === 0) {
                    daysRemainingEl.innerText = (currentLang === 'es' ? 'Hoy' : 'Today');
                    daysRemainingEl.className = 'info-value font-bold text-emerald-500 animate-pulse';
                } else {
                    daysRemainingEl.innerText = (currentLang === 'es' ? 'Vencido hace ' : 'Overdue ') + Math.abs(daysDiff) + (currentLang === 'es' ? ' días' : ' days');
                    daysRemainingEl.className = 'info-value font-bold text-red-500';
                }
            } else {
                daysRemainingEl.innerText = 'N/A';
                daysRemainingEl.className = 'info-value font-semibold text-slate-400';
            }

            emptyDiv.style.display = 'none';
            infoDiv.style.display = 'block';
        } else {
            // Available
            statusBadge.className = 'status-badge available';
            statusBadge.innerText = dict[currentLang]['statusAvailable'];

            emptyDiv.style.display = 'block';
            infoDiv.style.display = 'none';
        }
    }

    // Helper Date Formatter
    function formatDateString(str) {
        if (!str) return 'N/A';
        try {
            const parts = str.split('-');
            if (parts.length === 3) {
                return `${parts[2]}/${parts[1]}/${parts[0]}`; // DD/MM/YYYY
            }
            return str;
        } catch(e) {
            return str;
        }
    }

    // Check-in (Add Reservation) submit
    async function handleCheckIn(e) {
        e.preventDefault();
        
        const payload = {
            room: document.getElementById('checkin-room').value,
            cliente: document.getElementById('checkin-cliente').value,
            telefono: document.getElementById('checkin-telefono').value,
            fecha_inicio: document.getElementById('checkin-start').value,
            fecha_salida: document.getElementById('checkin-end').value,
            tasa_aseo: document.getElementById('checkin-aseo').value || 0,
            deposito: document.getElementById('checkin-deposito').value || 0,
            total_pagado: document.getElementById('checkin-total-pagado').value || 0,
            estado: 'ABIERTO',
            notas: document.getElementById('checkin-notas').value
        };

        closeModal('checkin-modal');
        showLoading('syncingData');

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/api/rooms-control/bookings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(payload)
            });
            const res = await response.json();
            if (res.success) {
                alert(dict[currentLang]['msgSaveSuccess']);
                document.getElementById('checkin-form').reset();
                await loadBookings();
            } else {
                alert('Error: ' + res.message);
            }
        } catch (err) {
            console.error(err);
            alert(dict[currentLang]['msgErrorAction']);
        } finally {
            hideLoading();
        }
    }

    // Edit Modal Open
    function openEditModal() {
        const booking = getActiveBooking(currentRoom);
        if (!booking) return;

        document.getElementById('edit-row').value = booking.row;
        document.getElementById('edit-room').value = booking.room;
        document.getElementById('edit-cliente').value = booking.cliente;
        document.getElementById('edit-telefono').value = booking.telefono;
        document.getElementById('edit-start').value = booking.fecha_inicio;
        document.getElementById('edit-end').value = booking.fecha_salida;
        document.getElementById('edit-aseo').value = booking.tasa_aseo || 0;
        document.getElementById('edit-deposito').value = booking.deposito || 0;
        document.getElementById('edit-total-pagado').value = booking.total_pagado || 0;
        document.getElementById('edit-estado').value = booking.estado.toUpperCase();
        document.getElementById('edit-notas').value = booking.notas;
        document.getElementById('edit-fecha-registro').value = booking.fecha_registro || '';

        openModal('edit-modal');
    }

    // Handle edit reservation submit
    async function handleEditSubmit(e) {
        e.preventDefault();

        const row = document.getElementById('edit-row').value;
        const payload = {
            room: document.getElementById('edit-room').value,
            cliente: document.getElementById('edit-cliente').value,
            telefono: document.getElementById('edit-telefono').value,
            fecha_inicio: document.getElementById('edit-start').value,
            fecha_salida: document.getElementById('edit-end').value,
            tasa_aseo: document.getElementById('edit-aseo').value || 0,
            deposito: document.getElementById('edit-deposito').value || 0,
            total_pagado: document.getElementById('edit-total-pagado').value || 0,
            estado: document.getElementById('edit-estado').value,
            notes: document.getElementById('edit-notas').value,
            fecha_registro: document.getElementById('edit-fecha-registro').value
        };

        closeModal('edit-modal');
        showLoading('savingData');

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/api/rooms-control/bookings/${row}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(payload)
            });
            const res = await response.json();
            if (res.success) {
                alert(dict[currentLang]['msgEditSuccess']);
                await loadBookings();
            } else {
                alert('Error: ' + res.message);
            }
        } catch (err) {
            console.error(err);
            alert(dict[currentLang]['msgErrorAction']);
        } finally {
            hideLoading();
        }
    }

    // Open Check-in Modal for current room
    function openCheckInModal() {
        document.getElementById('checkin-room').value = currentRoom;
        
        // Default start date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('checkin-start').value = today;
        document.getElementById('checkin-end').value = today;

        openModal('checkin-modal');
    }

    // Trigger Checkout Action
    async function triggerCheckout() {
        const booking = getActiveBooking(currentRoom);
        if (!booking) return;

        if (!confirm(dict[currentLang]['checkoutConfirm'])) return;

        showLoading('savingData');
        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/api/rooms-control/bookings/${booking.row}/checkout`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });
            const res = await response.json();
            if (res.success) {
                alert(dict[currentLang]['msgCheckoutSuccess']);
                await loadBookings();
            } else {
                alert('Error: ' + res.message);
            }
        } catch (err) {
            console.error(err);
            alert(dict[currentLang]['msgErrorAction']);
        } finally {
            hideLoading();
        }
    }

    // Trigger Delete Action
    async function triggerDelete() {
        const booking = getActiveBooking(currentRoom);
        if (!booking) return;

        if (!confirm(dict[currentLang]['deleteConfirm'])) return;

        showLoading('savingData');
        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/api/rooms-control/bookings/${booking.row}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });
            const res = await response.json();
            if (res.success) {
                alert(dict[currentLang]['msgDeleteSuccess']);
                await loadBookings();
            } else {
                alert('Error: ' + res.message);
            }
        } catch (err) {
            console.error(err);
            alert(dict[currentLang]['msgErrorAction']);
        } finally {
            hideLoading();
        }
    }

    // INITIALIZATION
    document.addEventListener('DOMContentLoaded', () => {
        initializeSelectOptions();
        setLanguage('{{ app()->getLocale() }}');
        loadBookings();
    });
</script>
</body>
</html>
