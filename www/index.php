<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Kernel;
use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

/**
 * Load environment variables.
 */
$dotenv = Dotenv::create(__DIR__ . '/..');
$dotenv->load();

/**
 * Set debug for development purposes.
 */
if (getenv('APP_ENV') == 'local') {
    ini_set('display_errors', true);
}

/**
 * Setup app.
 */
$app = require __DIR__ . '/../bootstrap/app.php';

/**
 * Handle incoming request.
 */
$request = Request::createFromGlobals();

$response = (new Kernel($app))->handle($request);

$response->send();