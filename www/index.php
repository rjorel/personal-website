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
 * Define app services.
 */
$services = [
    'router' => require __DIR__ . '/../bootstrap/router.php',
    'twig'   => require __DIR__ . '/../bootstrap/twig.php'
];

/**
 * Handle incoming request.
 */
$request = Request::createFromGlobals();

$response = (new Kernel($services))->handle($request);

$response->send();