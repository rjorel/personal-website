<?php

namespace App;

use App\Core\Application;
use App\Core\ExceptionHandler as BaseExceptionHandler;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment as TwigEnvironment;

class ExceptionHandler implements BaseExceptionHandler
{
    public function __construct(
        private Application $app
    ) {
        //
    }

    public function render(Request $request, Exception $exception): string
    {
        return $this->app[ TwigEnvironment::class ]->render('views/errors/404.html.twig');
    }
}
