<?php

namespace App;

class Application implements \ArrayAccess
{
    private $path;

    private $services = [];

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getPath($path = null)
    {
        return $this->path .
            ($path ? (DIRECTORY_SEPARATOR . $path) : '');
    }

    public function getPublicPath()
    {
        return $this->getPath('www');
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