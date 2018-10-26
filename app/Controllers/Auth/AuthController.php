<?php

namespace Esened\Controllers\Auth;

use Esened\Models\User;
use Esened\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller {

    //This method will render the view
    public function getSignUp($request, $response) {

        return $this->view->render($response, 'auth/signup.twig');
    }
    
    //What will happen when we submit the form
    public function postSignUp($request, $response) {

        //Here we create rules that check data received from form before sending to database.    
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email(),
            'name' => v::notEmpty(),
            'password' => v::noWhitespace()->notEmpty(),

        ]);

        //Before proceeding to database if validation failed we redirect to signup form
        if($validation->failed()){

            return $response->withRedirect($this->router->pathFor('auth.signup'));

        }
       
        //With a $request we receive data and pass it to User model with create methode.
       $user = User::create([
            'email' => $request->getParam('email'),
            'name' =>  $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        ]);

        //As soon as data will be in database it will redirect us to homepage
        return $response->withRedirect($this->router->pathFor('home'));

    }
}
