<?php

namespace App\Providers;

use App\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutes(
            $router = new Router()
        );

        $this->app['router'] = $router;
    }

    private function loadRoutes(Router $router)
    {
        (function () use ($router) {
            require $this->app->getAppPath() . '/routes.php';
        })();
    }
}