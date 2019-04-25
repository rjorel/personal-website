<?php

use App\Application;

$app = new Application(
    realpath(__DIR__ . '/..')
);

$app['router'] = require __DIR__ . '/router.php';
$app['twig'] = require __DIR__ . '/twig.php';

return $app;