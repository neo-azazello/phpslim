<?php

namespace Esened\Middleware;

//This middleware helps us to persist input datas if they were accidentaly posted to server
class OldInputMiddleware extends Middleware {

    public function __invoke($request, $response, $next)
    {

        $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
        $_SESSION['old'] = $request->getParams();

        $response = $next($request, $response);
        return $response;
    }
}