<?php

namespace Core;

use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    public function __construct(
        protected readonly Application $app,
        protected readonly Request $request
    ) {
        //
    }
}
