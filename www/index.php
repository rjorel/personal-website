<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

/**
 * Set debug for development purposes.
 */
$debug = true;// getenv('APP_ENV') == 'local';

if ($debug) {
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