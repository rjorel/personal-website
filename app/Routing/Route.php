<?php

namespace App\Routing;

class Route
{
    private $uri;
    private $method;

    private $controller;
    private $action;

    private $variables = [];

    public function __construct($uri, $method, $controller, $action)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
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