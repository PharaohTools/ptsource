<?php

Namespace Model;

class PharaohAPIAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getCurrentKey() {
        $key = $this->params['key'] ;
        return $key ;
    }

    public function isKeyCorrect() {
        $settings = $this->getSettings() ;
        $key = $this->getCurrentKey() ;
        $is_correct = false ;
        if ($settings['PharaohAPI']['enabled'] === 'on') {
            for ($i=0; $i<5; $i++) {
                if (isset($settings['PharaohAPI']['api_key_'.$i])) {
                    if ($settings['PharaohAPI']['api_key_'.$i] === $key) {
                        $is_correct = true ;
                    }
                }
            }
        }
        else {
            // API is not enabled
            return false ;
        }
        return $is_correct ;
    }

    public function isAPIEnabled() {
        $settings = $this->getSettings() ;
        if ($settings['PharaohAPI']['enabled'] === 'on') {
            return true ; }
        else {
            return false ; }
    }

    public function keyIsAllowedAccess() {
        $key_exists = $this->getCurrentKey() ;
        if ($key_exists === false) {
            return false ;
        }
        return true ;
    }

    protected function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }


    public function apiErrorRay($message) {
        return array (
            'status' => 'error',
            'message' => $message,
        ) ;
    }

    public function findAPIModule() {
        $api_module = $this->params['api_module'] ;
        return $api_module ;
    }

    public function findAPIFunction() {
        $api_function = $this->params['api_function'] ;
        return $api_function ;
    }

}