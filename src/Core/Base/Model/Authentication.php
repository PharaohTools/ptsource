<?php

Namespace Model;

class Authentication {

    // @todo everything below this line should probably be ion a model, or at least a helper
    public function handleAuthenticationResponse($ev, $control, $pageVars) {
        $mod_config = \Model\AppConfig::getAppVariable("mod_config");
        $handled = array() ;
        $handled["control"] = $control ;
        $handled["pageVars"] = $pageVars ;
        if (!isset($mod_config["Signup"]["signup_enabled"]) || $mod_config["Signup"]["signup_enabled"]=="off") {
            return $handled  ; }
        // if we have failed authentication, we will have a false
//        var_dump($ev) ;
        if (in_array(false, $ev)) {
            error_log("failed authentication, forcing back to signup module") ;
            $handled["control"] = "Signup";
            $handled["pageVars"]["route"]["control"] = "Signup" ;
            return $handled ; }
        // at this point we are authenticated, so lets check authorization too
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
                "AssetLoader", "Signup", "About" ) ;
            if (!in_array($control, $clientAllowedList)) {
                $handled["control"] = "ClientPortal";
                $handled["pageVars"]["route"]["control"] = "ClientPortal" ;
                return $handled ; } }
        $handled["control"] = $control;
        $handled["pageVars"]["route"]["control"] = $control ;
        return $handled ;
    }

}