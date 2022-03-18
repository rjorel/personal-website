<?php

use App\Controllers\DefaultController;
use App\Controllers\RepositoryController;
use App\Controllers\SitemapController;
use Core\Routing\Router;

/** @var Router $router */
$router->addRoute('GET', '/', DefaultController::class, 'index');
$router->addRoute('GET', '/skills', DefaultController::class, 'skills');
$router->addRoute('GET', '/achievements', DefaultController::class, 'achievements');
$router->addRoute('GET', '/about', DefaultController::class, 'about');
$router->addRoute('GET', '/repository-file', RepositoryController::class, 'getFile');
$router->addRoute('GET', '/repository', RepositoryController::class, 'index');
$router->addRoute('GET', '/sitemap\.xml', SitemapController::class, 'index');
