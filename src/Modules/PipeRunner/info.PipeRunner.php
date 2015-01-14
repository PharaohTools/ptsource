<?php

Namespace Info;

class PipeRunnerInfo extends CleopatraBase {

    public $hidden = false;

    public $name = "PipeRunner/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "PipeRunner" => array("start", "service", "pipestatus", "show", "child", "history", "summary") );
    }

    public function routeAliases() {
      return array("piperunner"=>"PipeRunner", "pipeRunner"=>"PipeRunner");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}