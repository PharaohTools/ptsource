<?php

Namespace Info;

class ApplicationInstanceInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Application Instance Configurations";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "ApplicationInstance" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("ApplicationInstance");
    }

    public function events() {
        return array("afterApplicationConfigurationSave");
    }

    public function configuration() {
        return array(
            "instance_id"=> array("type" => "text", "default" => "Instance ID", "label" => "Application Instance ID?", ),
            "instance_title"=> array("type" => "text", "default" => "Example Title", "label" => "Application Instance Title?", ),
            "organisation"=> array("type" => "text", "default" => "Example Organisation", "label" => "Organisation Name?", ),
            "force_ssl"=> array("type" => "boolean", "label" => "Force SSL?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides Application Instance Configuration It provides code
    functionality, but no extra CLI commands.

    ApplicationInstance

HELPDATA;
      return $help ;
    }

}