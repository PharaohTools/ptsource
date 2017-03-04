<?php

Namespace Model;

class PharaohAPIResponseAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Response") ;

    public function handleAPIResponse() {
        $apif = new \Model\PharaohAPI();
        $api_default = $apif->getModel($this->params) ;
        // if api is enabled
        if ($api_default->isAPIEnabled() === false) {
            $message = 'API Disabled' ;
            return $api_default->apiErrorRay($message) ;
        }
        // if the key exists
        if ($api_default->isKeyCorrect() === false) {
            $message = 'Unauthorized' ;
            return $api_default->apiErrorRay($message) ;
        }
        // run the event for this api call
        $api_result = $this->executeAPI() ;
        // return arrays of data as json
        return $api_result ;
    }

    public function executeAPI() {
        $apif = new \Model\PharaohAPI();
        $api_default = $apif->getModel($this->params) ;
        // Find API Model of requested module
        $api_module = $api_default->findAPIModule() ;
        $api_module_factory_string = '\Model\\'.$api_module ;

        if (!class_exists($api_module_factory_string)) {
            $api_result = array(
                'result' => 'failure' ,
                'module' => $api_module ,
                'function' => $api_default->findAPIFunction() ,
                'data' => 'Module '.$api_module.' does not exist'
            );
            return $api_result ;
        }

        $api_module_factory = new $api_module_factory_string() ;
        $api_model = $api_module_factory->getModel($this->params, 'API') ;

        $api_function = $api_default->findAPIFunction() ;
        if ($this->apiModelProvidesFunction($api_model, $api_function) === true) {
            // if apimodel->availableFunctions includes our function
            //   run the function
            $api_result = array(
                'result' => 'success' ,
                'module' => $api_default->findAPIModule() ,
                'function' => $api_default->findAPIFunction() ,
                'data' => $api_model->$api_function() ,
            );
        }
        else {
            // else
            //   return some no function error message
            $module = $api_default->findAPIModule() ;
            $api_result = array(
                'result' => 'failure' ,
                'module' => $module ,
                'function' => $api_default->findAPIFunction() ,
                'data' => $module.' API Does not provide this function'
            );
        }
        return $api_result ;
    }


    public function apiModelProvidesFunction($api_model, $function) {
        $allowed = $api_model->allowedFunctions() ;
        if (in_array($function, $allowed)) {
            return true ;
        }
        return false ;
    }

}
