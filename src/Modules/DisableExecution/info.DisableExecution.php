<?php

Namespace Info;

class DisableExecutionInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "DisableExecution Virtual Desktop Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "DisableExecution" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("DisableExecution"=>"DisableExecution");
    }

    public function events() {
        return array("prepareBuild");
    }

    public function configuration() {
        return array(
            "disable_build_execution"=> array("type" => "boolean", "default" => false, "label" => "Disable Build Execution?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with DisableExecution as a Build Step. It provides code
    functionality, but no extra CLI commands.

    DisableExecution

HELPDATA;
      return $help ;
    }

}