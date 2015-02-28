<?php

Namespace Info;

class ScheduledTasksInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Pipe Running Functionality and Pages";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "ScheduledTasks" => array("start", "apistart", "service", "pipestatus", "show", "child", "history", "summary") );
    }

    public function routeAliases() {
      return array("piperunner"=>"ScheduledTasks", "scheduledTasks"=>"ScheduledTasks");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}
