<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Router\RouterResolver;
use App\Infrastructure\Router\Matcher\StatisticMatcher;
use App\Infrastructure\Router\Matcher\EventMatcher;

$router = new RouterResolver([new EventMatcher(), new StatisticMatcher()]);
$response = $router->resolve(
    method: $_SERVER['REQUEST_METHOD'],
    path: parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

echo $response->body;