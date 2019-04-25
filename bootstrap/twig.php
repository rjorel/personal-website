<?php

use App\Twig\MixExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');

$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../var',
    'debug' => getenv('APP_ENV') == 'local'
]);

$twig->addExtension(new MixExtension(__DIR__ . '/../www'));

return $twig;