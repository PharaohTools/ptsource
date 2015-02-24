<?php

Namespace Info;

class TriggerRemoteInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "TriggerRemote Provisioner Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "TriggerRemote" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("trigger-remote"=>"TriggerRemote");
    }

    public function buildSteps() {
        return array("trigger-remote-script", "trigger-remote-file") ;
    }

    public function buildSettings() {
        return array("trigger-remote-script", "trigger-remote-file") ;
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with TriggerRemote as a Build Step. It provides code
    functionality, but no extra commands.

    TriggerRemote

HELPDATA;
      return $help ;
    }

}