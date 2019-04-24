<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    private $services;

    public function __construct($services = [])
    {
        $this->services = $services;
    }

    public function handle(Request $request): Response
    {
        return new Response('Hello world!');
    }
}