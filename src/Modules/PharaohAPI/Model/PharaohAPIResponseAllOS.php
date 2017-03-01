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
	    $api_result = array(
	        'module' => $api_default->findAPIModule() ,
	        'function' => $api_default->findAPIFunction() ,
            'data' => 'Something to respond with'
        );
		return $api_result ;
	}



}
