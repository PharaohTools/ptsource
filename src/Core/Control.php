<?php

Namespace Core ;

class Control {

    public function executeControl($control, $pageVars) {
        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($pageVars) ;
        $ev = $eventRunner->eventRunner("authenticate", true) ;
        // @todo lets get the below from a model, overridable
        $auth = new \Model\Authentication() ;
        $handled = $auth->handleAuthenticationResponse($ev, $control, $pageVars) ;
        $className = '\\Controller\\'.ucfirst($handled["control"]);
        $controlObject = new $className;
        return $controlObject->execute($handled["pageVars"]);
    }

}