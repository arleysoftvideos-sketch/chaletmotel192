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
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], outfit: ['Outfit', 'sans-serif'] } } }
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
        }
        *, ::before, ::after { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 20px; background-color: var(--bg-color); color: var(--text-color); }
        .container { max-width: 1200px; margin: 0 auto; background: var(--box-bg); padding: 30px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); border: 1px solid var(--border); }
        .header-nav { margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .back-link { color: var(--primary); text-decoration: none; font-weight: bold; font-size: 14px; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 5px; }
        .back-link:hover { color: var(--primary-hover); transform: translateX(-3px); }
        .lang-toggle { display: flex; gap: 6px; }
        .lang-btn { background: #14274c; border: 1px solid #1e293b; color: #94a3b8; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: all 0.2s ease; }
        .lang-btn:hover { background: #1e293b; color: #f8fafc; }
        .lang-btn.active { background: var(--primary); color: #0a1831; border-color: var(--primary-hover); }
        h1.page-title { font-family: 'Outfit', sans-serif; font-weight: 900; font-size: 2.2rem; text-transform: uppercase; letter-spacing: 1px; background: linear-gradient(to right, #ffffff, var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 25px; text-align: center; margin-top: 0; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 30px; }
        .stat-card { background: #081326; border: 1px solid var(--border); border-radius: 12px; padding: 15px 20px; text-align: center; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-number { font-size: 2rem; font-weight: 800; font-family: 'Outfit', sans-serif; margin-bottom: 5px; }
        .stat-label { font-size: 13px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .main-layout { display: grid; grid-template-columns: 1fr; gap: 25px; }
        @media (min-width: 900px) { .main-layout { grid-template-columns: 1.2fr 0.8fr; } }
        .room-nav-title { margin-bottom: 12px; font-weight: 700; color: #94a3b8; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .room-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px; margin-bottom: 25px; }
        .room-btn { padding: 14px 0; background-color: #14274c; border: 1px solid #1e293b; color: #cbd5e1; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 15px; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.15); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; }
        .room-btn:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.3); }
        .room-btn.available { border-bottom: 4px solid var(--success); }
        .room-btn.occupied { background-color: #581c1c !important; border: 1px solid #991b1b !important; border-bottom: 4px solid var(--danger) !important; color: #fca5a5 !important; }
        .room-btn.occupied:hover { background-color: #7f1d1d !important; box-shadow: 0 6px 15px rgba(239,68,68,0.25) !important; }
        .room-btn.active { background-color: var(--primary) !important; color: #0a1831 !important; border-color: var(--primary-hover) !important; box-shadow: 0 4px 12px rgba(255,183,3,0.3) !important; }
        .room-status-dot { width: 8px; height: 8px; border-radius: 50%; }
        .room-btn.available .room-status-dot { background-color: var(--success); }
        .room-btn.occupied .room-status-dot { background-color: var(--danger); }
        .detail-panel { background: #081326; border: 1px solid var(--border); border-radius: 16px; padding: 25px; position: sticky; top: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); min-height: 400px; }
        .detail-header { border-bottom: 2px solid var(--border); padding-bottom: 15px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .detail-title { font-family: 'Outfit', sans-serif; font-size: 20px; font-weight: 800; margin: 0; color: #ffffff; }
        .status-badge { padding: 5px 12px; border-radius: 30px; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-badge.available { background: rgba(16,185,129,0.15); color: var(--success); border: 1px solid rgba(16,185,129,0.3); }
        .status-badge.occupied { background: rgba(239,68,68,0.15); color: var(--danger); border: 1px solid rgba(239,68,68,0.3); }
        .info-group { margin-bottom: 15px; }
        .info-label { font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .info-value { font-size: 14px; color: #cbd5e1; font-weight: 500; }
        .notes-box { background: #0a1831; border: 1px solid var(--border); border-radius: 8px; padding: 12px; font-size: 13px; color: #cbd5e1; margin-top: 15px; max-height: 120px; overflow-y: auto; white-space: pre-wrap; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px; font-size: 14px; font-weight: 700; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background-color: var(--primary); color: #0a1831; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-secondary { background-color: #14274c; color: #cbd5e1; border: 1px solid #1e293b; }
        .btn-secondary:hover { background-color: #1e293b; }
        .btn-success { background-color: var(--success); color: white; }
        .btn-success:hover { background-color: #059669; }
        .btn-danger { background-color: var(--danger); color: white; }
        .btn-danger:hover { background-color: #dc2626; }
        .actions-stack { display: flex; flex-direction: column; gap: 10px; margin-top: 25px; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #cbd5e1; margin-bottom: 6px; }
        input[type="text"], input[type="tel"], input[type="number"], input[type="date"], select, textarea { width: 100%; padding: 10px 14px; background-color: #081326; color: #f8fafc; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; transition: border-color 0.2s; }
        input:focus, select:focus, textarea:focus { border-color: var(--primary); outline: none; }
        textarea { resize: vertical; }
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 1000; justify-content: center; align-items: center; padding: 20px; backdrop-filter: blur(4px); }
        .modal-content { background: #0a1831; width: 100%; max-width: 550px; max-height: 90vh; border-radius: 16px; border: 1px solid var(--border); overflow-y: auto; padding: 30px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.6); color: var(--text-color); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 12px; }
        .modal-title { font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 800; color: #ffffff; margin: 0; }
        .modal-close-btn { background: transparent; border: none; color: #94a3b8; font-size: 24px; cursor: pointer; }
        .modal-close-btn:hover { color: var(--danger); }
        .spinner-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(4,10,23,0.75); z-index: 2000; justify-content: center; align-items: center; flex-direction: column; gap: 15px; }
        .spinner { width: 50px; height: 50px; border: 4px solid var(--border); border-top: 4px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite; }
        @keyframes spin { 0%{transform:rotate(0deg);} 100%{transform:rotate(360deg);} }
    </style>
</head>
<body>

<!-- Spinner -->
<div class="spinner-overlay" id="loading-spinner">
    <div class="spinner"></div>
    <div style="font-weight: bold; color: var(--primary);" id="spinner-msg">Cargando datos...</div>
</div>

<!-- Modal Check-in -->
<div class="modal-overlay" id="checkin-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Registrar Check-In / Nueva Reserva</h3>
            <button class="modal-close-btn" onclick="closeModal('checkin-modal')">&times;</button>
        </div>
        <form id="checkin-form" onsubmit="handleCheckIn(event)">
            <div class="form-group">
                <label class="form-label">Habitación</label>
                <select id="checkin-room" required></select>
            </div>
            <div class="form-group">
                <label class="form-label">Nombre del Cliente</label>
                <input type="text" id="checkin-cliente" required>
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="tel" id="checkin-telefono">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" id="checkin-start" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha Salida</label>
                    <input type="date" id="checkin-end" required>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="form-group">
                    <label class="form-label">Tasa de Aseo</label>
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
                <textarea id="checkin-notas" rows="3"></textarea>
            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-primary">Crear Reserva / Check-In</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal-overlay" id="edit-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Editar Reserva</h3>
            <button class="modal-close-btn" onclick="closeModal('edit-modal')">&times;</button>
        </div>
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
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" id="edit-start" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha Salida</label>
                    <input type="date" id="edit-end" required>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="form-group">
                    <label class="form-label">Tasa de Aseo</label>
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
                <textarea id="edit-notas" rows="3"></textarea>
            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
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

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number text-red-500" id="stat-occupied">0</div>
            <div class="stat-label">Ocupadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number text-emerald-500" id="stat-available">28</div>
            <div class="stat-label">Disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number text-slate-300">28</div>
            <div class="stat-label">Total</div>
        </div>
    </div>

    <div class="main-layout">
        <!-- Grid de Habitaciones -->
        <div>
            <div class="room-nav-title">Piso 1 (101 - 114)</div>
            <div class="room-grid" id="nav-piso1">
                @for ($i = 101; $i <= 114; $i++)
                <button class="room-btn available" data-room="{{ $i }}" id="btn-room-{{ $i }}" onclick="selectRoom({{ $i }})">
                    <span class="room-status-dot"></span>
                    <span>{{ $i }}</span>
                </button>
                @endfor
            </div>

            <div class="room-nav-title">Piso 2 (201 - 214)</div>
            <div class="room-grid" id="nav-piso2">
                @for ($i = 201; $i <= 214; $i++)
                <button class="room-btn available" data-room="{{ $i }}" id="btn-room-{{ $i }}" onclick="selectRoom({{ $i }})">
                    <span class="room-status-dot"></span>
                    <span>{{ $i }}</span>
                </button>
                @endfor
            </div>
        </div>

        <!-- Panel de Detalles -->
        <div class="detail-panel">
            <div class="detail-header">
                <span class="detail-title">Habitación <span id="lbl-room">101</span></span>
                <span class="status-badge available" id="lbl-status">Disponible</span>
            </div>

            <div id="room-detail-empty" class="text-center py-10">
                <div class="text-4xl mb-4">🔑</div>
                <p class="text-slate-400 font-semibold mb-6">No hay reserva activa para esta habitación.</p>
                <button class="btn btn-primary" onclick="openCheckInModal()">Realizar Check-In</button>
            </div>

            <div id="room-detail-info" style="display: none;">
                <div class="info-group">
                    <div class="info-label">Cliente</div>
                    <div class="info-value text-white font-bold text-lg" id="detail-cliente"></div>
                </div>
                <div class="info-group">
                    <div class="info-label">Teléfono</div>
                    <div class="info-value" id="detail-telefono"></div>
                </div>
                <div class="grid grid-cols-3 gap-2 my-4">
                    <div class="info-group">
                        <div class="info-label">Fecha Entrada</div>
                        <div class="info-value font-semibold text-slate-200" id="detail-start"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Fecha Salida</div>
                        <div class="info-value font-semibold text-slate-200" id="detail-end"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Días Faltantes</div>
                        <div class="info-value font-bold" id="detail-days-remaining">-</div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2 my-4 border-t border-b border-slate-700 py-3">
                    <div class="info-group">
                        <div class="info-label">Aseo</div>
                        <div class="info-value text-yellow-400" id="detail-aseo">$0</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Depósito</div>
                        <div class="info-value text-yellow-400" id="detail-deposito">$0</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Total Pagado</div>
                        <div class="info-value text-yellow-400" id="detail-total-pagado">$0</div>
                    </div>
                </div>
                <div class="info-group">
                    <div class="info-label">Registrado el</div>
                    <div class="info-value text-sm text-slate-400" id="detail-registered"></div>
                </div>
                <div class="info-group">
                    <div class="info-label">Notas</div>
                    <div class="notes-box" id="detail-notas"></div>
                </div>
                <div class="actions-stack">
                    <button class="btn btn-success" onclick="triggerCheckout()">🚪 Realizar Check-Out (Cerrar)</button>
                    <button class="btn btn-secondary" onclick="openEditModal()">✏️ Editar Reserva</button>
                    <button class="btn btn-danger" onclick="triggerDelete()">🗑️ Eliminar Registro</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var currentLang = 'es';
    var bookingsList = [];
    var currentRoom = 101;
    var allRooms = [101,102,103,104,105,106,107,108,109,110,111,112,113,114,
                    201,202,203,204,205,206,207,208,209,210,211,212,213,214];

    function setLanguage(lang) {
        currentLang = lang;
        document.getElementById('btn-es').classList.toggle('active', lang === 'es');
        document.getElementById('btn-en').classList.toggle('active', lang === 'en');
    }

    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    function showLoading(msg) {
        document.getElementById('spinner-msg').innerText = msg || 'Cargando...';
        document.getElementById('loading-spinner').style.display = 'flex';
    }
    function hideLoading() { document.getElementById('loading-spinner').style.display = 'none'; }

    function initSelects() {
        var s1 = document.getElementById('checkin-room');
        var s2 = document.getElementById('edit-room');
        s1.innerHTML = ''; s2.innerHTML = '';
        allRooms.forEach(function(r) {
            var o1 = document.createElement('option'); o1.value = r; o1.text = r; s1.add(o1);
            var o2 = document.createElement('option'); o2.value = r; o2.text = r; s2.add(o2);
        });
    }

    function getActiveBooking(room) {
        var list = bookingsList.filter(function(b) { return parseInt(b.room) === parseInt(room); });
        if (!list.length) return null;
        list.sort(function(a, b) { return b.row - a.row; });
        var s = (list[0].estado || '').toUpperCase();
        return (s === 'ABIERTO' || s === 'OCUPADA') ? list[0] : null;
    }

    function updateStats() {
        var occ = allRooms.filter(function(r) { return getActiveBooking(r); }).length;
        document.getElementById('stat-occupied').innerText = occ;
        document.getElementById('stat-available').innerText = allRooms.length - occ;
    }

    function renderRoomGrid() {
        var p1 = document.getElementById('nav-piso1');
        var p2 = document.getElementById('nav-piso2');
        p1.innerHTML = ''; p2.innerHTML = '';
        allRooms.forEach(function(room) {
            var btn = document.createElement('button');
            var booking = getActiveBooking(room);
            btn.className = 'room-btn ' + (booking ? 'occupied' : 'available') + (room === currentRoom ? ' active' : '');
            var dot = document.createElement('span');
            dot.className = 'room-status-dot';
            btn.appendChild(dot);
            var num = document.createElement('span');
            num.innerText = room;
            btn.appendChild(num);
            btn.setAttribute('data-room', room);
            btn.onclick = (function(r) { return function() { selectRoom(r); }; })(room);
            (room < 200 ? p1 : p2).appendChild(btn);
        });
    }

    function selectRoom(room) {
        currentRoom = room;
        document.querySelectorAll('.room-btn').forEach(function(b) {
            b.classList.toggle('active', parseInt(b.getAttribute('data-room')) === parseInt(room));
        });
        document.getElementById('lbl-room').innerText = room;
        showDetails(room);
    }

    function fmtDate(str) {
        if (!str) return 'N/A';
        var p = str.split('-');
        return p.length === 3 ? p[2]+'/'+p[1]+'/'+p[0] : str;
    }

    function showDetails(room) {
        var b = getActiveBooking(room);
        var empty = document.getElementById('room-detail-empty');
        var info = document.getElementById('room-detail-info');
        var badge = document.getElementById('lbl-status');
        if (b) {
            badge.className = 'status-badge occupied';
            badge.innerText = currentLang === 'es' ? 'Ocupada' : 'Occupied';
            document.getElementById('detail-cliente').innerText = b.cliente || 'N/A';
            document.getElementById('detail-telefono').innerText = b.telefono || 'N/A';
            document.getElementById('detail-start').innerText = fmtDate(b.fecha_inicio);
            document.getElementById('detail-end').innerText = fmtDate(b.fecha_salida);
            document.getElementById('detail-aseo').innerText = '$' + (parseFloat(b.tasa_aseo)||0).toLocaleString();
            document.getElementById('detail-deposito').innerText = '$' + (parseFloat(b.deposito)||0).toLocaleString();
            document.getElementById('detail-total-pagado').innerText = '$' + (parseFloat(b.total_pagado)||0).toLocaleString();
            document.getElementById('detail-registered').innerText = b.fecha_registro || 'N/A';
            document.getElementById('detail-notas').innerText = b.notas || 'Sin notas.';
            // Dias faltantes
            var drEl = document.getElementById('detail-days-remaining');
            if (b.fecha_salida) {
                var today = new Date(); today.setHours(0,0,0,0);
                var pp = b.fecha_salida.split('-');
                var end = new Date(+pp[0], +pp[1]-1, +pp[2]); end.setHours(0,0,0,0);
                var diff = Math.ceil((end - today) / 86400000);
                if (diff > 0) { drEl.innerText = diff + (currentLang==='es'?' días':' days'); drEl.style.color='#f59e0b'; }
                else if (diff === 0) { drEl.innerText = '¡Hoy!'; drEl.style.color='#10b981'; }
                else { drEl.innerText=(currentLang==='es'?'Vencido hace ':'Overdue ')+Math.abs(diff)+(currentLang==='es'?' días':' days'); drEl.style.color='#ef4444'; }
            } else { document.getElementById('detail-days-remaining').innerText = 'N/A'; }
            empty.style.display = 'none'; info.style.display = 'block';
        } else {
            badge.className = 'status-badge available';
            badge.innerText = currentLang === 'es' ? 'Disponible' : 'Available';
            empty.style.display = 'block'; info.style.display = 'none';
        }
    }

    function loadBookings() {
        showLoading('Cargando datos...');
        fetch('/api/rooms-control/bookings')
            .then(function(r) { return r.json(); })
            .then(function(res) { if (res.success) bookingsList = res.data || []; })
            .catch(function(e) { console.error(e); })
            .finally(function() { renderRoomGrid(); showDetails(currentRoom); updateStats(); hideLoading(); });
    }

    function openCheckInModal() {
        document.getElementById('checkin-room').value = currentRoom;
        var t = new Date().toISOString().split('T')[0];
        document.getElementById('checkin-start').value = t;
        document.getElementById('checkin-end').value = t;
        openModal('checkin-modal');
    }

    function handleCheckIn(e) {
        e.preventDefault();
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        var p = {
            room: document.getElementById('checkin-room').value,
            cliente: document.getElementById('checkin-cliente').value,
            telefono: document.getElementById('checkin-telefono').value,
            fecha_inicio: document.getElementById('checkin-start').value,
            fecha_salida: document.getElementById('checkin-end').value,
            tasa_aseo: document.getElementById('checkin-aseo').value||0,
            deposito: document.getElementById('checkin-deposito').value||0,
            total_pagado: document.getElementById('checkin-total-pagado').value||0,
            estado: 'ABIERTO',
            notas: document.getElementById('checkin-notas').value
        };
        closeModal('checkin-modal'); showLoading('Sincronizando...');
        fetch('/api/rooms-control/bookings', { method:'POST', headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':tok}, body:JSON.stringify(p) })
            .then(function(r){return r.json();})
            .then(function(res){ if(res.success){document.getElementById('checkin-form').reset(); loadBookings();} else{alert('Error: '+res.message); hideLoading();} })
            .catch(function(){alert('Error al guardar.'); hideLoading();});
    }

    function openEditModal() {
        var b = getActiveBooking(currentRoom); if (!b) return;
        document.getElementById('edit-row').value = b.row;
        document.getElementById('edit-room').value = b.room;
        document.getElementById('edit-cliente').value = b.cliente;
        document.getElementById('edit-telefono').value = b.telefono;
        document.getElementById('edit-start').value = b.fecha_inicio;
        document.getElementById('edit-end').value = b.fecha_salida;
        document.getElementById('edit-aseo').value = b.tasa_aseo||0;
        document.getElementById('edit-deposito').value = b.deposito||0;
        document.getElementById('edit-total-pagado').value = b.total_pagado||0;
        document.getElementById('edit-estado').value = (b.estado||'').toUpperCase();
        document.getElementById('edit-notas').value = b.notas;
        document.getElementById('edit-fecha-registro').value = b.fecha_registro||'';
        openModal('edit-modal');
    }

    function handleEditSubmit(e) {
        e.preventDefault();
        var row = document.getElementById('edit-row').value;
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        var p = {
            room: document.getElementById('edit-room').value,
            cliente: document.getElementById('edit-cliente').value,
            telefono: document.getElementById('edit-telefono').value,
            fecha_inicio: document.getElementById('edit-start').value,
            fecha_salida: document.getElementById('edit-end').value,
            tasa_aseo: document.getElementById('edit-aseo').value||0,
            deposito: document.getElementById('edit-deposito').value||0,
            total_pagado: document.getElementById('edit-total-pagado').value||0,
            estado: document.getElementById('edit-estado').value,
            notes: document.getElementById('edit-notas').value,
            notas: document.getElementById('edit-notas').value,
            fecha_registro: document.getElementById('edit-fecha-registro').value
        };
        closeModal('edit-modal'); showLoading('Guardando...');
        fetch('/api/rooms-control/bookings/'+row, { method:'PUT', headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':tok}, body:JSON.stringify(p) })
            .then(function(r){return r.json();})
            .then(function(res){ if(res.success){loadBookings();} else{alert('Error: '+res.message); hideLoading();} })
            .catch(function(){alert('Error al guardar.'); hideLoading();});
    }

    function triggerCheckout() {
        var b = getActiveBooking(currentRoom); if (!b) return;
        if (!confirm('¿Confirmas el Check-out? El estado pasará a CERRADO.')) return;
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        showLoading('Guardando...');
        fetch('/api/rooms-control/bookings/'+b.row+'/checkout', { method:'POST', headers:{'Accept':'application/json','X-CSRF-TOKEN':tok} })
            .then(function(r){return r.json();})
            .then(function(res){ if(res.success){loadBookings();} else{alert('Error: '+res.message); hideLoading();} })
            .catch(function(){alert('Error.'); hideLoading();});
    }

    function triggerDelete() {
        var b = getActiveBooking(currentRoom); if (!b) return;
        if (!confirm('¿Eliminar permanentemente esta reserva? Esta acción no se puede deshacer.')) return;
        var tok = document.querySelector('meta[name="csrf-token"]').content;
        showLoading('Eliminando...');
        fetch('/api/rooms-control/bookings/'+b.row, { method:'DELETE', headers:{'Accept':'application/json','X-CSRF-TOKEN':tok} })
            .then(function(r){return r.json();})
            .then(function(res){ if(res.success){loadBookings();} else{alert('Error: '+res.message); hideLoading();} })
            .catch(function(){alert('Error.'); hideLoading();});
    }

    window.onload = function() {
        initSelects();
        renderRoomGrid();
        showDetails(currentRoom);
        loadBookings();
    };
</script>
</body>
</html>
