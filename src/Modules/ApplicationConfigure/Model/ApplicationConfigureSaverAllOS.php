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
        $r1 = $this->saveModConfigs();
        return ($r1 == true) ? true : false ;
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