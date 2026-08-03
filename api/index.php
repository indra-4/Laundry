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
// Only sets a value if it's not already defined by Vercel
// ============================================================
$envConfig = [
    // App
    'APP_NAME'             => 'AwnLaundry',
    'APP_ENV'              => 'production',
    'APP_KEY'              => 'base64:Cjbl2K4OKyEvi9rkoLAhERaHjgFDxAkB4Pg3E2Dpl+U=',
    'APP_DEBUG'            => 'true',
    'APP_URL'              => 'https://laundry-ashen-two.vercel.app',
    // Database (Neon PostgreSQL)
    'DB_CONNECTION'        => 'pgsql',
    'DB_HOST'              => 'ep-bold-wind-axkutgxv.c-4.us-east-2.aws.neon.tech',
    'DB_PORT'              => '5432',
    'DB_DATABASE'          => 'neondb',
    'DB_USERNAME'          => 'neondb_owner',
    'DB_PASSWORD'          => 'npg_k1LtrzsfC2En',
    // Serverless-compatible drivers (FORCED — these must not use file/database on Vercel)
    'SESSION_DRIVER'       => 'cookie',
    'CACHE_STORE'          => 'array',
    'LOG_CHANNEL'          => 'stderr',
    'QUEUE_CONNECTION'     => 'sync',
    'BROADCAST_CONNECTION' => 'log',
    'FILESYSTEM_DISK'      => 'local',
    'MAIL_MAILER'          => 'log',
];

foreach ($envConfig as $key => $value) {
    // For serverless drivers, always force the safe value
    $forceKeys = ['SESSION_DRIVER', 'CACHE_STORE', 'LOG_CHANNEL', 'QUEUE_CONNECTION', 'APP_DEBUG'];
    if (in_array($key, $forceKeys) || !getenv($key)) {
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// ============================================================
// BOOTSTRAP LARAVEL
// ============================================================
try {
    require __DIR__.'/../vendor/autoload.php';

    $app = require_once __DIR__.'/../bootstrap/app.php';
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


