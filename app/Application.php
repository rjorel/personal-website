<?php

namespace App;

use App\Providers\MailServiceProvider;
use App\Providers\RouteServiceProvider;
use App\Providers\ServiceProvider;
use App\Providers\TwigServiceProvider;
use ArrayAccess;

class Application implements ArrayAccess
{
    private static $providers = [
        MailServiceProvider::class,
        RouteServiceProvider::class,
        TwigServiceProvider::class
    ];

    private $path;

    private $services = [];

    public function __construct($path)
    {
        $this->path = $path;

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

    public function getCachePath()
    {
        return $this->getPath('var');
    }

    private function getPath($path = null)
    {
        return $this->path .
            ($path ? (DIRECTORY_SEPARATOR . $path) : '');
    }

    public function getPublicPath()
    {
        return $this->getPath('www');
    }

    public function getTemplatePath()
    {
        return $this->getPath('templates');
    }

    public function offsetExists($offset)
    {
        return isset($this->services[ $offset ]);
    }

    public function offsetGet($offset)
    {
        return $this->services[ $offset ];
    }

    public function offsetSet($offset, $value)
    {
        $this->services[ $offset ] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->services[ $offset ]);
    }
}