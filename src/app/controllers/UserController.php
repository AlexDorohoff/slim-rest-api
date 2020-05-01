<?php

namespace App\controllers;

use App\models\User;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class UserController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index($request, $response, $args)
    {
        $model = new User();
        $all = $model->getAll();
        $response->getBody()->write($all);
        return $response;
    }

    public static function delete(Request $request, Response $response, $args)
    {
        $model = new User();
        $all = $model->delete($args['id']);
        $response->getBody()->write($all);
        return $response;
    }

    public function view(Request $request, Response $response, $args)
    {
        $model = new User();
        $user = $model->getOne($args['id']);
        $response->getBody()->write($user);
        return $response;
    }

    public function update(Request $request, Response $response, $args){
        $model = new User();
        $user = $model->update($request, $args['id']);
        $response->getBody()->write($user);
        return $response;
    }

    public function save(Request $request, Response $response, $args){
        $model = new User();
        $user = $model->save($request);
        $response->getBody()->write($user);
        return $response;
    }
}