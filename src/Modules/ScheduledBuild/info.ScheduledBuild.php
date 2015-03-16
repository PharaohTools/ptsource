<?php

Namespace Info;

class ScheduledBuildInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Pipe Running Functionality and Pages";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "ScheduledBuild" => array("run-cycle") );
    }

    public function routeAliases() {
      return array("ScheduledBuild"=>"ScheduledBuild",
          "scheduledbuild"=>"ScheduledBuild",
          "scheduledBuild"=>"ScheduledBuild");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}
