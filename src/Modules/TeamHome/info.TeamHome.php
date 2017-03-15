<?php

Namespace Info;

class TeamHomeInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "TeamHome Module";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "TeamHome" => array("show", "delete") );
    }

    public function routeAliases() {
      return array("teamHome"=>"TeamHome");
    }

    public function ignoredAuthenticationRoutes() {
        return array( "TeamHome" => array("show") );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Team Home page module for a single build...
HELPDATA;
      return $help ;
    }

}