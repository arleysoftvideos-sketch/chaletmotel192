/**
 * LIQUORGUARD AI 2.0 - Core Face, Age & Emotion Verification Engine
 * Multi-Language & Real-time Neural Biometrics
 */
class LiquorGuardApp {
    constructor() {
        this.video = document.getElementById('videoElement');
        this.canvas = document.getElementById('overlayCanvas');
        this.ctx = this.canvas.getContext('2d');
        
        // Multi-Language Support
        this.currentLang = (window.LIQUOR_GUARD_USER && window.LIQUOR_GUARD_USER.language) ? window.LIQUOR_GUARD_USER.language : 'es';
        this.setupI18n();

        // State
        this.modelsLoaded = false;
        this.isScanning = false;
        this.currentFacingMode = 'user'; // 'user' (front) or 'environment' (back)
        this.soundEnabled = true;
        this.autoSnap = true;
        this.scanIntervalMs = 150;
        this.legalAge = (window.LIQUOR_GUARD_USER && window.LIQUOR_GUARD_USER.powers && window.LIQUOR_GUARD_USER.powers.custom_min_age) ? window.LIQUOR_GUARD_USER.powers.custom_min_age : 18;
        this.bufferYears = 4;
        
        // Scan tracking & smart single-scan per customer
        this.lastAgeEstimates = [];
        this.history = [];
        this.lastLogTimestamp = 0;
        this.stableFaceFrames = 0;
        this.hasLoggedCurrentCustomer = false;
        this.noFaceFrames = 0;
        this.stats = { total: 0, approved: 0, warning: 0, minor: 0 };
        
        // Audio Synthesizer (Web Audio API)
        this.audioCtx = null;
        this.lastSoundType = null;
        this.lastSoundTime = 0;

        this.initElements();
        this.bindEvents();
        this.applyLanguageUI();
        this.init();
    }

    setupI18n() {
        this.i18n = {
            es: {
                flag: '🇪🇸',
                searchingFace: 'Buscando rostro...',
                pointCamera: 'Apunte la cámara a la persona',
                yearsUnit: 'AÑOS',
                waitingFace: 'ESPERANDO CLIENTE',
                placeClient: 'Coloque al cliente frente al lente',
                ageEstimated: 'EDAD ESTIMADA',
                genderDetected: 'GÉNERO',
                aiConfidence: 'PRECISIÓN IA',
                predominantEmotion: 'EMOCIÓN',
                totalScans: 'Total Escaneos',
                allowed18: 'Permitidos (+18)',
                minorsBlocked: 'Menores Bloqueados',
                checkId: 'Verificar ID',
                recentScans: 'Registro de Escaneos Recientes',
                verdictAllowed: '✅ MAYOR DE EDAD CLARO',
                verdictAllowedSub: 'CLIENTE ADULTO CONFIRMADO',
                verdictWarning: '⚠️ ZONA DE DUDA / JOVEN',
                verdictWarningSub: 'PARECE MENOR DE {age} AÑOS - VERIFICAR ID',
                verdictMinor: '🚨 POSIBLE MENOR DE EDAD',
                verdictMinorSub: 'NO VENDER - EXIGIR IDENTIFICACIÓN OBLIGATORIA',
                male: 'Hombre',
                female: 'Mujer',
                loadingModels: 'Cargando Redes Neuronales de Rostro, Edad y Emoción...',
                modelsReady: '¡Modelos listos! Conectando cámara...',
                thTime: 'Hora',
                thPhoto: 'Foto',
                thAge: 'Edad Estimada',
                thGender: 'Género',
                thResult: 'Resultado',
                thState: 'Estado',
                badgeAllowed: 'PERMITIDO',
                badgeWarning: 'VERIFICAR ID',
                badgeMinor: 'BLOQUEADO',
                emptyHistory: 'Esperando los primeros escaneos faciales...',
                emotions: {
                    happy: '😊 Feliz',
                    sad: '😢 Triste',
                    angry: '😠 Estresado / Enojado',
                    surprised: '😲 Sorprendido',
                    disgusted: '🤢 Disgustado',
                    fearful: '😨 Nervioso / Asustado',
                    neutral: '😐 Neutral'
                }
            },
            en: {
                flag: '🇺🇸',
                searchingFace: 'Scanning for face...',
                pointCamera: 'Point camera at person',
                yearsUnit: 'YEARS',
                waitingFace: 'WAITING FOR CUSTOMER',
                placeClient: 'Place customer in front of lens',
                ageEstimated: 'ESTIMATED AGE',
                genderDetected: 'GENDER',
                aiConfidence: 'AI CONFIDENCE',
                predominantEmotion: 'EMOTION',
                totalScans: 'Total Scans',
                allowed18: 'Allowed (18+)',
                minorsBlocked: 'Minors Blocked',
                checkId: 'Check ID',
                recentScans: 'Recent Biometric Scans Log',
                verdictAllowed: '✅ CONFIRMED ADULT (+18)',
                verdictAllowedSub: 'SALE ALLOWED - ADULT CONFIRMED',
                verdictWarning: '⚠️ AGE DOUBT / BORDERLINE',
                verdictWarningSub: 'APPEARS UNDER {age} - MANDATORY ID CHECK',
                verdictMinor: '🚨 MINOR DETECTED',
                verdictMinorSub: 'DO NOT SERVE - LEGAL ID REQUIRED',
                male: 'Male',
                female: 'Female',
                loadingModels: 'Loading Neural Networks (Age, Gender & Emotion)...',
                modelsReady: 'AI Models Ready! Connecting camera...',
                thTime: 'Time',
                thPhoto: 'Photo',
                thAge: 'Estimated Age',
                thGender: 'Gender',
                thResult: 'Result',
                thState: 'Status',
                badgeAllowed: 'ALLOWED',
                badgeWarning: 'CHECK ID',
                badgeMinor: 'BLOCKED',
                emptyHistory: 'Waiting for first biometric scans...',
                emotions: {
                    happy: '😊 Happy',
                    sad: '😢 Sad',
                    angry: '😠 Stressed / Angry',
                    surprised: '😲 Surprised',
                    disgusted: '🤢 Disgusted',
                    fearful: '😨 Nervous / Fearful',
                    neutral: '😐 Neutral'
                }
            }
        };
    }

    t(key) {
        const dict = this.i18n[this.currentLang] || this.i18n['es'];
        return dict[key] || key;
    }

    getEmotionLabel(emotionKey) {
        const dict = this.i18n[this.currentLang] || this.i18n['es'];
        return (dict.emotions && dict.emotions[emotionKey]) ? dict.emotions[emotionKey] : '😐 Neutral';
    }

    applyLanguageUI() {
        const dict = this.i18n[this.currentLang] || this.i18n['es'];
        
        const flagEl = document.getElementById('langFlag');
        if (flagEl) flagEl.textContent = dict.flag;

        const ageUnit = document.querySelector('.age-unit');
        if (ageUnit) ageUnit.textContent = dict.yearsUnit;

        const labelAge = document.getElementById('labelMetaAge');
        if (labelAge) labelAge.textContent = dict.ageEstimated || 'EDAD ESTIMADA';
        const labelGender = document.getElementById('labelMetaGender');
        if (labelGender) labelGender.textContent = dict.genderDetected || 'GÉNERO';
        const labelConfidence = document.getElementById('labelMetaConfidence');
        if (labelConfidence) labelConfidence.textContent = dict.aiConfidence || 'PRECISIÓN IA';
        const labelExpression = document.getElementById('labelMetaExpression');
        if (labelExpression) labelExpression.textContent = dict.predominantEmotion || 'EMOCIÓN';

        // Stats labels
        const statLabels = document.querySelectorAll('.stat-info .stat-label');
        if (statLabels.length >= 4) {
            statLabels[0].textContent = dict.totalScans;
            statLabels[1].textContent = dict.allowed18;
            statLabels[2].textContent = dict.minorsBlocked;
            statLabels[3].textContent = dict.checkId;
        }

        // History Header
        const histTitle = document.querySelector('.history-header h2');
        if (histTitle) {
            histTitle.innerHTML = `<i class="fa-solid fa-clock-rotate-left"></i> ${dict.recentScans}`;
        }

        this.renderHistory();
        this.resetVerdictState();
    }

    toggleLanguage() {
        this.currentLang = (this.currentLang === 'es') ? 'en' : 'es';
        this.applyLanguageUI();
    }

    initElements() {
        // Status & Verdict Elements
        this.statusBanner = document.getElementById('statusBanner');
        this.statusTitle = document.getElementById('statusTitle');
        this.statusDesc = document.getElementById('statusDesc');
        this.statusIconBox = document.getElementById('statusIconBox');
        this.ageNumber = document.getElementById('ageNumber');
        
        this.decisionCard = document.getElementById('decisionCard');
        this.verdictText = document.getElementById('verdictText');
        this.verdictInstruction = document.getElementById('verdictInstruction');
        this.metaAge = document.getElementById('metaAge');
        this.cornerAgeVal = document.getElementById('cornerAgeVal');
        this.metricGender = document.getElementById('metaGender');
        this.metricConfidence = document.getElementById('metaConfidence');
        this.metaExpression = document.getElementById('metaExpression');
        
        // Stats
        this.statTotal = document.getElementById('statTotalScans') || document.getElementById('statTotal');
        this.statApproved = document.getElementById('statAllowed') || document.getElementById('statApproved');
        this.statWarning = document.getElementById('statCheckId') || document.getElementById('statWarning');
        this.statMinor = document.getElementById('statRejected') || document.getElementById('statMinor');
        this.historyTableBody = document.getElementById('historyTableBody');
        
        // Loaders
        this.viewportLoader = document.getElementById('viewportLoader');
        this.loaderStatusText = document.getElementById('loaderStatusText');
        this.progressBarFill = document.getElementById('progressBarFill');
        
        // Buttons
        this.btnSwitchCamera = document.getElementById('btnSwitchCamera');
        this.btnToggleSound = document.getElementById('btnToggleSound');
        this.btnSettings = document.getElementById('btnSettings');
        this.btnMobileGuide = document.getElementById('btnMobileGuide');
        this.btnClearHistory = document.getElementById('btnClearHistory');
        this.btnGrantCamera = document.getElementById('btnGrantCamera');
        this.btnToggleFullscreen = document.getElementById('btnToggleFullscreen');
        this.btnToggleLang = document.getElementById('btnToggleLang');
        
        // Modals
        this.modalSettings = document.getElementById('modalSettings');
        this.modalMobile = document.getElementById('modalMobile');
    }

    bindEvents() {
        if (this.btnSwitchCamera) {
            this.btnSwitchCamera.addEventListener('click', () => this.toggleCamera());
        }
        if (this.btnToggleSound) {
            this.btnToggleSound.addEventListener('click', () => this.toggleSound());
        }
        
        if (this.btnToggleLang) {
            this.btnToggleLang.addEventListener('click', () => this.toggleLanguage());
        }

        if (this.btnToggleFullscreen) {
            this.btnToggleFullscreen.addEventListener('click', () => this.toggleFullscreen());
        }

        document.addEventListener('fullscreenchange', () => {
            if (!document.fullscreenElement) {
                document.body.classList.remove('is-fullscreen');
                if (this.btnToggleFullscreen) this.btnToggleFullscreen.innerHTML = '<i class="fa-solid fa-expand"></i>';
            } else {
                document.body.classList.add('is-fullscreen');
                if (this.btnToggleFullscreen) this.btnToggleFullscreen.innerHTML = '<i class="fa-solid fa-compress"></i>';
            }
            setTimeout(() => this.resizeCanvas(), 250);
        });

        if (this.btnGrantCamera) {
            this.btnGrantCamera.addEventListener('click', async (e) => {
                e.stopPropagation();
                this.btnGrantCamera.style.display = 'none';
                await this.startCamera();
            });
        }

        const cameraViewport = document.getElementById('cameraViewport');
        if (cameraViewport) {
            cameraViewport.addEventListener('click', async (e) => {
                if (!this.currentStream && !e.target.closest('.viewport-quick-bar') && !e.target.closest('.modal-backdrop')) {
                    if (this.btnGrantCamera) this.btnGrantCamera.style.display = 'none';
                    await this.startCamera();
                }
            });
        }
        
        // Settings Modal
        if (this.btnSettings && this.modalSettings) {
            this.btnSettings.addEventListener('click', () => {
                this.modalSettings.classList.add('show');
            });
        }
        const btnCloseSettings = document.getElementById('btnCloseSettings');
        if (btnCloseSettings && this.modalSettings) {
            btnCloseSettings.addEventListener('click', () => {
                this.modalSettings.classList.remove('show');
            });
        }
        const btnSaveSettings = document.getElementById('btnSaveSettings');
        if (btnSaveSettings) {
            btnSaveSettings.addEventListener('click', () => this.saveSettings());
        }
        
        // Mobile Modal & QR
        if (this.btnMobileGuide && this.modalMobile) {
            this.btnMobileGuide.addEventListener('click', () => {
                this.generateQR();
                this.modalMobile.classList.add('show');
            });
        }
        const btnCloseMobile = document.getElementById('btnCloseMobile');
        if (btnCloseMobile && this.modalMobile) {
            btnCloseMobile.addEventListener('click', () => {
                this.modalMobile.classList.remove('show');
            });
        }
        const btnCloseMobile2 = document.getElementById('btnCloseMobile2');
        if (btnCloseMobile2 && this.modalMobile) {
            btnCloseMobile2.addEventListener('click', () => {
                this.modalMobile.classList.remove('show');
            });
        }
        
        const btnCopyUrl = document.getElementById('btnCopyUrl');
        if (btnCopyUrl) {
            btnCopyUrl.addEventListener('click', () => {
                const urlEl = document.getElementById('mobileUrlDisplay');
                const url = urlEl ? urlEl.innerText : window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    alert('¡Enlace copiado al portapapeles!');
                }).catch(() => {
                    prompt('Copie el enlace:', url);
                });
            });
        }

        if (this.btnClearHistory) {
            this.btnClearHistory.addEventListener('click', () => this.clearHistory());
        }

        const btnExportCSV = document.getElementById('btnExportCSV');
        if (btnExportCSV) {
            btnExportCSV.addEventListener('click', () => this.exportCSV());
        }

        const btnExportJSON = document.getElementById('btnExportJSON');
        if (btnExportJSON) {
            btnExportJSON.addEventListener('click', () => this.exportJSON());
        }

        // Update canvas sizing on window resize
        window.addEventListener('resize', () => this.resizeCanvas());
    }

    async init() {
        try {
            console.log('LiquorGuard: Initializing application...');
            // Wait for faceapi if it is loading asynchronously
            let retries = 0;
            while (typeof faceapi === 'undefined' && retries < 30) {
                await new Promise(r => setTimeout(r, 100));
                retries++;
            }

            if (typeof faceapi === 'undefined') {
                throw new Error('La librería face-api no se cargó correctamente.');
            }

            await this.loadAIModels();
            await this.startCamera();
            this.startDetectionLoop();
        } catch (err) {
            console.error('Error starting app:', err);
            if (this.loaderStatusText) {
                this.loaderStatusText.innerHTML = `
                    <div style="background:rgba(255,0,85,0.15); border:1px solid #ff0055; padding:12px; border-radius:10px; color:#fff;">
                        <strong style="color:#ff0055;"><i class="fa-solid fa-triangle-exclamation"></i> Error al iniciar IA</strong><br>
                        <small style="color:#94a3b8; font-size:12px;">${err.message || 'Comprueba tu conexión a internet o permisos.'}</small><br><br>
                        <button onclick="location.reload(true)" style="background:linear-gradient(135deg, #00f0ff, #0077ff); color:#000; border:none; padding:8px 18px; border-radius:8px; font-weight:800; cursor:pointer;">
                            <i class="fa-solid fa-arrows-rotate"></i> Reintentar
                        </button>
                    </div>
                `;
            }
        }
    }

    async loadAIModels() {
        console.log('LiquorGuard: Loading AI models...');
        if (this.loaderStatusText) this.loaderStatusText.innerText = (this.currentLang === 'en') ? 'Initializing Neural Engines...' : 'Iniciando Redes Neuronales...';
        if (this.progressBarFill) this.progressBarFill.style.width = '15%';

        const candidatePaths = [
            '/liquorguard-assets/models',
            'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights'
        ];

        let loaded = false;
        let lastErr = null;

        for (const modelPath of candidatePaths) {
            try {
                console.log('Trying model path:', modelPath);
                if (this.loaderStatusText) {
                    this.loaderStatusText.innerText = (this.currentLang === 'en') ? 'Loading Face Detection Engine (1/3)...' : 'Cargando Detector de Rostros (1/3)...';
                }
                await faceapi.nets.tinyFaceDetector.loadFromUri(modelPath);
                if (this.progressBarFill) this.progressBarFill.style.width = '45%';

                if (this.loaderStatusText) {
                    this.loaderStatusText.innerText = (this.currentLang === 'en') ? 'Loading Age & Landmarks (2/3)...' : 'Cargando Red de Edad y Puntos (2/3)...';
                }
                await faceapi.nets.faceLandmark68TinyNet.loadFromUri(modelPath);
                await faceapi.nets.ageGenderNet.loadFromUri(modelPath);
                if (this.progressBarFill) this.progressBarFill.style.width = '75%';

                if (this.loaderStatusText) {
                    this.loaderStatusText.innerText = (this.currentLang === 'en') ? 'Loading Emotion Recognition (3/3)...' : 'Cargando Red de Emociones (3/3)...';
                }
                await faceapi.nets.faceExpressionNet.loadFromUri(modelPath);
                if (this.progressBarFill) this.progressBarFill.style.width = '100%';

                loaded = true;
                console.log('AI models loaded successfully from:', modelPath);
                break;
            } catch (err) {
                lastErr = err;
                console.warn('Candidate path failed, trying fallback:', modelPath, err);
            }
        }

        if (!loaded) {
            throw lastErr || new Error('No se pudieron descargar los modelos de IA');
        }

        this.modelsLoaded = true;
        if (this.loaderStatusText) this.loaderStatusText.innerText = this.t('modelsReady');
        setTimeout(() => {
            if (this.viewportLoader) this.viewportLoader.style.display = 'none';
        }, 300);
    }

    async startCamera() {
        // Stop any active streams first
        if (this.currentStream) {
            this.currentStream.getTracks().forEach(track => track.stop());
            this.currentStream = null;
        }
        if (this.video && this.video.srcObject) {
            try {
                this.video.srcObject.getTracks().forEach(track => track.stop());
            } catch (e) {}
            this.video.srcObject = null;
        }

        // Configure video element attributes for aggressive mobile autoplay
        this.video.muted = true;
        this.video.defaultMuted = true;
        this.video.playsInline = true;
        this.video.setAttribute('playsinline', '');
        this.video.setAttribute('webkit-playsinline', '');
        this.video.setAttribute('autoplay', '');

        // Mirror selfie video if front camera
        this.video.style.transform = (this.currentFacingMode === 'user') ? 'scaleX(-1)' : 'scaleX(1)';

        const constraintsList = [
            // 1. Exact facing mode preference
            {
                video: {
                    facingMode: { ideal: this.currentFacingMode },
                    width: { ideal: 1280, max: 1920 },
                    height: { ideal: 720, max: 1080 }
                },
                audio: false
            },
            // 2. Simple facing mode string
            {
                video: { facingMode: this.currentFacingMode },
                audio: false
            },
            // 3. Fallback generic video
            {
                video: true,
                audio: false
            }
        ];

        let stream = null;
        let lastErr = null;

        for (const constraints of constraintsList) {
            try {
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    stream = await navigator.mediaDevices.getUserMedia(constraints);
                    if (stream) break;
                } else if (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia) {
                    const legacy = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                    stream = await new Promise((res, rej) => legacy.call(navigator, constraints, res, rej));
                    if (stream) break;
                }
            } catch (err) {
                lastErr = err;
                console.warn('Constraint attempt failed, trying next:', constraints, err);
            }
        }

        if (!stream) {
            console.error('All camera attempts failed:', lastErr);
            if (this.viewportLoader) this.viewportLoader.style.display = 'none';
            if (this.btnGrantCamera) this.btnGrantCamera.style.display = 'flex';
            if (this.verdictInstruction) {
                this.verdictInstruction.innerText = 'Cámara no detectada o permiso denegado. Toca el botón para activar.';
            }
            return;
        }

        this.currentStream = stream;
        this.video.srcObject = stream;

        // Hide grant button once stream acquired
        if (this.btnGrantCamera) this.btnGrantCamera.style.display = 'none';
        if (this.viewportLoader) this.viewportLoader.style.display = 'none';

        // Wait for video to actually start playing
        await new Promise((resolve) => {
            const onPlaying = () => {
                this.video.removeEventListener('playing', onPlaying);
                this.video.removeEventListener('loadeddata', onPlaying);
                this.resizeCanvas();
                resolve();
            };

            this.video.addEventListener('playing', onPlaying, { once: true });
            this.video.addEventListener('loadeddata', onPlaying, { once: true });

            this.video.play().then(() => {
                this.resizeCanvas();
                resolve();
            }).catch(e => {
                console.warn('Play pending user gesture:', e);
                if (this.btnGrantCamera) this.btnGrantCamera.style.display = 'flex';
                resolve();
            });

            // Timeout safety fallback
            setTimeout(onPlaying, 800);
        });

        this.resizeCanvas();
    }

    async toggleCamera() {
        this.currentFacingMode = (this.currentFacingMode === 'user') ? 'environment' : 'user';
        console.log('Switching camera to:', this.currentFacingMode);
        
        if (this.btnSwitchCamera) {
            this.btnSwitchCamera.style.transform = 'rotate(180deg)';
            setTimeout(() => { this.btnSwitchCamera.style.transform = 'none'; }, 300);
        }

        await this.startCamera();
    }

    toggleSound() {
        this.soundEnabled = !this.soundEnabled;
        if (this.soundEnabled) {
            this.btnToggleSound.classList.add('active');
            this.btnToggleSound.innerHTML = '<i class="fa-solid fa-volume-high"></i>';
        } else {
            this.btnToggleSound.classList.remove('active');
            this.btnToggleSound.innerHTML = '<i class="fa-solid fa-volume-xmark"></i>';
        }
    }

    resizeCanvas() {
        if (this.video.videoWidth > 0 && this.video.videoHeight > 0) {
            this.canvas.width = this.video.videoWidth;
            this.canvas.height = this.video.videoHeight;
        }
    }

    startDetectionLoop() {
        this.isScanning = true;
        
        const runDetection = async () => {
            if (!this.isScanning) return;
            
            if (this.video.readyState === 4 && this.modelsLoaded && this.video.videoWidth > 0) {
                try {
                    const options = new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 });
                    const detections = await faceapi.detectAllFaces(this.video, options)
                        .withFaceLandmarks(true)
                        .withAgeAndGender()
                        .withFaceExpressions();

                    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

                    if (detections && detections.length > 0) {
                        this.processDetections(detections);
                    } else {
                        this.noFaceFrames++;
                        if (this.noFaceFrames >= 10) { // ~1.5s sin rostro para permitir nuevo cliente
                            this.hasLoggedCurrentCustomer = false;
                            this.stableFaceFrames = 0;
                            this.resetVerdictState();
                        }
                    }
                } catch (e) {
                    console.error('Detection frame error:', e);
                }
            }

            setTimeout(runDetection, this.scanIntervalMs);
        };

        runDetection();
    }

    calibrateAge(rawAge) {
        if (!rawAge || isNaN(rawAge)) return 25;
        if (rawAge <= 20) {
            return Math.max(1, rawAge);
        }
        // Face-API age model naturally skews +8 to +12 years high on adults 35-65.
        // Apply smooth biological calibration curve:
        let calibrated = rawAge;
        if (rawAge > 20 && rawAge <= 35) {
            const factor = (rawAge - 20) / 15;
            calibrated = rawAge - (factor * 4.5);
        } else if (rawAge > 35 && rawAge <= 65) {
            const factor = (rawAge - 35) / 30;
            calibrated = (rawAge - 4.5) - (factor * 7.5);
        } else if (rawAge > 65) {
            calibrated = rawAge - 12;
        }
        return Math.max(16, calibrated);
    }

    processDetections(detections) {
        this.noFaceFrames = 0;
        this.stableFaceFrames++;

        // Take the main/largest face
        const primary = detections.reduce((prev, current) => {
            return (prev.detection.box.area > current.detection.box.area) ? prev : current;
        });

        const rawAge = primary.age;
        const calibratedAge = this.calibrateAge(rawAge);
        const isMale = primary.gender === 'male';
        const gender = isMale ? this.t('male') : this.t('female');
        const confidence = Math.round(primary.detection.score * 100);

        // Dominant Emotion Detection (Feliz, Triste, Enojado/Estresado, etc.)
        let dominantEmotion = 'neutral';
        if (primary.expressions) {
            const sortedExp = primary.expressions.asSortedArray();
            if (sortedExp.length > 0 && sortedExp[0].probability > 0.25) {
                dominantEmotion = sortedExp[0].expression;
            }
        }
        const emotionLabel = this.getEmotionLabel(dominantEmotion);

        // Robust moving average with outlier trimming over last 8 frames
        this.lastAgeEstimates.push(calibratedAge);
        if (this.lastAgeEstimates.length > 8) this.lastAgeEstimates.shift();
        const sorted = [...this.lastAgeEstimates].sort((a, b) => a - b);
        const trimmed = sorted.length >= 5 ? sorted.slice(1, -1) : sorted;
        const avgAge = Math.round(trimmed.reduce((a, b) => a + b, 0) / trimmed.length);

        // Classify Status for Liquor Store
        const cautionThreshold = this.legalAge + this.bufferYears;
        let status = 'approved';
        let verdict = '';
        let instruction = '';
        let colorHex = '#00ff88';

        if (avgAge < this.legalAge) {
            status = 'minor';
            verdict = this.t('verdictMinor');
            instruction = this.t('verdictMinorSub');
            colorHex = '#ff0055';
        } else if (avgAge <= cautionThreshold) {
            status = 'warning';
            verdict = this.t('verdictWarning');
            instruction = this.t('verdictWarningSub').replace('{age}', cautionThreshold);
            colorHex = '#ffb800';
        } else {
            status = 'approved';
            verdict = this.t('verdictAllowed');
            instruction = this.t('verdictAllowedSub');
            colorHex = '#00ff88';
        }

        // Draw HUD bounding box on canvas
        this.drawFaceHud(primary.detection.box, avgAge, status, colorHex, emotionLabel);

        // Update UI displays in real time
        this.updateVerdictUI(status, verdict, instruction, avgAge, gender, confidence, emotionLabel);

        // Register EXACTLY 1 scan & photo per customer session once stabilized (~0.8s)
        if (this.stableFaceFrames >= 5 && !this.hasLoggedCurrentCustomer) {
            this.hasLoggedCurrentCustomer = true;
            this.addHistoryRecord(avgAge, gender, status, primary.detection.box);
            this.playAlertSound(status);
        }
    }

    drawFaceHud(box, age, status, color, emotionLabel) {
        const { y, width, height } = box;
        // In mirrored front camera mode, compute horizontal position so text does not mirror
        const x = (this.currentFacingMode === 'user') ? (this.canvas.width - box.x - width) : box.x;
        
        this.ctx.save();
        
        // Bounding box border with futuristic glow
        this.ctx.strokeStyle = color;
        this.ctx.lineWidth = 3;
        this.ctx.shadowColor = color;
        this.ctx.shadowBlur = 15;
        
        // Draw corners
        const cornerLen = Math.min(width, height) * 0.25;
        this.ctx.beginPath();
        // Top Left
        this.ctx.moveTo(x, y + cornerLen);
        this.ctx.lineTo(x, y);
        this.ctx.lineTo(x + cornerLen, y);
        // Top Right
        this.ctx.moveTo(x + width - cornerLen, y);
        this.ctx.lineTo(x + width, y);
        this.ctx.lineTo(x + width, y + cornerLen);
        // Bottom Right
        this.ctx.moveTo(x + width, y + height - cornerLen);
        this.ctx.lineTo(x + width, y + height);
        this.ctx.lineTo(x + width - cornerLen, y + height);
        // Bottom Left
        this.ctx.moveTo(x + cornerLen, y + height);
        this.ctx.lineTo(x, y + height);
        this.ctx.lineTo(x, y + height - cornerLen);
        this.ctx.stroke();

        // Label above face box
        const labelText = `~${age} ${this.t('yearsUnit')} | ${emotionLabel}`;
        this.ctx.font = 'bold 14px "JetBrains Mono", monospace';
        const textWidth = this.ctx.measureText(labelText).width;
        
        this.ctx.fillStyle = 'rgba(6, 9, 15, 0.88)';
        this.ctx.fillRect(x, Math.max(0, y - 28), textWidth + 16, 24);
        
        this.ctx.fillStyle = color;
        this.ctx.fillText(labelText, x + 8, Math.max(17, y - 10));

        this.ctx.restore();
    }

    updateVerdictUI(status, verdict, instruction, age, gender, confidence, emotionLabel) {
        if (this.statusTitle) this.statusTitle.innerText = `${this.t('searchingFace').replace('...', '')}: ~${age} ${this.t('yearsUnit')}`;
        if (this.statusDesc) this.statusDesc.innerText = instruction;
        if (this.ageNumber) this.ageNumber.innerText = age;
        if (this.cornerAgeVal) this.cornerAgeVal.innerText = `~${age}`;
        
        if (this.decisionCard) this.decisionCard.className = `decision-card verdict-${status}`;
        if (this.verdictText) this.verdictText.innerText = verdict;
        if (this.verdictInstruction) this.verdictInstruction.innerText = instruction;
        
        if (this.metaAge) this.metaAge.innerText = `~${age} ${this.t('yearsUnit').toLowerCase()}`;
        if (this.metricGender) this.metricGender.innerText = gender;
        if (this.metricConfidence) this.metricConfidence.innerText = `${confidence}%`;
        if (this.metaExpression) this.metaExpression.innerText = emotionLabel || '😐 Neutral';
    }

    resetVerdictState() {
        this.lastAgeEstimates = [];
        if (this.statusTitle) this.statusTitle.innerText = this.t('searchingFace');
        if (this.statusDesc) this.statusDesc.innerText = this.t('pointCamera');
        if (this.ageNumber) this.ageNumber.innerText = '--';
        if (this.cornerAgeVal) this.cornerAgeVal.innerText = '--';
        
        if (this.decisionCard) this.decisionCard.className = 'decision-card';
        if (this.verdictText) this.verdictText.innerText = this.t('waitingFace');
        if (this.verdictInstruction) this.verdictInstruction.innerText = this.t('placeClient');
        
        if (this.metaAge) this.metaAge.innerText = '--';
        if (this.metricGender) this.metricGender.innerText = '--';
        if (this.metricConfidence) this.metricConfidence.innerText = '--%';
        if (this.metaExpression) this.metaExpression.innerText = '--';
    }

    playAlertSound(status) {
        if (!this.soundEnabled) return;
        const now = Date.now();
        if (this.lastSoundType === status && now - this.lastSoundTime < 2500) return;

        try {
            if (!this.audioCtx) {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                this.audioCtx = new AudioContext();
            }
            if (this.audioCtx.state === 'suspended') {
                this.audioCtx.resume();
            }

            this.lastSoundType = status;
            this.lastSoundTime = now;

            const osc = this.audioCtx.createOscillator();
            const gain = this.audioCtx.createGain();
            osc.connect(gain);
            gain.connect(this.audioCtx.destination);

            if (status === 'minor') {
                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(880, this.audioCtx.currentTime);
                osc.frequency.setValueAtTime(440, this.audioCtx.currentTime + 0.15);
                osc.frequency.setValueAtTime(880, this.audioCtx.currentTime + 0.3);
                gain.gain.setValueAtTime(0.3, this.audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, this.audioCtx.currentTime + 0.5);
                osc.start();
                osc.stop(this.audioCtx.currentTime + 0.5);
            } else if (status === 'warning') {
                osc.type = 'square';
                osc.frequency.setValueAtTime(587.33, this.audioCtx.currentTime);
                gain.gain.setValueAtTime(0.2, this.audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, this.audioCtx.currentTime + 0.3);
                osc.start();
                osc.stop(this.audioCtx.currentTime + 0.3);
            } else {
                osc.type = 'sine';
                osc.frequency.setValueAtTime(523.25, this.audioCtx.currentTime);
                osc.frequency.setValueAtTime(659.25, this.audioCtx.currentTime + 0.1);
                gain.gain.setValueAtTime(0.15, this.audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, this.audioCtx.currentTime + 0.25);
                osc.start();
                osc.stop(this.audioCtx.currentTime + 0.25);
            }
        } catch (e) {
            console.warn('Audio playback not allowed yet:', e);
        }
    }

    addHistoryRecord(age, gender, status, box) {
        let snapshotUrl = '';
        if (this.autoSnap && this.video.videoWidth > 0) {
            try {
                const snapCanvas = document.createElement('canvas');
                snapCanvas.width = 64;
                snapCanvas.height = 64;
                const sCtx = snapCanvas.getContext('2d');
                sCtx.drawImage(this.video, box.x, box.y, box.width, box.height, 0, 0, 64, 64);
                snapshotUrl = snapCanvas.toDataURL('image/jpeg', 0.7);
            } catch (e) {}
        }

        const now = new Date();
        const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        const record = { age, gender, status, timeStr, snapshotUrl };
        this.history.unshift(record);
        if (this.history.length > 20) this.history.pop();

        // Sync to backend DB asynchronously
        if (window.LIQUOR_GUARD_USER) {
            const verdictMap = { 'approved': 'ALLOWED', 'warning': 'CHECK_ID', 'minor': 'REJECTED' };
            fetch('/liquorguard/api/scans/record', {
                method: 'POST',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    age: age,
                    gender: gender,
                    verdict: verdictMap[status] || 'CHECK_ID',
                    confidence: 0.95
                })
            }).catch(e => console.warn('Could not sync scan to database', e));
        }

        // Update stats
        this.stats.total++;
        if (status === 'approved') this.stats.approved++;
        else if (status === 'warning') this.stats.warning++;
        else if (status === 'minor') this.stats.minor++;

        this.renderStats();
        this.renderHistory();
    }

    renderStats() {
        if (this.statTotal) this.statTotal.innerText = this.stats.total;
        if (this.statApproved) this.statApproved.innerText = this.stats.approved;
        if (this.statWarning) this.statWarning.innerText = this.stats.warning;
        if (this.statMinor) this.statMinor.innerText = this.stats.minor;
    }

    renderHistory() {
        if (!this.historyTableBody) return;
        if (this.history.length === 0) {
            this.historyTableBody.innerHTML = `<tr class="empty-row"><td colspan="6">${this.t('emptyHistory')}</td></tr>`;
            return;
        }

        this.historyTableBody.innerHTML = this.history.map(item => {
            const badgeClass = `badge-${item.status}`;
            const badgeText = item.status === 'minor' ? this.t('badgeMinor') : (item.status === 'warning' ? this.t('badgeWarning') : this.t('badgeAllowed'));
            const thumbImg = item.snapshotUrl 
                ? `<img src="${item.snapshotUrl}" style="width:32px;height:32px;border-radius:6px;object-fit:cover;" alt="Face">`
                : `<div style="width:32px;height:32px;border-radius:6px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-user" style="font-size:12px;"></i></div>`;

            return `
                <tr>
                    <td style="font-family: var(--font-mono); font-size: 11px;">${item.timeStr}</td>
                    <td>${thumbImg}</td>
                    <td><strong style="color: var(--accent-cyan);">~${item.age} ${this.t('yearsUnit').toLowerCase()}</strong></td>
                    <td>${item.gender}</td>
                    <td>${item.status === 'minor' ? this.t('badgeMinor') : (item.status === 'warning' ? this.t('badgeWarning') : this.t('badgeAllowed'))}</td>
                    <td><span class="hist-badge ${badgeClass}">${badgeText}</span></td>
                </tr>
            `;
        }).join('');
    }

    clearHistory() {
        this.history = [];
        this.stats = { total: 0, approved: 0, warning: 0, minor: 0 };
        this.renderStats();
        this.renderHistory();
    }

    saveSettings() {
        const inputLegalAge = document.getElementById('cfgMinAge') || document.getElementById('inputLegalAge');
        if (inputLegalAge) {
            this.legalAge = parseInt(inputLegalAge.value) || 18;
        }
        this.soundEnabled = document.getElementById('chkSoundAlerts').checked;
        this.autoSnap = document.getElementById('chkAutoSnap').checked;
        
        if (this.modalSettings) {
            this.modalSettings.classList.remove('show');
            this.modalSettings.style.display = 'none';
        }
    }

    generateQR() {
        const qrCanvas = document.getElementById('qrCanvas');
        const currentUrl = window.location.href;
        const urlDisplay = document.getElementById('mobileUrlDisplay');
        if (urlDisplay) urlDisplay.innerText = currentUrl;

        if (window.QRious && qrCanvas) {
            new QRious({
                element: qrCanvas,
                value: currentUrl,
                size: 180,
                background: '#ffffff',
                foreground: '#090c15'
            });
        }
    }

    exportCSV() {
        if (!this.history || this.history.length === 0) {
            alert('No hay registros de escaneos para exportar.');
            return;
        }
        let csv = 'Hora,Edad,Genero,Resultado\n';
        this.history.forEach(item => {
            csv += `"${item.timeStr}",${item.age},"${item.gender}","${item.status}"\n`;
        });
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `escaneos_liquorguard_${new Date().toISOString().slice(0,10)}.csv`;
        a.click();
        URL.revokeObjectURL(url);
    }

    exportJSON() {
        if (!this.history || this.history.length === 0) {
            alert('No hay registros de escaneos para exportar.');
            return;
        }
        const dataStr = 'data:text/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(this.history, null, 2));
        const a = document.createElement('a');
        a.href = dataStr;
        a.download = `escaneos_liquorguard_${new Date().toISOString().slice(0,10)}.json`;
        a.click();
    }

    toggleFullscreen() {
        const isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement);
        if (!isFullscreen) {
            const docEl = document.documentElement;
            if (docEl.requestFullscreen) {
                docEl.requestFullscreen().catch(() => {});
            } else if (docEl.webkitRequestFullscreen) {
                docEl.webkitRequestFullscreen();
            }
            document.body.classList.add('is-fullscreen');
            if (this.btnToggleFullscreen) {
                this.btnToggleFullscreen.innerHTML = '<i class="fa-solid fa-compress"></i>';
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen().catch(() => {});
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
            document.body.classList.remove('is-fullscreen');
            if (this.btnToggleFullscreen) {
                this.btnToggleFullscreen.innerHTML = '<i class="fa-solid fa-expand"></i>';
            }
        }
        setTimeout(() => this.resizeCanvas(), 300);
    }
}

// Safe bootstrap for immediate and deferred execution
function initLiquorGuardApp() {
    if (!window.liquorGuard) {
        console.log('LiquorGuard: Bootstrapping application instance...');
        window.liquorGuard = new LiquorGuardApp();
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLiquorGuardApp);
} else {
    initLiquorGuardApp();
}
