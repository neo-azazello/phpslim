<?php

//Creating basic route
/* $app->get('/',  function ($request, $response){
    return $this->view->render($response, 'home.twig');
}); */

//Despite container has already instantiated Home Controller here in router we may access the methode :index
$app->get('/', 'HomeController:index');