<?php

namespace Esened\Controllers;

use \Slim\Views\Twig as View;

class HomeController extends Controller {

    public function index($request, $response) {
        //Now index method will render home.twig file.
        return $this->view->render($response, 'home.twig');
    }
}
