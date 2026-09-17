/**
 * TaskSua - Motor de Captura POV 4K (Ultra HD POV Capture Engine)
 * Fase 1: Núcleo de Captura 4K con forzado automático, fallbacks y feedback de audio.
 */

class PovCaptureEngine {
    constructor(config = {}) {
        this.videoElement = config.videoElement || document.getElementById('povPreview');
        this.onStateChange = config.onStateChange || (() => {});
        this.onStreamReady = config.onStreamReady || (() => {});
        this.onRecordingComplete = config.onRecordingComplete || (() => {});
        this.onTimeUpdate = config.onTimeUpdate || (() => {});
        this.onAudioLevel = config.onAudioLevel || (() => {});

        this.stream = null;
        this.mediaRecorder = null;
        this.recordedChunks = [];
        this.state = 'idle'; // idle | streaming | recording | paused
        this.startTime = null;
        this.elapsedTime = 0;
        this.timerInterval = null;
        this.audioContext = null;
        this.audioAnalyser = null;
        this.audioDataArray = null;
        this.audioAnimFrame = null;
        this.selectedDeviceId = null;
        this.activeResolution = { width: 0, height: 0, fps: 0, label: 'Detectando...' };

        // Inicializar Audio Context para beeps sonoros
        this.initAudioFeedback();
    }

    /**
     * Web Audio API: Sonidos de aviso para operador con teléfono en arnés
     */
    initAudioFeedback() {
        try {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (AudioCtx) {
                this.audioContext = new AudioCtx();
            }
        } catch (e) {
            console.warn('Web Audio no soportado para feedback sonoro:', e);
        }
    }

    playBeep(type = 'start') {
        if (!this.audioContext) return;
        if (this.audioContext.state === 'suspended') {
            this.audioContext.resume();
        }

        const now = this.audioContext.currentTime;
        const osc = this.audioContext.createOscillator();
        const gain = this.audioContext.createGain();
        osc.connect(gain);
        gain.connect(this.audioContext.destination);

        if (type === 'start') {
            // Beep ascendente claro: Comienza grabación (880Hz -> 1320Hz)
            osc.frequency.setValueAtTime(880, now);
            osc.frequency.exponentialRampToValueAtTime(1320, now + 0.18);
            gain.gain.setValueAtTime(0.3, now);
            gain.gain.exponentialRampToValueAtTime(0.01, now + 0.22);
            osc.start(now);
            osc.stop(now + 0.22);
        } else if (type === 'pause') {
            // Doble beep medio: Pausado
            osc.frequency.setValueAtTime(660, now);
            gain.gain.setValueAtTime(0.2, now);
            gain.gain.exponentialRampToValueAtTime(0.01, now + 0.15);
            osc.start(now);
            osc.stop(now + 0.15);
        } else if (type === 'stop') {
            // Beep descendente: Toma finalizada (1100Hz -> 440Hz)
            osc.frequency.setValueAtTime(1100, now);
            osc.frequency.exponentialRampToValueAtTime(440, now + 0.28);
            gain.gain.setValueAtTime(0.3, now);
            gain.gain.exponentialRampToValueAtTime(0.01, now + 0.3);
            osc.start(now);
            osc.stop(now + 0.3);
        }
    }

    /**
     * Forzado 4K inteligente enfocado en Cámara 1 Trasera (Back)
     */
    async startCamera(deviceId = null, targetResolutionMode = '4k') {
        if (this.stream) {
            this.stopCamera();
        }

        // Si no se especificó deviceId, buscar automáticamente la Cámara 1 Trasera (Back)
        if (!deviceId) {
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                const videoDevices = devices.filter(d => d.kind === 'videoinput');
                const backCamera = videoDevices.find(d => {
                    const l = d.label.toLowerCase();
                    return l.includes('back') || l.includes('trasera') || l.includes('0, facing back') || l.includes('rear') || l.includes('environment');
                });
                if (backCamera) {
                    this.selectedDeviceId = backCamera.deviceId;
                }
            } catch (e) {
                console.warn('Error detectando cámara trasera principal:', e);
            }
        } else {
            this.selectedDeviceId = deviceId;
        }

        this.targetResMode = targetResolutionMode;

        // Constraints estrictos para 4K en Cámara Trasera 1
        const attempts = [
            // Intento 1: Cámara trasera 1 en 4K UHD
            {
                video: {
                    deviceId: this.selectedDeviceId ? { exact: this.selectedDeviceId } : undefined,
                    facingMode: this.selectedDeviceId ? undefined : { ideal: 'environment' },
                    width: { ideal: 3840, min: 1920 },
                    height: { ideal: 2160, min: 1080 },
                    frameRate: { ideal: 60, min: 30 }
                }
            },
            // Intento 2: Ideal 4K sin restricciones mínimas
            {
                video: {
                    deviceId: this.selectedDeviceId ? { exact: this.selectedDeviceId } : undefined,
                    facingMode: this.selectedDeviceId ? undefined : { ideal: 'environment' },
                    width: { ideal: 3840 },
                    height: { ideal: 2160 }
                }
            },
            // Intento 3: Trasera directa
            {
                video: {
                    deviceId: this.selectedDeviceId ? { exact: this.selectedDeviceId } : undefined,
                    facingMode: this.selectedDeviceId ? undefined : 'environment'
                }
            }
        ];

        let lastError = null;
        for (const attempt of attempts) {
            try {
                const constraints = {
                    video: attempt.video,
                    audio: {
                        echoCancellation: true,
                        noiseSuppression: true,
                        autoGainControl: true,
                        sampleRate: 48000
                    }
                };

                this.stream = await navigator.mediaDevices.getUserMedia(constraints);
                break;
            } catch (err) {
                lastError = err;
                console.warn('Fallo en intento de constraint, probando más flexible:', err);
            }
        }

        if (!this.stream) {
            throw lastError || new Error('No se pudo acceder a la cámara.');
        }

        // Si la cámara admite applyConstraints y capacidades máximas, intentamos elevarla al tope
        const videoTrack = this.stream.getVideoTracks()[0];
        if (videoTrack && typeof videoTrack.getCapabilities === 'function') {
            try {
                const caps = videoTrack.getCapabilities();
                console.log('Capacidades de hardware reportadas por el sensor:', caps);
                if (caps.width && caps.width.max && (targetResolutionMode === '4k' || targetResolutionMode === 'auto')) {
                    const maxWidth = Math.min(3840, caps.width.max);
                    const maxHeight = Math.min(2160, caps.height ? caps.height.max : 2160);
                    await videoTrack.applyConstraints({
                        width: { ideal: maxWidth },
                        height: { ideal: maxHeight }
                    }).catch(e => console.warn('applyConstraints no aplicado:', e));
                }
            } catch (e) {
                console.warn('Error leyendo capacidades:', e);
            }
        }

        this.videoElement.srcObject = this.stream;
        await this.videoElement.play().catch(e => console.log('Autoplay handled:', e));

        // Inspeccionar resolución real adquirida
        this.detectActualStreamResolution();

        // Conectar Analizador de Audio en vivo para VU Meter
        this.setupAudioMeter();

        this.state = 'streaming';
        this.onStateChange(this.state);
        this.onStreamReady(this.activeResolution, this.stream);

        return this.activeResolution;
    }

    detectActualStreamResolution() {
        if (!this.stream) return;
        const videoTrack = this.stream.getVideoTracks()[0];
        if (!videoTrack) return;

        const settings = videoTrack.getSettings ? videoTrack.getSettings() : {};
        const width = settings.width || this.videoElement.videoWidth || 0;
        const height = settings.height || this.videoElement.videoHeight || 0;
        const fps = Math.round(settings.frameRate || 30);

        let label = `${width}×${height} (${fps}fps)`;
        let tier = 'SD (Baja Resolución)';
        let tierCode = 'sd';

        if (width >= 3800 || height >= 2100) {
            tier = '4K Ultra HD';
            tierCode = '4k';
        } else if (width >= 2500 || height >= 1400) {
            tier = '2.5K QHD';
            tierCode = '2.5k';
        } else if (width >= 1900 || height >= 1000) {
            tier = '1080p Full HD';
            tierCode = '1080p';
        } else if (width >= 1200 || height >= 700) {
            tier = '720p HD';
            tierCode = '720p';
        }

        this.activeResolution = { width, height, fps, label, tier, tierCode };
    }

    setupAudioMeter() {
        try {
            if (!this.audioContext) this.initAudioFeedback();
            if (!this.audioContext) return;

            const audioTrack = this.stream.getAudioTracks()[0];
            if (!audioTrack) return;

            const source = this.audioContext.createMediaStreamSource(new MediaStream([audioTrack]));
            this.audioAnalyser = this.audioContext.createAnalyser();
            this.audioAnalyser.fftSize = 64;
            source.connect(this.audioAnalyser);

            this.audioDataArray = new Uint8Array(this.audioAnalyser.frequencyBinCount);

            const checkAudio = () => {
                if (this.state === 'idle') return;
                this.audioAnalyser.getByteFrequencyData(this.audioDataArray);
                let sum = 0;
                for (let i = 0; i < this.audioDataArray.length; i++) {
                    sum += this.audioDataArray[i];
                }
                const average = sum / this.audioDataArray.length;
                const normalized = Math.min(100, Math.round((average / 128) * 100));
                this.onAudioLevel(normalized);
                this.audioAnimFrame = requestAnimationFrame(checkAudio);
            };
            checkAudio();
        } catch (e) {
            console.warn('No se pudo inicializar el monitor de audio:', e);
        }
    }

    /**
     * Iniciar Grabación con MediaRecorder de alta fidelidad
     */
    startRecording() {
        if (!this.stream) throw new Error('No hay stream de video activo');
        if (this.state === 'recording') return;

        this.recordedChunks = [];

        // Detectar mejor MIME type compatible con ultra alta definición
        const mimeTypes = [
            'video/mp4;codecs=avc1,mp4a.40.2',
            'video/mp4',
            'video/webm;codecs=vp9,opus',
            'video/webm;codecs=vp8,opus',
            'video/webm'
        ];

        let selectedMime = '';
        for (const mime of mimeTypes) {
            if (MediaRecorder.isTypeSupported(mime)) {
                selectedMime = mime;
                break;
            }
        }

        // Bitrate alto optimizado para 4K (25 Mbps) o 1080p (12 Mbps)
        const is4K = this.activeResolution.width >= 3000;
        const targetBits = is4K ? 25000000 : 12000000;

        const options = {
            mimeType: selectedMime || undefined,
            videoBitsPerSecond: targetBits,
            audioBitsPerSecond: 192000
        };

        try {
            this.mediaRecorder = new MediaRecorder(this.stream, options);
        } catch (e) {
            console.warn('Opciones estrictas de MediaRecorder fallaron, usando defaults:', e);
            this.mediaRecorder = new MediaRecorder(this.stream);
        }

        this.mediaRecorder.ondataavailable = (event) => {
            if (event.data && event.data.size > 0) {
                this.recordedChunks.push(event.data);
            }
        };

        this.mediaRecorder.onstop = () => {
            this.handleRecordingStop();
        };

        // Emitir trozo cada 1 segundo (permite streaming & protección de vault)
        this.mediaRecorder.start(1000);

        this.state = 'recording';
        this.startTime = Date.now() - this.elapsedTime;
        this.startTimer();
        this.playBeep('start');
        this.onStateChange(this.state);
    }

    pauseRecording() {
        if (this.mediaRecorder && this.state === 'recording') {
            this.mediaRecorder.pause();
            this.state = 'paused';
            clearInterval(this.timerInterval);
            this.playBeep('pause');
            this.onStateChange(this.state);
        }
    }

    resumeRecording() {
        if (this.mediaRecorder && this.state === 'paused') {
            this.mediaRecorder.resume();
            this.state = 'recording';
            this.startTime = Date.now() - this.elapsedTime;
            this.startTimer();
            this.playBeep('start');
            this.onStateChange(this.state);
        }
    }

    stopRecording() {
        if (this.mediaRecorder && (this.state === 'recording' || this.state === 'paused')) {
            this.mediaRecorder.stop();
            this.state = 'streaming';
            clearInterval(this.timerInterval);
            this.playBeep('stop');
            this.onStateChange(this.state);
        }
    }

    handleRecordingStop() {
        const mimeType = this.mediaRecorder.mimeType || 'video/webm';
        const blob = new Blob(this.recordedChunks, { type: mimeType });
        const sizeBytes = blob.size;
        const sizeMB = (sizeBytes / (1024 * 1024)).toFixed(2);
        const durationSec = Math.round(this.elapsedTime / 1000);

        const metadata = {
            durationSeconds: durationSec,
            durationFormatted: this.formatTime(this.elapsedTime),
            resolution: this.activeResolution,
            sizeBytes: sizeBytes,
            sizeMB: sizeMB,
            mimeType: mimeType,
            timestamp: new Date().toISOString(),
            chunksCount: this.recordedChunks.length
        };

        // ── Liberar RAM del dispositivo: los chunks ya no son necesarios ──
        // El blob será enviado a Drive y luego también liberado allá
        this.recordedChunks = [];

        // Reset temporizador
        this.elapsedTime = 0;
        this.startTime = null;
        this.onTimeUpdate(this.formatTime(0), 0);

        // Notificar callback
        this.onRecordingComplete(blob, metadata);
    }

    startTimer() {
        clearInterval(this.timerInterval);
        this.timerInterval = setInterval(() => {
            this.elapsedTime = Date.now() - this.startTime;
            this.onTimeUpdate(this.formatTime(this.elapsedTime), this.elapsedTime);
        }, 200);
    }

    formatTime(ms) {
        const totalSeconds = Math.floor(ms / 1000);
        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;

        const pad = (num) => String(num).padStart(2, '0');
        if (hours > 0) {
            return `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
        }
        return `${pad(minutes)}:${pad(seconds)}`;
    }

    stopCamera() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
            this.stream = null;
        }
        if (this.audioAnimFrame) {
            cancelAnimationFrame(this.audioAnimFrame);
        }
        this.state = 'idle';
        this.onStateChange(this.state);
    }

    static async getAvailableCameras() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            return devices.filter(d => d.kind === 'videoinput').map((d, index) => ({
                deviceId: d.deviceId,
                label: d.label || `Cámara ${index + 1} ${index === 0 ? '(Principal / Trasera)' : ''}`
            }));
        } catch (e) {
            console.warn('Error enumerando cámaras:', e);
            return [];
        }
    }
}

window.PovCaptureEngine = PovCaptureEngine;
