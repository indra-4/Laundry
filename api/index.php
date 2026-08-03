<?php
ob_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

define('LARAVEL_START', microtime(true));

// Catch FATAL errors (out of memory, parse error, etc.) that try/catch cannot catch
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        while (ob_get_level()) ob_end_clean();
        http_response_code(200);
        header('Content-Type: text/plain; charset=utf-8');
        echo "=== FATAL PHP ERROR ===\n";
        echo $error['message'] . "\n";
        echo "File: " . $error['file'] . " (line " . $error['line'] . ")\n";
    }
});

// Create writable dirs in /tmp (Vercel filesystem is read-only)
foreach ([
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
] as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0777, true);
}

// Force serverless-compatible env vars
foreach ([
    'SESSION_DRIVER'       => 'cookie',
    'CACHE_STORE'          => 'array',
    'LOG_CHANNEL'          => 'stderr',
    'QUEUE_CONNECTION'     => 'sync',
    'BROADCAST_CONNECTION' => 'log',
    'FILESYSTEM_DISK'      => 'local',
] as $k => $v) {
    putenv("$k=$v"); $_ENV[$k] = $v; $_SERVER[$k] = $v;
}

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

