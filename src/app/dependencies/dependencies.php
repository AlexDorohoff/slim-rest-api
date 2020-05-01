<?php

$container = $app->getContainer();


$container['UserController'] = function ($container) {
    return new \App\conttrollers\UserController($container);
};