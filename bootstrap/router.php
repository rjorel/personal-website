<?php

use App\Routing\Route;
use App\Routing\Router;

$router = new Router;

$router->addRoute(new Route('/', 'GET', 'DefaultController', 'index'));
$router->addRoute(new Route('/skills', 'GET', 'DefaultController', 'skills'));
$router->addRoute(new Route('/achievements', 'GET', 'DefaultController', 'achievements'));
$router->addRoute(new Route('/contact', 'GET', 'DefaultController', 'contact'));
$router->addRoute(new Route('/about', 'GET', 'DefaultController', 'about'));
$router->addRoute(new Route('/repository', 'GET', 'DefaultController', 'repository'));

return $router;