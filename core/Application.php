<?php

namespace Core;

use ArrayAccess;
use Core\Routing\Router;

class Application implements ArrayAccess
{
    private array $services = [];

    public function __construct(
        private string $path,
        private Config $config
    ) {
        $this->registerBaseServices();

        $this->registerProviders();
    }

    private function registerBaseServices(): void
    {
        $this->services[ Router::class ] = new Router();
    }

    private function registerProviders(): void
    {
        foreach ($this->config->getProviders() as $provider) {
            $this->instantiateProvider($provider)->register();
        }
    }

    private function instantiateProvider(string $class): ServiceProvider
    {
        return new $class($this);
    }

    public function getTemplatePath(): string
    {
        return $this->getPath('templates');
    }

    private function getPath(string $path = null): string
    {
        return $this->path . ($path ? (DIRECTORY_SEPARATOR . $path) : '');
    }

    public function getEnvironment(): string
    {
        return getenv('APP_ENV') ?: '';
    }

    public function getCachePath(): string
    {
        return $this->getPath('var');
    }

    public function getPublicPath(): string
    {
        return $this->getPath('www');
    }

    public function getRouter(): Router
    {
        return $this->services[ Router::class ];
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->services[ $offset ]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->services[ $offset ];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->services[ $offset ] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->services[ $offset ]);
    }
}
