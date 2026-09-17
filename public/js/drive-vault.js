/**
 * TaskSua - Drive Vault Module
 * Sube videos POV 4K directamente a Google Drive con OAuth 2.0 (GIS)
 */

const DriveVault = (() => {
    const CONFIG = {
        clientId: window.DRIVE_CLIENT_ID || '',
        folderId: window.DRIVE_FOLDER_ID || '1EJ6QnBrV7qdOvONkhMBJX3wnDyNUPu1A',
        scopes: 'https://www.googleapis.com/auth/drive.file',
        discoveryDoc: 'https://www.googleapis.com/discovery/v1/apis/drive/v3/rest'
    };

    let tokenClient = null;
    let accessToken = null;
    let isReady = false;

    function loadScript(src) {
        return new Promise((resolve, reject) => {
            if (document.querySelector(`script[src="${src}"]`)) { resolve(); return; }
            const s = document.createElement('script');
            s.src = src; s.onload = resolve; s.onerror = reject;
            document.head.appendChild(s);
        });
    }

    async function init(clientId = null) {
        if (clientId) CONFIG.clientId = clientId;
        if (!CONFIG.clientId) { console.error('[DriveVault] Client ID no configurado.'); return false; }

        await loadScript('https://apis.google.com/js/api.js');
        await loadScript('https://accounts.google.com/gsi/client');

        await new Promise((resolve, reject) => gapi.load('client', { callback: resolve, onerror: reject }));
        await gapi.client.init({ discoveryDocs: [CONFIG.discoveryDoc] });

        tokenClient = google.accounts.oauth2.initTokenClient({
            client_id: CONFIG.clientId,
            scope: CONFIG.scopes,
            callback: (response) => {
                if (response.error) return;
                accessToken = response.access_token;
                gapi.client.setToken({ access_token: accessToken });
                sessionStorage.setItem('dvToken', accessToken);
            }
        });

        const saved = sessionStorage.getItem('dvToken');
        if (saved) { accessToken = saved; gapi.client.setToken({ access_token: saved }); }

        isReady = true;
        return true;
    }

    function requestAuth() {
        return new Promise((resolve, reject) => {
            if (!tokenClient) { reject(new Error('tokenClient no inicializado.')); return; }

            tokenClient.callback = (response) => {
                if (response.error) { reject(new Error(response.error)); return; }
                accessToken = response.access_token;
                gapi.client.setToken({ access_token: accessToken });
                sessionStorage.setItem('dvToken', accessToken);
                resolve(accessToken);
            };

            if (accessToken) {
                gapi.client.drive.files.list({ pageSize: 1 })
                    .then(() => resolve(accessToken))
                    .catch(() => {
                        accessToken = null;
                        sessionStorage.removeItem('dvToken');
                        tokenClient.requestAccessToken({ prompt: '' });
                    });
            } else {
                tokenClient.requestAccessToken({ prompt: 'consent' });
            }
        });
    }

    async function uploadVideo(blob, metadata, onProgress = () => {}) {
        if (!isReady) throw new Error('[DriveVault] Módulo no inicializado.');
        await requestAuth();
        if (!accessToken) throw new Error('[DriveVault] Sin token de acceso.');

        const now = new Date();
        const dateStr = now.toISOString().replace(/[:.]/g, '-').slice(0, 19);
        const res = metadata?.resolution?.tier || 'POV';
        const ext = blob.type.includes('mp4') ? 'mp4' : 'webm';
        const filename = `TaskSua_${res}_${dateStr}.${ext}`;

        onProgress(2, 'Preparando subida...');

        const fileMetadata = {
            name: filename,
            parents: [CONFIG.folderId],
            description: `TaskSua POV | ${metadata?.durationFormatted || ''} | ${metadata?.resolution?.width}x${metadata?.resolution?.height} | ${metadata?.sizeMB} MB`
        };

        onProgress(5, 'Iniciando sesión de subida...');

        const initRes = await fetch(
            'https://www.googleapis.com/upload/drive/v3/files?uploadType=resumable',
            {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json',
                    'X-Upload-Content-Type': blob.type,
                    'X-Upload-Content-Length': blob.size
                },
                body: JSON.stringify(fileMetadata)
            }
        );

        if (!initRes.ok) throw new Error(`Error iniciando subida: ${initRes.status}`);
        const uploadUrl = initRes.headers.get('Location');
        if (!uploadUrl) throw new Error('No se recibió URL de subida resumible.');

        onProgress(10, 'Subiendo a Google Drive...');

        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('PUT', uploadUrl, true);
            xhr.setRequestHeader('Content-Type', blob.type);

            xhr.upload.onprogress = (e) => {
                if (e.lengthComputable) {
                    const pct = Math.round(10 + (e.loaded / e.total) * 85);
                    const mb = (e.loaded / 1048576).toFixed(1);
                    const total = (e.total / 1048576).toFixed(1);
                    onProgress(pct, `Subiendo ${mb} / ${total} MB`);
                }
            };

            xhr.onload = async () => {
                if (xhr.status === 200 || xhr.status === 201) {
                    try {
                        const fd = JSON.parse(xhr.responseText);
                        onProgress(97, 'Obteniendo enlace...');
                        const linkRes = await gapi.client.drive.files.get({
                            fileId: fd.id, fields: 'id,name,webViewLink'
                        });
                        onProgress(100, '¡Guardado en Google Drive!');
                        resolve({ id: fd.id, name: filename, webViewLink: linkRes.result.webViewLink });
                    } catch (e) {
                        onProgress(100, '¡Video guardado!');
                        resolve({ id: 'ok', name: filename });
                    }
                } else {
                    reject(new Error(`HTTP ${xhr.status}: ${xhr.responseText.slice(0, 200)}`));
                }
            };
            xhr.onerror = () => reject(new Error('Error de red.'));
            xhr.onabort = () => reject(new Error('Subida cancelada.'));
            xhr.send(blob);
        });
    }

    /**
     * Sube un archivo JSON de metadatos a Drive (sin progreso, es pequeño).
     * @param {Object} jsonData - El objeto de metadatos TaskSua
     * @param {string} filename - Nombre del archivo .json
     */
    async function uploadJson(jsonData, filename) {
        if (!accessToken) return null;
        const blob = new Blob([JSON.stringify(jsonData, null, 2)], { type: 'application/json' });
        const meta = { name: filename, parents: [CONFIG.folderId], mimeType: 'application/json' };

        const form = new FormData();
        form.append('metadata', new Blob([JSON.stringify(meta)], { type: 'application/json' }));
        form.append('file', blob);

        const res = await fetch(
            'https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name',
            { method: 'POST', headers: { 'Authorization': `Bearer ${accessToken}` }, body: form }
        );
        if (!res.ok) return null;
        return await res.json();
    }

    function isAuthenticated() { return !!accessToken; }

    function signOut() {
        if (accessToken) google.accounts.oauth2.revoke(accessToken);
        accessToken = null;
        sessionStorage.removeItem('dvToken');
        gapi.client.setToken(null);
    }

    return { init, requestAuth, uploadVideo, uploadJson, isAuthenticated, signOut, CONFIG };
})();

window.DriveVault = DriveVault;
