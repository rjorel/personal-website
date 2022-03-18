<?php

namespace App;

use App\Providers\RouteServiceProvider;
use App\Providers\TwigServiceProvider;
use Core\Config;

class AppConfig implements Config
{
    public function getProviders(): array
    {
        return [
            RouteServiceProvider::class,
            TwigServiceProvider::class
        ];
    }
}
