<?php

namespace Esened\Controllers\Auth;

use Esened\Models\User;
use Esened\Controllers\Controller;
use Respect\Validation\Validator as v;

class PasswordController extends Controller {

    public function getChangePassword($request, $response) {

        return $this->view->render($response, 'auth/changepass.twig');

    }

    public function postChangePassword($request, $response) {

        $validation = $this->validator->validate($request, [

            'password_old' => v::noWhitespace()->notEmpty()->matchesPassword($this->auth->user()->password),
            'password' => v::noWhitespace()->notEmpty(),

        ]);
        
        if($validation->failed()) {

            return $response->withRedirect($this->router->pathFor('password.change'));
        }

        $this->auth->user()->setPassword($request->getParam('password'));
        $this->flash->addMessage('success', 'Your password has been updated!');

        return $response->withRedirect($this->router->pathFor('home'));

    }

}
