<?php

namespace App;

use App\Providers\RouteServiceProvider;
use App\Providers\ServiceProvider;
use App\Providers\TwigServiceProvider;
use ArrayAccess;

class Application implements ArrayAccess
{
    private static $providers = [
        RouteServiceProvider::class,
        TwigServiceProvider::class
    ];

    private array $services = [];

    public function __construct(
        private string $path
    ) {
        $this->boot();
    }

    private function boot()
    {
        foreach (self::$providers as $provider) {
            $this->instantiateProvider($provider)->register();
        }
    }

    private function instantiateProvider($class): ServiceProvider
    {
        return new $class($this);
    }

    public function getAppPath()
    {
        return $this->getPath('app');
    }

    private function getPath($path = null)
    {
        return $this->path
            . ($path ? (DIRECTORY_SEPARATOR . $path) : '');
    }

    public function getCachePath()
    {
        return $this->getPath('var');
    }

    public function getPublicPath()
    {
        return $this->getPath('www');
    }

    public function getTemplatePath()
    {
        return $this->getPath('templates');
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
