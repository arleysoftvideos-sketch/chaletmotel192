<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#090a0f">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <title>TaskSua | Motor de Captura POV 4K</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #090a0f;
            --surface-dark: rgba(18, 20, 29, 0.85);
            --surface-border: rgba(255, 255, 255, 0.12);
            --accent-red: #ef4444;
            --accent-red-glow: rgba(239, 68, 68, 0.45);
            --accent-green: #10b981;
            --accent-green-glow: rgba(16, 185, 129, 0.35);
            --accent-blue: #3b82f6;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        body, html {
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Contenedor del visor POV */
        .camera-viewport { position: fixed; inset: 0; width: 100vw; height: 100vh; max-width: 100vw; max-height: 100vh; border-radius: 0; border: none; z-index: 1;
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
        }

        #povPreview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background: #000;
        }

        /* Guías de encuadre POV (Crosshair & Safe Margin) */
        .pov-crosshair {
            position: absolute;
            inset: 8% 6%;
            border: 1px dashed rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            transition: border-color 0.3s ease;
        }

        .pov-crosshair.recording {
            border-color: rgba(239, 68, 68, 0.4);
        }

        .crosshair-center {
            width: 32px;
            height: 32px;
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .crosshair-center::after {
            content: '';
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
        }

        .crosshair-tag {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.6);
            background: rgba(0, 0, 0, 0.4);
            padding: 4px 10px;
            border-radius: 20px;
            backdrop-filter: blur(8px);
        }

        /* HUD Superior */
        .hud-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background: linear-gradient(to bottom, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);
            z-index: 20;
            pointer-events: auto;
        }

        .badge-res {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface-dark);
            border: 1px solid var(--surface-border);
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent-green);
            box-shadow: 0 0 8px var(--accent-green);
        }

        .hud-timer-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .rec-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(15, 17, 23, 0.85);
            border: 1px solid var(--surface-border);
            padding: 6px 16px;
            border-radius: 30px;
            backdrop-filter: blur(12px);
        }

        .rec-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #64748b;
        }

        .rec-indicator.active {
            background: var(--accent-red);
            box-shadow: 0 0 12px var(--accent-red);
            animation: pulse-rec 1s infinite alternate;
        }

        @keyframes pulse-rec {
            from { opacity: 0.4; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1.15); }
        }

        .timer-text {
            font-family: 'JetBrains Mono', monospace;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        /* Medidor de Audio VU Meter */
        .audio-meter-box {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--surface-dark);
            border: 1px solid var(--surface-border);
            padding: 6px 12px;
            border-radius: 30px;
            backdrop-filter: blur(12px);
        }

        .audio-bars-container {
            width: 36px;
            height: 12px;
            background: rgba(255,255,255,0.1);
            border-radius: 6px;
            overflow: hidden;
            position: relative;
        }

        .audio-bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #10b981, #f59e0b, #ef4444);
            transition: width 0.08s ease;
        }

        /* Banner de Tarea Activa */
        .task-banner {
            position: absolute;
            top: 75px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(18, 20, 29, 0.75);
            border: 1px solid var(--surface-border);
            backdrop-filter: blur(16px);
            padding: 6px 16px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            max-width: 90%;
            z-index: 15;
        }

        .task-badge {
            background: rgba(59, 130, 246, 0.25);
            color: #60a5fa;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 12px;
            text-transform: uppercase;
        }

        .task-title {
            font-size: 13px;
            font-weight: 600;
            color: #f1f5f9;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* HUD Inferior - Controles de Grabación */
        .hud-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px 24px 34px;
            background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0) 100%);
            z-index: 20;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 18px;
        }

        .controls-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 28px;
            width: 100%;
        }

        /* Botón de Pausa */
        .btn-subcontrol {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid var(--surface-border);
            color: #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(12px);
            transition: all 0.2s ease;
        }

        .btn-subcontrol:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .btn-subcontrol:not(:disabled):active {
            transform: scale(0.92);
        }

        /* Botón REC Principal */
        .btn-record-main {
            position: relative;
            width: 82px;
            height: 82px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            border: 3px solid rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-record-main:active {
            transform: scale(0.94);
        }

        .btn-record-inner {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: var(--accent-red);
            box-shadow: 0 0 20px var(--accent-red-glow);
            transition: all 0.3s ease;
        }

        /* Estado grabando del botón principal: cambia a cuadrado de stop */
        .btn-record-main.is-recording .btn-record-inner {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.8);
        }

        /* Selector de Cámara y Ajustes */
        .tools-bar {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .camera-select {
            background: rgba(18, 20, 29, 0.85);
            color: #cbd5e1;
            border: 1px solid var(--surface-border);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-family: inherit;
            outline: none;
            backdrop-filter: blur(10px);
        }

        /* ── Adaptabilidad Dinámica Horizontal / Landscape ── */
        @media (orientation: landscape) {
            .hud-top {
                padding: 10px 18px;
                right: 120px; /* Dejar libre el lateral derecho para controles */
            }

            .task-banner {
                top: 10px;
                left: 45%;
                padding: 4px 12px;
                font-size: 12px;
            }

            .pov-crosshair {
                inset: 10% 15% 10% 8%; /* Espacio amplio 16:9 libre de la barra lateral */
            }

            /* Los controles se reubican al lateral derecho como cámara profesional */
            .hud-bottom {
                top: 0;
                bottom: 0;
                left: auto;
                right: 0;
                width: 110px;
                height: 100vh;
                padding: 18px 10px;
                background: linear-gradient(to left, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0) 100%);
                justify-content: center;
                gap: 20px;
            }

            .controls-row {
                flex-direction: column;
                gap: 22px;
            }

            .btn-record-main {
                width: 72px;
                height: 72px;
            }

            .btn-record-inner {
                width: 52px;
                height: 52px;
            }

            .tools-bar {
                position: absolute;
                bottom: 12px;
                right: 8px;
                width: 94px;
            }

            .camera-select {
                width: 94px;
                font-size: 10px;
                padding: 4px 6px;
            }
        }

        /* Pantalla de Permisos / Inicio */
        .permission-screen {
            position: absolute;
            inset: 0;
            background: rgba(9, 10, 15, 0.96);
            backdrop-filter: blur(20px);
            z-index: 100;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
            text-align: center;
        }

        .permission-card {
            max-width: 420px;
            background: rgba(22, 27, 38, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .pulse-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .btn-launch {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 30px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);
            transition: transform 0.2s ease;
        }

        .btn-launch:active {
            transform: scale(0.96);
        }

        /* Modal de Previsualización (Fase 2 Hook) */
        .preview-modal {
            position: absolute;
            inset: 0;
            background: rgba(9, 10, 15, 0.95);
            backdrop-filter: blur(16px);
            z-index: 50;
            display: none;
            flex-direction: column;
            padding: 24px;
            overflow-y: auto;
        }

        .preview-modal.show {
            display: flex;
        }

        .preview-video-container {
            width: 100%;
            max-height: 48vh;
            border-radius: 16px;
            overflow: hidden;
            background: #000;
            margin-bottom: 16px;
            border: 1px solid var(--surface-border);
        }

        #recordedVideo {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .preview-meta-card {
            background: rgba(22, 27, 38, 0.85);
            border: 1px solid var(--surface-border);
            border-radius: 16px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .meta-label {
            color: var(--text-muted);
        }

        .meta-val {
            font-weight: 600;
            color: #e2e8f0;
            font-family: 'JetBrains Mono', monospace;
        }

        .preview-actions {
            display: flex;
            gap: 12px;
            width: 100%;
        }

        .btn-action-discard {
            flex: 1;
            padding: 14px;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            border-radius: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-action-save {
            flex: 2;
            padding: 14px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: white;
            border-radius: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 15px var(--accent-green-glow);
        }

        /* ── Drive Upload UI ── */
        .drive-upload-section {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 4px;
        }

        .btn-drive-upload {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4285F4 0%, #1a73e8 100%);
            border: none;
            color: white;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(66, 133, 244, 0.4);
            transition: all 0.2s ease;
        }

        .btn-drive-upload:active { transform: scale(0.97); }
        .btn-drive-upload:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .drive-progress-container {
            display: none;
            flex-direction: column;
            gap: 6px;
        }

        .drive-progress-container.show { display: flex; }

        .drive-progress-track {
            width: 100%;
            height: 8px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .drive-progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #4285F4, #34a853);
            border-radius: 8px;
            transition: width 0.3s ease;
        }

        .drive-progress-label {
            font-size: 12px;
            color: var(--text-muted);
            text-align: center;
        }

        .drive-success-card {
            display: none;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 14px;
            padding: 14px 16px;
            gap: 8px;
            flex-direction: column;
            align-items: center;
        }

        .drive-success-card.show { display: flex; }

        .drive-success-title {
            font-size: 14px;
            font-weight: 700;
            color: #10b981;
        }

        .drive-success-link {
            font-size: 12px;
            color: #60a5fa;
            text-decoration: none;
            word-break: break-all;
            text-align: center;
        }

        /* ── Overlay de Subida a Drive (sobre cámara, auto) ── */
        .upload-overlay {
            position: fixed;
            inset: 0;
            background: rgba(9, 10, 15, 0.88);
            backdrop-filter: blur(18px);
            z-index: 200;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            padding: 32px;
        }

        .upload-overlay.show { display: flex; }

        .upload-overlay-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(66, 133, 244, 0.15);
            border: 1px solid rgba(66, 133, 244, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse-drive 1.8s ease infinite;
        }

        @keyframes pulse-drive {
            0%, 100% { box-shadow: 0 0 0 0 rgba(66,133,244,0.4); }
            50% { box-shadow: 0 0 0 16px rgba(66,133,244,0); }
        }

        .upload-overlay-title {
            font-size: 18px;
            font-weight: 800;
            color: #f8fafc;
        }

        .upload-overlay-sub {
            font-size: 13px;
            color: var(--text-muted);
            text-align: center;
            max-width: 280px;
            line-height: 1.5;
        }

        .upload-overlay-bar-track {
            width: 100%;
            max-width: 320px;
            height: 10px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .upload-overlay-bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #4285F4, #34a853);
            border-radius: 10px;
            transition: width 0.35s ease;
        }

        .upload-overlay-label {
            font-size: 13px;
            color: var(--text-muted);
            font-family: 'JetBrains Mono', monospace;
        }

        /* Drive status en preview modal (sólo resultado) */
        .drive-status-row {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(66, 133, 244, 0.1);
            border: 1px solid rgba(66, 133, 244, 0.25);
            margin-top: 4px;
        }

        .drive-status-row.success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .drive-status-row.error {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .drive-status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #4285F4;
            flex-shrink: 0;
        }

        .drive-status-row.success .drive-status-dot { background: #10b981; }
        .drive-status-row.error .drive-status-dot { background: #ef4444; }

        .drive-status-text {
            font-size: 12px;
            color: #94a3b8;
            flex: 1;
        }

        .drive-status-link {
            font-size: 12px;
            font-weight: 700;
            color: #60a5fa;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-retry-drive {
            background: transparent;
            border: 1px solid rgba(66,133,244,0.4);
            color: #60a5fa;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-retry-drive:hover { background: rgba(66,133,244,0.15); }
    </style>
</head>
<body>

    <!-- Viewport Cámara POV -->
    <div class="camera-viewport">
        <video id="povPreview" playsinline muted autoplay></video>

        <!-- Retícula POV & Encuadre seguro de manos -->
        <div class="pov-crosshair" id="crosshair">
            <span class="crosshair-tag">Zona POV Superior</span>
            <div class="crosshair-center"></div>
            <span class="crosshair-tag">Área Manos y Acción</span>
        </div>

        <!-- HUD Superior Ultra-Limpio -->
        <div class="hud-top">
            <!-- Insignia 4K Fija -->
            <div class="badge-res">
                <span class="badge-dot" id="resDot" style="background: #10b981; box-shadow: 0 0 10px #10b981;"></span>
                <span id="resLabel" style="font-weight: 800; letter-spacing: 0.02em;">4K Ultra HD</span>
            </div>

            <!-- Contador REC -->
            <div class="hud-timer-container">
                <div class="rec-pill">
                    <span class="rec-indicator" id="recDot"></span>
                    <span class="timer-text" id="timerDisplay">00:00</span>
                </div>
            </div>

            <!-- Indicador Micrófono -->
            <div class="audio-meter-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                    <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                </svg>
                <div class="audio-bars-container">
                    <div class="audio-bar-fill" id="audioBar"></div>
                </div>
            </div>
        </div>

        <!-- Tag Tarea Asignada -->
        <div class="task-banner">
            <span class="task-badge">{{ $category }}</span>
            <span class="task-title">{{ $taskTitle }}</span>
        </div>

        <!-- HUD Inferior: Exclusivo Grabar y Parar -->
        <div class="hud-bottom">
            <div class="controls-row">
                <!-- Botón Principal: GRABAR / PARAR -->
                <div class="btn-record-main" id="btnRecord" title="Toca para Iniciar o Detener la Grabación">
                    <div class="btn-record-inner" id="recordIcon"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay auto-subida a Drive -->
    <div class="upload-overlay" id="uploadOverlay">
        <div class="upload-overlay-icon">
            <svg width="30" height="26" viewBox="0 0 87.3 78" fill="#4285F4" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.6 66.85l3.85 6.65c.8 1.4 1.95 2.5 3.3 3.3l13.75-23.8H0c0 1.55.4 3.1 1.2 4.5z"/>
                <path d="M43.65 25L29.9 1.2C28.55.4 27 0 25.45 0c-1.55 0-3.1.4-4.5 1.2L6.6 11.15l19.2 33.25z"/>
                <path d="M73.55 76.8c1.35-.8 2.5-1.9 3.3-3.3l1.6-2.75 7.65-13.25c.8-1.4 1.2-2.95 1.2-4.5H60.8l5.65 9.2z"/>
                <path d="M43.65 25L57.4 1.2C56 .4 54.45 0 52.85 0H34.4c-1.55 0-3.1.4-4.5 1.2z"/>
                <path d="M60.8 53H27.45L13.7 76.8c1.35.8 2.9 1.2 4.5 1.2h50.8c1.6 0 3.15-.4 4.5-1.2z"/>
                <path d="M43.65 25L60.8 53h26.5L73.55 11.15c-1.35-.8-2.9-1.2-4.5-1.2h-0.85z"/>
            </svg>
        </div>
        <div class="upload-overlay-title">Guardando en Google Drive</div>
        <div class="upload-overlay-sub" id="uploadOverlaySub">Subiendo video POV a tu carpeta...</div>
        <div class="upload-overlay-bar-track">
            <div class="upload-overlay-bar-fill" id="uploadOverlayFill"></div>
        </div>
        <div class="upload-overlay-label" id="uploadOverlayLabel">Preparando...</div>
    </div>

    <!-- Pantalla Inicial de Permisos -->
    <div class="permission-screen" id="permissionScreen">
        <div class="permission-card">
            <div class="pulse-icon">📹</div>
            <h2 style="font-size: 20px; font-weight: 800;">Motor POV 4K TaskSua</h2>
            <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5;">
                Para calibrar el sensor 4K (3840×2160) y habilitar el audio de referencia, necesitamos acceso a tu cámara y micrófono.
            </p>
            <button class="btn-launch" id="btnActivate">
                Activar Cámara 4K
            </button>
        </div>
    </div>

    <!-- Modal Previsualización (Puente a Fase 2: Bóveda Local) -->
    <div class="preview-modal" id="previewModal">
        <h3 style="font-size: 18px; margin-bottom: 12px; font-weight: 700;">Verificación de Toma POV</h3>
        
        <div class="preview-video-container">
            <video id="recordedVideo" controls playsinline></video>
        </div>

        <div class="preview-meta-card">
            <div class="meta-row">
                <span class="meta-label">Resolución de Grabación:</span>
                <span class="meta-val" id="metaRes">3840×2160</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Duración:</span>
                <span class="meta-val" id="metaDuration">00:00</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Tamaño Estimado:</span>
                <span class="meta-val" id="metaSize">0.00 MB</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">ID Tarea:</span>
                <span class="meta-val">{{ $taskId ?? 'POV-GEN-01' }}</span>
            </div>
        </div>

        <div class="preview-actions">
            <button class="btn-action-discard" id="btnDiscard">Descartar / Regrabar</button>
            <button class="btn-action-save" id="btnNewRec" style="background: linear-gradient(135deg, #334155 0%, #1e293b 100%); border: 1px solid rgba(255,255,255,0.1); box-shadow: none;">🟢 Nueva grabación</button>
        </div>

        <!-- Estado de Drive (auto-gestionado, sólo muestra resultado) -->
        <div class="drive-status-row" id="driveStatusRow">
            <span class="drive-status-dot" id="driveStatusDot"></span>
            <span class="drive-status-text" id="driveStatusText">Guardando en Google Drive...</span>
            <a class="drive-status-link" id="driveStatusLink" href="#" target="_blank" style="display:none">Ver →</a>
            <button class="btn-retry-drive" id="btnRetryDrive" style="display:none">Reintentar</button>
        </div>
    </div>

    <!-- Configuración Drive (reemplaza con tu Client ID) -->
    <script>
        window.DRIVE_CLIENT_ID = '{{ env("GOOGLE_DRIVE_CLIENT_ID", "") }}';
        window.DRIVE_FOLDER_ID = '1EJ6QnBrV7qdOvONkhMBJX3wnDyNUPu1A';
    </script>

    <!-- Cargar Motor JS -->
    <script src="{{ asset('js/pov-engine.js') }}"></script>
    <script src="{{ asset('js/drive-vault.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const povVideo       = document.getElementById('povPreview');
            const permissionScreen = document.getElementById('permissionScreen');
            const btnActivate    = document.getElementById('btnActivate');
            const btnRecord      = document.getElementById('btnRecord');
            const resLabel       = document.getElementById('resLabel');
            const resDot         = document.getElementById('resDot');
            const recDot         = document.getElementById('recDot');
            const timerDisplay   = document.getElementById('timerDisplay');
            const audioBar       = document.getElementById('audioBar');
            const crosshair      = document.getElementById('crosshair');
            const previewModal   = document.getElementById('previewModal');
            const recordedVideo  = document.getElementById('recordedVideo');
            const metaRes        = document.getElementById('metaRes');
            const metaDuration   = document.getElementById('metaDuration');
            const metaSize       = document.getElementById('metaSize');
            const btnDiscard     = document.getElementById('btnDiscard');
            const btnSaveLocal   = document.getElementById('btnSaveLocal');

            // Overlay de subida
            const uploadOverlay      = document.getElementById('uploadOverlay');
            const uploadOverlaySub   = document.getElementById('uploadOverlaySub');
            const uploadOverlayFill  = document.getElementById('uploadOverlayFill');
            const uploadOverlayLabel = document.getElementById('uploadOverlayLabel');

            // Estado drive en preview
            const driveStatusRow  = document.getElementById('driveStatusRow');
            const driveStatusDot  = document.getElementById('driveStatusDot');
            const driveStatusText = document.getElementById('driveStatusText');
            const driveStatusLink = document.getElementById('driveStatusLink');
            const btnRetryDrive   = document.getElementById('btnRetryDrive');

            // ─── Variables de estado ───
            let lastRecordedBlob = null;
            let lastMetadata     = null;
            let lastBlobUrl      = null; // para poder revocarlo y liberar RAM
            let driveReady       = false;

            // ─── Inicializar DriveVault silenciosamente ───
            const clientId = window.DRIVE_CLIENT_ID;
            if (clientId) {
                DriveVault.init(clientId)
                    .then(ok => { driveReady = ok; console.log('[Drive] Listo:', ok); })
                    .catch(e  => console.warn('[Drive] Init error:', e));
            }

            // ─── Función central de subida a Drive vía Backend Service Account ───
            async function uploadToDrive(blob, metadata) {
                // Mostrar overlay de subida
                uploadOverlayFill.style.width = '0%';
                uploadOverlayFill.style.background = 'linear-gradient(90deg, #4285F4, #34a853)';
                uploadOverlayLabel.textContent = 'Enviando a Google Drive...';
                uploadOverlaySub.textContent   = `Subiendo ${metadata.sizeMB} MB directo a Drive (sin ocupar almacenamiento local)`;
                uploadOverlay.classList.add('show');

                // Generar Task ID único
                const now      = new Date();
                const dateStr  = now.toISOString().replace(/[:.]/g, '-').slice(0, 19);
                const taskId   = `TSK-${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}${String(now.getDate()).padStart(2,'0')}-${String(Math.floor(Math.random()*9000)+1000)}`;
                const ext      = blob.type.includes('mp4') ? 'mp4' : 'webm';
                const filename = `TaskSua_${metadata.resolution?.tier || 'POV'}_${dateStr}.${ext}`;

                // ── Construir JSON estructurado según especificación TaskSua ──
                const tsStart  = new Date(now.getTime() - (metadata.durationSeconds * 1000));
                const taskJson = {
                    task_id: taskId,
                    platform: 'TaskSua',
                    assigned_to: {
                        operator_id: 'operator_01',
                        device_info: {
                            model: navigator.userAgent.match(/\(([^)]+)\)/)?.[1] || 'Mobile/Web Browser',
                            resolution_forced: `${metadata.resolution?.width || 0}x${metadata.resolution?.height || 0}`,
                            target_fps: metadata.resolution?.fps || 30
                        }
                    },
                    task_details: {
                        title: '{{ $taskTitle }}' || 'POV Task - Point of View Recording',
                        category: '{{ $category }}' || 'POV',
                        instructions: 'Mantener la toma fija a la altura de los ojos, asegurar iluminación adecuada y evitar movimientos bruscos.',
                        status: 'completed'
                    },
                    capture_metadata: {
                        file_name: filename,
                        file_size_bytes: metadata.sizeBytes,
                        file_size_mb: parseFloat(metadata.sizeMB),
                        duration_seconds: metadata.durationSeconds,
                        duration_formatted: metadata.durationFormatted,
                        actual_resolution: `${metadata.resolution?.width || 0}x${metadata.resolution?.height || 0}`,
                        resolution_tier: metadata.resolution?.tier || 'Unknown',
                        fps: metadata.resolution?.fps || 30,
                        codec: blob.type,
                        chunks_count: metadata.chunksCount || 0,
                        timestamp_start: tsStart.toISOString(),
                        timestamp_end: now.toISOString()
                    },
                    sync_status: {
                        local_vault_path: null,
                        uploaded: false,
                        upload_attempts: 1,
                        cloud_url: null,
                        drive_folder_id: '1EJ6QnBrV7qdOvONkhMBJX3wnDyNUPu1A'
                    },
                    qc_review: {
                        status: 'pending',
                        reviewed_by: null,
                        feedback: ''
                    }
                };

                const formData = new FormData();
                formData.append('video', blob, filename);
                formData.append('metadata', JSON.stringify(taskJson));
                formData.append('_token', '{{ csrf_token() }}');

                return new Promise((resolve, reject) => {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/tasksua/upload', true);

                    xhr.upload.onprogress = (e) => {
                        if (e.lengthComputable) {
                            const pct = Math.round((e.loaded / e.total) * 100);
                            uploadOverlayFill.style.width = pct + '%';
                            uploadOverlayLabel.textContent = `${pct}% (${(e.loaded / (1024*1024)).toFixed(1)} / ${(e.total / (1024*1024)).toFixed(1)} MB)`;
                            if (pct === 100) {
                                uploadOverlayLabel.textContent = 'Procesando en Google Drive...';
                            }
                        }
                    };

                    xhr.onload = () => {
                        // ── LIBERAR MEMORIA DEL DISPOSITIVO INMEDIATAMENTE ──
                        if (lastBlobUrl) { URL.revokeObjectURL(lastBlobUrl); lastBlobUrl = null; }
                        lastRecordedBlob = null;
                        recordedVideo.pause();
                        recordedVideo.src = '';

                        uploadOverlay.classList.remove('show');

                        try {
                            const resp = JSON.parse(xhr.responseText);
                            if (xhr.status >= 200 && xhr.status < 300 && resp.success) {
                                showPreview(null, metadata, resp);
                                setDriveStatus('success', '✅ Guardado en Google Drive + JSON (celular libre)', resp.drive_url, resp.file_name);
                                resolve(resp);
                            } else {
                                const errMsg = resp.error || `Error HTTP ${xhr.status}`;
                                showPreview(null, metadata, null);
                                setDriveStatus('error', '❌ ' + errMsg);
                                reject(new Error(errMsg));
                            }
                        } catch (err) {
                            showPreview(null, metadata, null);
                            setDriveStatus('error', '❌ Error en la respuesta del servidor');
                            reject(err);
                        }
                    };

                    xhr.onerror = () => {
                        uploadOverlay.classList.remove('show');
                        showPreview(null, metadata, null);
                        setDriveStatus('error', '❌ Error de red al contactar servidor');
                        reject(new Error('Network error'));
                    };

                    xhr.send(formData);
                });
            }

            // ─── Mostrar modal de preview ───
            // Si blob es null (ya fue liberado), muestra solo los metadatos y el link de Drive
            function showPreview(blob, metadata, driveResult = null) {
                if (blob) {
                    if (lastBlobUrl) URL.revokeObjectURL(lastBlobUrl);
                    lastBlobUrl = URL.createObjectURL(blob);
                    recordedVideo.src = lastBlobUrl;
                } else {
                    // Ya liberado: mostrar placeholder en el video
                    recordedVideo.src = '';
                }
                metaRes.textContent      = `${metadata.resolution.width}×${metadata.resolution.height}`;
                metaDuration.textContent = metadata.durationFormatted;
                metaSize.textContent     = `${metadata.sizeMB} MB`;
                previewModal.classList.add('show');
            }

            // ─── Actualizar fila de estado de Drive ───
            function setDriveStatus(state, text, link = null, name = null) {
                driveStatusRow.className  = `drive-status-row ${state}`;
                driveStatusText.textContent = text;
                driveStatusLink.style.display = (link && state === 'success') ? 'inline' : 'none';
                btnRetryDrive.style.display   = (state === 'error') ? 'inline-block' : 'none';
                if (link) driveStatusLink.href = link;
                if (name) driveStatusLink.textContent = name + ' →';
            }

            // ─── Motor de Captura POV ───
            const engine = new PovCaptureEngine({
                videoElement: povVideo,
                onStateChange: (state) => {
                    if (state === 'recording') {
                        btnRecord.classList.add('is-recording');
                        recDot.classList.add('active');
                        crosshair.classList.add('recording');
                    } else {
                        btnRecord.classList.remove('is-recording');
                        recDot.classList.remove('active');
                        crosshair.classList.remove('recording');
                    }
                },
                onStreamReady: (res) => {
                    resLabel.textContent = `${res.tier} (${res.width}×${res.height})`;
                    resDot.style.background  = res.tierCode === '4k' ? '#10b981' : '#06b6d4';
                    resDot.style.boxShadow   = `0 0 10px ${res.tierCode === '4k' ? '#10b981' : '#06b6d4'}`;
                },
                onTimeUpdate: (ft) => { timerDisplay.textContent = ft; },
                onAudioLevel: (lvl) => { audioBar.style.width = lvl + '%'; },

            // ─── GRABACIÓN COMPLETA: auto-subir a Drive, no guardar en cel ───
                onRecordingComplete: (blob, metadata) => {
                    lastRecordedBlob = blob;
                    lastMetadata     = metadata;

                    setDriveStatus('uploading', 'Subiendo a Drive...');

                    // Upload automático — Drive es el único destino
                    uploadToDrive(blob, metadata);
                }
            });

            // ─── Activar cámara ───
            async function activateCamera() {
                try {
                    await engine.startCamera(null, '4k');
                    permissionScreen.style.display = 'none';
                } catch (err) {
                    permissionScreen.style.display = 'flex';
                }
            }

            btnActivate.addEventListener('click', () => activateCamera());
            activateCamera();

            // ─── Botón Grabar / Parar ───
            btnRecord.addEventListener('click', () => {
                if (engine.state === 'recording')     engine.stopRecording();
                else if (engine.state === 'streaming') engine.startRecording();
            });

            // ─── Descartar ───
            btnDiscard.addEventListener('click', () => {
                if (confirm('¿Descartar esta toma?')) {
                    previewModal.classList.remove('show');
                    recordedVideo.pause();
                    recordedVideo.src = '';
                    if (lastBlobUrl) { URL.revokeObjectURL(lastBlobUrl); lastBlobUrl = null; }
                    lastRecordedBlob = null;
                    lastMetadata = null;
                }
            });

            // ─── Nueva grabación (cierra preview, vuelve a cámara) ───
            document.getElementById('btnNewRec').addEventListener('click', () => {
                previewModal.classList.remove('show');
                recordedVideo.pause();
                recordedVideo.src = '';
                if (lastBlobUrl) { URL.revokeObjectURL(lastBlobUrl); lastBlobUrl = null; }
                lastRecordedBlob = null;
                lastMetadata = null;
            });

            // ─── Reintentar subida a Drive ───
            btnRetryDrive.addEventListener('click', () => {
                if (lastRecordedBlob && lastMetadata) {
                    setDriveStatus('uploading', 'Reintentando subida a Drive...');
                    driveStatusLink.style.display = 'none';
                    btnRetryDrive.style.display   = 'none';
                    uploadToDrive(lastRecordedBlob, lastMetadata);
                }
            });

            // ─── PWA Service Worker ───
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js').catch(e => console.log('SW:', e));
            }
        });
    </script>
</body>
</html>



