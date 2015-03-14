<?php

Namespace Model;

class ShutdownLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "disable_build_execution" =>
                array(
                    "type" => "boolean",
                    "optional" => true,
                    "name" => "Disable build execution"
                ),
            );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array("beforeSettings" => array("disableBuildIfNeeded",),);
        return $ff ;
    }

    public function disableBuildIfNeeded() {
        $this->params["app-settings"]["app_config"] = \Model\AppConfig::getAppVariable("app_config");
        $this->params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        if (isset($this->params["app-settings"]["mod_config"]["Shutdown"]) &&
            $this->params["app-settings"]["mod_config"]["Shutdown"]["disable_build_execution"] == "on") {
            $logging->log ("Build execution of all builds disabled through shutdown module a application level, aborting...", $this->getModuleName() ) ;
            $logging->log ("ABORTED EXECUTION", $this->getModuleName() ) ;
            return false ; }
        $mn = $this->getModuleName() ;
        if (isset($this->params["build-settings"][$mn]["Shutdown"]) &&
            $this->params["build-settings"][$mn]["Shutdown"]["disable_build_execution"] == "on") {
            $logging->log ("Build execution of this build disabled through shutdown module at build level, aborting...", $this->getModuleName() ) ;
            $logging->log ("ABORTED EXECUTION", $this->getModuleName() ) ;
            return false ; }
        else {
            return true ; }
    }

}