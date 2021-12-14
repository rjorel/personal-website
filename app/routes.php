<?php

use App\Controllers\DefaultController;
use App\Controllers\RepositoryController;
use App\Controllers\SitemapController;
use App\Core\Routing\Router;

/** @var Router $router */
$router->get('/', DefaultController::class, 'index');
$router->get('/skills', DefaultController::class, 'skills');
$router->get('/achievements', DefaultController::class, 'achievements');
$router->get('/about', DefaultController::class, 'about');
$router->get('/repository-file', RepositoryController::class, 'getFile');
$router->get('/repository', RepositoryController::class, 'index');
$router->get('/sitemap\.xml', SitemapController::class, 'index');
