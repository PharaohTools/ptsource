<?php

Namespace Info;

class ApplicationConfigureInfo extends CleopatraBase {

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
This module provides configuration for this instance of Phrankinsense ...
HELPDATA;
      return $help ;
    }

}