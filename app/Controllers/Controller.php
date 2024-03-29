<?php

namespace App\Controllers;

use Core\Controller as BaseController;
use Twig\Environment as TwigEnvironment;

abstract class Controller extends BaseController
{
    protected function render(string $view, array $vars = []): string
    {
        return $this->app[ TwigEnvironment::class ]->render($view, $vars);
    }
}
