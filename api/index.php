<?php

// Buffer ALL output so no stray bytes corrupt HTTP headers
ob_start();

// Kill deprecated/notice output at PHP level
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

define('LARAVEL_START', microtime(true));

// --- VERCEL WRITABLE STORAGE ---
// Vercel filesystem is read-only except /tmp
foreach ([
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// --- FORCE CORRECT ENV FOR SERVERLESS ---
// These override any wrong values to ensure serverless-compatible config
$forceEnv = [
    'SESSION_DRIVER'       => 'cookie',
    'CACHE_STORE'          => 'array',
    'LOG_CHANNEL'          => 'stderr',
    'QUEUE_CONNECTION'     => 'sync',
    'BROADCAST_CONNECTION' => 'log',
    'FILESYSTEM_DISK'      => 'local',
];
foreach ($forceEnv as $k => $v) {
    putenv("$k=$v");
    $_ENV[$k] = $v;
    $_SERVER[$k] = $v;
}

// --- BOOTSTRAP LARAVEL ---
require __DIR__.'/../vendor/autoload.php';

try {
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->useStoragePath('/tmp/storage');

    // Discard any stray output (deprecation warnings etc.) before sending response
    ob_end_clean();

    $app->handleRequest(Illuminate\Http\Request::capture());

} catch (\Throwable $e) {
    // Use 200 so Vercel doesn't intercept and hide the real error text
    ob_end_clean();
    http_response_code(200);
    header('Content-Type: text/plain; charset=utf-8');
    echo "=== LARAVEL ERROR ===\n";
    echo $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . " (line " . $e->getLine() . ")\n\n";
    echo $e->getTraceAsString();
}

