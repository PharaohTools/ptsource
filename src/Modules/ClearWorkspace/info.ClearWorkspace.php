<?php

Namespace Info;

class ClearWorkspaceInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "ClearWorkspace Provisioner Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "ClearWorkspace" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("clearworkspace"=>"ClearWorkspace");
    }

    public function buildSteps() {
        return array("clearworkspace");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with ClearWorkspace as a Build Step. It provides code
    functionality, but no extra commands.

    ClearWorkspace

HELPDATA;
      return $help ;
    }

}