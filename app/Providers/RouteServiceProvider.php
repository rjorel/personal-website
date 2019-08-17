<?php

namespace App\Providers;

use App\Route;
use App\Router;

class RouteServiceProvider extends ServiceProvider
{
    private static $routes = [
        ['/', 'GET', 'DefaultController', 'index'],
        ['/skills', 'GET', 'DefaultController', 'skills'],
        ['/achievements', 'GET', 'DefaultController', 'achievements'],
        ['/about', 'GET', 'DefaultController', 'about'],
        ['/contact', 'GET', 'ContactController', 'index'],
        ['/contact', 'POST', 'ContactController', 'send'],
        ['/repository-file', 'GET', 'RepositoryController', 'getFile'],
        ['/repository(/.*)?', 'GET', 'RepositoryController', 'index'],
        ['/sitemap\.xml', 'GET', 'SitemapController', 'index'],
    ];

    public function register()
    {
        $router = new Router;

        foreach (self::$routes as $route) {
            $router->addRoute(new Route(...$route));
        }

        $this->app['router'] = $router;
    }
}