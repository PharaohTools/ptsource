<?php

Namespace Info;

class ApplicationConfigureInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Application Configuration Pages";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "ApplicationConfigure" => array("show", "save") );
    }

    public function routeAliases() {
      return array("applicationConfigure"=>"ApplicationConfigure");
    }

    public function helpDefinition() {
      $help = "This module provides application level configuration settings for this instance of Pharaoh ".PHARAOH_APP."... " ;
      return $help ;
    }

}