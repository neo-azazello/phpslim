<?php

namespace Esened\Controllers\Auth;

use Esened\Models\User;
use Esened\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller {

    public function getSignOut($request, $response) {

        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getSignIn($request, $response) {
        
        return $this->view->render($response, 'auth/signin.twig');
    
    }

    public function postSignIn($request, $response) {

        //Here we create rules that check data received from form before sending to database.    
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email(),
            'password' => v::noWhitespace()->notEmpty(),

        ]);

        if($validation->failed()){
            
            $this->flash->addMessage('error', 'All required inputes must be filled');
        }

        $auth = $this->auth->attempt(

            $request->getParam('email'),
            $request->getParam('password')
            
        );

        if(!$auth){
            
            $this->flash->addMessage('error', 'Entered auth details are wrong');
            return $response->withRedirect($this->router->pathFor('auth.signin'));

        }

        return $response->withRedirect($this->router->pathFor('home'));

    }

    //This method will render the view
    public function getSignUp($request, $response) {

        return $this->view->render($response, 'auth/signup.twig');
    }
    
    //What will happen when we submit the form
    public function postSignUp($request, $response) {

        //Here we create rules that check data received from form before sending to database.    
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
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

        $this->flash->addMessage('success', 'You have been signed up!');

        //As soon as the user is registered he automaticaly be signed in to website
        $this->auth->attempt($user->email, $request->getParam('password'));

        //As soon as data will be in database it will redirect us to homepage
        return $response->withRedirect($this->router->pathFor('home'));

    }
}
