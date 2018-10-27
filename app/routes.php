<?php

use Esened\Middleware\AuthMiddleware;
use Esened\Middleware\GuestMiddleware;


//Despite container has already instantiated Home Controller here in router we may access the methode :index
$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function () {

    //We are setting the URL where signup form will appear
    $this->get('/signup', 'AuthController:getSignUp')->setName('auth.signup');
    //This route will receive a data posted from signup form
    $this->post('/signup', 'AuthController:postSignUp');

    $this->get('/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/signin', 'AuthController:postSignIn');

})->add(new GuestMiddleware($container));


$app->group('', function () {

    $this->get('/signout', 'AuthController:getSignOut')->setName('auth.signout');

    $this->get('/passchange', 'PasswordController:getChangePassword')->setName('password.change');
    $this->post('/passchange', 'PasswordController:postChangePassword');

})->add(new AuthMiddleware($container));