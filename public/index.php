<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Buki\Router\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\TrajetController;

$router = new \Buki\Router\Router([
    'base_folder' => str_replace('\\', '/', __DIR__),
]);

$router->get('/', function(Request $request, Response $response) {
    $controller = new HomeController();
    return $controller->index($request, $response);
});

$router->get('/login', function(Request $request, Response $response) {
    $controller = new AuthController();
    return $controller->showLoginForm($request, $response);
});

$router->post('/login', function(Request $request, Response $response) {
    $controller = new AuthController();
    return $controller->login($request, $response);
});

$router->get('/logout', function(Request $request, Response $response) {
    $controller = new AuthController();
    return $controller->logout($request, $response);
});

$router->get('/trajet/create', function(Request $request, Response $response) {
    $controller = new TrajetController();
    return $controller->showCreateForm($request, $response);
});

$router->post('/trajet/create', function(Request $request, Response $response) {
    $controller = new TrajetController();
    return $controller->create($request, $response);
});

$router->run();