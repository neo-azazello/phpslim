<?php

use Respect\Validation\Validator as v;

//Starting new session in aour application
session_start();

// require the main Slim 3 Framework file
require __DIR__ . "/../vendor/autoload.php";

//Instantiate Slim Framework instance. 
$app = new \Slim\App([
    //Passing some configuration options to Slim
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => '138.201.64.85',
            'database' => 'compboar_app',
            'username' => 'compboar_app',
            'password' => 'OL(%_%uxX{~r',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],
    ]
]);

//We need attach things to container. So we firstly grab the container
$container = $app->getContainer();

//Using Eloquent db component we try to connect to our mysql db. 
//Firs we instantiate DB class and later we call cnnector.
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

//Adding db to container in order to access it from controllers
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['auth'] = function ($container) {
    return new \Esened\Auth\Auth;
};

//Adding to container flash messages
$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages;
};

//Starting to bind everything with container
//First the view
$container['view'] = function ($container) { //when we would use view it will resolve from container

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

   //Make available Auth class inside of our templates
   $view->getEnvironment()->addGlobal('auth', [
       //Here we are essentaily doing is we are calling the database once but store it inside of our view variables
        'check' => $container->auth->check(),
        'user' => $container->auth->user(),
   ]);

   //Giving availibiity of flash functionality to our twig views
   $view->getEnvironment()->addGlobal('flash', $container->flash);

   return $view;
};

//Attach validator to our container
$container['validator'] = function ($container) {
    return new \Esened\Validation\Validator;
};

//Starting bind Controller to router. When router calls base url (/) system will instantate HomeController.
$container['HomeController'] = function ($container) {
    return new \Esened\Controllers\HomeController($container);
}; 

$container['AuthController'] = function ($container) {
    return new \Esened\Controllers\Auth\AuthController($container);
}; 

$container['PasswordController'] = function ($container) {
    return new \Esened\Controllers\Auth\PasswordController($container);
}; 


//Attaching  CSRF module to our system container.
$container['csrf'] = function ($container) {
    return new \Slim\Csrf\Guard;
};


//Attaching Validation Middleware to our container
$app->add(new \Esened\Middleware\ValidationErrorsMiddleware($container));

//Attach Middleware that checks input data persistance
$app->add(new \Esened\Middleware\OldInputMiddleware($container));

//Attach Middleware that checks forms via CSRF
$app->add(new \Esened\Middleware\CsrfViewMiddleware($container));

//Turning on the csrf system wide
$app->add($container->csrf);

//Allowing this validation library to use our rules 
v::with('Esened\\Validation\\Rules\\');

// require the routing file
require __DIR__ . "/../app/routes.php";

