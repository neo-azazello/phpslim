<?php

namespace Esened\Controllers\Auth;

use Esened\Controllers\Controller;

class AuthController extends Controller {

    //This method will render the view
    public function getSignUp($request, $response) {

        return $this->view->render($response, 'auth/signup.twig');
    }
    
    //What will happen when we submit the form
    public function postSignUp(){

    }
}
