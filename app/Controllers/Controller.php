<?php

namespace App\Controllers;

use App\Application;
use App\Router;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class Controller
{
    protected $app;
    protected $request;

    public function __construct(Application $app, Request $request)
    {
        $this->app = $app;
        $this->request = $request;
    }

    protected function render($view, array $vars = [])
    {
        return $this->getTwigEnvironment()->render($view, $vars);
    }

    protected function getTwigEnvironment(): Environment
    {
        return $this->app['twig'];
    }

    protected function getRouter(): Router
    {
        return $this->app['router'];
    }
}
