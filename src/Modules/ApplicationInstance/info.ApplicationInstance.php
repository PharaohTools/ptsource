<?php

Namespace Info;

class ApplicationInstanceInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "ApplicationInstance Virtual Desktop Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "ApplicationInstance" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("xvnc"=>"ApplicationInstance");
    }

    public function events() {
        return array("afterSettings", "afterBuildComplete");
    }

    public function buildSettings() {
        return array("xvnc_during_build");
    }

    public function configuration() {
        return array(
            "xvnc_command"=> array("type" => "text", "default" => "", "label" => "ApplicationInstance Command Location?", ),
            "xvnc_min_id"=> array("type" => "text", "default" => "0", "label" => "ApplicationInstance Minimum Desktop ID?", ),
            "xvnc_max_id"=> array("type" => "text", "default" => "99", "label" => "ApplicationInstance Maximum Desktop ID?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with ApplicationInstance as a Build Step. It provides code
    functionality, but no extra CLI commands.

    ApplicationInstance

HELPDATA;
      return $help ;
    }

}