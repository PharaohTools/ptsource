<?php

Namespace Model;

class Authentication {

    // @todo everything below this line should probably be ion a model, or at least a helper
    public function handleAuthenticationResponse($control, $pageVars) {

        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($pageVars) ;
        $ev = $eventRunner->eventRunner("authenticate", true) ;

        $mod_config = \Model\AppConfig::getAppVariable("mod_config");
        $handled = array() ;
        $handled["control"] = $control ;
        $handled["pageVars"] = $pageVars ;
        if (!isset($mod_config["Signup"]["signup_enabled"]) || $mod_config["Signup"]["signup_enabled"]=="off") {
            return $handled  ; }


        // find modules which provide ignore auth routes
        $ignoredAuthRoutes = array();
        $infos = \Core\AutoLoader::getInfoObjects();

        foreach ($infos as $info) {
            if (method_exists($info, "ignoredAuthenticationRoutes")) {
                $ignoredAuthRoutes[$info->getModuleName()] = $info->ignoredAuthenticationRoutes() ; } }
        if (array_key_exists($handled["control"], $ignoredAuthRoutes) &&
            in_array($handled["action"], $ignoredAuthRoutes[$handled["control"]])) {
            // if we are requesting something with ignored auth, just return it
            error_log("ignoring auth for {$handled["control"]}, {$handled["action"]} ") ;
            return $handled ; }

        // if we have failed authentication, we will have a false
        // var_dump($ev) ;
        if (in_array(false, $ev)) {
            error_log("failed authentication, forcing back to signup module") ;
            $handled["control"] = "Signup";
            $handled["pageVars"]["route"]["control"] = "Signup" ;
            return $handled ; }
        // at this point we are authenticated, so lets check authorization too
        $handled = $this->handleAuthorizationResponse($handled["control"], $handled["pageVars"]) ;
        return $handled  ;
    }

    private function handleAuthorizationResponse($control, $pageVars) {
        $handled = array() ;
        $handled["pageVars"] = $pageVars ;
        $umf = new \Model\UserManager();
        $um = $umf->getModel(array());
        // the user is logged in, but restricted
        $restricted = $um->getRestrictionStatus() ;
        if ($restricted === true) {
            error_log("restricted user authentication, forcing back to signup module") ;
            $handled["control"] = "Signup";
            $handled["pageVars"]["route"]["control"] = "Signup" ;
            return $handled ; }
        // @todo this is not needed for this app
        // @todo this looks like it should be supported in module code
        // a module should be able to define
//        $myRole = $um->getMyUserRoleId() ;
        // if we are a client use client

//        if ($myRole==4) {
//            $clientAllowedList = array(
//                "ClientPortal", "ClientJobList", "ClientJobHome", "ClientDocuments", "PostInput",
//                "AssetLoader", "Signup", "About" ) ;
//            if (!in_array($control, $clientAllowedList)) {
//                $handled["control"] = "ClientPortal";
//                $handled["pageVars"]["route"]["control"] = "ClientPortal" ;
//                return $handled ; } }
        $handled["control"] = $control;
        $handled["pageVars"]["route"]["control"] = $control ;
        return $handled ;
    }

}