<?php

Namespace Model;

class ApplicationConfigureSaverAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("ApplicationConfigureSaver") ;

    public function saveAllConfigs() {
        $r1 = $this->saveAppConfigs();
        $r2 = $this->saveModConfigs();
        return ($r1 == true && $r2 == true) ? true : false ;
    }

    public function saveAppConfigs() {
        // @todo escape this data from injection etc
        $appConfigVar = $_REQUEST["app_config"] ;
        $appConfig = new \Model\AppConfig();
        $appConfig->setAppVariable("app_config", $appConfigVar);
        // @todo actually use logic here
        return true ;
    }

    public function saveModConfigs() {
        // @todo escape this data from injection etc
        $appConfigVar = $_REQUEST["mod_config"] ;
        $appConfig = new \Model\AppConfig();
        $appConfig->setAppVariable("mod_config", $appConfigVar);
        // @todo actually use logic here
        return true ;
    }

}