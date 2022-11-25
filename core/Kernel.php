<?php

namespace Core;

use Core\Routing\Route;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    public function __construct(
        private Application $app,
        private ExceptionHandler $exceptionHandler
    ) {
        //
    }

    public function handle(Request $request): Response
    {
        $response = $this->sendRequest($request);

        return $this->prepareResponse($response);
    }

    private function sendRequest(Request $request): Response|array|string
    {
        try {
            $route = $this->findRoute($request);
        } catch (RuntimeException $exception) {
            return $this->exceptionHandler->render($request, $exception);
        }

        $controller = $this->instantiateController($request, $route);

        return $this->runAction($controller, $route);
    }

    private function findRoute(Request $request): Route
    {
        return $this->app->getRouter()->find(
            $request->getPathInfo(),
            $request->getMethod()
        );
    }

    private function instantiateController(Request $request, Route $route): Controller
    {
        $controller = $route->controller;

        return new $controller($this->app, $request);
    }

    private function runAction(Controller $controller, Route $route): Response|array|string
    {
        $action = $route->action;
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
