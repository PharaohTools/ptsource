<?php

Namespace Info;

class BuildMoniterInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "BuildMoniter/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "BuildMoniter" => array("show") );
    }

    public function routeAliases() {
      return array("buildMoniter"=>"BuildMoniter");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}