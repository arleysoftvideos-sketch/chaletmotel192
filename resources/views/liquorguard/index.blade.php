<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/liquorguard-assets/css/style.css">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#06090f">
</head>
<body class="theme-dark">
    <div class="app-container">
        <!-- HEADER / TOP BAR (CLEAN, MODERN & RESPONSIVE) -->
        <header class="app-header">
            <div class="brand">
                <div class="logo-icon">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>
                <div class="brand-info">
                    <div class="brand-title">LiquorGuard <span class="badge-ai">AI</span></div>
                    <div class="brand-sub">{{ session('lg_business', 'Licorería') }}</div>
                </div>
            </div>
            
            <div class="header-actions">
                @if(in_array(session('lg_role'), ['superadmin', 'admin']))
                <a href="/liquorguard/admin" class="btn-icon btn-admin-crown" title="Panel de Administración">
                    <i class="fa-solid fa-crown"></i>
                </a>
                @endif

                <button id="btnSettings" class="btn-icon" title="Configuración">
                    <i class="fa-solid fa-sliders"></i>
                </button>

                <button id="btnToggleLang" class="btn-icon" title="Idioma">
                    <span id="langFlag">🇪🇸</span>
                </button>

                <a href="/liquorguard/logout" class="btn-icon btn-logout" title="Cerrar Sesión">
                    <i class="fa-solid fa-power-off"></i>
                </a>
            </div>
        </header>

        <!-- MAIN SCANNER CONTAINER -->
        <main class="scanner-main">
            <!-- CAMERA & HUD DISPLAY -->
            <div class="camera-viewport" id="cameraViewport">
                <!-- Video stream -->
                <video id="videoElement" autoplay playsinline muted></video>
                <!-- AI HUD Canvas -->
                <canvas id="overlayCanvas"></canvas>

                <!-- Floating Corner Age Indicator in Screen -->
                <div class="hud-corner-age" id="hudCornerAge">
                    <span class="corner-age-val" id="cornerAgeVal">--</span>
                    <span class="corner-age-unit"></span>
                </div>

                <!-- HUD Overlays -->
                <div class="hud-corners">
                    <span class="corner top-left"></span>
                    <span class="corner top-right"></span>
                    <span class="corner bottom-left"></span>
                    <span class="corner bottom-right"></span>
                </div>

                <!-- Laser scan animation -->
                <div class="laser-scanner" id="laserScanner"></div>

                <!-- Loading / Setup Overlay (Clean Cyber Loader) -->
                <div class="viewport-loader" id="viewportLoader">
                    <div class="cyber-spinner"></div>
                    <p id="loaderStatusText" style="font-weight:700; font-size:13px; color:#f8fafc;">Iniciando Inteligencia Artificial...</p>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" id="progressBarFill"></div>
                    </div>
                </div>

                <!-- Action Controls Overlay on Camera -->
                <button id="btnGrantCamera" class="btn-grant-camera" style="display:none;">
                    <i class="fa-solid fa-camera"></i> <span></span>
                </button>

                <div class="viewport-quick-bar">
                    <button id="btnToggleSound" class="quick-btn active" title="Sonido">
                        <i class="fa-solid fa-volume-high"></i>
                    </button>
                    <button id="btnSwitchCamera" class="quick-btn" title="Cambiar Cámara Frontal/Trasera">
                        <i class="fa-solid fa-camera-rotate"></i>
                    </button>
                    <button id="btnToggleMode" class="quick-btn" title="Modo Continuo / 1 Scan">
                        <i class="fa-solid fa-bolt"></i>
                    </button>
                </div>
            </div>

            <!-- DECISION BANNER (BIG SCREEN FOR CASHIER) -->
            <section class="decision-card" id="decisionCard">
                <div class="decision-main">
                    <div class="decision-label"></div>
                    <div class="decision-verdict" id="verdictText"></div>
                    <div class="decision-instruction" id="verdictInstruction"></div>
                </div>
                <div class="decision-meta">
                    <div class="meta-item highlight">
                        <span class="meta-label" id="labelMetaAge">EDAD ESTIMADA</span>
                        <span class="meta-val age-highlight" id="metaAge">--</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label" id="labelMetaGender">GÉNERO</span>
                        <span class="meta-val" id="metaGender">--</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label" id="labelMetaConfidence">PRECISIÓN IA</span>
                        <span class="meta-val" id="metaConfidence">--%</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label" id="labelMetaExpression">EMOCIÓN</span>
                        <span class="meta-val" id="metaExpression">--</span>
                    </div>
                </div>
            </section>

            <!-- STATS & AUDIT DASHBOARD -->
            <section class="stats-panel">
                <div class="stat-card">
                    <div class="stat-icon total"><i class="fa-solid fa-users"></i></div>
                    <div class="stat-info">
                        <div class="stat-val" id="statTotalScans">0</div>
                        <div class="stat-label">Escaneos totales</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon allowed"><i class="fa-solid fa-shield-check"></i></div>
                    <div class="stat-info">
                        <div class="stat-val" id="statAllowed">0</div>
                        <div class="stat-label">Permitidos +18</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon rejected"><i class="fa-solid fa-ban"></i></div>
                    <div class="stat-info">
                        <div class="stat-val" id="statRejected">0</div>
                        <div class="stat-label">Menores bloqueados</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon warning"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="stat-info">
                        <div class="stat-val" id="statCheckId">0</div>
                        <div class="stat-label">Verificar ID</div>
                    </div>
                </div>
            </section>

            <!-- RECENT SCAN HISTORY TABLE -->
            <section class="history-panel">
                <div class="history-header">
                    <h2><i class="fa-solid fa-clock-rotate-left"></i> Escaneos recientes</h2>
                    <div class="history-actions">
                        
                        <button id="btnExportCSV" class="btn-action"><i class="fa-solid fa-file-csv"></i> CSV</button>
                        <button id="btnExportJSON" class="btn-action"><i class="fa-solid fa-file-code"></i> JSON</button>
                        
                        <button id="btnClearHistory" class="btn-action danger"><i class="fa-solid fa-trash-can"></i> Limpiar</button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Foto</th>
                                <th>Edad</th>
                                <th>Género</th>
                                <th>Resultado</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <tr class="empty-row">
                                <td colspan="6">Sin escaneos aún. Activa la cámara para comenzar.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>

        <!-- APP FOOTER (DAYS REMAINING & CLIENT ACCOUNT STATUS DOWN HERE) -->
        <footer class="app-footer">
            <div class="client-account-pill">
                <i class="fa-solid fa-store" style="color: var(--accent-cyan);"></i>
                <strong style="color: #fff;"></strong>
                <span class="badge-sub-days ">
                    
                </span>
            </div>
        </footer>

        <!-- MODAL 1: SETTINGS -->
        <div class="modal-backdrop" id="modalSettings">
            <div class="modal-box">
                <div class="modal-header">
                    <h3 style="font-size: 16px; font-weight: 800; color: #fff;"><i class="fa-solid fa-sliders" style="color: var(--accent-cyan);"></i> Configuración del Escáner</h3>
                    <button class="btn-close-modal" id="btnCloseSettings">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Edad Mínima Legal Requerida</label>
                        <input type="number" id="cfgMinAge" value="" min="16" max="25">
                    </div>
                    <div class="form-toggle">
                        <span>Alertas de Sonido</span>
                        <input type="checkbox" id="chkSoundAlerts" checked>
                    </div>
                    <div class="form-toggle">
                        <span>Captura Automática de Foto en Historial</span>
                        <input type="checkbox" id="chkAutoSnap" checked>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 16px;">
                    <button class="btn-primary" id="btnSaveSettings">Guardar Cambios</button>
                </div>
            </div>
        </div>

        <!-- MODAL 2: MOBILE GUIDE & QR -->
        <div class="modal-backdrop" id="modalMobile">
            <div class="modal-box">
                <div class="modal-header">
                    <h3 style="font-size: 16px; font-weight: 800; color: #fff;"><i class="fa-solid fa-mobile-screen-button" style="color: var(--accent-cyan);"></i> Abrir en Celular o Tablet</h3>
                    <button class="btn-close-modal" id="btnCloseMobile">&times;</button>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
                        Escanea este código QR con tu celular o abre la URL directa:
                    </p>
                    
                    <div style="background: #fff; padding: 12px; border-radius: 12px; display: inline-block; margin-bottom: 16px;">
                        <canvas id="qrCanvas"></canvas>
                    </div>

                    <div style="background: #070a11; padding: 10px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
                        <code id="mobileUrlDisplay" style="color: var(--accent-cyan); font-size: 12px; word-break: break-all;"></code>
                        <button id="btnCopyUrl" style="background: rgba(255,255,255,0.1); color: #fff; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; cursor: pointer;">Copiar</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-primary" id="btnCloseMobile2">Entendido</button>
                </div>
            </div>
        </div>

    </div>

    <!-- SCRIPTS -->
    <script>
window.LIQUOR_GUARD_USER = {
    id: 1,
    business_name: "LiquorGuard",
    role: "client",
    language: "es",
    powers: {
        can_export_reports: true,
        can_change_min_age: false,
        can_view_logs: true,
        custom_min_age: 18
    }
};
</script>
    <script src="/liquorguard-assets/js/face-api.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script src="/liquorguard-assets/js/app.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/liquorguard-assets/sw.js').then(reg => {
                console.log('LiquorGuard Offline ServiceWorker registered', reg.scope);
            }).catch(err => {
                console.warn('ServiceWorker registration skipped:', err);
            });
        }
    </script>
</body>
</html>