<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application;
use App\Kernel;
use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

/**
 * Load environment variables.
 */
(Dotenv::create(__DIR__ . '/..'))->safeLoad();

/**
 * Set debug for development purposes.
 */
if (getenv('APP_ENV') == 'local') {
    ini_set('display_errors', true);
}

/**
 * Instantiate app.
 */
$app = new Application(
    realpath(__DIR__ . '/..')
);

/**
 * Handle incoming request.
 */
$request = Request::createFromGlobals();

$response = (new Kernel($app))->handle($request);

$response->send();