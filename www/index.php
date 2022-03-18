<?php

require __DIR__ . '/../vendor/autoload.php';

use App\AppConfig;
use App\ExceptionHandler;
use Core\Application;
use Core\Kernel;
use Symfony\Component\HttpFoundation\Request;

/**
 * Set debug for development purposes.
 */
if (getenv('APP_DEBUG')) {
    ini_set('display_errors', true);
}

/**
 * Instantiate app.
 */
$app = new Application(
    realpath(__DIR__ . '/..'),
    new AppConfig()
);

/**
 * Handle incoming request.
 */
(new Kernel($app, new ExceptionHandler($app)))
    ->handle(Request::createFromGlobals())
    ->send();
