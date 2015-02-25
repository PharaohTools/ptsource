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
        $this->params["build-settings"]["app_config"] = \Model\AppConfig::getAppVariable("app_config");
        $this->params["build-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
        if (isset($this->params["build-settings"]["mod_config"]["Shutdown"]) &&
            $this->params["build-settings"]["mod_config"]["Shutdown"]["disable_build_execution"] == "on") {
            $loggingFactory = new \Model\Logging();
            $this->params["echo-log"] = true ;
            $logging = $loggingFactory->getModel($this->params);
            $logging->log ("Build execution disabled through shutdown module, aborting...", $this->getModuleName() ) ;
            $logging->log ("ABORTED EXECUTION", $this->getModuleName() ) ;
            return false ; }
        else {
            return true ; }
    }

}