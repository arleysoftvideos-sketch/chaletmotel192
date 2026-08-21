<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Super Administrador - LiquorGuard AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg-base: #07090e;
            --bg-card: #0f1523;
            --bg-card-hover: #141c2e;
            --bg-input: #080c14;
            --accent-cyan: #00f0ff;
            --accent-blue: #0070f3;
            --accent-magenta: #ff0055;
            --accent-green: #00ff88;
            --accent-amber: #ffb800;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-glow: rgba(0, 240, 255, 0.3);
            --radius-xl: 20px;
            --radius-lg: 14px;
            --radius-md: 10px;
            --shadow-card: 0 10px 30px -10px rgba(0, 0, 0, 0.6);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Top Navigation Bar */
        .admin-nav {
            background: rgba(15, 21, 35, 0.9);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border-subtle);
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(0, 240, 255, 0.2), rgba(0, 112, 243, 0.2));
            border: 1px solid var(--border-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-cyan);
            font-size: 20px;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .badge-superadmin {
            background: linear-gradient(135deg, #ff0055, #ff5500);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-left: 8px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .admin-profile-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .admin-profile-pill strong { color: var(--text-main); }

        .btn-nav {
            padding: 8px 16px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-nav-scanner {
            background: rgba(0, 240, 255, 0.15);
            color: var(--accent-cyan);
            border: 1px solid var(--border-glow);
        }
        .btn-nav-scanner:hover {
            background: var(--accent-cyan);
            color: #000;
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.4);
        }

        .btn-nav-logout {
            background: rgba(255, 0, 85, 0.12);
            color: var(--accent-magenta);
            border: 1px solid rgba(255, 0, 85, 0.3);
        }
        .btn-nav-logout:hover {
            background: var(--accent-magenta);
            color: #fff;
        }

        /* Layout Main */
        .admin-container {
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 32px 24px;
            flex: 1;
        }

        /* Header section */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 14px;
        }

        .btn-primary-action {
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            color: #050b14;
            padding: 13px 24px;
            border-radius: var(--radius-md);
            font-weight: 800;
            font-size: 14px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(0, 240, 255, 0.3);
            transition: all 0.2s ease;
        }
        .btn-primary-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 240, 255, 0.5);
        }

        /* KPI Cards Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .kpi-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: 22px 20px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-card);
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .kpi-card:hover {
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .kpi-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .kpi-card.cyan::after { background: var(--accent-cyan); box-shadow: 0 0 12px var(--accent-cyan); }
        .kpi-card.green::after { background: var(--accent-green); box-shadow: 0 0 12px var(--accent-green); }
        .kpi-card.amber::after { background: var(--accent-amber); box-shadow: 0 0 12px var(--accent-amber); }
        .kpi-card.magenta::after { background: var(--accent-magenta); box-shadow: 0 0 12px var(--accent-magenta); }
        .kpi-card.blue::after { background: var(--accent-blue); box-shadow: 0 0 12px var(--accent-blue); }

        .kpi-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .kpi-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
        }

        .kpi-icon {
            font-size: 18px;
            color: var(--text-dim);
        }

        .kpi-value {
            font-size: 32px;
            font-weight: 800;
            font-family: 'JetBrains Mono', monospace;
            line-height: 1;
        }

        /* Filter & Search Bar */
        .table-toolbar {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .filter-tabs {
            display: flex;
            gap: 8px;
            background: var(--bg-input);
            padding: 4px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-subtle);
        }

        .tab-btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .tab-btn.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .search-box {
            position: relative;
            min-width: 280px;
        }

        .search-input {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 10px 16px 10px 38px;
            color: var(--text-main);
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
        }

        .search-input:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.2);
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            font-size: 13px;
        }

        /* Clients Table */
        .table-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .clients-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .clients-table th {
            background: rgba(8, 12, 20, 0.6);
            padding: 14px 18px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-dim);
            border-bottom: 1px solid var(--border-subtle);
        }

        .clients-table td {
            padding: 16px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            vertical-align: middle;
        }

        .clients-table tr:hover td {
            background: var(--bg-card-hover);
        }

        .client-info-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(0, 240, 255, 0.1);
            color: var(--accent-cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 16px;
            border: 1px solid rgba(0, 240, 255, 0.2);
        }

        .client-name { font-weight: 700; color: var(--text-main); margin-bottom: 2px; }
        .client-contact { font-size: 12px; color: var(--text-muted); }
        .client-email { font-family: 'JetBrains Mono', monospace; font-size: 12px; color: var(--text-muted); }

        /* Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.active {
            background: rgba(0, 255, 136, 0.12);
            color: var(--accent-green);
            border: 1px solid rgba(0, 255, 136, 0.3);
        }

        .status-badge.warning {
            background: rgba(255, 184, 0, 0.12);
            color: var(--accent-amber);
            border: 1px solid rgba(255, 184, 0, 0.3);
        }

        .status-badge.suspended,
        .status-badge.expired {
            background: rgba(255, 0, 85, 0.12);
            color: var(--accent-magenta);
            border: 1px solid rgba(255, 0, 85, 0.3);
        }

        .days-left-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 700;
        }

        .powers-icons {
            display: flex;
            gap: 6px;
        }

        .power-tag {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            color: var(--text-dim);
        }

        .power-tag.enabled {
            background: rgba(0, 240, 255, 0.1);
            color: var(--accent-cyan);
            border-color: rgba(0, 240, 255, 0.3);
        }

        /* Action Buttons in Table */
        .actions-group {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
        }

        .btn-table-action {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--border-subtle);
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: all 0.2s ease;
        }

        .btn-table-action:hover {
            transform: translateY(-2px);
            color: var(--text-main);
        }

        .btn-table-action.renew:hover { background: rgba(0, 255, 136, 0.15); color: var(--accent-green); border-color: var(--accent-green); }
        .btn-table-action.powers:hover { background: rgba(0, 240, 255, 0.15); color: var(--accent-cyan); border-color: var(--accent-cyan); }
        .btn-table-action.suspend:hover { background: rgba(255, 184, 0, 0.15); color: var(--accent-amber); border-color: var(--accent-amber); }
        .btn-table-action.key:hover { background: rgba(0, 112, 243, 0.15); color: var(--accent-blue); border-color: var(--accent-blue); }
        .btn-table-action.delete:hover { background: rgba(255, 0, 85, 0.15); color: var(--accent-magenta); border-color: var(--accent-magenta); }

        /* Modal Styles */
        .modal-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(4, 7, 12, 0.85);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-card {
            background: #0f1523;
            border: 1px solid var(--border-glow);
            border-radius: var(--radius-xl);
            max-width: 580px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 35px rgba(0, 240, 255, 0.15);
            animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalPop {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-header {
            padding: 22px 28px;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-main);
        }

        .btn-close-modal {
            background: none;
            border: none;
            color: var(--text-dim);
            font-size: 18px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }
        .btn-close-modal:hover { color: var(--text-main); }

        .modal-body {
            padding: 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-full { grid-column: span 2; }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .form-input, .form-select {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 12px 14px;
            color: var(--text-main);
            font-size: 13px;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus, .form-select:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 12px rgba(0, 240, 255, 0.2);
        }

        /* Month Selector Buttons */
        .month-selector-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin-top: 6px;
        }

        .month-chip {
            background: var(--bg-input);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 10px 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .month-chip input { display: none; }
        .month-chip .num { font-size: 16px; font-weight: 800; color: var(--text-main); }
        .month-chip .txt { font-size: 10px; color: var(--text-dim); text-transform: uppercase; }

        .month-chip.active {
            background: rgba(0, 240, 255, 0.15);
            border-color: var(--accent-cyan);
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.2);
        }
        .month-chip.active .num { color: var(--accent-cyan); }
        .month-chip.active .txt { color: var(--text-main); }

        /* Power Switches */
        .powers-box {
            background: var(--bg-input);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 14px;
            margin-top: 6px;
        }

        .power-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }
        .power-item:last-child { border-bottom: none; }

        .power-info { display: flex; flex-direction: column; }
        .power-name { font-size: 13px; font-weight: 700; color: var(--text-main); }
        .power-desc { font-size: 11px; color: var(--text-dim); }

        /* Switch UI */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .toggle-switch input { opacity: 0; width: 0; height: 0; }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(255, 255, 255, 0.1);
            transition: .3s;
            border-radius: 24px;
            border: 1px solid var(--border-subtle);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: var(--text-dim);
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: rgba(0, 240, 255, 0.3);
            border-color: var(--accent-cyan);
        }

        input:checked + .slider:before {
            transform: translateX(20px);
            background-color: var(--accent-cyan);
            box-shadow: 0 0 8px var(--accent-cyan);
        }

        .modal-footer {
            padding: 20px 28px;
            border-top: 1px solid var(--border-subtle);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: rgba(8, 12, 20, 0.4);
            border-radius: 0 0 var(--radius-xl) var(--radius-xl);
        }

        .btn-cancel {
            padding: 10px 18px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit {
            padding: 10px 22px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            border: none;
            color: #000;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(0, 240, 255, 0.3);
        }

        /* WhatsApp Output Modal */
        .whatsapp-output-box {
            background: #06090e;
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: var(--radius-md);
            padding: 16px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            line-height: 1.6;
            white-space: pre-wrap;
            color: #d1fae5;
            margin-bottom: 16px;
        }

        /* Toast notifications */
        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            padding: 14px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            animation: toastIn 0.3s ease;
        }
        .toast.success { border-color: var(--accent-green); color: var(--accent-green); }
        .toast.error { border-color: var(--accent-magenta); color: var(--accent-magenta); }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-dim);
        }
        .empty-icon { font-size: 40px; margin-bottom: 14px; color: var(--text-dim); }

        @media (max-width: 650px) {
            .modal-backdrop {
                padding: 10px !important;
                align-items: flex-start !important;
                overflow-y: auto !important;
            }
            .modal-card {
                max-height: 95vh !important;
                margin: 10px auto !important;
                width: 100% !important;
            }
            .modal-body {
                padding: 16px 12px !important;
            }
            .form-grid {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }
            .form-full {
                grid-column: span 1 !important;
            }
            .modal-footer {
                padding: 14px 16px !important;
                flex-direction: column-reverse !important;
                gap: 8px !important;
            }
            .modal-footer button {
                width: 100% !important;
                justify-content: center !important;
                padding: 14px !important;
                font-size: 14px !important;
            }
        }
    </style>
</head>
<body>
    <!-- Top Nav -->
    <header class="admin-nav">
        <div class="nav-brand">
            <div class="brand-icon-box">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <div class="brand-title">LiquorGuard AI <span class="badge-superadmin"><i class="fa-solid fa-crown"></i> Super Admin</span></div>
                <div style="font-size: 11px; color: var(--text-dim);">Centro de Control Maestro & Licenciamiento</div>
            </div>
        </div>

        <div class="nav-actions">
            <div class="user-badge">
                <i class="fa-solid fa-user-shield"></i>
                <span>{{ session("lg_role") === "superadmin" ? "Superadmin" : "Admin" }}: <strong>{{ session("lg_name", session("lg_business", "Jovan Suarez")) }}</strong></span>
            </div>
            <a href="/liquorguard" class="btn-nav btn-nav-scanner">
                <i class="fa-solid fa-camera"></i> Ir al Escáner
            </a>
            <a href="/liquorguard/logout" class="btn-nav btn-nav-logout">
                <i class="fa-solid fa-power-off"></i> Salir
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Gestión de Clientes y Suscripciones</h1>
                <p class="page-subtitle">Crea cuentas, asigna meses comprados, gestiona poderes y monitorea licencias.</p>
            </div>
            <button class="btn-primary-action" id="btnOpenCreateModal">
                <i class="fa-solid fa-plus"></i> Nuevo Cliente (Asignar Meses)
            </button>
        </div>

        <!-- KPI Grid -->
        <div class="kpi-grid">
            <div class="kpi-card cyan">
                <div class="kpi-top">
                    <span class="kpi-label">Total Clientes</span>
                    <i class="fa-solid fa-users kpi-icon"></i>
                </div>
                <div class="kpi-value" id="kpiTotalClients">--</div>
            </div>

            <div class="kpi-card green">
                <div class="kpi-top">
                    <span class="kpi-label">Activos / Al Día</span>
                    <i class="fa-solid fa-circle-check kpi-icon"></i>
                </div>
                <div class="kpi-value" id="kpiActiveClients">--</div>
            </div>

            <div class="kpi-card amber">
                <div class="kpi-top">
                    <span class="kpi-label">Por Vencer (&le; 7 días)</span>
                    <i class="fa-solid fa-clock kpi-icon"></i>
                </div>
                <div class="kpi-value" id="kpiExpiringSoon">--</div>
            </div>

            <div class="kpi-card magenta">
                <div class="kpi-top">
                    <span class="kpi-label">Suspendidos</span>
                    <i class="fa-solid fa-ban kpi-icon"></i>
                </div>
                <div class="kpi-value" id="kpiSuspendedClients">--</div>
            </div>

            <div class="kpi-card blue">
                <div class="kpi-top">
                    <span class="kpi-label">Escaneos Totales</span>
                    <i class="fa-solid fa-camera-viewfinder kpi-icon"></i>
                </div>
                <div class="kpi-value" id="kpiTotalScans">--</div>
            </div>
        </div>

        <!-- Table Toolbar -->
        <div class="table-toolbar">
            <div class="filter-tabs">
                <button class="tab-btn active" data-status="">Todos</button>
                <button class="tab-btn" data-status="active">Activos</button>
                <button class="tab-btn" data-status="expired">Vencidos</button>
                <button class="tab-btn" data-status="suspended">Suspendidos</button>
            </div>

            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Buscar por negocio, dueño o correo...">
            </div>
        </div>

        <!-- Clients Table -->
        <div class="table-card">
            <div class="table-responsive">
                <table class="clients-table">
                    <thead>
                        <tr>
                            <th>Negocio / Dueño</th>
                            <th>Correo / Contacto</th>
                            <th>Meses / Vencimiento</th>
                            <th>Estado</th>
                            <th>Escaneos</th>
                            <th>Poderes</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="clientsTableBody">
                        <tr>
                            <td colspan="7" style="text-align:center; padding: 40px;">
                                <i class="fa-solid fa-spinner fa-spin"></i> Cargando clientes...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- MODAL 1: CREAR NUEVO CLIENTE -->
    <div class="modal-backdrop" id="modalCreateClient">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fa-solid fa-user-plus" style="color: var(--accent-cyan);"></i>
                    Crear Nuevo Cliente y Asignar Meses
                </div>
                <button class="btn-close-modal" data-close="modalCreateClient">&times;</button>
            </div>
            <form id="formCreateClient" autocomplete="off">
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nombre del Negocio / Local *</label>
                            <input type="text" name="business_name" class="form-input" placeholder="Ej: Discoteca La 70" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nombre del Contacto / Dueño *</label>
                            <input type="text" name="contact_name" class="form-input" placeholder="Ej: Carlos Pérez" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Correo Electrónico (Usuario) *</label>
                            <input type="email" name="email" id="newClientEmail" class="form-input" placeholder="cliente@correo.com" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contraseña Inicial <span class="req">*</span></label>
                            <input type="text" name="password" id="inputNewClientPass" class="form-input" placeholder="Mínimo 6 caracteres" required autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tipo de Cuenta / Rol *</label>
                            <select name="role" class="form-select" style="width:100%; background:var(--bg-card); border:1px solid var(--border-color); color:#fff; padding:10px; border-radius:var(--radius-md); font-weight:700;">
                                <option value="client" selected>👤 Cliente (Solo Escáner Facial)</option>
                                <option value="admin">🛡️ Administrador (Panel + Escáner)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Idioma de la App del Cliente</label>
                            <select name="language" class="form-select" style="width:100%; background:var(--bg-card); border:1px solid var(--border-color); color:#fff; padding:10px; border-radius:var(--radius-md); font-weight:700;">
                                <option value="es" selected>🇪🇸 Español (Predeterminado)</option>
                                <option value="en">🇺🇸 English (Inglés)</option>
                            </select>
                        </div>

                        <!-- Selector de Meses Comprados -->
                        <div class="form-group form-full">
                            <label class="form-label">Meses Comprados / Tiempo de Vigencia</label>
                            <div class="month-selector-grid">
                                <label class="month-chip active">
                                    <input type="radio" name="months_purchased" value="1" checked>
                                    <div class="num">1</div>
                                    <div class="txt">Mes</div>
                                </label>
                                <label class="month-chip">
                                    <input type="radio" name="months_purchased" value="2">
                                    <div class="num">2</div>
                                    <div class="txt">Meses</div>
                                </label>
                                <label class="month-chip">
                                    <input type="radio" name="months_purchased" value="3">
                                    <div class="num">3</div>
                                    <div class="txt">Meses</div>
                                </label>
                                <label class="month-chip">
                                    <input type="radio" name="months_purchased" value="6">
                                    <div class="num">6</div>
                                    <div class="txt">Meses</div>
                                </label>
                                <label class="month-chip">
                                    <input type="radio" name="months_purchased" value="12">
                                    <div class="num">12</div>
                                    <div class="txt">1 Año</div>
                                </label>
                            </div>
                        </div>

                        <!-- Configuración de Poderes -->
                        <div class="form-group form-full">
                            <label class="form-label">Poderes y Permisos del Cliente</label>
                            <div class="powers-box">
                                <div class="power-item">
                                    <div class="power-info">
                                        <span class="power-name"><i class="fa-solid fa-file-export" style="color:var(--accent-cyan);"></i> Exportar Reportes</span>
                                        <span class="power-desc">Permite descargar reportes de escaneos en CSV y JSON</span>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="can_export_reports" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="power-item">
                                    <div class="power-info">
                                        <span class="power-name"><i class="fa-solid fa-sliders" style="color:var(--accent-amber);"></i> Cambiar Edad Mínima</span>
                                        <span class="power-desc">Permite ajustar el umbral de edad (ej. 18 ó 21 años)</span>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="can_change_min_age" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="power-item">
                                    <div class="power-info">
                                        <span class="power-name"><i class="fa-solid fa-list-check" style="color:var(--accent-green);"></i> Ver Auditoría e Historial</span>
                                        <span class="power-desc">Permite ver la lista detallada de escaneos previos</span>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="can_view_logs" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-close="modalCreateClient">Cancelar</button>
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar y Generar Acceso
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: MENSAJE WHATSAPP GENERADO -->
    <div class="modal-backdrop" id="modalWhatsApp">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title" style="color: var(--accent-green);">
                    <i class="fa-brands fa-whatsapp"></i> ¡Cliente Creado! Acceso y Mensaje
                </div>
                <button class="btn-close-modal" data-close="modalWhatsApp">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Direct Clickable Link -->
                <div style="margin-bottom: 14px; padding: 12px 16px; background: rgba(0, 240, 255, 0.08); border: 1px solid rgba(0, 240, 255, 0.3); border-radius: 10px;">
                    <div style="font-size: 11px; font-weight: 700; color: var(--accent-cyan); text-transform: uppercase; margin-bottom: 4px;">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Hipervínculo directo (Toca para probar):
                    </div>
                    <a id="directLinkAnchor" href="#" target="_blank" style="color: #fff; font-size: 14px; font-weight: 700; text-decoration: underline; word-break: break-all; display: inline-flex; align-items: center; gap: 6px;">
                        <span></span> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 11px; color: var(--accent-cyan);"></i>
                    </a>
                </div>

                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">
                    Mensaje formateado para enviar a tu cliente:
                </p>
                <div class="whatsapp-output-box" id="whatsappTextContainer"></div>
            </div>
            <div class="modal-footer" style="gap: 10px; flex-wrap: wrap;">
                <button type="button" class="btn-cancel" data-close="modalWhatsApp">Cerrar</button>
                <button type="button" class="btn-submit" id="btnCopyWhatsApp" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid var(--border-subtle);">
                    <i class="fa-solid fa-copy"></i> Copiar Mensaje
                </button>
                <button type="button" class="btn-submit" id="btnSendDirectWhatsApp" style="background: linear-gradient(135deg, #10b981, #059669); color: #fff;">
                    <i class="fa-brands fa-whatsapp"></i> Abrir en WhatsApp
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 3: RENOVAR MESES -->
    <div class="modal-backdrop" id="modalRenew">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title" style="color: var(--accent-green);">
                    <i class="fa-solid fa-arrows-rotate"></i> Renovar Suscripción de Cliente
                </div>
                <button class="btn-close-modal" data-close="modalRenew">&times;</button>
            </div>
            <form id="formRenewClient">
                <input type="hidden" id="renewClientId">
                <div class="modal-body">
                    <p style="font-size: 14px; margin-bottom: 16px;">
                        Renovar servicio para: <strong id="renewBusinessName" style="color: var(--accent-cyan);"></strong>
                    </p>
                    <label class="form-label">Selecciona cuántos meses renovar:</label>
                    <div class="month-selector-grid" style="margin-bottom: 20px;">
                        <label class="month-chip active">
                            <input type="radio" name="renew_months" value="1" checked>
                            <div class="num">+1</div>
                            <div class="txt">Mes</div>
                        </label>
                        <label class="month-chip">
                            <input type="radio" name="renew_months" value="2">
                            <div class="num">+2</div>
                            <div class="txt">Meses</div>
                        </label>
                        <label class="month-chip">
                            <input type="radio" name="renew_months" value="3">
                            <div class="num">+3</div>
                            <div class="txt">Meses</div>
                        </label>
                        <label class="month-chip">
                            <input type="radio" name="renew_months" value="6">
                            <div class="num">+6</div>
                            <div class="txt">Meses</div>
                        </label>
                        <label class="month-chip">
                            <input type="radio" name="renew_months" value="12">
                            <div class="num">+12</div>
                            <div class="txt">1 Año</div>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-close="modalRenew">Cancelar</button>
                    <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #10b981, #059669); color: #fff;">
                        <i class="fa-solid fa-check"></i> Confirmar Renovación
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 4: EDITAR PODERES -->
    <div class="modal-backdrop" id="modalPowers">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title" style="color: var(--accent-cyan);">
                    <i class="fa-solid fa-bolt"></i> Modificar Poderes del Cliente
                </div>
                <button class="btn-close-modal" data-close="modalPowers">&times;</button>
            </div>
            <form id="formEditPowers">
                <input type="hidden" id="editPowersClientId">
                <div class="modal-body">
                    <p style="font-size: 14px; margin-bottom: 16px;">
                        Cliente: <strong id="editPowersBusinessName" style="color: var(--accent-cyan);"></strong>
                    </p>
                    <div class="powers-box">
                        <div class="power-item">
                            <div class="power-info">
                                <span class="power-name"><i class="fa-solid fa-file-export" style="color:var(--accent-cyan);"></i> Exportar Reportes</span>
                                <span class="power-desc">Descarga de informes CSV y JSON</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="powerExport" name="can_export_reports">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="power-item">
                            <div class="power-info">
                                <span class="power-name"><i class="fa-solid fa-sliders" style="color:var(--accent-amber);"></i> Cambiar Edad Mínima</span>
                                <span class="power-desc">Permite modificar la edad requerida</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="powerAge" name="can_change_min_age">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="power-item">
                            <div class="power-info">
                                <span class="power-name"><i class="fa-solid fa-list-check" style="color:var(--accent-green);"></i> Ver Auditoría</span>
                                <span class="power-desc">Visualizar historial de escaneos</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="powerLogs" name="can_view_logs">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 16px;">
                        <label class="form-label"><i class="fa-solid fa-language" style="color:var(--accent-cyan);"></i> Idioma de la App</label>
                        <select id="powerLanguage" name="language" class="form-select" style="width:100%; background:var(--bg-surface); border:1px solid var(--border-color); color:#fff; padding:10px; border-radius:var(--radius-md); font-weight:700;">
                            <option value="es">🇪🇸 Español</option>
                            <option value="en">🇺🇸 English</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-close="modalPowers">Cancelar</button>
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Poderes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 5: CAMBIAR CONTRASEÑA -->
    <div class="modal-backdrop" id="modalPassword">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title" style="color: var(--accent-blue);">
                    <i class="fa-solid fa-key"></i> Restablecer Contraseña
                </div>
                <button class="btn-close-modal" data-close="modalPassword">&times;</button>
            </div>
            <form id="formResetPassword">
                <input type="hidden" id="resetPassClientId">
                <div class="modal-body">
                    <p style="font-size: 14px; margin-bottom: 16px;">
                        Cliente: <strong id="resetPassBusinessName" style="color: var(--accent-cyan);"></strong>
                    </p>
                    <div class="form-group">
                        <label class="form-label">Nueva Contraseña *</label>
                        <input type="text" id="inputNewPassValue" class="form-input" placeholder="NuevaClave123*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-close="modalPassword">Cancelar</button>
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-check"></i> Actualizar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Notifications Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // State
        let allClients = [];
        let currentStatusFilter = '';
        let currentSearchQuery = '';

        // DOM elements
        const clientsTableBody = document.getElementById('clientsTableBody');
        const searchInput = document.getElementById('searchInput');
        const tabBtns = document.querySelectorAll('.tab-btn');

        // Toast Helper
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i> <span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        // Modal Helpers
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        document.querySelectorAll('[data-close]').forEach(btn => {
            btn.addEventListener('click', () => {
                closeModal(btn.getAttribute('data-close'));
            });
        });

        // Close modal when clicking backdrop outside card
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.addEventListener('click', (e) => {
                if (e.target === backdrop) backdrop.style.display = 'none';
            });
        });

        // Month chips interaction
        document.querySelectorAll('.month-chip').forEach(chip => {
            chip.addEventListener('click', () => {
                const parent = chip.closest('.month-selector-grid');
                parent.querySelectorAll('.month-chip').forEach(c => c.classList.remove('active'));
                chip.classList.add('active');
                chip.querySelector('input[type="radio"]').checked = true;
            });
        });

        // Open create modal
        document.getElementById('btnOpenCreateModal').addEventListener('click', () => {
            const form = document.getElementById('formCreateClient');
            if (form) {
                form.reset();
                const emailInput = document.getElementById('newClientEmail');
                if (emailInput) emailInput.value = '';
            }
            const passInput = document.getElementById('inputNewClientPass');
            if (passInput) {
                passInput.value = 'LqGuard' + Math.floor(1000 + Math.random() * 9000) + '*';
            }
            openModal('modalCreateClient');
        });

        // Fetch Metrics & Clients
        async function loadMetrics() {
            try {
                const res = await fetch('/liquorguard/api/admin/metrics', { credentials: 'include' });
                const data = await res.json();
                if (data.success) {
                    document.getElementById('kpiTotalClients').textContent = data.metrics.total_clients;
                    document.getElementById('kpiActiveClients').textContent = data.metrics.active_clients;
                    document.getElementById('kpiExpiringSoon').textContent = data.metrics.expiring_soon;
                    document.getElementById('kpiSuspendedClients').textContent = data.metrics.suspended_clients;
                    document.getElementById('kpiTotalScans').textContent = data.metrics.total_scans;
                }
            } catch (e) {
                console.error('Error loading metrics', e);
            }
        }

        async function loadClients() {
            try {
                const url = `/liquorguard/api/admin/list?search=${encodeURIComponent(currentSearchQuery)}&status=${encodeURIComponent(currentStatusFilter)}`;
                const res = await fetch(url, { credentials: 'include' });
                const data = await res.json();

                if (data.success) {
                    allClients = data.clients;
                    renderClientsTable(allClients);
                } else {
                    clientsTableBody.innerHTML = `<tr><td colspan="7" style="text-align:center; color: var(--accent-magenta); padding: 30px;">${data.message}</td></tr>`;
                }
            } catch (e) {
                clientsTableBody.innerHTML = `<tr><td colspan="7" style="text-align:center; color: var(--accent-magenta); padding: 30px;">Error de conexión con el servidor.</td></tr>`;
            }
        }

        function renderClientsTable(clients) {
            if (clients.length === 0) {
                clientsTableBody.innerHTML = `
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fa-solid fa-users-slash"></i></div>
                                <h3>No se encontraron clientes</h3>
                                <p style="font-size: 13px; margin-top: 4px;">Usa el botón "Nuevo Cliente" para registrar al primer establecimiento.</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            clients.forEach(c => {
                const initial = c.business_name ? c.business_name.charAt(0).toUpperCase() : 'C';
                
                // Status badge
                let statusBadge = '';
                if (c.status === 'active') {
                    if (c.days_left <= 7) {
                        statusBadge = `<span class="status-badge warning"><i class="fa-solid fa-triangle-exclamation"></i> Por Vencer</span>`;
                    } else {
                        statusBadge = `<span class="status-badge active"><i class="fa-solid fa-circle-check"></i> Activo</span>`;
                    }
                } else if (c.status === 'suspended') {
                    statusBadge = `<span class="status-badge suspended"><i class="fa-solid fa-ban"></i> Suspendido</span>`;
                } else {
                    statusBadge = `<span class="status-badge expired"><i class="fa-solid fa-clock-rotate-left"></i> Vencido</span>`;
                }

                // Days left text
                let daysText = '';
                if (c.days_left > 0) {
                    daysText = `<span style="color: ${c.days_left <= 7 ? 'var(--accent-amber)' : 'var(--accent-green)'}; font-weight: 700;">${c.days_left} días restantes</span>`;
                } else {
                    daysText = `<span style="color: var(--accent-magenta); font-weight: 700;">Vencido hace ${Math.abs(c.days_left)} días</span>`;
                }

                html += `
                    <tr>
                        <td>
                            <div class="client-info-cell">
                                <div class="client-avatar">${initial}</div>
                                <div>
                                    <div class="client-name">
                                        ${escapeHtml(c.business_name)}
                                        ${c.role === 'admin' 
                                            ? '<span style="font-size: 10px; font-weight: 800; background: rgba(0,210,255,0.18); color: var(--accent-cyan); border: 1px solid rgba(0,210,255,0.4); padding: 1px 6px; border-radius: 4px; margin-left: 4px;">ADMIN</span>' 
                                            : '<span style="font-size: 10px; font-weight: 800; background: rgba(255,255,255,0.06); color: var(--text-dim); border: 1px solid var(--border-color); padding: 1px 6px; border-radius: 4px; margin-left: 4px;">CLIENTE</span>'}
                                        <span style="font-size: 10px; font-weight: 800; background: rgba(0,240,255,0.12); color: var(--accent-cyan); border: 1px solid rgba(0,240,255,0.3); padding: 1px 5px; border-radius: 4px; margin-left: 4px;">
                                            ${c.language === 'en' ? '🇺🇸 EN' : '🇪🇸 ES'}
                                        </span>
                                    </div>
                                    <div class="client-contact"><i class="fa-solid fa-user" style="font-size:10px;"></i> ${escapeHtml(c.contact_name)}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="client-email">${escapeHtml(c.email)}</div>
                            <div style="font-size: 11px; color: var(--text-dim);">Registrado: ${c.formatted_created}</div>
                        </td>
                        <td>
                            <div class="days-left-badge">${daysText}</div>
                            <div style="font-size: 11px; color: var(--text-dim);"><i class="fa-regular fa-calendar"></i> ${c.formatted_expires}</div>
                        </td>
                        <td>${statusBadge}</td>
                        <td>
                            <strong style="font-family: 'JetBrains Mono', monospace; color: var(--accent-cyan); font-size: 15px;">${c.total_scans}</strong>
                        </td>
                        <td>
                            <div class="powers-icons">
                                <span class="power-tag ${c.can_export_reports ? 'enabled' : ''}" title="Exportar Reportes"><i class="fa-solid fa-file-export"></i></span>
                                <span class="power-tag ${c.can_change_min_age ? 'enabled' : ''}" title="Cambiar Edad Mínima"><i class="fa-solid fa-sliders"></i></span>
                                <span class="power-tag ${c.can_view_logs ? 'enabled' : ''}" title="Ver Auditoría"><i class="fa-solid fa-list-check"></i></span>
                            </div>
                        </td>
                        <td>
                            <div class="actions-group">
                                <button class="btn-table-action renew" onclick="openRenewModal(${c.id}, '${escapeHtml(c.business_name)}')" title="Renovar Meses">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                </button>
                                <button class="btn-table-action powers" onclick="openPowersModal(${c.id}, '${escapeHtml(c.business_name)}', ${c.can_export_reports ? 1 : 0}, ${c.can_change_min_age ? 1 : 0}, ${c.can_view_logs ? 1 : 0}, '${c.language || 'es'}')" title="Editar Poderes e Idioma">
                                    <i class="fa-solid fa-bolt"></i>
                                </button>
                                <button class="btn-table-action suspend" onclick="toggleClientStatus(${c.id}, '${c.status}')" title="${c.status === 'suspended' ? 'Activar' : 'Suspender'}">
                                    <i class="fa-solid ${c.status === 'suspended' ? 'fa-play' : 'fa-pause'}"></i>
                                </button>
                                <button class="btn-table-action key" onclick="openPasswordModal(${c.id}, '${escapeHtml(c.business_name)}')" title="Cambiar Contraseña">
                                    <i class="fa-solid fa-key"></i>
                                </button>
                                <button class="btn-table-action delete" onclick="deleteClient(${c.id}, '${escapeHtml(c.business_name)}')" title="Eliminar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });

            clientsTableBody.innerHTML = html;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }

        // Month chip interactive selection
        document.querySelectorAll('.month-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                const parentGrid = this.closest('.month-selector-grid');
                if (parentGrid) {
                    parentGrid.querySelectorAll('.month-chip').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) radio.checked = true;
                }
            });
        });

        // Form Submit: Create Client
        document.getElementById('formCreateClient').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const origHtml = submitBtn ? submitBtn.innerHTML : '';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creando Cliente...';
            }

            const formData = new FormData(form);
            const data = {
                business_name: (formData.get('business_name') || '').trim(),
                contact_name: (formData.get('contact_name') || '').trim(),
                email: (formData.get('email') || '').trim(),
                password: (formData.get('password') || '').trim(),
                role: formData.get('role') || 'client',
                language: formData.get('language') || 'es',
                months_purchased: parseInt(formData.get('months_purchased') || '1'),
                can_export_reports: form.querySelector('input[name="can_export_reports"]')?.checked ? 1 : 0,
                can_change_min_age: form.querySelector('input[name="can_change_min_age"]')?.checked ? 1 : 0,
                can_view_logs: form.querySelector('input[name="can_view_logs"]')?.checked ? 1 : 0
            };

            try {
                const res = await fetch('/liquorguard/api/admin/create', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await res.json();

                if (result.success) {
                    form.reset();
                    closeModal('modalCreateClient');
                    showToast(result.message);
                    loadMetrics();
                    loadClients();

                    // Open WhatsApp Modal with generated copyable text & clickable link
                    const loginUrl = result.login_url || (window.location.origin + '//liquorguard/login');
                    const linkAnchor = document.getElementById('directLinkAnchor');
                    linkAnchor.href = loginUrl;
                    linkAnchor.querySelector('span').textContent = loginUrl;

                    document.getElementById('whatsappTextContainer').textContent = result.whatsapp_message;
                    openModal('modalWhatsApp');
                } else {
                    showToast(result.message || 'Error al crear el cliente', 'error');
                }
            } catch (err) {
                console.error('Create client network error:', err);
                showToast('Error de conexión al procesar la solicitud.', 'error');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = origHtml;
                }
            }
        });

        // Copy WhatsApp message
        document.getElementById('btnCopyWhatsApp').addEventListener('click', () => {
            const text = document.getElementById('whatsappTextContainer').textContent;
            navigator.clipboard.writeText(text).then(() => {
                showToast('¡Mensaje copiado al portapapeles!');
            });
        });

        // Send Direct to WhatsApp (opens chat with prefilled message & clickable link)
        document.getElementById('btnSendDirectWhatsApp').addEventListener('click', () => {
            const text = document.getElementById('whatsappTextContainer').textContent;
            const waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
            window.open(waUrl, '_blank');
        });

        // Open Renew Modal
        window.openRenewModal = function(id, name) {
            document.getElementById('renewClientId').value = id;
            document.getElementById('renewBusinessName').textContent = name;
            openModal('modalRenew');
        };

        // Form Submit: Renew Client
        document.getElementById('formRenewClient').addEventListener('submit', async (e) => {
            e.preventDefault();
            const clientId = document.getElementById('renewClientId').value;
            const months = document.querySelector('input[name="renew_months"]:checked').value;

            try {
                const res = await fetch('/liquorguard/api/admin/renew', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ client_id: clientId, months: parseInt(months) })
                });
                const result = await res.json();

                if (result.success) {
                    closeModal('modalRenew');
                    showToast(result.message);
                    loadMetrics();
                    loadClients();

                    if (result.whatsapp_message) {
                        const loginUrl = result.login_url || 'http://192.168.0.142:8080//liquorguard/login';
                        const linkAnchor = document.getElementById('directLinkAnchor');
                        linkAnchor.href = loginUrl;
                        linkAnchor.querySelector('span').textContent = loginUrl;

                        document.getElementById('whatsappTextContainer').textContent = result.whatsapp_message;
                        openModal('modalWhatsApp');
                    }
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) {
                showToast('Error al renovar.', 'error');
            }
        });

        // Open Powers Modal
        window.openPowersModal = function(id, name, canExport, canChangeAge, canViewLogs, lang) {
            document.getElementById('editPowersClientId').value = id;
            document.getElementById('editPowersBusinessName').textContent = name;
            document.getElementById('powerExport').checked = canExport == 1;
            document.getElementById('powerAge').checked = canChangeAge == 1;
            document.getElementById('powerLogs').checked = canViewLogs == 1;
            document.getElementById('powerLanguage').value = lang || 'es';
            openModal('modalPowers');
        };

        // Form Submit: Edit Powers
        document.getElementById('formEditPowers').addEventListener('submit', async (e) => {
            e.preventDefault();
            const clientId = document.getElementById('editPowersClientId').value;
            const canExport = document.getElementById('powerExport').checked ? 1 : 0;
            const canChangeAge = document.getElementById('powerAge').checked ? 1 : 0;
            const canViewLogs = document.getElementById('powerLogs').checked ? 1 : 0;
            const language = document.getElementById('powerLanguage').value;

            try {
                const res = await fetch('/liquorguard/api/admin/update_powers', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        client_id: clientId,
                        can_export_reports: canExport,
                        can_change_min_age: canChangeAge,
                        can_view_logs: canViewLogs,
                        language: language
                    })
                });
                const result = await res.json();

                if (result.success) {
                    closeModal('modalPowers');
                    showToast(result.message);
                    loadClients();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) {
                showToast('Error al actualizar poderes.', 'error');
            }
        });

        // Toggle Status (Active / Suspended)
        window.toggleClientStatus = async function(id, currentStatus) {
            const newStatus = currentStatus === 'suspended' ? 'active' : 'suspended';
            const actionText = newStatus === 'suspended' ? 'suspender' : 'reactivar';
            
            if (!confirm(`¿Estás seguro de que deseas ${actionText} a este cliente?`)) return;

            try {
                const res = await fetch('/liquorguard/api/admin/toggle_status', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ client_id: id, status: newStatus })
                });
                const result = await res.json();

                if (result.success) {
                    showToast(result.message);
                    loadMetrics();
                    loadClients();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) {
                showToast('Error al cambiar estado.', 'error');
            }
        };

        // Open Password Modal
        window.openPasswordModal = function(id, name) {
            document.getElementById('resetPassClientId').value = id;
            document.getElementById('resetPassBusinessName').textContent = name;
            document.getElementById('inputNewPassValue').value = 'LqGuard' + Math.floor(1000 + Math.random() * 9000) + '*';
            openModal('modalPassword');
        };

        // Form Submit: Reset Password
        document.getElementById('formResetPassword').addEventListener('submit', async (e) => {
            e.preventDefault();
            const clientId = document.getElementById('resetPassClientId').value;
            const newPass = document.getElementById('inputNewPassValue').value.trim();

            try {
                const res = await fetch('/liquorguard/api/admin/reset_password', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ client_id: clientId, new_password: newPass })
                });
                const result = await res.json();

                if (result.success) {
                    closeModal('modalPassword');
                    showToast(result.message);
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) {
                showToast('Error al actualizar contraseña.', 'error');
            }
        });

        // Delete Client
        window.deleteClient = async function(id, name) {
            if (!confirm(`⚠️ ATENCIÓN: ¿Seguro que deseas eliminar definitivamente a "${name}"? Se borrará todo su historial de escaneos.`)) return;

            try {
                const res = await fetch('/liquorguard/api/admin/delete', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ client_id: id })
                });
                const result = await res.json();

                if (result.success) {
                    showToast(result.message);
                    loadMetrics();
                    loadClients();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) {
                showToast('Error al eliminar cliente.', 'error');
            }
        };

        // Filter Tabs
        tabBtns.forEach(tab => {
            tab.addEventListener('click', () => {
                tabBtns.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                currentStatusFilter = tab.getAttribute('data-status');
                loadClients();
            });
        });

        // Search Input (Debounce)
        let searchTimeout = null;
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearchQuery = searchInput.value.trim();
                loadClients();
            }, 300);
        });

        // Initial Load
        loadMetrics();
        loadClients();
    </script>
</body>
</html>
