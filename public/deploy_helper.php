<?php
// deploy_helper.php
$secret = 'Arley_20260525_$';
if (!isset($_GET['token']) || $_GET['token'] !== $secret) {
    header('HTTP/1.1 403 Forbidden');
    echo "Access denied.";
    exit;
}

header('Content-Type: text/plain; charset=utf-8');

echo "=== INICIANDO DESPLIEGUE DESDE PHP ===\n\n";

// Directorio del proyecto (un nivel arriba de public/)
$project_dir = dirname(__DIR__);
chdir($project_dir);
echo "Directorio actual: " . getcwd() . "\n\n";

echo "--- RESETEANDO CAMBIOS LOCALES EN EL SERVIDOR ---\n";
$output_reset = shell_exec("git reset --hard 2>&1");
echo $output_reset . "\n";

echo "--- LIMPIANDO ARCHIVOS NO RASTREADOS ---\n";
$output_clean = shell_exec("git clean -fd 2>&1");
echo $output_clean . "\n";

echo "--- EJECUTANDO GIT PULL ---\n";
$output_git = shell_exec("git pull origin main 2>&1");
echo $output_git . "\n";

echo "--- EJECUTANDO MIGRACIONES ---\n";
$output_migrate = shell_exec("php artisan migrate --force 2>&1");
echo $output_migrate . "\n";

echo "--- LIMPIANDO CACHE ---\n";
$output_cache = shell_exec("php artisan config:clear 2>&1 && php artisan route:clear 2>&1");
echo $output_cache . "\n";

echo "\n=== PROCESO COMPLETADO ===";
