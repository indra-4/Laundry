<?php

// Capture all output — prevents warning text from corrupting HTTP response
ob_start();

// Suppress ALL notices/warnings at PHP level before anything loads
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

define('LARAVEL_START', microtime(true));

// Create writable directories in /tmp for Vercel's read-only filesystem
$dirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Register the Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Point Laravel's storage to /tmp
$app->useStoragePath('/tmp/storage');

// Clear the output buffer before Laravel sends the real response
ob_end_clean();

// Handle the request
$app->handleRequest(Illuminate\Http\Request::capture());
