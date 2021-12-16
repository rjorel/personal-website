<?php

namespace App;

use App\Core\Config;
use App\Providers\RouteServiceProvider;
use App\Providers\TwigServiceProvider;

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
