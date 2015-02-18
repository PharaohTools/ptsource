<?php

Namespace Info;

class WorkspaceInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Workspace/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "Workspace" => array("show") );
    }

    public function routeAliases() {
      return array("workspace"=>"Workspace");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}