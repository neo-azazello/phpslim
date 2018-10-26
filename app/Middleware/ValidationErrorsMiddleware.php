<?php

namespace Esened\Middleware;

//The main purpose of this middleware is to pass to the view the validation errors.
class ValidationErrorsMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {

      //When error messages are set globally from Validator class we may use it here   
      if(isset($_SESSION['errors'])) {  
       
        $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
        unset($_SESSION['errors']);

      }

        //All Midlewares must return next callable midlleware
        $response = $next($request, $response);
        return $response;

    }
}