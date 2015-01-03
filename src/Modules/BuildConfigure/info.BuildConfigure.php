<?php

Namespace Info;

class BuildConfigureInfo extends CleopatraBase {

    public $hidden = true;

    public $name = "BuildConfigure/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "BuildConfigure" => array("show") );
    }

    public function routeAliases() {
      return array("buildList"=>"BuildConfigure");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}