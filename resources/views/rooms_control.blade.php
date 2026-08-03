<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        .hero-rooms-banner {
            background-image: linear-gradient(to right, rgba(6, 16, 33, 0.95) 0%, rgba(6, 16, 33, 0.85) 40%, rgba(6, 16, 33, 0.3) 100%), url('/images/motel_banner.png');
            background-size: cover;
            background-position: center;
            border-radius: 16px;
            padding: 35px 40px;
            margin-bottom: 25px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        .hero-rooms-banner::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(4, 10, 23, 0.15);
            pointer-events: none;
        }
        .hero-rooms-banner-content {
            position: relative;
            z-index: 10;
        }
        .hero-rooms-banner-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 2.2rem;
            color: #ffffff;
            margin: 0 0 8px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.6);
        }
        .hero-rooms-banner-subtitle {
            font-size: 13px;
            color: var(--primary);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        }
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

        /* ---- RATE CALCULATOR ---- */
        .calc-panel { background: #040d1a; border: 1px solid rgba(245,158,11,0.25); border-radius: 10px; padding: 14px; margin-bottom: 14px; display: none; }
        .calc-title { font-size: 11px; font-weight: 700; color: var(--warning); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; }
        .calc-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; text-align: center; margin-bottom: 10px; }
        .calc-cell-label { font-size: 10px; color: #64748b; margin-bottom: 3px; text-transform: uppercase; letter-spacing: 0.5px; }
        .calc-cell-value { font-size: 15px; font-weight: 800; color: #f8fafc; }
        .calc-cell-value.green { color: var(--success); font-size: 18px; }
        .calc-cell-value.gold { color: var(--warning); }
        .calc-breakdown { font-size: 11px; color: #64748b; text-align: center; margin-bottom: 10px; min-height: 14px; }
        .calc-apply-btn { width: 100%; padding: 8px; background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.35); border-radius: 6px; color: var(--warning); font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .calc-apply-btn:hover { background: rgba(245,158,11,0.22); }
        .rate-edit-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; margin-bottom: 8px; }
        .rate-edit-item label { font-size: 10px; color: #64748b; display: block; margin-bottom: 3px; }
        .rate-edit-item input { padding: 5px 8px; font-size: 12px; }

        /* ---- DASHBOARD WIDGETS ---- */
        .widget-card { background: #081326; border: 1px solid var(--border); border-radius: 12px; padding: 15px; }
        .widget-title { font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
        .widget-list { display: flex; flex-direction: column; gap: 8px; max-height: 250px; overflow-y: auto; }
        .widget-item { background: #0a1831; border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; transition: all 0.2s; font-size: 13px; border-left: 3px solid var(--border); }
        .widget-item:hover { border-color: var(--primary); transform: translateY(-1px); }
        .widget-item-info { display: flex; flex-direction: column; gap: 2px; }
        .widget-item-room { font-weight: bold; color: var(--primary); background: rgba(255, 183, 3, 0.1); padding: 2px 6px; border-radius: 4px; font-size: 11px; margin-right: 6px; display: inline-block; }
        .widget-item-name { color: #f8fafc; font-weight: 600; }
        .widget-item-sub { font-size: 11px; color: #64748b; }
        .widget-badge { font-size: 10px; font-weight: bold; padding: 3px 8px; border-radius: 6px; text-transform: uppercase; }
        .widget-badge.danger { background: rgba(239, 68, 68, 0.15); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.3); }
        .widget-badge.warning { background: rgba(245, 158, 11, 0.15); color: var(--warning); border: 1px solid rgba(245, 158, 11, 0.3); }
        .widget-badge.success { background: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.3); }
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
            <h3 class="modal-title" data-i18n="checkinTitle">+ Nueva Reserva / Check-In</h3>
            <button class="modal-close-btn" onclick="closeModal('checkin-modal')">&times;</button>
        </div>
        <div class="overlap-warning" id="checkin-overlap-warning" data-i18n="overlapWarningCheckIn">⚠️ Las fechas seleccionadas se solapan con una reserva existente.</div>
        <form id="checkin-form" onsubmit="handleCheckIn(event)">
            <div class="form-group">
                <label class="form-label" data-i18n="roomLabel">Habitación</label>
                <select id="checkin-room" required onchange="checkCheckinOverlap()"></select>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="guestLabel">Nombre del Cliente</label>
                <input type="text" id="checkin-cliente" required>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="phoneLabel">Teléfono</label>
                <input type="tel" id="checkin-telefono">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="form-group">
                    <label class="form-label" data-i18n="startLabel">Fecha Entrada</label>
                    <input type="date" id="checkin-start" required onchange="checkCheckinOverlap(); runCalc();">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="endLabel">Fecha Salida</label>
                    <input type="date" id="checkin-end" required onchange="checkCheckinOverlap(); runCalc();">
                </div>
            </div>

            <!-- People Count + Calculator -->
            <div class="form-group">
                <label class="form-label" for="checkin-bed-type" data-i18n="bedTypeLabel">👥 Número de Personas</label>
                <select id="checkin-bed-type" onchange="runCalc()">
                    <option value="" data-i18n="bedSelectPrompt">-- Seleccionar número de personas --</option>
                    <option value="Single" data-i18n="bedSingle">1 Persona &nbsp;($75/día)</option>
                    <option value="Doble" data-i18n="bedDouble">2 Personas - Cama Doble ($105/día)</option>
                    <option value="Twin" data-i18n="bedTwin">2 Personas - 2 Camas ($105/día)</option>
                    <option value="Queen" data-i18n="bedQueen">3 Personas ($140/día)</option>
                </select>
            </div>

            <!-- Calculator Panel -->
            <div class="calc-panel" id="calc-panel">
                <div class="calc-title" id="calc-title" data-i18n="calcTitle">🧮 Calculadora de Tarifa</div>
                <div class="rate-edit-row">
                    <div class="rate-edit-item">
                        <label data-i18n="rateDailyLabel">💵 Tarifa Diaria</label>
                        <input type="number" id="rate-daily" min="0" step="0.01" onchange="runCalc()">
                    </div>
                    <div class="rate-edit-item">
                        <label data-i18n="rateWeeklyLabel">💵 Tarifa Semanal</label>
                        <input type="number" id="rate-weekly" min="0" step="0.01" onchange="runCalc()">
                    </div>
                    <div class="rate-edit-item">
                        <label data-i18n="rateMonthlyLabel">💵 Tarifa Mensual</label>
                        <input type="number" id="rate-monthly" min="0" step="0.01" onchange="runCalc()">
                    </div>
                </div>
                <div class="calc-grid">
                    <div>
                        <div class="calc-cell-label" data-i18n="lblCalcDays">Días</div>
                        <div class="calc-cell-value" id="calc-days">-</div>
                    </div>
                    <div>
                        <div class="calc-cell-label" data-i18n="lblCalcPeriod">Período</div>
                        <div class="calc-cell-value" id="calc-period">-</div>
                    </div>
                    <div>
                        <div class="calc-cell-label" data-i18n="lblCalcBaseRate">Tarifa Base</div>
                        <div class="calc-cell-value gold" id="calc-rate">-</div>
                    </div>
                    <div>
                        <div class="calc-cell-label" data-i18n="lblCalcTotal">TOTAL</div>
                        <div class="calc-cell-value green" id="calc-total">-</div>
                    </div>
                </div>
                <div class="calc-breakdown" id="calc-breakdown"></div>
                <!-- Month-by-month schedule (visible for contracts >= 6 months) -->
                <div id="calc-schedule-container" style="display:none; margin-top:12px; padding-top:12px; border-top:1px dashed rgba(245,158,11,0.3); text-align:left;">
                    <div style="font-size:11px; font-weight:700; color:var(--warning); margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;" data-i18n="lblPaymentSchedule">📅 Calendario de Pagos Mensuales</div>
                    <div id="calc-schedule-list" style="font-size:12px; display:grid; grid-template-columns: repeat(2, 1fr); gap:6px; color:#cbd5e1; margin-bottom:10px;"></div>
                </div>
                <button type="button" class="calc-apply-btn" onclick="applyCalcToForm()" data-i18n="applyBtn">✅ Usar este total</button>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div class="form-group">
                    <label class="form-label" data-i18n="aseoLabel">Tasa Aseo</label>
                    <input type="number" id="checkin-aseo" min="0" step="0.01" value="0">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="depositoLabel">Depósito</label>
                    <input type="number" id="checkin-deposito" min="0" step="0.01" value="0">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="totalPaidLabel">Total Pagado</label>
                    <input type="number" id="checkin-total-pagado" min="0" step="0.01" value="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="notesLabel">Notas</label>
                <textarea id="checkin-notas" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" data-i18n="saveBookingBtn">Guardar Reserva</button>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal-overlay" id="edit-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" data-i18n="editTitle">✏️ Editar Reserva</h3>
            <button class="modal-close-btn" onclick="closeModal('edit-modal')">&times;</button>
        </div>
        <div class="overlap-warning" id="edit-overlap-warning" data-i18n="overlapWarningEdit">⚠️ Las fechas seleccionadas se solapan con otra reserva existente.</div>
        <form id="edit-form" onsubmit="handleEditSubmit(event)">
            <input type="hidden" id="edit-row">
            <input type="hidden" id="edit-fecha-registro">
            <div class="form-group">
                <label class="form-label" data-i18n="roomLabel">Habitación</label>
                <select id="edit-room" required></select>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="guestLabel">Nombre del Cliente</label>
                <input type="text" id="edit-cliente" required>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="phoneLabel">Teléfono</label>
                <input type="tel" id="edit-telefono">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="form-group">
                    <label class="form-label" data-i18n="startLabel">Fecha Entrada</label>
                    <input type="date" id="edit-start" required onchange="checkEditOverlap()">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="endLabel">Fecha Salida</label>
                    <input type="date" id="edit-end" required onchange="checkEditOverlap()">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="form-group">
                    <label class="form-label" data-i18n="aseoLabel">Tasa Aseo</label>
                    <input type="number" id="edit-aseo" min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="depositoLabel">Depósito</label>
                    <input type="number" id="edit-deposito" min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label class="form-label" data-i18n="totalPaidLabel">Total Pagado</label>
                    <input type="number" id="edit-total-pagado" min="0" step="0.01">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="statusLabel">Estado</label>
                <select id="edit-estado" required>
                    <option value="ABIERTO" data-i18n="statusOpen">ABIERTO</option>
                    <option value="CERRADO" data-i18n="statusClosed">CERRADO</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" data-i18n="notesLabel">Notas</label>
                <textarea id="edit-notas" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" data-i18n="saveChangesBtn">Guardar Cambios</button>
        </form>
    </div>
</div>

<!-- Room Info Popup Modal -->
<div class="modal-overlay" id="room-modal" onclick="handleRoomModalClick(event)">
    <div class="modal-content" style="max-width:500px; position:relative;" onclick="event.stopPropagation()">
        <div class="modal-header" style="margin-bottom:14px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <h3 class="modal-title" id="rm-title" data-i18n="roomTitle">Habitación ---</h3>
                <span class="status-badge" id="rm-badge" data-i18n="roomStatus">Libre</span>
            </div>
            <button class="modal-close-btn" onclick="closeModal('room-modal')">×</button>
        </div>
        <div id="rm-body"></div>
    </div>
</div>
<!-- Contenido Principal -->
<div class="container">
    <div class="header-nav">
        <a href="/" class="back-link" data-i18n="backLink">← Volver a Inicio</a>
        <div class="lang-toggle">
            <button id="btn-es" class="lang-btn active" data-lang="es" onclick="setLanguage('es')">🇪🇸 ES</button>
            <button id="btn-en" class="lang-btn" data-lang="en" onclick="setLanguage('en')">🇺🇸 EN</button>
        </div>
    </div>

    <!-- Hero Banner with Hotel Photo -->
    <div class="hero-rooms-banner">
        <div class="hero-rooms-banner-content">
            <h1 class="hero-rooms-banner-title" data-i18n="pageTitle">🏨 Control de Habitaciones y Reservas</h1>
            <p class="hero-rooms-banner-subtitle" data-i18n="pageSubTitle">Panel de administración y control de disponibilidad en Kissimmee</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number" style="color:var(--danger);" id="stat-occupied">0</div>
            <div class="stat-label" data-i18n="statOccupied">Ocupadas Hoy</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:var(--warning);" id="stat-reserved">0</div>
            <div class="stat-label" data-i18n="statReserved">Con Reserva</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:var(--success);" id="stat-available">28</div>
            <div class="stat-label" data-i18n="statAvailable">Disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:#cbd5e1;">28</div>
            <div class="stat-label" data-i18n="statTotal">Total</div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="main-layout">
        <!-- Room Buttons (rendered by Blade) -->
        <div>
            <div class="room-nav-title" data-i18n="floor1">🏢 Piso 1 — Habitaciones 101 a 114</div>
            <div class="room-grid" id="nav-piso1">
                @for ($i = 101; $i <= 114; $i++)
                <button class="room-btn available" data-room="{{ $i }}" id="btn-room-{{ $i }}" onclick="selectRoom({{ $i }})">
                    <span class="room-status-dot"></span>
                    <span>{{ $i }}</span>
                </button>
                @endfor
            </div>

            <div class="room-nav-title" data-i18n="floor2">🏢 Piso 2 — Habitaciones 201 a 214</div>
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
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--success);margin-right:4px;"></span><span data-i18n="legendAvailable">Disponible</span></span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--warning);margin-right:4px;"></span><span data-i18n="legendReserved">Con reserva futura</span></span>
                <span><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--danger);margin-right:4px;"></span><span data-i18n="legendOccupied">Ocupada hoy</span></span>
            </div>

            <!-- Dashboard Widgets (Upcoming Departures & Unpaid Rents) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" style="margin-top: 24px;" id="dashboard-widgets">
                <!-- Carga dinámica -->
            </div>
        </div>

        <!-- Detail Panel -->
        <div class="detail-panel" id="detail-panel">
            <div class="detail-header">
                <span class="detail-title"><span data-i18n="lblRoomHeader">Habitación</span> <span id="lbl-room">---</span></span>
                <span class="status-badge available" id="lbl-status" data-i18n="statusFree">Libre</span>
            </div>

            <!-- No room selected -->
            <div id="state-no-room" class="empty-state">
                <div class="empty-state-icon">👆</div>
                <p style="color:#64748b; font-size:13px;" data-i18n="selectRoomPrompt">Selecciona una habitación para ver su detalle</p>
            </div>

            <!-- Room selected - dynamic content -->
            <div id="state-room-selected" style="display:none;">
                <!-- Current booking info (visible when occupied) -->
                <div id="current-booking-section" style="display:none;">
                    <div class="info-group">
                        <div class="info-label" data-i18n="lblCurrentGuest">Cliente Actual</div>
                        <div class="info-value" style="font-size:1rem; font-weight:800; color:#f8fafc;" id="detail-cliente"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label" data-i18n="lblPhone">Teléfono</div>
                        <div class="info-value" id="detail-telefono"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-2" style="margin:12px 0;">
                        <div class="info-group">
                            <div class="info-label" data-i18n="lblCheckIn">Entrada</div>
                            <div class="info-value" id="detail-start"></div>
                        </div>
                        <div class="info-group">
                            <div class="info-label" data-i18n="lblCheckOut">Salida</div>
                            <div class="info-value" id="detail-end"></div>
                        </div>
                        <div class="info-group">
                            <div class="info-label" data-i18n="lblDaysRemaining">Días restantes</div>
                            <div class="info-value font-bold" id="detail-days-remaining">-</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2" style="border-top:1px solid var(--border); border-bottom:1px solid var(--border); padding:10px 0; margin:10px 0;">
                        <div class="info-group">
                            <div class="info-label" data-i18n="lblCleaning">Aseo</div>
                            <div class="info-value" style="color:var(--primary);" id="detail-aseo">$0</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label" data-i18n="lblDeposit">Depósito</div>
                            <div class="info-value" style="color:var(--primary);" id="detail-deposito">$0</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label" data-i18n="lblTotalPaid">Total Pagado</div>
                            <div class="info-value" style="color:var(--primary);" id="detail-total-pagado">$0</div>
                        </div>
                    </div>
                    <div class="info-group">
                        <div class="info-label" data-i18n="lblRegisteredAt">Registrado el</div>
                        <div class="info-value" style="font-size:12px; color:#64748b;" id="detail-registered"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label" data-i18n="lblNotes">Notas</div>
                        <div style="background:#0a1831; border:1px solid var(--border); border-radius:8px; padding:10px; font-size:12px; max-height:80px; overflow-y:auto; white-space:pre-wrap;" id="detail-notas"></div>
                    </div>
                    <!-- Payment Schedule inside Detail Panel -->
                    <div id="detail-schedule-container" style="display:none; margin-top:12px; padding-top:12px; border-top:1px dashed var(--border);">
                        <div class="info-label" data-i18n="lblPaymentSchedule">📅 Calendario de Pagos Mensuales</div>
                        <div id="detail-schedule-list" style="font-size:11px; display:grid; grid-template-columns: repeat(1, 1fr); gap:4px; color:#cbd5e1; margin-top:6px;"></div>
                    </div>
                    <div class="actions-stack">
                        <button class="btn btn-success btn-sm" onclick="triggerCheckout()" data-i18n="btnCheckout">🚪 Realizar Check-Out</button>
                        <button class="btn btn-secondary btn-sm" onclick="openEditModalForCurrentRoom()" data-i18n="btnEditCurrent">✏️ Editar Reserva Actual</button>
                        <button class="btn btn-danger btn-sm" onclick="triggerDeleteCurrent()" data-i18n="btnDeleteCurrent">🗑️ Eliminar Registro</button>
                    </div>
                </div>

                <!-- Available (free now, may have future bookings) -->
                <div id="available-booking-section" style="display:none;">
                    <div class="empty-state" style="padding:10px 0;">
                        <div class="empty-state-icon" id="avail-icon">🔑</div>
                        <p style="color:#94a3b8; font-size:13px; margin-bottom:12px;" id="avail-text">Habitación disponible</p>
                        <button class="btn btn-primary btn-sm" onclick="openCheckInModal()" data-i18n="newReservation">+ Nueva Reserva</button>
                    </div>
                </div>

                <!-- Booking History List -->
                <div id="history-section" style="display:none;">
                    <div class="section-divider" data-i18n="lblHistory">📋 Historial de Reservas</div>
                    <div id="history-list"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Occupancy -->
    <!-- Monthly Occupancy -->
    <div class="monthly-section">
        <div class="monthly-section-title" data-i18n="lblMonthlyOccupancy">📅 Ocupación por Mes</div>
        <div class="months-grid" id="monthly-container">
            <p style="color:#64748b; font-size:13px;">Cargando datos...</p>
        </div>
    </div>
</div>

<script>
    var currentLang = '{{ app()->getLocale() }}';
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

    // ========== PAYMENT UTILITIES ==========
    function parsePaymentStatus(notas) {
        if (!notas) return [];
        var match = notas.match(/\[PAGOS:\s*([\d,]*)\s*\]/);
        if (!match) return [];
        var listStr = match[1].trim();
        if (!listStr) return [];
        return listStr.split(',').map(function(n) { return parseInt(n); }).filter(function(n) { return !isNaN(n); });
    }

    function cleanNotes(notas) {
        if (!notas) return '';
        return notas.replace(/\[PAGOS:\s*[\d,]*\s*\]/, '').trim();
    }

    function toggleMonthPayment(row, monthNum, isPaid) {
        var b = bookingsList.find(function(x) { return parseInt(x.row) === parseInt(row); });
        if (!b) return;

        var paidMonths = parsePaymentStatus(b.notas);
        var index = paidMonths.indexOf(monthNum);
        if (isPaid) {
            if (index === -1) paidMonths.push(monthNum);
        } else {
            if (index !== -1) paidMonths.splice(index, 1);
        }

        var baseNotes = cleanNotes(b.notas);
        var tag = '[PAGOS: ' + paidMonths.sort(function(a,b){return a-b;}).join(',') + ']';
        var newNotes = baseNotes ? baseNotes + '\n' + tag : tag;

        var tok = document.querySelector('meta[name="csrf-token"]').content;
        var p = {
            room: b.room,
            cliente: b.cliente,
            telefono: b.telefono,
            fecha_inicio: b.fecha_inicio,
            fecha_salida: b.fecha_salida,
            tasa_aseo: b.tasa_aseo || 0,
            deposito: b.deposito || 0,
            total_pagado: b.total_pagado || 0,
            estado: b.estado,
            notas: newNotes,
            notes: newNotes,
            fecha_registro: b.fecha_registro
        };

        showLoading(currentLang === 'es' ? 'Actualizando estado de pago...' : 'Updating payment status...');
        fetch('/api/rooms-control/bookings/' + row, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': tok
            },
            body: JSON.stringify(p)
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success) {
                loadBookings();
            } else {
                alert('Error: ' + res.message);
                hideLoading();
            }
        })
        .catch(function() {
            alert(currentLang === 'es' ? 'Error al actualizar.' : 'Error updating.');
            hideLoading();
        });
    }


    // ========== ROOM INFO MODAL ==========
    function handleRoomModalClick(e) {
        if (e.target === document.getElementById('room-modal')) closeModal('room-modal');
    }

    function showRoomModal(room) {
        currentRoom = room;
        var booking  = getCurrentBooking(room);
        var allBook  = getActiveBookingsForRoom(room);
        var status   = getRoomStatus(room);

        // Header
        document.getElementById('rm-title').innerText = (currentLang === 'es' ? 'Habitación ' : 'Room ') + room;
        var badge = document.getElementById('rm-badge');
        if (status === 'occupied') {
            badge.className = 'status-badge occupied'; badge.innerText = currentLang === 'es' ? 'Ocupada' : 'Occupied';
        } else if (status === 'reserved') {
            badge.className = 'status-badge reserved'; badge.innerText = currentLang === 'es' ? 'Con Reservas' : 'Has Bookings';
        } else {
            badge.className = 'status-badge available'; badge.innerText = currentLang === 'es' ? 'Disponible' : 'Available';
        }

        var html = '';

        // Current booking section
        if (status === 'occupied' && booking) {
            html += buildCurrentBookingHTML(booking, room);
        } else {
            var icon = status === 'reserved' ? '📅' : '🔑';
            var msg  = status === 'reserved'
                ? (currentLang === 'es' ? 'Disponible ahora — tiene reservas futuras' : 'Available now — has future bookings')
                : (currentLang === 'es' ? 'Sin reservas activas — habitación libre' : 'No active bookings — free room');
            html += '<div style="text-align:center; padding:16px 0;">';
            html += '<div style="font-size:2.5rem; margin-bottom:8px;">' + icon + '</div>';
            html += '<p style="color:#94a3b8; font-size:13px; margin-bottom:14px;">' + msg + '</p>';
            html += '<button class="btn btn-primary btn-sm" style="display:inline-flex;width:auto;padding:9px 20px;" onclick="closeModal(\'room-modal\'); openCheckInModal();">' + (currentLang === 'es' ? '+ Nueva Reserva para Hab. ' : '+ New Booking for Room ') + room + '</button>';
            html += '</div>';
        }

        // History
        if (allBook.length > 0) {
            html += '<div class="section-divider" style="margin-top:16px;">' + (currentLang === 'es' ? '📋 Historial de Reservas' : '📋 Booking History') + '</div>';
            allBook.forEach(function(b) {
                var isCurr   = isOccupiedToday(b);
                var isFut    = isFutureBooking(b);
                var isClosed = (b.estado||'').toUpperCase() === 'CERRADO';
                var tc   = isCurr ? 'is-current' : (isFut ? 'is-future' : 'is-past');
                var txt  = isCurr 
                    ? (currentLang === 'es' ? 'ACTIVO' : 'ACTIVE') 
                    : (isFut 
                        ? (currentLang === 'es' ? 'FUTURO' : 'FUTURE') 
                        : (isClosed ? (currentLang === 'es' ? 'CERRADO' : 'CLOSED') : (currentLang === 'es' ? 'PASADO' : 'PAST')));
                var diff = calcDaysRemaining(b.fecha_salida);
                var dStr = '';
                if (diff !== null && isCurr) {
                    if (diff > 0) dStr = ' <span style="color:#f59e0b; font-size:11px;">(' + diff + (currentLang === 'es' ? ' días restantes)' : ' days remaining)') + '</span>';
                    else if (diff === 0) dStr = ' <span style="color:#10b981; font-size:11px;">(' + (currentLang === 'es' ? '¡Hoy!)' : 'Today!)') + '</span>';
                    else dStr = ' <span style="color:#ef4444; font-size:11px;">(' + (currentLang === 'es' ? 'Vencido)' : 'Overdue)') + '</span>';
                }
                html += '<div class="booking-card ' + tc + '">';
                html += '<div class="booking-card-header"><span class="booking-card-name">' + (b.cliente||'N/A') + '</span><span class="booking-tag ' + tc + '">' + txt + '</span></div>';
                html += '<div class="booking-card-dates">' + fmtDate(b.fecha_inicio) + ' → ' + fmtDate(b.fecha_salida) + dStr + '</div>';
                html += '<div class="booking-card-meta">' + (b.telefono||'') + (b.total_pagado ? ' | $'+parseFloat(b.total_pagado).toLocaleString() : '') + '</div>';
                if (!isClosed) {
                    html += '<div class="booking-card-actions">';
                    html += '<button class="mini-btn mini-btn-edit" onclick="closeModal(\'room-modal\'); openEditModalForRow(' + b.row + ');">' + (currentLang === 'es' ? '✏️ Editar' : '✏️ Edit') + '</button>';
                    if (isCurr) html += '<button class="mini-btn mini-btn-del" onclick="closeModal(\'room-modal\'); triggerCheckoutRow(' + b.row + ');">' + (currentLang === 'es' ? '🚪 Checkout' : '🚪 Checkout') + '</button>';
                    html += '<button class="mini-btn mini-btn-del" onclick="closeModal(\'room-modal\'); triggerDeleteRow(' + b.row + ');">' + (currentLang === 'es' ? '🗑️ Borrar' : '🗑️ Delete') + '</button>';
                    html += '</div>';
                }
                html += '</div>';
            });
        } else {
            html += '<p style="color:#64748b; text-align:center; padding:12px; font-size:12px;">' + (currentLang === 'es' ? 'Sin reservas registradas.' : 'No bookings registered.') + '</p>';
        }

        // Bottom action
        html += '<div style="margin-top:14px; padding-top:12px; border-top:1px solid var(--border);">';
        html += '<button class="btn btn-primary btn-sm" onclick="closeModal(\'room-modal\'); openCheckInModal();">' + (currentLang === 'es' ? '+ Nueva Reserva para Hab. ' : '+ New Booking for Room ') + room + '</button>';
        html += '</div>';

        document.getElementById('rm-body').innerHTML = html;
        openModal('room-modal');
    }

    function buildCurrentBookingHTML(b, room) {
        var diff = calcDaysRemaining(b.fecha_salida);
        var dColor = '#f59e0b', dText = '-';
        if (diff !== null) {
            if (diff > 0)  { dText = diff + (currentLang === 'es' ? ' días' : ' days');           dColor = '#f59e0b'; }
            else if (diff === 0) { dText = currentLang === 'es' ? '¡Hoy!' : 'Today!';            dColor = '#10b981'; }
            else           { dText = (currentLang === 'es' ? 'Vencido ' : 'Overdue ') + Math.abs(diff)+'d'; dColor = '#ef4444'; }
        }
        var h = '';
        h += '<div class="info-group"><div class="info-label">' + (currentLang === 'es' ? 'Cliente Actual' : 'Current Guest') + '</div><div class="info-value" style="font-size:1rem;font-weight:800;color:#f8fafc;">' + (b.cliente||'N/A') + '</div></div>';
        h += '<div class="info-group"><div class="info-label">' + (currentLang === 'es' ? 'Teléfono' : 'Phone') + '</div><div class="info-value">' + (b.telefono||'N/A') + '</div></div>';
        h += '<div class="grid grid-cols-3 gap-2" style="margin:10px 0;">';
        h += '<div class="info-group"><div class="info-label">' + (currentLang === 'es' ? 'Entrada' : 'Check-In') + '</div><div class="info-value">' + fmtDate(b.fecha_inicio) + '</div></div>';
        h += '<div class="info-group"><div class="info-label">' + (currentLang === 'es' ? 'Salida' : 'Check-Out') + '</div><div class="info-value">' + fmtDate(b.fecha_salida) + '</div></div>';
        h += '<div class="info-group"><div class="info-label">' + (currentLang === 'es' ? 'Días rest.' : 'Days remaining') + '</div><div class="info-value font-bold" style="color:' + dColor + ';">' + dText + '</div></div>';
        h += '</div>';
        h += '<div class="grid grid-cols-3 gap-2" style="border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:8px 0;margin:8px 0;">';
        h += '<div class="info-group"><div class="info-label">' + (currentLang === 'es' ? 'Aseo' : 'Cleaning') + '</div><div class="info-value" style="color:var(--primary);">$' + (parseFloat(b.tasa_aseo)||0).toLocaleString() + '</div></div>';
        h += '<div class="info-group"><div class="info-label">' + (currentLang === 'es' ? 'Depósito' : 'Deposit') + '</div><div class="info-value" style="color:var(--primary);">$' + (parseFloat(b.deposito)||0).toLocaleString() + '</div></div>';
        h += '<div class="info-group"><div class="info-label">' + (currentLang === 'es' ? 'Total Pagado' : 'Total Paid') + '</div><div class="info-value" style="color:var(--primary);">$' + (parseFloat(b.total_pagado)||0).toLocaleString() + '</div></div>';
        h += '</div>';
        var cleanN = cleanNotes(b.notas);
        if (cleanN) h += '<div class="info-group"><div class="info-label">' + (currentLang === 'es' ? 'Notas' : 'Notes') + '</div><div style="background:#0a1831;border:1px solid var(--border);border-radius:8px;padding:8px;font-size:12px;max-height:60px;overflow-y:auto;white-space:pre-wrap;">' + cleanN + '</div></div>';
        
        // Dynamic month-by-month schedule list in modal
        var totalDays = Math.ceil((parseDate(b.fecha_salida) - parseDate(b.fecha_inicio)) / 86400000) + 1;
        var months  = Math.floor(totalDays / 30);
        if (totalDays >= 28 && months >= 6) {
            var rM = Math.round((parseFloat(b.total_pagado) || 0) / (months - 1));
            var depVal = parseFloat(b.deposito) || rM;
            var paidMonths = parsePaymentStatus(b.notas);
            h += '<div class="section-divider" style="margin-top:14px; margin-bottom:8px;">' + (currentLang === 'es' ? '📅 Calendario de Pagos Mensuales' : '📅 Monthly Payment Schedule') + '</div>';
            h += '<div style="font-size:12px; display:grid; grid-template-columns: repeat(2, 1fr); gap:6px; color:#cbd5e1; margin-bottom:12px;">';
            for (var i = 1; i <= months; i++) {
                var monthLabel = currentLang === 'es' ? 'Mes ' + i : 'Month ' + i;
                var isChecked = paidMonths.indexOf(i) !== -1 ? 'checked' : '';
                
                if (i === 1) {
                    var rentPart = '$' + rM.toLocaleString();
                    var depPart = '$' + depVal.toLocaleString();
                    var totalPart = '$' + (rM + depVal).toLocaleString();
                    h += '<div style="grid-column: 1 / -1; display:flex; align-items:center; justify-content:space-between; padding:4px 8px; background:rgba(255,255,255,0.03); border-radius:6px; border:1px solid rgba(255,255,255,0.08); gap:8px;">';
                    h += '  <div style="display:flex; align-items:center; gap:8px;">';
                    h += '    <input type="checkbox" ' + isChecked + ' onchange="toggleMonthPayment(' + b.row + ', ' + i + ', this.checked)" style="width:14px; height:14px; accent-color:var(--primary); cursor:pointer;">';
                    h += '    <span>' + monthLabel + ' (+ ' + (currentLang === 'es' ? 'Depósito' : 'Deposit') + ')</span>';
                    h += '  </div>';
                    h += '  <span class="font-bold">' + rentPart + ' + ' + depPart + ' = ' + totalPart + '</span>';
                    h += '</div>';
                } else if (i === 5) {
                    h += '<div style="display:flex; align-items:center; justify-content:space-between; padding:4px 8px; background:rgba(16,185,129,0.15); border-radius:6px; border:1px solid var(--success); gap:8px;">';
                    h += '  <div style="display:flex; align-items:center; gap:8px;">';
                    h += '    <input type="checkbox" checked disabled style="width:14px; height:14px; accent-color:var(--success); cursor:not-allowed;">';
                    h += '    <span>' + monthLabel + '</span>';
                    h += '  </div>';
                    h += '  <span class="font-bold" style="color:var(--success);">' + (currentLang === 'es' ? '¡Gratis!' : 'Free!') + '</span>';
                    h += '</div>';
                } else {
                    h += '<div style="display:flex; align-items:center; justify-content:space-between; padding:4px 8px; background:rgba(255,255,255,0.03); border-radius:6px; border:1px solid rgba(255,255,255,0.05); gap:8px;">';
                    h += '  <div style="display:flex; align-items:center; gap:8px;">';
                    h += '    <input type="checkbox" ' + isChecked + ' onchange="toggleMonthPayment(' + b.row + ', ' + i + ', this.checked)" style="width:14px; height:14px; accent-color:var(--primary); cursor:pointer;">';
                    h += '    <span>' + monthLabel + '</span>';
                    h += '  </div>';
                    h += '  <span class="font-bold">$' + rM.toLocaleString() + '</span>';
                    h += '</div>';
                }
            }
            h += '</div>';
        }

        
        h += '<div class="actions-stack" style="margin-top:12px;">';
        h += '<button class="btn btn-success btn-sm" onclick="closeModal(\'room-modal\'); triggerCheckoutRow(' + b.row + ');">' + (currentLang === 'es' ? '🚪 Check-Out' : '🚪 Check-Out') + '</button>';
        h += '<button class="btn btn-secondary btn-sm" onclick="closeModal(\'room-modal\'); openEditModalForRow(' + b.row + ');">' + (currentLang === 'es' ? '✏️ Editar Reserva' : '✏️ Edit Booking') + '</button>';
        h += '<button class="btn btn-danger btn-sm" onclick="closeModal(\'room-modal\'); triggerDeleteRow(' + b.row + ');">' + (currentLang === 'es' ? '🗑️ Eliminar Registro' : '🗑️ Delete Record') + '</button>';
        h += '</div>';
        return h;
    }

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

    // ========== LANGUAGE & TRANSLATIONS ==========
    const translations = {
        es: {
            pageTitle: '🏨 Control de Habitaciones y Reservas',
            pageSubTitle: 'Panel de administración y control de disponibilidad en Kissimmee',
            calcTitle: '🧮 Calculadora de Tarifa',
            bedTypeLabel: '👥 Número de Personas',
            rateDailyLabel: '💵 Tarifa Diaria',
            rateWeeklyLabel: '💵 Tarifa Semanal',
            rateMonthlyLabel: '💵 Tarifa Mensual',
            applyBtn: '✅ Usar este total',
            newReservation: '+ Nueva Reserva',
            editReservation: '✏️ Editar Reserva',
            checkinTitle: '+ Nueva Reserva / Check-In',
            overlapWarningCheckIn: '⚠️ Las fechas seleccionadas se solapan con una reserva existente.',
            overlapWarningEdit: '⚠️ Las fechas seleccionadas se solapan con otra reserva existente.',
            roomLabel: 'Habitación',
            guestLabel: 'Nombre del Cliente',
            phoneLabel: 'Teléfono',
            startLabel: 'Fecha Entrada',
            endLabel: 'Fecha Salida',
            aseoLabel: 'Tasa Aseo',
            depositoLabel: 'Depósito',
            totalPaidLabel: 'Total Pagado',
            notesLabel: 'Notas',
            saveBookingBtn: 'Guardar Reserva',
            editTitle: '✏️ Editar Reserva',
            statusLabel: 'Estado',
            statusOpen: 'ABIERTO',
            statusClosed: 'CERRADO',
            saveChangesBtn: 'Guardar Cambios',
            backLink: '← Volver a Inicio',
            statOccupied: 'Ocupadas Hoy',
            statReserved: 'Con Reserva',
            statAvailable: 'Disponibles',
            statTotal: 'Total',
            floor1: '🏢 Piso 1 — Habitaciones 101 a 114',
            floor2: '🏢 Piso 2 — Habitaciones 201 a 214',
            legendAvailable: 'Disponible',
            legendReserved: 'Con reserva futura',
            legendOccupied: 'Ocupada hoy',
            lblRoomHeader: 'Habitación',
            statusFree: 'Libre',
            selectRoomPrompt: 'Selecciona una habitación para ver su detalle',
            lblCurrentGuest: 'Cliente Actual',
            lblPhone: 'Teléfono',
            lblCheckIn: 'Entrada',
            lblCheckOut: 'Salida',
            lblDaysRemaining: 'Días restantes',
            lblCleaning: 'Aseo',
            lblDeposit: 'Depósito',
            lblTotalPaid: 'Total Pagado',
            lblRegisteredAt: 'Registrado el',
            lblNotes: 'Notas',
            btnCheckout: '🚪 Realizar Check-Out',
            btnEditCurrent: '✏️ Editar Reserva Actual',
            btnDeleteCurrent: '🗑️ Eliminar Registro',
            lblHistory: '📋 Historial de Reservas',
            lblMonthlyOccupancy: '📅 Ocupación por Mes',
            lblPaymentSchedule: '📅 Calendario de Pagos Mensuales',
            bedSelectPrompt: '-- Seleccionar número de personas --',
            bedSingle: '1 Persona ($75/día)',
            bedDouble: '2 Personas - Cama Doble ($105/día)',
            bedTwin: '2 Personas - 2 Camas ($105/día)',
            bedQueen: '3 Personas ($140/día)',
            bedKing: '4+ Personas',
            lblCalcDays: 'Días',
            lblCalcPeriod: 'Período',
            lblCalcBaseRate: 'Tarifa Base',
            lblCalcTotal: 'TOTAL'
        },
        en: {
            pageTitle: '🏨 Rooms and Bookings Control',
            pageSubTitle: 'Administration panel and availability control in Kissimmee',
            calcTitle: '🧮 Rate Calculator',
            bedTypeLabel: '👥 Number of People',
            rateDailyLabel: '💵 Daily Rate',
            rateWeeklyLabel: '💵 Weekly Rate',
            rateMonthlyLabel: '💵 Monthly Rate',
            applyBtn: '✅ Use this total',
            newReservation: '+ New Booking',
            editReservation: '✏️ Edit Booking',
            checkinTitle: '+ New Booking / Check-In',
            overlapWarningCheckIn: '⚠️ Selected dates overlap with an existing booking.',
            overlapWarningEdit: '⚠️ Selected dates overlap with another existing booking.',
            roomLabel: 'Room',
            guestLabel: 'Guest Name',
            phoneLabel: 'Phone',
            startLabel: 'Check-In Date',
            endLabel: 'Check-Out Date',
            aseoLabel: 'Cleaning Fee',
            depositoLabel: 'Deposit',
            totalPaidLabel: 'Total Paid',
            notesLabel: 'Notes',
            saveBookingBtn: 'Save Booking',
            editTitle: '✏️ Edit Booking',
            statusLabel: 'Status',
            statusOpen: 'OPEN',
            statusClosed: 'CLOSED',
            saveChangesBtn: 'Save Changes',
            backLink: '← Back to Home',
            statOccupied: 'Occupied Today',
            statReserved: 'Reserved',
            statAvailable: 'Available',
            statTotal: 'Total',
            floor1: '🏢 Floor 1 — Rooms 101 to 114',
            floor2: '🏢 Floor 2 — Rooms 201 to 214',
            legendAvailable: 'Available',
            legendReserved: 'With future booking',
            legendOccupied: 'Occupied today',
            lblRoomHeader: 'Room',
            statusFree: 'Free',
            selectRoomPrompt: 'Select a room to view details',
            lblCurrentGuest: 'Current Guest',
            lblPhone: 'Phone',
            lblCheckIn: 'Check-In',
            lblCheckOut: 'Check-Out',
            lblDaysRemaining: 'Days Remaining',
            lblCleaning: 'Cleaning',
            lblDeposit: 'Deposit',
            lblTotalPaid: 'Total Paid',
            lblRegisteredAt: 'Registered At',
            lblNotes: 'Notes',
            btnCheckout: '🚪 Check-Out',
            btnEditCurrent: '✏️ Edit Current Booking',
            btnDeleteCurrent: '🗑️ Delete Record',
            lblHistory: '📋 Booking History',
            lblMonthlyOccupancy: '📅 Monthly Occupancy',
            lblPaymentSchedule: '📅 Monthly Payment Schedule',
            bedSelectPrompt: '-- Select number of people --',
            bedSingle: '1 Person ($75/day)',
            bedDouble: '2 People - Double Bed ($105/day)',
            bedTwin: '2 People - 2 Beds ($105/day)',
            bedQueen: '3 People ($140/day)',
            bedKing: '4+ People',
            lblCalcDays: 'Days',
            lblCalcPeriod: 'Period',
            lblCalcBaseRate: 'Base Rate',
            lblCalcTotal: 'TOTAL'
        }
    };

    function applyTranslations() {
        const t = translations[currentLang] || translations['es'];
        const elems = document.querySelectorAll('[data-i18n]');
        elems.forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (!t[key]) return;
            // Handle placeholders for inputs, textareas, selects
            if (['INPUT', 'TEXTAREA', 'SELECT'].includes(el.tagName)) {
                if (el.hasAttribute('placeholder')) {
                    el.placeholder = t[key];
                }
                if (el.tagName === 'INPUT' && el.type === 'button') {
                    el.value = t[key];
                }
            }
            // Update visible text for common elements
            if (['BUTTON', 'DIV', 'SPAN', 'H1', 'H3', 'P', 'LABEL', 'A', 'OPTION'].includes(el.tagName)) {
                el.innerText = t[key];
            }
        });
    }

    function setLanguage(lang) {
        currentLang = lang;
        fetch('?lang=' + lang).catch(err => console.error(err));
        document.getElementById('btn-es').classList.toggle('active', lang === 'es');
        document.getElementById('btn-en').classList.toggle('active', lang === 'en');
        applyTranslations();
        if (currentRoom) {
            showDetails(currentRoom);
            var roomModal = document.getElementById('room-modal');
            if (roomModal && roomModal.style.display === 'flex') {
                showRoomModal(currentRoom);
            }
        }
        renderMonthly();
        renderDashboardWidgets();
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
        console.log('selectRoom triggered for room', room);
        currentRoom = room;
        document.querySelectorAll('.room-btn').forEach(function(b) {
            b.classList.toggle('active', parseInt(b.getAttribute('data-room')) === parseInt(room));
        });
        document.getElementById('lbl-room').innerText = room;
        document.getElementById('state-no-room').style.display = 'none';
        document.getElementById('state-room-selected').style.display = 'block';
        // Optionally update side panel details
        // showDetails(room);
        // Open the room info popup modal
        showRoomModal(room);
        // Ensure modal is visible (fallback)
        openModal('room-modal');
        console.log('selectRoom completed');
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
        document.getElementById('detail-notas').innerText = cleanNotes(b.notas) || (currentLang === 'es' ? 'Sin notas.' : 'No notes.');
        var drEl = document.getElementById('detail-days-remaining');
        var diff = calcDaysRemaining(b.fecha_salida);
        if (diff !== null) {
            if (diff > 0) { drEl.innerText = diff + (currentLang==='es'?' días':' days'); drEl.style.color = '#f59e0b'; }
            else if (diff === 0) { drEl.innerText = '¡Hoy!'; drEl.style.color = '#10b981'; }
            else { drEl.innerText = (currentLang==='es'?'Vencido ':'Overdue ') + Math.abs(diff) + 'd'; drEl.style.color = '#ef4444'; }
        }

        // Populate payment schedule in detail panel
        var totalDays = Math.ceil((parseDate(b.fecha_salida) - parseDate(b.fecha_inicio)) / 86400000) + 1;
        var months  = Math.floor(totalDays / 30);
        var schedContainer = document.getElementById('detail-schedule-container');
        var schedList = document.getElementById('detail-schedule-list');

        if (totalDays >= 28 && months >= 6) {
            schedContainer.style.display = 'block';
            schedList.innerHTML = '';
            var rM = Math.round((parseFloat(b.total_pagado) || 0) / (months - 1));
            var depVal = parseFloat(b.deposito) || rM;
            var paidMonths = parsePaymentStatus(b.notas);
            for (var i = 1; i <= months; i++) {
                var monthLabel = currentLang === 'es' ? 'Mes ' + i : 'Month ' + i;
                var isChecked = paidMonths.indexOf(i) !== -1 ? 'checked' : '';
                var row = document.createElement('div');
                row.style.display = 'flex';
                row.style.alignItems = 'center';
                row.style.justifyContent = 'space-between';
                row.style.padding = '4px 8px';
                row.style.borderRadius = '4px';
                row.style.gap = '8px';

                if (i === 1) {
                    row.style.background = 'rgba(255,255,255,0.03)';
                    row.style.border = '1px solid rgba(255,255,255,0.08)';
                    
                    var rentPart = '$' + rM.toLocaleString();
                    var depPart = '$' + depVal.toLocaleString();
                    var totalPart = '$' + (rM + depVal).toLocaleString();
                    
                    row.innerHTML = '<div style="display:flex; align-items:center; gap:8px;">'
                        + '  <input type="checkbox" ' + isChecked + ' onchange="toggleMonthPayment(' + b.row + ', ' + i + ', this.checked)" style="width:14px; height:14px; accent-color:var(--primary); cursor:pointer;">'
                        + '  <span>' + monthLabel + ' (+ ' + (currentLang === 'es' ? 'Depósito' : 'Dep.') + ')</span>'
                        + '</div>'
                        + '<span class="font-bold">' + totalPart + '</span>';
                } else if (i === 5) {
                    row.style.background = 'rgba(16,185,129,0.15)';
                    row.style.border = '1px solid var(--success)';
                    row.innerHTML = '<div style="display:flex; align-items:center; gap:8px;">'
                        + '  <input type="checkbox" checked disabled style="width:14px; height:14px; accent-color:var(--success); cursor:not-allowed;">'
                        + '  <span>' + monthLabel + '</span>'
                        + '</div>'
                        + '<span class="font-bold" style="color:var(--success);">' + (currentLang === 'es' ? '¡Gratis!' : 'Free!') + '</span>';
                } else {
                    row.style.background = 'rgba(255,255,255,0.03)';
                    row.style.border = '1px solid rgba(255,255,255,0.05)';
                    row.innerHTML = '<div style="display:flex; align-items:center; gap:8px;">'
                        + '  <input type="checkbox" ' + isChecked + ' onchange="toggleMonthPayment(' + b.row + ', ' + i + ', this.checked)" style="width:14px; height:14px; accent-color:var(--primary); cursor:pointer;">'
                        + '  <span>' + monthLabel + '</span>'
                        + '</div>'
                        + '<span class="font-bold">$' + rM.toLocaleString() + '</span>';
                }
                schedList.appendChild(row);
            }
        } else {
            schedContainer.style.display = 'none';
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
            var tagText = isCurr 
                ? (currentLang === 'es' ? 'ACTIVO' : 'ACTIVE') 
                : (isFut 
                    ? (currentLang === 'es' ? 'FUTURO' : 'FUTURE') 
                    : (isClosed ? (currentLang === 'es' ? 'CERRADO' : 'CLOSED') : (currentLang === 'es' ? 'PASADO' : 'PAST')));

            var card = document.createElement('div');
            card.className = 'booking-card ' + tagClass;

            var actionsHtml = '';
            if (!isClosed) {
                actionsHtml = '<div class="booking-card-actions">'
                    + '<button class="mini-btn mini-btn-edit" onclick="openEditModalForRow(' + b.row + ')">' + (currentLang === 'es' ? '✏️ Editar' : '✏️ Edit') + '</button>'
                    + (isCurr ? '<button class="mini-btn mini-btn-del" onclick="triggerCheckoutRow(' + b.row + ')">' + (currentLang === 'es' ? '🚪 Checkout' : '🚪 Checkout') + '</button>' : '')
                    + '<button class="mini-btn mini-btn-del" onclick="triggerDeleteRow(' + b.row + ')">' + (currentLang === 'es' ? '🗑️ Borrar' : '🗑️ Delete') + '</button>'
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

        // Determine range dynamically: from current month to the last booking's end date
        var activeBookings = bookingsList.filter(function(b) {
            return (b.estado||'').toUpperCase() !== 'CERRADO';
        });

        // Find the furthest end date across all bookings
        var maxDate = null;
        activeBookings.forEach(function(b) {
            var e = parseDate(b.fecha_salida);
            if (e && (!maxDate || e > maxDate)) maxDate = e;
        });

        // Build month array from current month to month of last booking
        var months = [];
        var today = todayDate();
        var startMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        var endMonth = maxDate
            ? new Date(maxDate.getFullYear(), maxDate.getMonth(), 1)
            : new Date(today.getFullYear(), today.getMonth() + 3, 1); // fallback: +3 months

        var cursor = new Date(startMonth);
        while (cursor <= endMonth) {
            months.push({ year: cursor.getFullYear(), month: cursor.getMonth() });
            cursor.setMonth(cursor.getMonth() + 1);
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

    // ========== DASHBOARD WIDGETS ==========
    function renderDashboardWidgets() {
        var container = document.getElementById('dashboard-widgets');
        if (!container) return;
        container.innerHTML = '';

        var activeBookings = bookingsList.filter(function(b) {
            return (b.estado||'').toUpperCase() !== 'CERRADO';
        });

        // 1. Calculate Upcoming Departures (next 7 days)
        var today = todayDate();
        var limitDate = new Date(today);
        limitDate.setDate(limitDate.getDate() + 7);

        var departures = activeBookings.filter(function(b) {
            var e = parseDate(b.fecha_salida);
            return e && e >= today && e <= limitDate;
        }).sort(function(a, b) {
            return (parseDate(a.fecha_salida)||new Date(0)) - (parseDate(b.fecha_salida)||new Date(0));
        });

        // 2. Calculate Unpaid Rent Alerts (for contracts >= 6 months)
        var unpaidAlerts = [];
        activeBookings.forEach(function(b) {
            if (!isOccupiedToday(b)) return; // only current active guests
            var totalDays = Math.ceil((parseDate(b.fecha_salida) - parseDate(b.fecha_inicio)) / 86400000) + 1;
            var months = Math.floor(totalDays / 30);
            if (totalDays >= 28 && months >= 6) {
                var paidMonths = parsePaymentStatus(b.notas);
                var rM = Math.round((parseFloat(b.total_pagado) || 0) / (months - 1));
                
                // Days elapsed since check-in up to today
                var daysSinceCheckIn = Math.ceil((today - parseDate(b.fecha_inicio)) / 86400000) + 1;
                var currentProgressMonth = Math.min(months, Math.max(1, Math.ceil(daysSinceCheckIn / 30)));
                
                for (var i = 1; i <= currentProgressMonth; i++) {
                    if (i === 5) continue; // Month 5 is free
                    if (paidMonths.indexOf(i) === -1) {
                        unpaidAlerts.push({
                            booking: b,
                            monthNum: i,
                            amount: rM
                        });
                    }
                }
            }
        });

        // Column 1: Departures
        var depCard = document.createElement('div');
        depCard.className = 'widget-card';
        var depHtml = '<div class="widget-title">📅 ' 
            + (currentLang === 'es' ? 'Salidas Próximas (7 días)' : 'Upcoming Departures (7 days)') 
            + '</div>';
        
        if (departures.length > 0) {
            depHtml += '<div class="widget-list">';
            departures.forEach(function(b) {
                var diff = calcDaysRemaining(b.fecha_salida);
                var badgeClass = 'success';
                var badgeText = '';
                if (diff === 0) {
                    badgeClass = 'danger';
                    badgeText = currentLang === 'es' ? 'Hoy' : 'Today';
                } else if (diff === 1) {
                    badgeClass = 'warning';
                    badgeText = currentLang === 'es' ? 'Mañana' : 'Tomorrow';
                } else {
                    badgeClass = 'success';
                    badgeText = currentLang === 'es' ? 'En ' + diff + ' días' : 'In ' + diff + ' days';
                }

                depHtml += '<div class="widget-item" onclick="selectRoom(' + b.room + ')">'
                    + '  <div class="widget-item-info">'
                    + '    <div><span class="widget-item-room">Hab. ' + b.room + '</span><span class="widget-item-name">' + (b.cliente || 'N/A') + '</span></div>'
                    + '    <span class="widget-item-sub">' + fmtDate(b.fecha_salida) + '</span>'
                    + '  </div>'
                    + '  <span class="widget-badge ' + badgeClass + '">' + badgeText + '</span>'
                    + '</div>';
            });
            depHtml += '</div>';
        } else {
            depHtml += '<p style="color:#64748b; font-size:13px; text-align:center; padding:15px; margin:0;">'
                + (currentLang === 'es' ? 'Sin salidas programadas en los próximos 7 días.' : 'No departures scheduled in the next 7 days.')
                + '</p>';
        }
        depCard.innerHTML = depHtml;
        container.appendChild(depCard);

        // Column 2: Unpaid Alerts
        var unpaidCard = document.createElement('div');
        unpaidCard.className = 'widget-card';
        var unpaidHtml = '<div class="widget-title">⚠️ ' 
            + (currentLang === 'es' ? 'Rentas Pendientes' : 'Unpaid Monthly Rent') 
            + '</div>';
        
        if (unpaidAlerts.length > 0) {
            unpaidHtml += '<div class="widget-list">';
            unpaidAlerts.forEach(function(alertItem) {
                var b = alertItem.booking;
                var monthNum = alertItem.monthNum;
                var amount = alertItem.amount;
                var monthLabel = currentLang === 'es' ? 'Mes ' + monthNum : 'Month ' + monthNum;

                unpaidHtml += '<div class="widget-item" onclick="selectRoom(' + b.room + ')">'
                    + '  <div class="widget-item-info">'
                    + '    <div><span class="widget-item-room">Hab. ' + b.room + '</span><span class="widget-item-name">' + (b.cliente || 'N/A') + '</span></div>'
                    + '    <span class="widget-item-sub">' + monthLabel + '</span>'
                    + '  </div>'
                    + '  <span class="widget-badge danger">$' + amount.toLocaleString() + '</span>'
                    + '</div>';
            });
            unpaidHtml += '</div>';
        } else {
            unpaidHtml += '<p style="color:#10b981; font-size:13px; text-align:center; padding:15px; margin:0; font-weight: 500;">'
                + (currentLang === 'es' ? '✅ Todos los pagos están al día.' : '✅ All payments are up to date.')
                + '</p>';
        }
        unpaidCard.innerHTML = unpaidHtml;
        container.appendChild(unpaidCard);
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
            alert(currentLang === 'es' ? 'La fecha de salida debe ser posterior a la de entrada.' : 'Departure date must be after check-in date.');
            return;
        }
        if (hasOverlap(room, startDate, endDate, null)) {
            alert(currentLang === 'es' 
                ? '⚠️ Las fechas seleccionadas se solapan con una reserva existente para la habitación ' + room + '. Selecciona otras fechas.'
                : '⚠️ Selected dates overlap with an existing booking for room ' + room + '. Select other dates.');
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
        closeModal('checkin-modal'); 
        showLoading(currentLang === 'es' ? 'Guardando reserva...' : 'Saving booking...');
        fetch('/api/rooms-control/bookings', { method:'POST', headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':tok}, body:JSON.stringify(p) })
            .then(function(r){return r.json();})
            .then(function(res){ if (res.success) { loadBookings(); } else { alert('Error: ' + res.message); hideLoading(); } })
            .catch(function() { alert(currentLang === 'es' ? 'Error al guardar.' : 'Error saving booking.'); hideLoading(); });
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
        document.getElementById('edit-notas').value = cleanNotes(b.notas);
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
            alert(currentLang === 'es' ? 'La fecha de salida debe ser posterior a la de entrada.' : 'Departure date must be after check-in date.');
            return;
        }
        if (hasOverlap(room, startDate, endDate, row)) {
            alert(currentLang === 'es' 
                ? '⚠️ Las fechas se solapan con otra reserva existente para la habitación ' + room + '.'
                : '⚠️ Selected dates overlap with another existing booking for room ' + room + '.');
            return;
        }
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        var oldBooking = bookingsList.find(function(x) { return parseInt(x.row) === parseInt(row); });
        var paidMonths = oldBooking ? parsePaymentStatus(oldBooking.notas) : [];
        var tag = paidMonths.length > 0 ? '[PAGOS: ' + paidMonths.sort(function(a,b){return a-b;}).join(',') + ']' : '';
        var rawNotes = document.getElementById('edit-notas').value || '';
        var finalNotes = rawNotes.trim();
        if (tag) {
            finalNotes = finalNotes ? finalNotes + '\n' + tag : tag;
        }

        var p = {
            room: room, cliente: document.getElementById('edit-cliente').value,
            telefono: document.getElementById('edit-telefono').value,
            fecha_inicio: startDate, fecha_salida: endDate,
            tasa_aseo: document.getElementById('edit-aseo').value || 0,
            deposito: document.getElementById('edit-deposito').value || 0,
            total_pagado: document.getElementById('edit-total-pagado').value || 0,
            estado: document.getElementById('edit-estado').value,
            notes: finalNotes,
            notas: finalNotes,
            fecha_registro: document.getElementById('edit-fecha-registro').value
        };
        closeModal('edit-modal'); 
        showLoading(currentLang === 'es' ? 'Guardando...' : 'Saving...');
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
        if (!confirm(currentLang === 'es' ? '¿Confirmar Check-Out? El estado pasará a CERRADO.' : 'Confirm Check-Out? Status will be set to CLOSED.')) return;
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        showLoading(currentLang === 'es' ? 'Procesando check-out...' : 'Processing check-out...');
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
        if (!confirm(currentLang === 'es' ? '¿Eliminar permanentemente esta reserva? No se puede deshacer.' : 'Delete this booking permanently? This action cannot be undone.')) return;
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        showLoading(currentLang === 'es' ? 'Eliminando...' : 'Deleting...');
        fetch('/api/rooms-control/bookings/' + row, { method:'DELETE', headers:{'Accept':'application/json','X-CSRF-TOKEN':tok} })
            .then(function(r){return r.json();})
            .then(function(res){ if (res.success) { loadBookings(); } else { alert('Error: ' + res.message); hideLoading(); } })
            .catch(function() { alert(currentLang === 'es' ? 'Error.' : 'Error.'); hideLoading(); });
    }

    // ========== LOAD FROM API ==========
    function loadBookings(isSilent) {
        if (!isSilent) showLoading('Cargando datos...');
        fetch('/api/rooms-control/bookings')
            .then(function(r) { return r.json(); })
            .then(function(res) { if (res.success) bookingsList = res.data || []; })
            .catch(function(e) { console.error('Error:', e); })
            .finally(function() {
                updateRoomGrid();
                updateStats();
                if (currentRoom) showDetails(currentRoom);
                renderMonthly();
                renderDashboardWidgets();
                if (!isSilent) hideLoading();
            });
    }

    // ========== RATE CALCULATOR ==========
    var ROOM_RATES = {
        'Single': { daily: 75,  weekly: 500, monthly: 800,  label: '1 Persona' },
        'Doble':  { daily: 105, weekly: 700, monthly: 1000, label: '2 Personas (Cama Doble)' },
        'Twin':   { daily: 105, weekly: 700, monthly: 1200, label: '2 Personas (2 Camas)' },
        'Queen':  { daily: 140, weekly: 900, monthly: 2400, label: '3 Personas' },
        'King':   { daily: 140, weekly: 900, monthly: 2400, label: '3 Personas' }
    };

    function runCalc() {
        var bedType   = document.getElementById('checkin-bed-type').value;
        var startStr  = document.getElementById('checkin-start').value;
        var endStr    = document.getElementById('checkin-end').value;
        var panel     = document.getElementById('calc-panel');

        if (!bedType || !startStr || !endStr) { panel.style.display = 'none'; return; }

        var start = parseDate(startStr), end = parseDate(endStr);
        if (!start || !end || end < start) { panel.style.display = 'none'; return; }

        panel.style.display = 'block';

        var rates = ROOM_RATES[bedType];

        // Fill rate fields if empty or just changed bed type
        var dEl = document.getElementById('rate-daily');
        var wEl = document.getElementById('rate-weekly');
        var mEl = document.getElementById('rate-monthly');
        if (!dEl._customized) { dEl.value = rates.daily; }
        if (!wEl._customized) { wEl.value = rates.weekly; }
        if (!mEl._customized) { mEl.value = rates.monthly; }

        var rDaily   = parseFloat(dEl.value) || rates.daily;
        var rWeekly  = parseFloat(wEl.value) || rates.weekly;
        var rMonthly = parseFloat(mEl.value) || rates.monthly;

        var totalDays = Math.ceil((end - start) / 86400000) + 1;

        // Calculate Calendar Months and Extra Days
        var yearsDiff = end.getFullYear() - start.getFullYear();
        var monthsDiff = end.getMonth() - start.getMonth();
        var months = yearsDiff * 12 + monthsDiff;

        if (end.getDate() < start.getDate()) {
            months--;
        }

        var temp = new Date(start);
        temp.setMonth(temp.getMonth() + months);
        var extraDays = Math.ceil((end - temp) / 86400000);
        if (extraDays < 0) extraDays = 0;

        var weeks = Math.floor(extraDays / 7);
        var days  = extraDays % 7;

        // Financial Optimization: If extra days cost more than 1 month, round it up
        var extraCost = weeks * rWeekly + days * rDaily;
        if (totalDays >= 28 && extraCost > rMonthly) {
            months += 1;
            extraDays = 0;
            weeks = 0;
            days = 0;
            extraCost = 0;
        }

        var total = 0;
        var parts = [];
        var period = '';
        var baseRate = '';

        var isSixMonthsOrMore = (totalDays >= 28 && months >= 6);
        if (totalDays >= 28) {
            if (isSixMonthsOrMore) {
                total += (months - 1) * rMonthly;
                parts.push(months + (currentLang === 'es' ? ' meses × $' : ' months × $') + rMonthly.toLocaleString());
                parts.push((currentLang === 'es' ? '🎁 Mes 5 Gratis × -$' : '🎁 Month 5 Free × -$') + rMonthly.toLocaleString());
            } else {
                total += months * rMonthly;
                if (months > 0) parts.push(months + (currentLang === 'es' ? ' mes' : ' month') + (months > 1 ? (currentLang === 'es' ? 'es' : 's') : '') + ' × $' + rMonthly.toLocaleString());
            }
            total += weeks   * rWeekly;
            total += days    * rDaily;
            if (weeks > 0)   parts.push(weeks  + ' sem × $' + rWeekly.toLocaleString());
            if (days > 0)    parts.push(days   + ' día' + (days > 1 ? 's' : '') + ' × $' + rDaily.toLocaleString());
            period   = months > 0 ? (currentLang === 'es' ? 'Mensual' : 'Monthly') : (currentLang === 'es' ? 'Semanal' : 'Weekly');
            baseRate = '$' + rMonthly.toLocaleString() + '/' + (currentLang === 'es' ? 'mes' : 'mo');
        } else if (totalDays >= 7) {
            total += weeks * rWeekly;
            total += days  * rDaily;
            if (weeks > 0) parts.push(weeks + ' sem × $' + rWeekly.toLocaleString());
            if (days > 0)  parts.push(days + ' día' + (days > 1 ? 's' : '') + ' × $' + rDaily.toLocaleString());
            period   = 'Semanal';
            baseRate = '$' + rWeekly.toLocaleString() + '/sem';
        } else {
            total = totalDays * rDaily;
            parts.push(totalDays + ' día' + (totalDays > 1 ? 's' : '') + ' × $' + rDaily.toLocaleString());
            period   = 'Diario';
            baseRate = '$' + rDaily.toLocaleString() + '/día';
        }


        document.getElementById('calc-days').innerText      = totalDays;
        document.getElementById('calc-period').innerText    = period;
        document.getElementById('calc-rate').innerText      = baseRate;
        document.getElementById('calc-total').innerText     = '$' + Math.round(total).toLocaleString();
        document.getElementById('calc-breakdown').innerText = parts.join(' + ');

        // Month-by-month payment list schedule + deposit auto-fill
        var schedContainer = document.getElementById('calc-schedule-container');
        var schedList = document.getElementById('calc-schedule-list');
        var depInput = document.getElementById('checkin-deposito');

        if (isSixMonthsOrMore) {
            schedContainer.style.display = 'block';
            schedList.innerHTML = '';
            for (var i = 1; i <= months; i++) {
                var monthLabel = currentLang === 'es' ? 'Mes ' + i : 'Month ' + i;
                var row = document.createElement('div');
                row.style.display = 'flex';
                row.style.justifyContent = 'space-between';
                row.style.padding = '4px 8px';
                row.style.borderRadius = '6px';
                
                if (i === 1) {
                    row.style.gridColumn = '1 / -1';
                    row.style.background = 'rgba(255,255,255,0.03)';
                    row.style.border = '1px solid rgba(255,255,255,0.08)';
                    
                    var rentPart = '$' + rMonthly.toLocaleString();
                    var depPart = '$' + rMonthly.toLocaleString();
                    var totalPart = '$' + (rMonthly * 2).toLocaleString();
                    
                    row.innerHTML = '<span>' + monthLabel + ' (+ ' + (currentLang === 'es' ? 'Depósito' : 'Deposit') + ')</span>'
                        + '<span class="font-bold">' + rentPart + ' + ' + depPart + ' = ' + totalPart + '</span>';
                } else if (i === 5) {
                    row.style.background = 'rgba(16,185,129,0.15)';
                    row.style.border = '1px solid var(--success)';
                    row.innerHTML = '<span>' + monthLabel + '</span>'
                        + '<span class="font-bold" style="color:var(--success);">' + (currentLang === 'es' ? '¡Gratis!' : 'Free!') + '</span>';
                } else {
                    row.style.background = 'rgba(255,255,255,0.03)';
                    row.style.border = '1px solid rgba(255,255,255,0.05)';
                    row.innerHTML = '<span>' + monthLabel + '</span>'
                        + '<span class="font-bold">$' + rMonthly.toLocaleString() + '</span>';
                }
                schedList.appendChild(row);
            }
            // Add deposit row to schedule
            var depRow = document.createElement('div');
            depRow.style.display = 'flex';
            depRow.style.justifyContent = 'space-between';
            depRow.style.padding = '6px 10px';
            depRow.style.background = 'rgba(245,158,11,0.1)';
            depRow.style.borderRadius = '6px';
            depRow.style.border = '1px dashed var(--warning)';
            depRow.style.gridColumn = '1 / -1';
            depRow.style.marginTop = '6px';
            depRow.innerHTML = '<span>💼 ' + (currentLang === 'es' ? 'Depósito Requerido (1 Mes)' : 'Required Deposit (1 Month)') + '</span><span class="font-bold" style="color:var(--warning);">' + '$' + rMonthly.toLocaleString() + '</span>';
            schedList.appendChild(depRow);

            // Pre-fill deposit field in the main checkin form
            if (depInput) depInput.value = rMonthly;
        } else {
            schedContainer.style.display = 'none';
            // Only clear deposit if it is exactly equal to the previous monthly rate (meaning it was auto-filled)
            if (depInput && (parseFloat(depInput.value) === rMonthly)) {
                depInput.value = 0;
            }
        }
    }

    // Mark rate fields as customized when user types in them
    ['rate-daily','rate-weekly','rate-monthly'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', function() { this._customized = true; runCalc(); });
        }
    });

    function applyCalcToForm() {
        var totalText = document.getElementById('calc-total').innerText.replace(/[$,]/g, '');
        var total = parseFloat(totalText);
        if (!isNaN(total)) {
            document.getElementById('checkin-total-pagado').value = Math.round(total);
        }
    }

    // ========== INIT ==========
    window.onload = function() {
        setLanguage(currentLang);
        initSelects();
        loadBookings();
        // Mark rate inputs as not customized initially
        ['rate-daily','rate-weekly','rate-monthly'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el._customized = false;
        });

        // Auto-sincronización rápida (cada 5 segundos) en segundo plano sin pantalla de carga
        // Solo refresca si el usuario NO está activamente escribiendo o en un modal
        setInterval(function() {
            var active = document.activeElement;
            var isTyping = active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA' || active.tagName === 'SELECT');
            var isModalOpen = document.querySelector('.modal-overlay[style*="display: flex"]') || document.querySelector('.modal-overlay[style*="display: block"]');
            if (!isTyping && !isModalOpen) { 
                loadBookings(true);
            }
        }, 5000);

        // Refresco instantáneo al cambiar de ventana o enfocar la pestaña
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                loadBookings(true);
            }
        });
    };
</script>
</body>
</html>
