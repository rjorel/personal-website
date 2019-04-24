<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Kernel;
use App\Twig\MixExtension;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Set debug for development purposes.
 */
$debug = true;// getenv('APP_ENV') == 'local';

if ($debug) {
    ini_set('display_errors', true);
}

/**
 * Setup twig.
 */
$loader = new FilesystemLoader(__DIR__ . '/../templates');

$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../var',
    'debug' => $debug
]);

$twig->addExtension(new MixExtension(__DIR__ . '/../www'));

/**
 * Handle incoming request.
 */
$request = Request::createFromGlobals();

$response = (new Kernel($twig))->handle($request);

$response->send();