<?php

namespace Core;

abstract class ServiceProvider
{
    public function __construct(
        protected Application $app
    ) {
        //
    }

    abstract public function register();
}
