<?php

/**
 * Vercel Serverless Function Entry Point for Laravel
 * 
 * This file serves as the entry point for Vercel serverless functions
 * and routes all requests to the Laravel application.
 */

// Set the base path
$basePath = dirname(__DIR__);

// Handle CORS headers
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    http_response_code(200);
    exit;
}

// Define the application's public directory
define('LARAVEL_START', microtime(true));

// Require the Laravel autoloader
require_once $basePath . '/vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once $basePath . '/bootstrap/app.php';

// Handle the request
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = \Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
