<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    public function __construct(
        protected Application $app,
        protected Request $request
    ) {
        //
    }
}
