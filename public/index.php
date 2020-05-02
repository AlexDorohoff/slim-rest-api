<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\controllers\UserController;
use App\models\User;

require '../vendor/autoload.php';
$config = ['settings' => [
    'addContentLengthHeader' => false,
    'debug' => true,
    'displayErrorDetails' => true,
]];
$app = new Slim\App($config);

$app->get('/', function ($request, $response, $args) {
    return $response->withJson("Hello ");
});

$app->get('/users', UserController::class . ':index');

$app->get('/users/{id}',UserController::class . ':view');

$app->post('/users',UserController::class . ':save');

$app->put('/users/{id}',UserController::class . ':update');

$app->delete('/users/{id}',UserController::class . ':delete');

$app->run();