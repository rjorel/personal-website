<?php

namespace App\Core;

abstract class ServiceProvider
{
    public function __construct(
        protected Application $app
    ) {
        //
    }

    abstract public function register();
}
