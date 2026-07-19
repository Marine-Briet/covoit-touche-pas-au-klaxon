<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Buki\Router\Router;
use App\Models\TrajetModel;

$router = new \Buki\Router\Router([
    'base_folder' => str_replace('\\', '/', __DIR__),
]);

$router->get('/', function(Request $request, Response $response) {
    
    $response->setContent('Bienvenue sur le site Touche pas au klaxon!');
    return $response;
});

$router->run();