<?php

Namespace Info;

class BuildMonitorInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "BuildMonitor/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "BuildMonitor" => array("show") );
    }

    public function routeAliases() {
      return array("buildMonitor"=>"BuildMonitor");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}