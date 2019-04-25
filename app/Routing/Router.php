<?php

namespace App\Routing;

use RuntimeException;

class Router
{
    private $routes = [];

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    public function find(string $uri, string $method): Route
    {
        $routes = $this->filterRoutesForUri(
            $this->routes, $uri
        );

        $finalRoutes = $this->filterRoutesForMethod(
            $routes, $method
        );

        if (empty($finalRoutes)) {
            throw new RuntimeException(
                sprintf('No route for URI "%s" (method: %s)', $uri, $method)
            );
        }

        // Return last route, to give a logical priority during route registration.
        return end($finalRoutes);
    }

    private function filterRoutesForUri(array $routes, string $uri): array
    {
        return array_filter($routes, function (Route $route) use ($uri) {
            $regex = $this->formatForRegex(
                $route->getUri()
            );

            if (preg_match($regex, $uri, $matches)) {
                $route->setVariables(array_slice($matches, 1));
                return true;
            }

            return false;
        });
    }

    private function formatForRegex($uri)
    {
        return '/^' . $this->escapeSlashes($uri) . '$/';
    }

    private function escapeSlashes($uri)
    {
        return str_replace('/', '\/', $uri);
    }

    private function filterRoutesForMethod(array $routes, string $method): array
    {
        return array_filter($routes, function (Route $route) use ($method) {
            return $route->getMethod() == $method;
        });
    }
}