<?php

Namespace Info;

class RepositoryHomeInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "RepositoryHome Module";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "RepositoryHome" => array("show", "delete") );
    }

    public function routeAliases() {
      return array("repositoryHome"=>"RepositoryHome");
    }

    public function ignoredAuthenticationRoutes() {
        return array( "RepositoryHome" => array("show") );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Repository Home page module for a single build...
HELPDATA;
      return $help ;
    }

}