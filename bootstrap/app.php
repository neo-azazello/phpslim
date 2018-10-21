<?php
//Starting new session in aour application
session_start();

// require the main Slim 3 Framework file
require __DIR__ . "/../vendor/autoload.php";

//Instantiate Slim Framework instance. 
$app = new \Slim\App([
    //Passing some configuration options to Slim
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

//We need attach things to container. So we firstly grab the container
$container = $app->getContainer();

//Starting to bind everything with container
//First the view
$container['view'] = function($container) { //when we would use view it will resolve from container

    //Creating new Twig View Instance, then specify the folder and give options
   $view = new \Slim\Views\Twig(__DIR__ . '/../res/views', [
       //An array of options
       'cache' => false,
   ]);  

   //Extension helps us to generate urls to different routes within our views
   $view->addExtension(new \Slim\Views\TwigExtension(
       //We need router because we are going to generate urls for links
       $container->router,
       //Pull in the current url
       $container->request->geturi()
   ));

   return $view;
}; 

//Starting bind Controller to router. When router calls base url (/) system will instantate HomeController.
$container['HomeController'] = function ($container) {
    return new \Esened\Controllers\HomeController($container);
}; 

// require the routing file
require __DIR__ . "/../app/routes.php";
