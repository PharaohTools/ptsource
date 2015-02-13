<?php

Namespace Info;

class ApplicationConfigureInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Application Configuration Pages";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "ApplicationConfigure" => array("show") );
    }

    public function routeAliases() {
      return array("applicationConfigure"=>"ApplicationConfigure");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
This module provides configuration for this instance of PTBuild ...
HELPDATA;
      return $help ;
    }

}