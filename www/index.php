<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$response = (new Kernel())->handle($request);

$response->send();