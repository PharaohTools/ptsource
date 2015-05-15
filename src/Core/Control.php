<?php

Namespace Core ;

class Control {

    public function executeControl($control, $pageVars) {
        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($pageVars) ;
        $ev = $eventRunner->eventRunner("authenticate", true) ;
        // @todo lets get the below from a model, overridable
        $handled = $this->handleAuthenticationResponse($ev, $control, $pageVars) ;
        $control = $handled["control"] ;
        $pageVars = $handled["pageVars"] ;
        $className = '\\Controller\\'.ucfirst($control);
        $controlObject = new $className;
        return $controlObject->execute($pageVars);
    }

    // @todo everything below this line should probably be ion a model, or at least a helper
    private function handleAuthenticationResponse($ev, $control, $pageVars) {
        $handled = array() ;
        $handled["control"] = $control ;
        $handled["pageVars"] = $pageVars ;
        // if we have failed authentication, we will have a false
        if (in_array(false, $ev)) {
            error_log("failed authentication, forcing back to signup module") ;
            $handled["control"] = "Signup";
            $handled["pageVars"]["route"]["control"] = "Signup" ;
            return $handled ; }
        // at this point we are authenticaed, so lets check authorization too
        $handled = $this->handleAuthorizationResponse($ev, $handled["control"], $handled["pageVars"]) ;
        return $handled  ;
    }

    private function handleAuthorizationResponse($ev, $control, $pageVars) {
        $handled = array() ;
        $handled["pageVars"] = $pageVars ;
        $umf = new \Model\UserManager();
        $um = $umf->getModel(array());

        // the user is logged in, but resticted
        $restricted = $um->getRestrictionStatus() ;
        if ($restricted === true) {
            error_log("restricted user authentication, forcing back to signup module") ;
            $handled["control"] = "Signup";
            $handled["pageVars"]["route"]["control"] = "Signup" ;
            return $handled ; }
        $myRole = $um->getMyUserRoleId() ;
        // if we are a client use client
        if ($myRole==4) {
            $clientAllowedList = array(
                "ClientPortal", "ClientJobList", "ClientJobHome", "ClientDocuments", "PostInput",
                "AssetLoader", "Signup", "About"
            ) ;
            if (!in_array($control, $clientAllowedList)) {
                $handled["control"] = "ClientPortal";
                $handled["pageVars"]["route"]["control"] = "ClientPortal" ;
                return $handled ; } }
        $handled["control"] = $control;
        $handled["pageVars"]["route"]["control"] = $control ;
        return $handled ;
    }

}