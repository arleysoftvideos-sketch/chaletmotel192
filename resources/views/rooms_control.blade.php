<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App Hotel Control - Reservas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { corePlugins: { preflight: false } }</script>
    <style>
        :root {
            --primary: #ffb703; --primary-hover: #fbc02d;
            --bg-color: #040a17; --box-bg: #0a1831;
            --border: #14274c; --text-color: #cbd5e1;
            --success: #10b981; --danger: #ef4444; --warning: #f59e0b;
        }
        *, ::before, ::after { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 20px; background-color: var(--bg-color); color: var(--text-color); }
        .container { max-width: 1300px; margin: 0 auto; background: var(--box-bg); padding: 30px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); border: 1px solid var(--border); }
        .header-nav { margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .back-link { color: var(--primary); text-decoration: none; font-weight: bold; font-size: 14px; transition: all 0.2s ease; }
        .back-link:hover { color: var(--primary-hover); }
        .lang-toggle { display: flex; gap: 6px; }
        .lang-btn { background: #14274c; border: 1px solid #1e293b; color: #94a3b8; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: all 0.2s ease; }
        .lang-btn.active { background: var(--primary); color: #0a1831; border-color: var(--primary-hover); }
        h1.page-title { font-family: 'Outfit', sans-serif; font-weight: 900; font-size: 2rem; text-transform: uppercase; letter-spacing: 1px; background: linear-gradient(to right, #ffffff, var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 25px; text-align: center; margin-top: 0; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 25px; }
        .stat-card { background: #081326; border: 1px solid var(--border); border-radius: 12px; padding: 15px 20px; text-align: center; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-number { font-size: 2rem; font-weight: 800; font-family: 'Outfit', sans-serif; margin-bottom: 3px; }
        .stat-label { font-size: 12px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .main-layout { display: grid; grid-template-columns: 1fr; gap: 20px; }
        @media (min-width: 900px) { .main-layout { grid-template-columns: 1.3fr 0.7fr; } }
        .room-nav-title { margin-bottom: 10px; margin-top: 15px; font-weight: 700; color: #94a3b8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .room-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(72px, 1fr)); gap: 8px; margin-bottom: 5px; }

        /* ---- ROOM BUTTON STATES ---- */
        .room-btn { padding: 12px 0; background-color: #14274c; border: 1px solid #1e293b; color: #cbd5e1; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 14px; transition: all 0.2s ease; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; }
        .room-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.3); }
        .room-btn.available { border-bottom: 4px solid var(--success); }
        .room-btn.occupied { background-color: #581c1c !important; border: 1px solid #991b1b !important; border-bottom: 4px solid var(--danger) !important; color: #fca5a5 !important; }
        .room-btn.occupied:hover { background-color: #7f1d1d !important; }
        .room-btn.reserved { background-color: #451a03 !important; border: 1px solid #92400e !important; border-bottom: 4px solid var(--warning) !important; color: #fde68a !important; }
        .room-btn.reserved:hover { background-color: #78350f !important; }
        .room-btn.active { outline: 3px solid var(--primary) !important; outline-offset: 2px !important; }
        .room-status-dot { width: 7px; height: 7px; border-radius: 50%; }
        .room-btn.available .room-status-dot { background-color: var(--success); }
        .room-btn.occupied .room-status-dot { background-color: var(--danger); }
        .room-btn.reserved .room-status-dot { background-color: var(--warning); }

        /* ---- DETAIL PANEL ---- */
        .detail-panel { background: #081326; border: 1px solid var(--border); border-radius: 16px; padding: 20px; position: sticky; top: 20px; max-height: 90vh; overflow-y: auto; }
        .detail-header { border-bottom: 2px solid var(--border); padding-bottom: 12px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        .detail-title { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 800; margin: 0; color: #fff; }
        .status-badge { padding: 4px 10px; border-radius: 30px; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-badge.available { background: rgba(16,185,129,0.15); color: var(--success); border: 1px solid rgba(16,185,129,0.3); }
        .status-badge.occupied { background: rgba(239,68,68,0.15); color: var(--danger); border: 1px solid rgba(239,68,68,0.3); }
        .status-badge.reserved { background: rgba(245,158,11,0.15); color: var(--warning); border: 1px solid rgba(245,158,11,0.3); }
        .info-group { margin-bottom: 12px; }
        .info-label { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px; }
        .info-value { font-size: 14px; color: #cbd5e1; font-weight: 500; }

        /* ---- BOOKING HISTORY CARDS ---- */
        .section-divider { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin: 15px 0 8px; padding-bottom: 6px; border-bottom: 1px solid var(--border); }
        .booking-card { background: #0a1831; border: 1px solid var(--border); border-radius: 8px; padding: 10px 12px; margin-bottom: 7px; border-left: 3px solid var(--border); }
        .booking-card.is-current { border-left-color: var(--danger); }
        .booking-card.is-future { border-left-color: var(--warning); }
        .booking-card.is-past { opacity: 0.55; }
        .booking-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
        .booking-card-name { font-weight: 700; color: #f8fafc; font-size: 13px; }
        .booking-tag { padding: 2px 7px; border-radius: 10px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .booking-tag.is-current { background: rgba(239,68,68,0.2); color: #ef4444; }
        .booking-tag.is-future { background: rgba(245,158,11,0.2); color: #f59e0b; }
        .booking-tag.is-past { background: rgba(100,116,139,0.2); color: #64748b; }
        .booking-card-dates { font-size: 12px; color: #94a3b8; }
        .booking-card-meta { font-size: 11px; color: #64748b; margin-top: 3px; }
        .booking-card-actions { display: flex; gap: 5px; margin-top: 7px; }
        .mini-btn { font-size: 11px; padding: 3px 8px; border-radius: 4px; cursor: pointer; border: 1px solid; transition: all 0.15s; }
        .mini-btn-edit { background: #14274c; border-color: #1e293b; color: #94a3b8; }
        .mini-btn-edit:hover { background: #1e293b; color: #f8fafc; }
        .mini-btn-del { background: #450a0a; border-color: #7f1d1d; color: #fca5a5; }
        .mini-btn-del:hover { background: #7f1d1d; }

        /* ---- MONTHLY OCCUPANCY ---- */
        .monthly-section { margin-top: 30px; padding-top: 25px; border-top: 1px solid var(--border); }
        .monthly-section-title { font-family: 'Outfit', sans-serif; font-size: 1.1rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; }
        .months-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px; }
        .month-card { background: #081326; border: 1px solid var(--border); border-radius: 12px; padding: 15px; }
        .month-title { font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 0.95rem; color: var(--primary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; display: flex; justify-content: space-between; }
        .month-badge { font-size: 11px; background: rgba(255,183,3,0.1); color: var(--primary); padding: 2px 8px; border-radius: 10px; }
        .month-booking-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid #14274c; font-size: 12px; }
        .month-booking-row:last-child { border-bottom: none; }
        .month-room-badge { background: #14274c; color: #94a3b8; padding: 2px 7px; border-radius: 6px; font-weight: bold; font-size: 11px; min-width: 40px; text-align: center; }
        .month-booking-info { flex: 1; padding: 0 8px; color: #cbd5e1; }
        .month-booking-dates { color: #64748b; font-size: 11px; }

        /* ---- BUTTONS & FORMS ---- */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; width: 100%; padding: 10px 12px; font-size: 13px; font-weight: 700; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background-color: var(--primary); color: #0a1831; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-secondary { background-color: #14274c; color: #cbd5e1; border: 1px solid #1e293b; }
        .btn-secondary:hover { background-color: #1e293b; }
        .btn-success { background-color: var(--success); color: white; }
        .btn-success:hover { background-color: #059669; }
        .btn-danger { background-color: var(--danger); color: white; }
        .btn-danger:hover { background-color: #dc2626; }
        .btn-sm { padding: 7px 10px; font-size: 12px; }
        .actions-stack { display: flex; flex-direction: column; gap: 8px; margin-top: 15px; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: #cbd5e1; margin-bottom: 5px; }
        input[type="text"], input[type="tel"], input[type="number"], input[type="date"], select, textarea { width: 100%; padding: 9px 12px; background-color: #081326; color: #f8fafc; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; transition: border-color 0.2s; font-family: 'Inter', sans-serif; }
        input:focus, select:focus, textarea:focus { border-color: var(--primary); outline: none; }
        textarea { resize: vertical; }
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 1000; justify-content: center; align-items: center; padding: 20px; backdrop-filter: blur(4px); }
        .modal-content { background: #0a1831; width: 100%; max-width: 540px; max-height: 90vh; border-radius: 16px; border: 1px solid var(--border); overflow-y: auto; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.6); color: var(--text-color); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid var(--border); padding-bottom: 12px; }
        .modal-title { font-family: 'Outfit', sans-serif; font-size: 1.3rem; font-weight: 800; color: #fff; margin: 0; }
        .modal-close-btn { background: transparent; border: none; color: #94a3b8; font-size: 22px; cursor: pointer; }
        .modal-close-btn:hover { color: var(--danger); }
        .spinner-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(4,10,23,0.8); z-index: 2000; justify-content: center; align-items: center; flex-direction: column; gap: 12px; }
        .spinner { width: 46px; height: 46px; border: 4px solid var(--border); border-top: 4px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite; }
        @keyframes spin { 0%{transform:rotate(0deg);} 100%{transform:rotate(360deg);} }
        .empty-state { text-align: center; padding: 20px 10px; }
        .empty-state-icon { font-size: 2.5rem; margin-bottom: 8px; }
        .overlap-warning { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 8px; padding: 10px 14px; margin-bottom: 12px; font-size: 13px; color: #fca5a5; display: none; }
    </style>
</head>
<body>

<!-- Spinner -->
<div class="spinner-overlay" id="loading-spinner">
    <div class="spinner"></div>
    <div style="font-weight:bold; color:var(--primary);" id="spinner-msg">Cargando...</div>
</div>

<!-- Modal Check-in -->
<div class="modal-overlay" id="checkin-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">+ Nueva Reserva / Check-In</h3>
            <button class="modal-close-btn" onclick="closeModal('checkin-modal')">&times;</button>
        </div>
        <div class="overlap-warning" id="checkin-overlap-warning">⚠️ Las fechas seleccionadas se solapan con una reserva existente.</div>
        <form id="checkin-form" onsubmit="handleCheckIn(event)">
            <div class="form-group">
                <label class="form-label">Habitación</label>
                <select id="checkin-room" required onchange="checkCheckinOverlap()"></select>
            </div>
            <div class="form-group">
                <label class="form-label">Nombre del Cliente</label>
                <input type="text" id="checkin-cliente" required>
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="tel" id="checkin-telefono">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="form-group">
                    <label class="form-label">Fecha Entrada</label>
                    <input type="date" id="checkin-start" required onchange="checkCheckinOverlap()">
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha Salida</label>
                    <input type="date" id="checkin-end" required onchange="checkCheckinOverlap()">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="form-group">
                    <label class="form-label">Tasa Aseo</label>
                    <input type="number" id="checkin-aseo" min="0" step="0.01" value="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Depósito</label>
                    <input type="number" id="checkin-deposito" min="0" step="0.01" value="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Total Pagado</label>
                    <input type="number" id="checkin-total-pagado" min="0" step="0.01" value="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Notas</label>
                <textarea id="checkin-notas" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Reserva</button>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal-overlay" id="edit-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">✏️ Editar Reserva</h3>
            <button class="modal-close-btn" onclick="closeModal('edit-modal')">&times;</button>
        </div>
        <div class="overlap-warning" id="edit-overlap-warning">⚠️ Las fechas seleccionadas se solapan con otra reserva existente.</div>
        <form id="edit-form" onsubmit="handleEditSubmit(event)">
            <input type="hidden" id="edit-row">
            <input type="hidden" id="edit-fecha-registro">
            <div class="form-group">
                <label class="form-label">Habitación</label>
                <select id="edit-room" required></select>
            </div>
            <div class="form-group">
                <label class="form-label">Nombre del Cliente</label>
                <input type="text" id="edit-cliente" required>
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="tel" id="edit-telefono">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="form-group">
                    <label class="form-label">Fecha Entrada</label>
                    <input type="date" id="edit-start" required onchange="checkEditOverlap()">
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha Salida</label>
                    <input type="date" id="edit-end" required onchange="checkEditOverlap()">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="form-group">
                    <label class="form-label">Tasa Aseo</label>
                    <input type="number" id="edit-aseo" min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label class="form-label">Depósito</label>
                    <input type="number" id="edit-deposito" min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label class="form-label">Total Pagado</label>
                    <input type="number" id="edit-total-pagado" min="0" step="0.01">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Estado</label>
                <select id="edit-estado" required>
                    <option value="ABIERTO">ABIERTO</option>
                    <option value="CERRADO">CERRADO</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Notas</label>
                <textarea id="edit-notas" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container">
    <div class="header-nav">
        <a href="/" class="back-link">← Volver a Inicio</a>
        <div class="lang-toggle">
            <button id="btn-es" class="lang-btn active" onclick="setLanguage('es')">🇪🇸 ES</button>
            <button id="btn-en" class="lang-btn" onclick="setLanguage('en')">🇺🇸 EN</button>
        </div>
    </div>

    <h1 class="page-title">🏨 Control de Habitaciones y Reservas</h1>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number" style="color:var(--danger);" id="stat-occupied">0</div>
            <div class="stat-label">Ocupadas Hoy</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:var(--warning);" id="stat-reserved">0</div>
            <div class="stat-label">Con Reserva</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:var(--success);" id="stat-available">28</div>
            <div class="stat-label">Disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:#cbd5e1;">28</div>
            <div class="stat-label">Total</div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="main-layout">
        <!-- Room Buttons (rendered by Blade) -->
        <div>
            <div class="room-nav-title">🏢 Piso 1 — Habitaciones 101 a 114</div>
            <div class="room-grid" id="nav-piso1">
                @for ($i = 101; $i <= 114; $i++)
                <button class="room-btn available" data-room="{{ $i }}" id="btn-room-{{ $i }}" onclick="selectRoom({{ $i }})">
                    <span class="room-status-dot"></span>
                    <span>{{ $i }}</span>
                </button>
                @endfor
            </div>

            <div class="room-nav-title">🏢 Piso 2 — Habitaciones 201 a 214</div>
            <div class="room-grid" id="nav-piso2">
                @for ($i = 201; $i <= 214; $i++)
                <button class="room-btn available" data-room="{{ $i }}" id="btn-room-{{ $i }}" onclick="selectRoom({{ $i }})">
                    <span class="room-status-dot"></span>
                    <span>{{ $i }}</span>
                </button>
                @endfor
            </div>

            <!-- Legend -->
            <div style="display:flex; gap:15px; margin-top:15px; font-size:12px; color:#64748b;">
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--success);margin-right:4px;"></span>Disponible</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--warning);margin-right:4px;"></span>Con reserva futura</span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--danger);margin-right:4px;"></span>Ocupada hoy</span>
            </div>
        </div>

        <!-- Detail Panel -->
        <div class="detail-panel" id="detail-panel">
            <div class="detail-header">
                <span class="detail-title">Habitación <span id="lbl-room">---</span></span>
                <span class="status-badge available" id="lbl-status">Libre</span>
            </div>

            <!-- No room selected -->
            <div id="state-no-room" class="empty-state">
                <div class="empty-state-icon">👆</div>
                <p style="color:#64748b; font-size:13px;">Selecciona una habitación para ver su detalle</p>
            </div>

            <!-- Room selected - dynamic content -->
            <div id="state-room-selected" style="display:none;">
                <!-- Current booking info (visible when occupied) -->
                <div id="current-booking-section" style="display:none;">
                    <div class="info-group">
                        <div class="info-label">Cliente Actual</div>
                        <div class="info-value" style="font-size:1rem; font-weight:800; color:#f8fafc;" id="detail-cliente"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Teléfono</div>
                        <div class="info-value" id="detail-telefono"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-2" style="margin:12px 0;">
                        <div class="info-group">
                            <div class="info-label">Entrada</div>
                            <div class="info-value" id="detail-start"></div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Salida</div>
                            <div class="info-value" id="detail-end"></div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Días restantes</div>
                            <div class="info-value font-bold" id="detail-days-remaining">-</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2" style="border-top:1px solid var(--border); border-bottom:1px solid var(--border); padding:10px 0; margin:10px 0;">
                        <div class="info-group">
                            <div class="info-label">Aseo</div>
                            <div class="info-value" style="color:var(--primary);" id="detail-aseo">$0</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Depósito</div>
                            <div class="info-value" style="color:var(--primary);" id="detail-deposito">$0</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Total Pagado</div>
                            <div class="info-value" style="color:var(--primary);" id="detail-total-pagado">$0</div>
                        </div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Registrado el</div>
                        <div class="info-value" style="font-size:12px; color:#64748b;" id="detail-registered"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Notas</div>
                        <div style="background:#0a1831; border:1px solid var(--border); border-radius:8px; padding:10px; font-size:12px; max-height:80px; overflow-y:auto; white-space:pre-wrap;" id="detail-notas"></div>
                    </div>
                    <div class="actions-stack">
                        <button class="btn btn-success btn-sm" onclick="triggerCheckout()">🚪 Realizar Check-Out</button>
                        <button class="btn btn-secondary btn-sm" onclick="openEditModalForCurrentRoom()">✏️ Editar Reserva Actual</button>
                        <button class="btn btn-danger btn-sm" onclick="triggerDeleteCurrent()">🗑️ Eliminar Registro</button>
                    </div>
                </div>

                <!-- Available (free now, may have future bookings) -->
                <div id="available-booking-section" style="display:none;">
                    <div class="empty-state" style="padding:10px 0;">
                        <div class="empty-state-icon" id="avail-icon">🔑</div>
                        <p style="color:#94a3b8; font-size:13px; margin-bottom:12px;" id="avail-text">Habitación disponible</p>
                        <button class="btn btn-primary btn-sm" onclick="openCheckInModal()">+ Nueva Reserva</button>
                    </div>
                </div>

                <!-- Booking History List -->
                <div id="history-section" style="display:none;">
                    <div class="section-divider">📋 Historial de Reservas</div>
                    <div id="history-list"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Occupancy -->
    <div class="monthly-section">
        <div class="monthly-section-title">📅 Ocupación por Mes</div>
        <div class="months-grid" id="monthly-container">
            <p style="color:#64748b; font-size:13px;">Cargando datos...</p>
        </div>
    </div>
</div>

<script>
    var currentLang = 'es';
    var bookingsList = [];
    var currentRoom = null;
    var allRooms = [101,102,103,104,105,106,107,108,109,110,111,112,113,114,
                    201,202,203,204,205,206,207,208,209,210,211,212,213,214];

    // ========== DATE UTILITIES ==========
    function parseDate(str) {
        if (!str) return null;
        var p = str.split('-');
        if (p.length !== 3) return null;
        return new Date(parseInt(p[0]), parseInt(p[1]) - 1, parseInt(p[2]));
    }
    function todayDate() {
        var d = new Date(); d.setHours(0,0,0,0); return d;
    }
    function isOccupiedToday(b) {
        if ((b.estado||'').toUpperCase() === 'CERRADO') return false;
        var t = todayDate(), s = parseDate(b.fecha_inicio), e = parseDate(b.fecha_salida);
        return s && e && t >= s && t <= e;
    }
    function isFutureBooking(b) {
        if ((b.estado||'').toUpperCase() === 'CERRADO') return false;
        var s = parseDate(b.fecha_inicio);
        return s && s > todayDate();
    }
    function isPastBooking(b) {
        var e = parseDate(b.fecha_salida);
        return e && e < todayDate();
    }
    function fmtDate(str) {
        if (!str) return 'N/A';
        var p = str.split('-');
        return p.length === 3 ? p[2]+'/'+p[1]+'/'+p[0] : str;
    }
    function calcDaysRemaining(endStr) {
        var e = parseDate(endStr); if (!e) return null;
        return Math.ceil((e - todayDate()) / 86400000);
    }
    function hasOverlap(room, startStr, endStr, excludeRow) {
        var ns = parseDate(startStr), ne = parseDate(endStr);
        if (!ns || !ne) return false;
        var roomBookings = bookingsList.filter(function(b) {
            return parseInt(b.room) === parseInt(room)
                && (b.estado||'').toUpperCase() !== 'CERRADO'
                && (!excludeRow || parseInt(b.row) !== parseInt(excludeRow));
        });
        return roomBookings.some(function(b) {
            var bs = parseDate(b.fecha_inicio), be = parseDate(b.fecha_salida);
            return bs && be && ns <= be && ne >= bs;
        });
    }

    // ========== ROOM STATUS ==========
    function getRoomStatus(room) {
        var bookings = bookingsList.filter(function(b) { return parseInt(b.room) === parseInt(room); });
        if (bookings.some(isOccupiedToday)) return 'occupied';
        if (bookings.some(isFutureBooking)) return 'reserved';
        return 'available';
    }
    function getActiveBookingsForRoom(room) {
        return bookingsList.filter(function(b) {
            return parseInt(b.room) === parseInt(room);
        }).sort(function(a, b) {
            var da = parseDate(a.fecha_inicio) || new Date(0);
            var db = parseDate(b.fecha_inicio) || new Date(0);
            return db - da;
        });
    }
    function getCurrentBooking(room) {
        var found = null;
        bookingsList.forEach(function(b) {
            if (parseInt(b.room) === parseInt(room) && isOccupiedToday(b)) {
                if (!found || b.row > found.row) found = b;
            }
        });
        return found;
    }

    // ========== LANGUAGE ==========
    function setLanguage(lang) {
        currentLang = lang;
        document.getElementById('btn-es').classList.toggle('active', lang === 'es');
        document.getElementById('btn-en').classList.toggle('active', lang === 'en');
    }

    // ========== MODALS ==========
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    function showLoading(msg) {
        document.getElementById('spinner-msg').innerText = msg || 'Cargando...';
        document.getElementById('loading-spinner').style.display = 'flex';
    }
    function hideLoading() { document.getElementById('loading-spinner').style.display = 'none'; }

    // ========== SELECTS INIT ==========
    function initSelects() {
        var s1 = document.getElementById('checkin-room');
        var s2 = document.getElementById('edit-room');
        s1.innerHTML = ''; s2.innerHTML = '';
        allRooms.forEach(function(r) {
            var o1 = document.createElement('option'); o1.value = r; o1.text = r; s1.add(o1);
            var o2 = document.createElement('option'); o2.value = r; o2.text = r; s2.add(o2);
        });
    }

    // ========== STATS ==========
    function updateStats() {
        var occ = 0, res = 0, avail = 0;
        allRooms.forEach(function(r) {
            var s = getRoomStatus(r);
            if (s === 'occupied') occ++;
            else if (s === 'reserved') res++;
            else avail++;
        });
        document.getElementById('stat-occupied').innerText = occ;
        document.getElementById('stat-reserved').innerText = res;
        document.getElementById('stat-available').innerText = avail;
    }

    // ========== ROOM GRID UPDATE ==========
    function updateRoomGrid() {
        allRooms.forEach(function(room) {
            var btn = document.getElementById('btn-room-' + room);
            if (!btn) return;
            var status = getRoomStatus(room);
            var isActive = (room === currentRoom);
            btn.className = 'room-btn ' + status + (isActive ? ' active' : '');
        });
    }

    // ========== SELECT ROOM ==========
    function selectRoom(room) {
        currentRoom = room;
        document.querySelectorAll('.room-btn').forEach(function(b) {
            b.classList.toggle('active', parseInt(b.getAttribute('data-room')) === parseInt(room));
        });
        document.getElementById('lbl-room').innerText = room;
        document.getElementById('state-no-room').style.display = 'none';
        document.getElementById('state-room-selected').style.display = 'block';
        showDetails(room);
    }

    // ========== SHOW ROOM DETAILS ==========
    function showDetails(room) {
        var currentBooking = getCurrentBooking(room);
        var allBookings = getActiveBookingsForRoom(room);
        var futureBookings = allBookings.filter(isFutureBooking);
        var status = getRoomStatus(room);

        var badge = document.getElementById('lbl-status');
        var currentSection = document.getElementById('current-booking-section');
        var availSection = document.getElementById('available-booking-section');
        var histSection = document.getElementById('history-section');

        currentSection.style.display = 'none';
        availSection.style.display = 'none';
        histSection.style.display = 'none';

        if (status === 'occupied' && currentBooking) {
            badge.className = 'status-badge occupied';
            badge.innerText = currentLang === 'es' ? 'Ocupada' : 'Occupied';
            currentSection.style.display = 'block';
            fillCurrentBooking(currentBooking);
        } else if (status === 'reserved') {
            badge.className = 'status-badge reserved';
            badge.innerText = currentLang === 'es' ? 'Con Reservas' : 'Has Bookings';
            availSection.style.display = 'block';
            document.getElementById('avail-icon').innerText = '📅';
            document.getElementById('avail-text').innerText = currentLang === 'es'
                ? 'Disponible ahora — tiene ' + futureBookings.length + ' reserva(s) futura(s)'
                : 'Available now — ' + futureBookings.length + ' future booking(s)';
        } else {
            badge.className = 'status-badge available';
            badge.innerText = currentLang === 'es' ? 'Disponible' : 'Available';
            availSection.style.display = 'block';
            document.getElementById('avail-icon').innerText = '🔑';
            document.getElementById('avail-text').innerText = currentLang === 'es'
                ? 'Sin reservas — disponible para check-in'
                : 'No bookings — available for check-in';
        }

        if (allBookings.length > 0) {
            histSection.style.display = 'block';
            renderHistory(allBookings);
        }
    }

    function fillCurrentBooking(b) {
        document.getElementById('detail-cliente').innerText = b.cliente || 'N/A';
        document.getElementById('detail-telefono').innerText = b.telefono || 'N/A';
        document.getElementById('detail-start').innerText = fmtDate(b.fecha_inicio);
        document.getElementById('detail-end').innerText = fmtDate(b.fecha_salida);
        document.getElementById('detail-aseo').innerText = '$' + (parseFloat(b.tasa_aseo)||0).toLocaleString();
        document.getElementById('detail-deposito').innerText = '$' + (parseFloat(b.deposito)||0).toLocaleString();
        document.getElementById('detail-total-pagado').innerText = '$' + (parseFloat(b.total_pagado)||0).toLocaleString();
        document.getElementById('detail-registered').innerText = b.fecha_registro || 'N/A';
        document.getElementById('detail-notas').innerText = b.notas || 'Sin notas.';
        var drEl = document.getElementById('detail-days-remaining');
        var diff = calcDaysRemaining(b.fecha_salida);
        if (diff !== null) {
            if (diff > 0) { drEl.innerText = diff + (currentLang==='es'?' días':' days'); drEl.style.color = '#f59e0b'; }
            else if (diff === 0) { drEl.innerText = '¡Hoy!'; drEl.style.color = '#10b981'; }
            else { drEl.innerText = (currentLang==='es'?'Vencido ':'Overdue ') + Math.abs(diff) + 'd'; drEl.style.color = '#ef4444'; }
        }
    }

    function renderHistory(bookings) {
        var container = document.getElementById('history-list');
        container.innerHTML = '';
        bookings.forEach(function(b) {
            var isCurr = isOccupiedToday(b);
            var isFut = isFutureBooking(b);
            var isClosed = (b.estado||'').toUpperCase() === 'CERRADO';
            var tagClass = isCurr ? 'is-current' : (isFut ? 'is-future' : 'is-past');
            var tagText = isCurr ? 'ACTIVO' : (isFut ? 'FUTURO' : (isClosed ? 'CERRADO' : 'PASADO'));

            var card = document.createElement('div');
            card.className = 'booking-card ' + tagClass;

            var actionsHtml = '';
            if (!isClosed) {
                actionsHtml = '<div class="booking-card-actions">'
                    + '<button class="mini-btn mini-btn-edit" onclick="openEditModalForRow(' + b.row + ')">✏️ Editar</button>'
                    + (isCurr ? '<button class="mini-btn mini-btn-del" onclick="triggerCheckoutRow(' + b.row + ')">🚪 Checkout</button>' : '')
                    + '<button class="mini-btn mini-btn-del" onclick="triggerDeleteRow(' + b.row + ')">🗑️ Borrar</button>'
                    + '</div>';
            }

            card.innerHTML = '<div class="booking-card-header">'
                + '<span class="booking-card-name">' + (b.cliente || 'N/A') + '</span>'
                + '<span class="booking-tag ' + tagClass + '">' + tagText + '</span>'
                + '</div>'
                + '<div class="booking-card-dates">' + fmtDate(b.fecha_inicio) + ' → ' + fmtDate(b.fecha_salida) + '</div>'
                + '<div class="booking-card-meta">' + (b.telefono || '') + (b.total_pagado ? ' | $' + parseFloat(b.total_pagado).toLocaleString() : '') + '</div>'
                + actionsHtml;

            container.appendChild(card);
        });
    }

    // ========== MONTHLY OCCUPANCY ==========
    function renderMonthly() {
        var container = document.getElementById('monthly-container');
        container.innerHTML = '';
        var months = [];
        for (var i = -1; i <= 4; i++) {
            var d = new Date(); d.setDate(1); d.setMonth(d.getMonth() + i);
            months.push({ year: d.getFullYear(), month: d.getMonth() });
        }
        var anyFound = false;
        months.forEach(function(m) {
            var monthStart = new Date(m.year, m.month, 1);
            var monthEnd = new Date(m.year, m.month + 1, 0);
            var mBookings = bookingsList.filter(function(b) {
                if ((b.estado||'').toUpperCase() === 'CERRADO') return false;
                var bs = parseDate(b.fecha_inicio), be = parseDate(b.fecha_salida);
                return bs && be && bs <= monthEnd && be >= monthStart;
            }).sort(function(a, b) {
                return (parseDate(a.fecha_inicio)||new Date(0)) - (parseDate(b.fecha_inicio)||new Date(0));
            });
            if (!mBookings.length) return;
            anyFound = true;
            var monthName = monthStart.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' });
            var card = document.createElement('div');
            card.className = 'month-card';
            var html = '<div class="month-title"><span>' + monthName.charAt(0).toUpperCase() + monthName.slice(1) + '</span>'
                + '<span class="month-badge">' + mBookings.length + ' reserva' + (mBookings.length !== 1 ? 's' : '') + '</span></div>';
            mBookings.forEach(function(b) {
                var isCurr = isOccupiedToday(b), isFut = isFutureBooking(b);
                var tagClass = isCurr ? 'is-current' : (isFut ? 'is-future' : 'is-past');
                var tagText = isCurr ? 'ACTIVO' : (isFut ? 'FUTURO' : 'PASADO');
                html += '<div class="month-booking-row">'
                    + '<span class="month-room-badge">Hab.' + b.room + '</span>'
                    + '<div class="month-booking-info">' + (b.cliente || 'N/A') + '<br>'
                    + '<span class="month-booking-dates">' + fmtDate(b.fecha_inicio) + ' → ' + fmtDate(b.fecha_salida) + '</span></div>'
                    + '<span class="booking-tag ' + tagClass + '">' + tagText + '</span>'
                    + '</div>';
            });
            card.innerHTML = html;
            container.appendChild(card);
        });
        if (!anyFound) {
            container.innerHTML = '<p style="color:#64748b; font-size:13px; text-align:center; padding:20px;">No hay reservas en los próximos meses.</p>';
        }
    }

    // ========== CHECK OVERLAP LIVE ==========
    function checkCheckinOverlap() {
        var room = document.getElementById('checkin-room').value;
        var s = document.getElementById('checkin-start').value;
        var e = document.getElementById('checkin-end').value;
        var w = document.getElementById('checkin-overlap-warning');
        if (room && s && e) {
            w.style.display = hasOverlap(room, s, e, null) ? 'block' : 'none';
        }
    }
    function checkEditOverlap() {
        var room = document.getElementById('edit-room').value;
        var s = document.getElementById('edit-start').value;
        var e = document.getElementById('edit-end').value;
        var row = document.getElementById('edit-row').value;
        var w = document.getElementById('edit-overlap-warning');
        if (room && s && e) {
            w.style.display = hasOverlap(room, s, e, row) ? 'block' : 'none';
        }
    }

    // ========== CHECK-IN ==========
    function openCheckInModal() {
        document.getElementById('checkin-room').value = currentRoom || allRooms[0];
        var t = new Date().toISOString().split('T')[0];
        document.getElementById('checkin-start').value = t;
        document.getElementById('checkin-end').value = t;
        document.getElementById('checkin-overlap-warning').style.display = 'none';
        document.getElementById('checkin-form').reset();
        document.getElementById('checkin-room').value = currentRoom || allRooms[0];
        document.getElementById('checkin-start').value = t;
        document.getElementById('checkin-end').value = t;
        openModal('checkin-modal');
    }
    function handleCheckIn(e) {
        e.preventDefault();
        var room = document.getElementById('checkin-room').value;
        var startDate = document.getElementById('checkin-start').value;
        var endDate = document.getElementById('checkin-end').value;
        if (new Date(startDate) > new Date(endDate)) {
            alert('La fecha de salida debe ser posterior a la de entrada.');
            return;
        }
        if (hasOverlap(room, startDate, endDate, null)) {
            alert('⚠️ Las fechas seleccionadas se solapan con una reserva existente para la habitación ' + room + '. Selecciona otras fechas.');
            return;
        }
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        var p = {
            room: room, cliente: document.getElementById('checkin-cliente').value,
            telefono: document.getElementById('checkin-telefono').value,
            fecha_inicio: startDate, fecha_salida: endDate,
            tasa_aseo: document.getElementById('checkin-aseo').value || 0,
            deposito: document.getElementById('checkin-deposito').value || 0,
            total_pagado: document.getElementById('checkin-total-pagado').value || 0,
            estado: 'ABIERTO', notas: document.getElementById('checkin-notas').value
        };
        closeModal('checkin-modal'); showLoading('Guardando reserva...');
        fetch('/api/rooms-control/bookings', { method:'POST', headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':tok}, body:JSON.stringify(p) })
            .then(function(r){return r.json();})
            .then(function(res){ if (res.success) { loadBookings(); } else { alert('Error: ' + res.message); hideLoading(); } })
            .catch(function() { alert('Error al guardar.'); hideLoading(); });
    }

    // ========== EDIT ==========
    function openEditModalForRow(row) {
        var b = null;
        bookingsList.forEach(function(x) { if (parseInt(x.row) === parseInt(row)) b = x; });
        if (!b) return;
        document.getElementById('edit-row').value = b.row;
        document.getElementById('edit-room').value = b.room;
        document.getElementById('edit-cliente').value = b.cliente;
        document.getElementById('edit-telefono').value = b.telefono;
        document.getElementById('edit-start').value = b.fecha_inicio;
        document.getElementById('edit-end').value = b.fecha_salida;
        document.getElementById('edit-aseo').value = b.tasa_aseo || 0;
        document.getElementById('edit-deposito').value = b.deposito || 0;
        document.getElementById('edit-total-pagado').value = b.total_pagado || 0;
        document.getElementById('edit-estado').value = (b.estado || '').toUpperCase();
        document.getElementById('edit-notas').value = b.notas;
        document.getElementById('edit-fecha-registro').value = b.fecha_registro || '';
        document.getElementById('edit-overlap-warning').style.display = 'none';
        openModal('edit-modal');
    }
    function openEditModalForCurrentRoom() {
        var b = getCurrentBooking(currentRoom);
        if (b) openEditModalForRow(b.row);
    }
    function handleEditSubmit(e) {
        e.preventDefault();
        var row = document.getElementById('edit-row').value;
        var room = document.getElementById('edit-room').value;
        var startDate = document.getElementById('edit-start').value;
        var endDate = document.getElementById('edit-end').value;
        if (new Date(startDate) > new Date(endDate)) {
            alert('La fecha de salida debe ser posterior a la de entrada.');
            return;
        }
        if (hasOverlap(room, startDate, endDate, row)) {
            alert('⚠️ Las fechas se solapan con otra reserva existente para la habitación ' + room + '.');
            return;
        }
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        var p = {
            room: room, cliente: document.getElementById('edit-cliente').value,
            telefono: document.getElementById('edit-telefono').value,
            fecha_inicio: startDate, fecha_salida: endDate,
            tasa_aseo: document.getElementById('edit-aseo').value || 0,
            deposito: document.getElementById('edit-deposito').value || 0,
            total_pagado: document.getElementById('edit-total-pagado').value || 0,
            estado: document.getElementById('edit-estado').value,
            notes: document.getElementById('edit-notas').value,
            notas: document.getElementById('edit-notas').value,
            fecha_registro: document.getElementById('edit-fecha-registro').value
        };
        closeModal('edit-modal'); showLoading('Guardando...');
        fetch('/api/rooms-control/bookings/' + row, { method:'PUT', headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':tok}, body:JSON.stringify(p) })
            .then(function(r){return r.json();})
            .then(function(res){ if (res.success) { loadBookings(); } else { alert('Error: ' + res.message); hideLoading(); } })
            .catch(function() { alert('Error.'); hideLoading(); });
    }

    // ========== CHECKOUT ==========
    function triggerCheckout() {
        var b = getCurrentBooking(currentRoom); if (!b) return;
        triggerCheckoutRow(b.row);
    }
    function triggerCheckoutRow(row) {
        if (!confirm('¿Confirmar Check-Out? El estado pasará a CERRADO.')) return;
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        showLoading('Procesando check-out...');
        fetch('/api/rooms-control/bookings/' + row + '/checkout', { method:'POST', headers:{'Accept':'application/json','X-CSRF-TOKEN':tok} })
            .then(function(r){return r.json();})
            .then(function(res){ if (res.success) { loadBookings(); } else { alert('Error: ' + res.message); hideLoading(); } })
            .catch(function() { alert('Error.'); hideLoading(); });
    }

    // ========== DELETE ==========
    function triggerDeleteCurrent() {
        var b = getCurrentBooking(currentRoom); if (!b) return;
        triggerDeleteRow(b.row);
    }
    function triggerDeleteRow(row) {
        if (!confirm('¿Eliminar permanentemente esta reserva? No se puede deshacer.')) return;
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        showLoading('Eliminando...');
        fetch('/api/rooms-control/bookings/' + row, { method:'DELETE', headers:{'Accept':'application/json','X-CSRF-TOKEN':tok} })
            .then(function(r){return r.json();})
            .then(function(res){ if (res.success) { loadBookings(); } else { alert('Error: ' + res.message); hideLoading(); } })
            .catch(function() { alert('Error.'); hideLoading(); });
    }

    // ========== LOAD FROM API ==========
    function loadBookings() {
        showLoading('Cargando datos...');
        fetch('/api/rooms-control/bookings')
            .then(function(r) { return r.json(); })
            .then(function(res) { if (res.success) bookingsList = res.data || []; })
            .catch(function(e) { console.error('Error:', e); })
            .finally(function() {
                updateRoomGrid();
                updateStats();
                if (currentRoom) showDetails(currentRoom);
                renderMonthly();
                hideLoading();
            });
    }

    // ========== INIT ==========
    window.onload = function() {
        initSelects();
        loadBookings();
    };
</script>
</body>
</html>
