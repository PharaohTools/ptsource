<?php

Namespace Info;

class AboutInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "About Module";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "About" => array("show") );
    }

    public function routeAliases() {
      return array("about"=>"About");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Repository Home page module for a single build...
HELPDATA;
      return $help ;
    }

}