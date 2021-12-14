<?php

namespace App\Controllers;

use App\Application;
use App\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class Controller
{
    public function __construct(
        protected Application $app,
        protected Request $request
    ) {
        //
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
