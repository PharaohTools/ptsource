<?php

Namespace Core ;

class Control {

    public function executeControl($control, $pageVars) {
        $auth = new \Model\Authentication() ;
        $handled = $auth->handleAuthenticationResponse($control, $pageVars) ;
        $className = '\\Controller\\'.ucfirst($handled["control"]);
        $controlObject = new $className;
        return $controlObject->execute($handled["pageVars"]);
    }

}