<?php

namespace App\Providers;

use Core\Routing\Router;
use Core\ServiceProvider;

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
