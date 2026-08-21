<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title></title>
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#07090e">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg-deep: #07090e;
            --bg-surface: #0f1523;
            --bg-surface-elevated: #162034;
            --accent-cyan: #00f0ff;
            --accent-blue: #0070f3;
            --accent-magenta: #ff0055;
            --accent-green: #00ff88;
            --accent-amber: #ffb800;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-tertiary: #64748b;
            --border-glass: rgba(255, 255, 255, 0.08);
            --border-glow: rgba(0, 240, 255, 0.3);
            --glow-cyan: 0 0 30px rgba(0, 240, 255, 0.25);
            --radius-lg: 18px;
            --radius-md: 12px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .bg-glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            opacity: 0.25;
        }
        .orb-1 { top: -100px; left: -100px; width: 400px; height: 400px; background: #00f0ff; }
        .orb-2 { bottom: -150px; right: -100px; width: 450px; height: 450px; background: #ff0055; opacity: 0.15; }

        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: rgba(15, 21, 35, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass);
            border-radius: var(--radius-lg);
            padding: 32px 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 35px rgba(0, 240, 255, 0.1);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo-icon-box {
            width: 58px;
            height: 58px;
            margin: 0 auto 12px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(0, 240, 255, 0.15), rgba(0, 112, 243, 0.15));
            border: 1px solid var(--border-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-cyan);
            font-size: 26px;
            box-shadow: var(--glow-cyan);
        }

        .brand-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff;
            margin-bottom: 4px;
        }

        .brand-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 6px;
            background: rgba(0, 240, 255, 0.15);
            color: var(--accent-cyan);
            border: 1px solid rgba(0, 240, 255, 0.3);
            margin-left: 4px;
            vertical-align: middle;
        }

        .brand-desc {
            color: var(--text-secondary);
            font-size: 12px;
        }

        /* App Installers Box */
        .install-box {
            background: rgba(8, 12, 20, 0.85);
            border: 1px solid rgba(0, 240, 255, 0.25);
            border-radius: var(--radius-md);
            padding: 16px;
            margin-bottom: 24px;
            text-align: center;
        }

        .install-title {
            font-size: 13px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .install-desc {
            font-size: 11px;
            color: var(--text-secondary);
            margin-bottom: 12px;
        }

        .install-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .btn-install {
            padding: 10px 8px;
            border-radius: 10px;
            border: 1px solid var(--border-glass);
            background: rgba(255, 255, 255, 0.04);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-install.android {
            border-color: rgba(0, 255, 136, 0.3);
            background: rgba(0, 255, 136, 0.08);
            color: var(--accent-green);
        }
        .btn-install.android:hover {
            background: var(--accent-green);
            color: #000;
            box-shadow: 0 0 15px rgba(0, 255, 136, 0.4);
        }

        .btn-install.ios {
            border-color: rgba(0, 240, 255, 0.3);
            background: rgba(0, 240, 255, 0.08);
            color: var(--accent-cyan);
        }
        .btn-install.ios:hover {
            background: var(--accent-cyan);
            color: #000;
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.4);
        }

        .divider-text {
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--text-tertiary);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 20px 0;
        }
        .divider-text::before, .divider-text::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-glass);
        }
        .divider-text span { padding: 0 10px; }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-tertiary);
            font-size: 14px;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            background: rgba(8, 12, 20, 0.7);
            border: 1px solid var(--border-glass);
            border-radius: var(--radius-md);
            padding: 12px 14px 12px 40px;
            color: var(--text-primary);
            font-size: 13px;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-cyan);
            background: rgba(12, 18, 30, 0.9);
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.2);
        }

        .form-control:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--accent-cyan);
        }

        .btn-toggle-pass {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: var(--text-tertiary);
            cursor: pointer;
            padding: 4px;
            font-size: 13px;
        }
        .btn-toggle-pass:hover { color: var(--text-primary); }

        .btn-login {
            width: 100%;
            padding: 13px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            border: none;
            color: #050b14;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(0, 240, 255, 0.3);
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 240, 255, 0.45);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert-error {
            background: rgba(255, 0, 85, 0.12);
            border: 1px solid rgba(255, 0, 85, 0.3);
            border-radius: var(--radius-md);
            padding: 10px 14px;
            color: #ff3366;
            font-size: 12px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Install Instruction Modals */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(4, 7, 12, 0.85);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-backdrop.show { display: flex; }

        .modal-box {
            background: #0f1523;
            border: 1px solid var(--border-glow);
            border-radius: var(--radius-lg);
            max-width: 400px;
            width: 100%;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.8);
            text-align: left;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .modal-step {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
            font-size: 13px;
            line-height: 1.4;
            color: var(--text-secondary);
        }
        .modal-step strong { color: #fff; }
        .step-num {
            width: 24px;
            height: 24px;
            background: rgba(0, 240, 255, 0.15);
            color: var(--accent-cyan);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 11px;
            flex-shrink: 0;
        }

        .btn-modal-close {
            width: 100%;
            padding: 11px;
            background: var(--accent-cyan);
            color: #000;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="bg-glow-orb orb-1"></div>
    <div class="bg-glow-orb orb-2"></div>

    <div class="login-card">
        <!-- BRAND -->
        <div class="brand-header">
            <div class="logo-icon-box">
                <i class="fa-solid fa-id-card-clip"></i>
            </div>
            <h1 class="brand-title">LiquorGuard <span class="brand-badge">AI</span></h1>
            <p class="brand-desc">Sistema de verificación de edad por IA</p>
        </div>

        <!-- 1-TAP APP INSTALLERS (IOS & ANDROID) -->
        <div class="install-box">
            <div class="install-title">
                <i class="fa-solid fa-mobile-screen-button" style="color:var(--accent-cyan);"></i>
                Instala la app
            </div>
            <p class="install-desc">Úsala desde tu celular o tablet</p>
            <div class="install-grid">
                <button type="button" class="btn-install android" id="btnInstallAndroid">
                    <i class="fa-brands fa-android"></i> Android
                </button>
                <button type="button" class="btn-install ios" id="btnInstallIos">
                    <i class="fa-brands fa-apple"></i> iOS / iPhone
                </button>
            </div>
        </div>

        <div class="divider-text">
            <span>Iniciar sesión</span>
        </div>

        <!-- ERROR ALERT -->
        <div class="alert-error" id="errorAlert" style="">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span id="errorText"></span>
        </div>

        <!-- LOGIN FORM -->
        <form id="loginForm" autocomplete="off">
            <div class="form-group">
                <label class="form-label">Correo electrónico</label>
                <div class="input-wrapper">
                    <input type="email" id="email" class="form-control" placeholder="usuario@correo.com" required autocomplete="username">
                    <i class="fa-solid fa-envelope input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Contraseña</label>
                <div class="input-wrapper">
                    <input type="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <button type="button" class="btn-toggle-pass" id="btnTogglePass">
                        <i class="fa-regular fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                <span>Iniciar sesión</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
    </div>

    <!-- MODAL INSTRUCCIONES ANDROID -->
    <div class="modal-backdrop" id="modalAndroid">
        <div class="modal-box">
            <div class="modal-header">
                <h3 style="color:#fff; font-size:15px; font-weight:800;"><i class="fa-brands fa-android" style="color:var(--accent-green);"></i> Instalar en Android</h3>
            </div>
            <div class="modal-step">
                <div class="step-num">1</div>
                <div>Abre Chrome y toca el menú ⋮</div>
            </div>
            <div class="modal-step">
                <div class="step-num">2</div>
                <div>Selecciona "Agregar a pantalla de inicio"</div>
            </div>
            <div class="modal-step">
                <div class="step-num">3</div>
                <div>Confirma tocando Agregar</div>
            </div>
            <button class="btn-modal-close" onclick="document.getElementById('modalAndroid').classList.remove('show')">Cerrar</button>
        </div>
    </div>

    <!-- MODAL INSTRUCCIONES IOS -->
    <div class="modal-backdrop" id="modalIos">
        <div class="modal-box">
            <div class="modal-header">
                <h3 style="color:#fff; font-size:15px; font-weight:800;"><i class="fa-brands fa-apple" style="color:var(--accent-cyan);"></i> Instalar en iOS</h3>
            </div>
            <div class="modal-step">
                <div class="step-num">1</div>
                <div>Abre Safari y toca el botón compartir</div>
            </div>
            <div class="modal-step">
                <div class="step-num">2</div>
                <div>Toca "Agregar a inicio"</div>
            </div>
            <div class="modal-step">
                <div class="step-num">3</div>
                <div>Confirma tocando Agregar</div>
            </div>
            <button class="btn-modal-close" onclick="document.getElementById('modalIos').classList.remove('show')">Cerrar</button>
        </div>
    </div>

    <script>
        // Native PWA Deferred Prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
        });

        document.getElementById('btnInstallAndroid').addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                deferredPrompt = null;
            } else {
                document.getElementById('modalAndroid').classList.add('show');
            }
        });

        document.getElementById('btnInstallIos').addEventListener('click', () => {
            document.getElementById('modalIos').classList.add('show');
        });

        // Toggle Password
        const passInput = document.getElementById('password');
        const btnTogglePass = document.getElementById('btnTogglePass');
        const eyeIcon = document.getElementById('eyeIcon');
        btnTogglePass.addEventListener('click', () => {
            const isPass = passInput.type === 'password';
            passInput.type = isPass ? 'text' : 'password';
            eyeIcon.className = isPass ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        });

        // Form Submit
        const form = document.getElementById('loginForm');
        const btnLogin = document.getElementById('btnLogin');
        const errorAlert = document.getElementById('errorAlert');
        const errorText = document.getElementById('errorText');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            errorAlert.style.display = 'none';
            btnLogin.disabled = true;
            btnLogin.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Iniciando sesión...';

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            try {
                const res = await fetch('/liquorguard/api/auth/login', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });

                const data = await res.json();

                if (data.success) {
                    window.location.href = data.redirect || '/liquorguard';
                } else {
                    errorText.textContent = data.message || 'Error de credenciales';
                    errorAlert.style.display = 'flex';
                    btnLogin.disabled = false;
                    btnLogin.innerHTML = '<span>Iniciar sesión</span> <i class="fa-solid fa-arrow-right"></i>';
                }
            } catch (err) {
                errorText.textContent = 'Error de conexión. Intente nuevamente.';
                errorAlert.style.display = 'flex';
                btnLogin.disabled = false;
                btnLogin.innerHTML = '<span>Iniciar sesión</span> <i class="fa-solid fa-arrow-right"></i>';
            }
        });

        // Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/liquorguard-assets/sw.js').catch(() => {});
        }
    </script>
</body>
</html>
