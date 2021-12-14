<?php

namespace App\Providers;

use App\Core\Routing\Router;
use App\Core\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutes($this->app->getRouter());
    }

    private function loadRoutes(Router $router)
    {
        (function () use ($router) {
            require __DIR__ . '/../routes.php';
        })();
    }
}
