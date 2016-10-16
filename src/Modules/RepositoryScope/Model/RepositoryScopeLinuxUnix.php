<?php

Namespace Model;

class RepositoryScopeLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    private $lm ;
    private $pipeline ;

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable Public Scope for Repository?"
            ),
            "public_pages" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Make Repository Pages Public?"
            ),
            "public_read" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Allow Public Code Reads?"
            ),
            "public_write" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Allow Public Code Writes?"
            ),
        );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    // @todo need thee cron execution event to do this
    public function getEvents() {
        $ff = array(
            "prepareBuild" => array(
                "pollSCMChanges",
            ),
        );
        return $ff ;
    }

    public function pollSCMChanges() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $this->params["php-log"] = true ;
        $this->params["build-settings"] = $this->pipeline["settings"];
        $this->params["app-settings"]["app_config"] = \Model\AppConfig::getAppVariable("app_config");
        $this->params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
        $this->lm = $loggingFactory->getModel($this->params);
    }


}