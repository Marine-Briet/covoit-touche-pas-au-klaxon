<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Buki\Router\Router;
use App\Controllers\HomeController;

$router = new \Buki\Router\Router([
    'base_folder' => str_replace('\\', '/', __DIR__),
]);

$router->get('/', function(Request $request, Response $response) {
    $controller = new HomeController();
    return $controller->index($request, $response);
});

$router->run();