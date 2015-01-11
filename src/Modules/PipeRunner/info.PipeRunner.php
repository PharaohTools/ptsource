<?php

Namespace Info;

class PipeRunnerInfo extends CleopatraBase {

    public $hidden = false;

    public $name = "PipeRunner/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "PipeRunner" => array("show") );
    }

    public function routeAliases() {
      return array("buildConfigure"=>"PipeRunner");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}