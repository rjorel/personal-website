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
        $route = $this->findRoute($request);

        $controller = $this->instantiateController($request, $route);

        $response = $this->runAction($controller, $route);

        return $this->prepareResponse($response);
    }

    private function findRoute(Request $request)
    {
        return $this->getRouter()->find(
            $request->getRequestUri(), $request->getMethod()
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
                sprintf('No action "%s" for controller "%s"', $action, $controller)
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