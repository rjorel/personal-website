<?php

use App\Routing\Route;
use App\Routing\Router;

$router = new Router;

$router->addRoute(new Route('/', 'GET', 'DefaultController', 'index'));
$router->addRoute(new Route('/skills', 'GET', 'DefaultController', 'skills'));
$router->addRoute(new Route('/achievements', 'GET', 'DefaultController', 'achievements'));
$router->addRoute(new Route('/about', 'GET', 'DefaultController', 'about'));

$router->addRoute(new Route('/contact', 'GET', 'ContactController', 'index'));
$router->addRoute(new Route('/contact', 'POST', 'ContactController', 'send'));

$router->addRoute(new Route('/repository', 'GET', 'RepositoryController', 'index'));
$router->addRoute(new Route('/repository/file', 'GET', 'RepositoryController', 'file'));

$router->addRoute(new Route('/sitemap', 'GET', 'SitemapController', 'index'));

return $router;