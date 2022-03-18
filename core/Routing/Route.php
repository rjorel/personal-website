<?php

namespace Core\Routing;

class Route
{
    private array $variables = [];

    public function __construct(
        public readonly string $uri,
        public readonly string $method,
        public readonly string $controller,
        public readonly string $action
    ) {
        //
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
