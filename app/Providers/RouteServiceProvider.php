<?php

namespace App\Providers;

use Core\Routing\Router;
use Core\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutes($this->app->getRouter());
    }

    private function loadRoutes(Router $router): void
    {
        (function () use ($router) {
            require __DIR__ . '/../routes.php';
        })();
    }
}
