<?php

Namespace Info;

class BuildHomeInfo extends CleopatraBase {

    public $hidden = false;

    public $name = "BuildHome/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "BuildHome" => array("show") );
    }

    public function routeAliases() {
      return array("buildHome"=>"BuildHome");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Build Home page module for a single build...
HELPDATA;
      return $help ;
    }

}