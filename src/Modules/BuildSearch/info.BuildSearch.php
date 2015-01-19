<?php

Namespace Info;

class BuildSearchInfo extends CleopatraBase {

    public $hidden = false;

    public $name = "BuildSearch/Search Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "BuildSearch" => array("search") );
    }

    public function routeAliases() {
      return array("buildsearch"=>"BuildSearch");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - it will search built list...
HELPDATA;
      return $help ;
    }

}
