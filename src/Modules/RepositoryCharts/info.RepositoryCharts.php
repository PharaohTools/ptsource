<?php

Namespace Info;

class RepositoryChartsInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Repository Charts Section";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "RepositoryCharts" => array("show", "delete") );
    }

    public function routeAliases() {
      return array("repositoryCharts"=>"RepositoryCharts");
    }

    public function ignoredAuthenticationRoutes() {
        return array( "RepositoryCharts" => array("show") );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Repository Charts page module for a single build...
HELPDATA;
      return $help ;
    }

}