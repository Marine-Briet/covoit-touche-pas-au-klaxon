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
use App\Controllers\AdminController;
use App\Controllers\AdminUtilisateurController;
use App\Controllers\AdminAgenceController;
use App\Controllers\AdminTrajetController;

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

$router->get('/trajet/edit/:id', function(Request $request, Response $response, $id) {
    $controller = new TrajetController();
    return $controller->showEditForm($request, $response, $id);
});

$router->post('/trajet/edit/:id', function(Request $request, Response $response, $id) {
    $controller = new TrajetController();
    return $controller->edit($request, $response, $id);
});

$router->post('/trajet/delete/:id', function(Request $request, Response $response, $id) {
    $controller = new TrajetController();
    return $controller->delete($request, $response, $id);
});

$router->get('/admin', function(Request $request, Response $response) {
    $controller = new AdminController();
    return $controller->index($request, $response);
});

$router->get('/admin/utilisateurs', function(Request $request, Response $response) {
    $controller = new AdminUtilisateurController();
    return $controller->index($request, $response);
});

$router->get('/admin/agences', function(Request $request, Response $response) {
    $controller = new AdminAgenceController();
    return $controller->index($request, $response);
});

$router->get('/admin/agences/create', function(Request $request, Response $response) {
    $controller = new AdminAgenceController();
    return $controller->showCreateForm($request, $response);
});

$router->post('/admin/agences/create', function(Request $request, Response $response) {
    $controller = new AdminAgenceController();
    return $controller->create($request, $response);
});

$router->get('/admin/agences/edit/:id', function(Request $request, Response $response, $id) {
    $controller = new AdminAgenceController();
    return $controller->showEditForm($request, $response, $id);
});

$router->post('/admin/agences/edit/:id', function(Request $request, Response $response, $id) {
    $controller = new AdminAgenceController();
    return $controller->edit($request, $response, $id);
});

$router->post('/admin/agences/delete/:id', function(Request $request, Response $response, $id) {
    $controller = new AdminAgenceController();
    return $controller->delete($request, $response, $id);
});

$router->get('/admin/trajets', function(Request $request, Response $response) {
    $controller = new AdminTrajetController();
    return $controller->index($request, $response);
});

$router->post('/admin/trajets/delete/:id', function(Request $request, Response $response, $id) {
    $controller = new AdminTrajetController();
    return $controller->delete($request, $response, $id);
});

$router->run();