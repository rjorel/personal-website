<?php

namespace App;

use App\Controllers\Controller;
use App\Routing\Route;
use App\Routing\Router;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    public function __construct(
        private Application $app
    ) {
        //
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
        } catch (RuntimeException) {
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
        $controller = $route->getController();

        return new $controller($this->app, $request);
    }

    private function runAction(Controller $controller, Route $route)
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

    private function prepareResponse(Response|array|string $response): Response
    {
        if ($response instanceof Response) {
            return $response;
        }

        if (is_array($response)) {
            return new JsonResponse($response);
        }

        return new Response($response);
    }
}
