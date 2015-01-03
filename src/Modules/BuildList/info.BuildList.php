<?php

Namespace Info;

class BuildListInfo extends CleopatraBase {

    public $hidden = true;

    public $name = "BuildList/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "BuildList" => array("show") );
    }

    public function routeAliases() {
      return array("buildList"=>"BuildList");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}