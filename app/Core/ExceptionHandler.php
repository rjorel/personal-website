<?php

namespace App\Core;

use Exception;
use Symfony\Component\HttpFoundation\Request;

interface ExceptionHandler
{
    public function render(Request $request, Exception $exception): string;
}
