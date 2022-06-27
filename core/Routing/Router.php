<?php

namespace Core\Routing;

use RuntimeException;

class Router
{
    private array $routesByMethod = [];

    public function addRoute(string $method, string $uri, string $controller, string $action): void
    {
        $this->addRouteForMethod(new Route($uri, $controller, $action), $method);
    }

    private function addRouteForMethod(Route $route, string $method): void
    {
        $this->routesByMethod[ $this->normalizeMethod($method) ][] = $route;
    }

    private function normalizeMethod(string $method): string
    {
        return strtolower($method);
    }

    public function getRoutes(): array
    {
        return array_merge(...array_values($this->routesByMethod));
    }

    public function find(string $uri, string $method): Route
    {
        $route = $this->findRouteByUri(
            $this->getRoutesForMethod($method),
            $uri
        );

        if (!$route) {
            throw new RuntimeException("No route for URI \"{$uri}\" (method: \"{$method}\")");
        }

        return $route;
    }

    private function getRoutesForMethod(string $method): array
    {
        return $this->routesByMethod[ $this->normalizeMethod($method) ];
    }

    private function findRouteByUri(array $routes, string $uri): ?Route
    {
        $matchingRoutes = array_filter($routes, function (Route $route) use ($uri) {
            if (preg_match($this->getUriRegex($route->uri), $uri, $matches)) {
                $route->setVariables(array_slice($matches, 1));
                return true;
            }

            return false;
        });

        // Return first route, to give a logical priority during route registration.
        return array_shift($matchingRoutes);
    }

    private function getUriRegex(string $uri): string
    {
        return '/^' . preg_quote($uri, '/') . '$/';
    }
}
