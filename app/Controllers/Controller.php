<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class Controller
{
    private $request;
    private $services;

    public function __construct(Request $request, array $services = [])
    {
        $this->request = $request;
        $this->services = $services;
    }

    protected function render($view, array $vars = [])
    {
        return $this->getTwigEnvironment()->render($view, $vars);
    }

    protected function getTwigEnvironment(): Environment
    {
        return $this->services['twig'];
    }
}
