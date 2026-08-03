<?php
ob_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

define('LARAVEL_START', microtime(true));

// Catch FATAL errors that try/catch cannot handle
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        while (ob_get_level()) ob_end_clean();
        http_response_code(200);
        header('Content-Type: text/plain; charset=utf-8');
        echo "=== FATAL PHP ERROR ===\n" . $error['message'] . "\nFile: " . $error['file'] . ':' . $error['line'];
    }
});

// Create writable storage dirs in /tmp (Vercel is read-only except /tmp)
foreach ([
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
] as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0777, true);
}

// ============================================================
// ENVIRONMENT VARIABLES
// Priority: Vercel dashboard env vars > these hardcoded defaults
// These ensure Laravel can boot on Vercel even if dashboard envs are missing
// ============================================================
$currentHost = $_SERVER['HTTP_HOST'] ?? 'laundry-ashen-two.vercel.app';
$envConfig = [
    'APP_NAME'             => 'AwnLaundry',
    'APP_ENV'              => 'production',
    'APP_KEY'              => 'base64:Cjbl2K4OKyEvi9rkoLAhERaHjgFDxAkB4Pg3E2Dpl+U=',
    'APP_URL'              => 'https://' . $currentHost,
    // Database (Neon PostgreSQL)
    'DB_CONNECTION'        => 'pgsql',
    'DB_HOST'              => 'ep-bold-wind-axkutgxv.c-4.us-east-2.aws.neon.tech',
    'DB_PORT'              => '5432',
    'DB_DATABASE'          => 'neondb',
    'DB_USERNAME'          => 'neondb_owner',
    'DB_PASSWORD'          => 'npg_k1LtrzsfC2En',
    // Serverless-compatible drivers (FORCED — these must not use file on Vercel)
    'SESSION_DRIVER'       => 'database', // Changed from cookie to database to avoid 419 limits
    'CACHE_STORE'          => 'array',
    'LOG_CHANNEL'          => 'stderr',
    'QUEUE_CONNECTION'     => 'sync',
    'BROADCAST_CONNECTION' => 'log',
    'FILESYSTEM_DISK'      => 'local',
    'MAIL_MAILER'          => 'log',
];

foreach ($envConfig as $key => $value) {
    // For serverless drivers, always force the safe value
    $forceKeys = ['SESSION_DRIVER', 'CACHE_STORE', 'LOG_CHANNEL', 'QUEUE_CONNECTION', 'DB_SSLMODE', 'APP_DEBUG'];
    if (in_array($key, $forceKeys) || !getenv($key)) {
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

$dbUser = getenv('DB_USERNAME') ?: 'neondb_owner';
$dbPass = getenv('DB_PASSWORD') ?: 'npg_k1LtrzsfC2En';
$dbHost = getenv('DB_HOST') ?: 'ep-bold-wind-axkutgxv.c-4.us-east-2.aws.neon.tech';
$dbName = getenv('DB_DATABASE') ?: 'neondb';
$endpointId = explode('.', $dbHost)[0]; // e.g. ep-bold-wind-axkutgxv

// Pass the Neon endpoint ID by hijacking the sslmode parameter.
// This works because Laravel's PostgresConnector blindly concatenates ssl parameters.
// This prevents the "options" query parameter from corrupting Laravel's PDO options array.
$neonSslMode = "require;options=endpoint={$endpointId}";
putenv("DB_SSLMODE={$neonSslMode}");
$_ENV['DB_SSLMODE'] = $neonSslMode;
$_SERVER['DB_SSLMODE'] = $neonSslMode;

// Force overwrite DB_URL without query string parameters
$neonUrl = "pgsql://{$dbUser}:" . rawurlencode($dbPass) . "@{$dbHost}:5432/{$dbName}";
putenv("DB_URL={$neonUrl}");
$_ENV['DB_URL'] = $neonUrl;
$_SERVER['DB_URL'] = $neonUrl;

// ============================================================
// BOOTSTRAP LARAVEL
// ============================================================
try {
    require __DIR__.'/../vendor/autoload.php';

    // Copy bootstrap/cache to writable /tmp location so Laravel can write services.php
    $tmpBootstrap = '/tmp/bootstrap';
    if (!is_dir($tmpBootstrap.'/cache')) {
        mkdir($tmpBootstrap.'/cache', 0777, true);
    }
    // Copy our production packages.php to the writable location
    $pkgSrc = __DIR__.'/../bootstrap/cache/packages.php';
    $pkgDst = $tmpBootstrap.'/cache/packages.php';
    if (file_exists($pkgSrc) && !file_exists($pkgDst)) {
        copy($pkgSrc, $pkgDst);
    }

    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->useBootstrapPath($tmpBootstrap);
    $app->useStoragePath('/tmp/storage');

    ob_end_clean();
    $app->handleRequest(Illuminate\Http\Request::capture());

} catch (\Throwable $e) {
    while (ob_get_level()) ob_end_clean();
    http_response_code(200);
    header('Content-Type: text/plain; charset=utf-8');
    echo "=== LARAVEL EXCEPTION ===\n";
    echo $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . " (line " . $e->getLine() . ")\n\n";
    echo $e->getTraceAsString();
}


