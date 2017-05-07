<?php

Namespace Model;

class PharaohAPIRequestAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Request") ;

    public function performAPIRequest() {
        // make the request to the API of target
        $api_request_result = $this->pharaohAPICall() ;
        // either return an error or a PHP array from the JSON data
        return $api_request_result ;
    }

    protected function findAPIInstanceURL() {
        $api_module = $this->params['api_instance_url'] ;
        return $api_module ;
    }

	public function findAPIRequestKey() {
        $api_function = $this->params['api_key'] ;
        return $api_function ;
    }

    protected function pharaohAPICall() {

        $apif = new \Model\PharaohAPI();
        $api_default = $apif->getModel($this->params) ;
        // get the instance url for the request
        $instance_url = $this->findAPIInstanceURL() ;
        // get the key for the request
        $curlParams['key'] = $this->findAPIRequestKey() ;
        // get the API module for the request
        $curlParams['api_module'] = $api_default->findAPIModule() ;
        // get the API function call for the request
        $curlParams['api_function'] = $api_default->findAPIFunction() ;
        // get the API function parameters for the request
//        $curlParams['api_module'] = $api_default->findAPIFunction() ;


        $curlParams['control'] = 'PharaohAPI' ;
        $curlParams['action'] = 'call' ;
        $curlParams['output-format'] = 'JSON' ;

        $extra_params = $this->getExtraAPIParams() ;
        $curlParams = array_merge($extra_params, $curlParams) ;

        $ch = curl_init();
        $curlUrl = $this->ensureTrailingSlash($instance_url).'index.php?control=PharaohAPI&action=call&output-format=JSON' ;
//        $curlUrl = $this->ensureTrailingSlash($instance_url) ; //.'index.php?control=PharaohAPI&action=call&output-format=JSON' ;
        curl_setopt($ch, CURLOPT_URL,$curlUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlParams));
        curl_setopt($ch, CURLOPT_POST, 1);

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
//
//        ob_start();
//        var_dump('api returned: '.$server_output) ;
//        $out = ob_get_clean() ;
//        file_put_contents('/tmp/pharaohlog', "From Source: \n" .$out, FILE_APPEND) ;
        curl_close ($ch);
        $callObject = json_decode($server_output, true);

        return $callObject;
    }


    public function getExtraAPIParams() {
        $extras = array() ;
        foreach ($this->params as $key => $value) {
            if (strpos($key,'api_param_') === 0) {
                $new_key = substr($key, 10) ;
                $extras[$new_key] = $value ; } }
        return $extras ;
    }

}
