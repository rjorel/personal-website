<?php

namespace App\Routing;

class Route
{
    private array $variables = [];

    public function __construct(
        private string $uri,
        private string $method,
        private string $controller,
        private string $action
    ) {
        //
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }

    public function setVariables(array $variables)
    {
        $this->variables = $variables;
    }
}
