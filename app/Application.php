<?php

namespace App;

use App\Core\Application as BaseApplication;
use App\Providers\RouteServiceProvider;
use App\Providers\TwigServiceProvider;

class Application extends BaseApplication
{
    protected static array $providers = [
        RouteServiceProvider::class,
        TwigServiceProvider::class
    ];
}
