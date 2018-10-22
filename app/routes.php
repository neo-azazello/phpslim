<?php

//Creating basic route
/* $app->get('/',  function ($request, $response){
    return $this->view->render($response, 'home.twig');
}); */

//Despite container has already instantiated Home Controller here in router we may access the methode :index
$app->get('/', 'HomeController:index')->setName('home');

//We are setting the URL where signup form will appear
$app->get('/signup', 'AuthController:getSignUp')->setName('auth.signup');
//This route will receive a data posted from signup form
$app->post('/signup', 'AuthController:postSignUp');