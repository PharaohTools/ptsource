<?php

Namespace Info;

class PipeRunnerInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Pipe Running Functionality and Pages";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
        return array( "PipeRunner" => array("start", "apistart", "service", "pipestatus", "show", "child", "history",
          "summary", "findrunning", "terminate-child", "terminate", "termservice", "termstatus") );
    }

    public function ignoredAuthenticationRoutes() {
        return array( "PipeRunner" => array("child", "terminate-child") );
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
