<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri !== '/' && file_exists(__DIR__ . '/www' . $uri)) {
    return false; // Serve the requested resource as-is.
}

require_once __DIR__ . '/www/index.php';
