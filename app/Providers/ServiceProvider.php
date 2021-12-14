<?php

namespace App\Providers;

use App\Application;

abstract class ServiceProvider
{
    public function __construct(
        protected Application $app
    ) {
        //
    }

    abstract public function register();
}
