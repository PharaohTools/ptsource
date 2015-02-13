<?php

Namespace Info;

class PipeRunnerInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Pipe Running Functionality and Pages";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "PipeRunner" => array("start", "apistart", "service", "pipestatus", "show", "child", "history", "summary") );
    }

    public function routeAliases() {
      return array("piperunner"=>"PipeRunner", "pipeRunner"=>"PipeRunner");
    }

    public function configuration() {
        return array(
            "concurrent_runs"=> array(
                "type" => "boolean",
                "default" => false,
                "label" => "Execute concurrent runs if necessary?",
            ),
            "enable_pipe"=> array(
                "type" => "boolean",
                "default" => true,
                "label" => "Enable the execution of this pipeline",
            ),
        );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}
