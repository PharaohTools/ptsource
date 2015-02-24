<?php

Namespace Model;

class ApplicationConfigureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret["app_configs"] = $this->getAppConfigs();
        $ret["mod_configs"] = $this->getModuleConfigs();
        $ret["current_configs"] = $this->getCurrentConfigs();
        return $ret ;
    }

    private function getAppConfigs() {
        $configs = array(
                    "instance_id" => array(
                        "label" => "Instance ID",
                        "type" => "text",
                        "desc" => "Enter an instance ID that will generated",
                        "default" => "1234567890", ),
                    "instance_title" => array(
                        "label" => "Instance Title",
                        "type" => "text",
                        "desc" => "Enter the title you'd like to apply to this instance (for clustering)",
                        "default" => "My Development Instance" ),
                    "organisation" => array(
                        "label" => "Organisation",
                        "type" => "text",
                        "desc" => "Enter the name of your Organisation",
                        "default" => "An Organisation" ),
                    "force_ssl" => array(
                        "label" => "Force SSL",
                        "type" => "boolean",
                        "desc" => "Switch on to force web connections to be made via SSL",
                        "default" => false ),
                    );
        return $configs;
    }

    private function getModuleConfigs() {
        $configs = array();
        $infos = \Core\AutoLoader::getInfoObjects();
        foreach ($infos as $info) {
            if (method_exists($info, "configuration")) {
                $fullName = get_class($info) ;
                $modName = str_replace("Info", "", $fullName) ;
                $modName = str_replace("\\", "", $modName) ;
                $configs[$modName] = $info->configuration() ; } }
        return $configs ;
    }

    private function getCurrentConfigs() {
        $configs = array();
        $configs["app_config"] = \Model\AppConfig::getAppVariable("app_config") ;
        $configs["mod_config"] = \Model\AppConfig::getAppVariable("mod_config") ;
        return $configs ;
    }

}