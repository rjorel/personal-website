<?php

namespace App;

use App\Routing\Route;
use App\Routing\Router;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request): Response
    {
        $response = $this->sendRequest($request);

        return $this->prepareResponse($response);
    }

    private function sendRequest(Request $request)
    {
        try {
            $route = $this->findRoute($request);
        } catch (RuntimeException $e) {
            return $this->app['twig']->render('views/errors/404.html.twig');
        }

        $controller = $this->instantiateController($request, $route);

        return $this->runAction($controller, $route);
    }

    private function findRoute(Request $request)
    {
        return $this->getRouter()->find(
            $request->getPathInfo(), $request->getMethod()
        );
    }

    private function getRouter(): Router
    {
        return $this->app['router'];
    }

    private function instantiateController(Request $request, Route $route)
    {
        $controller = $this->getControllerClass(
            $route->getController()
        );

        return new $controller($this->app, $request);
    }

    private function getControllerClass(string $controller): string
    {
        return 'App\\Controllers\\' . $controller;
    }

    private function runAction($controller, Route $route)
    {
        $action = $route->getAction();
        $vars = $route->getVariables();

        if (!method_exists($controller, $action)) {
            throw new RuntimeException(
                sprintf('No action "%s" for controller "%s"', $action, get_class($controller))
            );
        }

        return $controller->$action(...$vars);
    }

    private function prepareResponse($response)
    {
        if (is_array($response)) {
            return new JsonResponse($response);
        }

        return new Response($response);
    }
}