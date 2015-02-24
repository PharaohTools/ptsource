<?php

Namespace Info;

class ShutdownInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Shutdown Virtual Desktop Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "Shutdown" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("shutdown"=>"Shutdown");
    }

    public function events() {
        return array("beforeSettings");
    }

    public function configuration() {
        return array(
            "disable_build_execution"=> array("type" => "boolean", "default" => false, "label" => "Disable Build Execution?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Shutdown as a Build Step. It provides code
    functionality, but no extra CLI commands.

    Shutdown

HELPDATA;
      return $help ;
    }

}