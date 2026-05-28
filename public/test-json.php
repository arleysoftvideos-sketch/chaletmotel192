<?php
$path = __DIR__ . '/../storage/app/google-credentials.json';
echo "<h3>Diagnóstico de Credenciales de Google</h3>";
echo "<strong>Ruta del archivo:</strong> " . htmlspecialchars($path) . "<br>";
echo "<strong>¿El archivo existe?:</strong> " . (file_exists($path) ? 'Sí' : 'No') . "<br>";
echo "<strong>¿Es legible por el servidor web?:</strong> " . (is_readable($path) ? 'Sí' : 'No') . "<br>";

$content = @file_get_contents($path);
if ($content === false) {
    echo "<strong>Error:</strong> No se pudo leer el archivo (Fallo al abrir el flujo o permisos denegados).<br>";
} else {
    echo "<strong>Tamaño leído:</strong> " . strlen($content) . " bytes<br>";
    $data = json_decode($content, true);
    if ($data) {
        echo "<strong>JSON Decodificado:</strong> Válido (Contiene " . count($data) . " elementos).<br>";
        echo "<strong>Email de servicio:</strong> " . htmlspecialchars($data['client_email'] ?? 'No definido') . "<br>";
    } else {
        echo "<strong>JSON Decodificado:</strong> <span style='color:red;'>Inválido</span><br>";
        echo "<strong>Error de JSON:</strong> " . json_last_error_msg() . "<br>";
        echo "<strong>Contenido crudo leído:</strong><br>";
        echo "<pre style='background:#f4f4f4; pading:10px; border:1px solid #ccc;'>" . htmlspecialchars($content) . "</pre>";
    }
}
