<?php

Namespace Info;

class CronInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Cron Scheduled Task Driver Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "Cron" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("cron"=>"Cron");
    }

    public function configuration() {
        return array(
            "cron_enable"=> array("type" => "boolean", "default" => "on", "label" => "Cron Enabled?", ),
            "cron_switch_user"=> array("type" => "boolean", "default" => "on", "label" => "Use switching user if available?", ),
            "cron_command"=> array("type" => "text", "default" => "/usr/bin/ptbuild ScheduledTasks execute --yes --guess", "label" => "Cron Command for Scheduled Tasks?", ),
            "cron_frequency"=> array("type" => "text", "default" => "*/10 * * * *", "label" => "Cron Execution Frequency?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Cron as a Scheduled Task Driver. It provides code
    functionality, but no extra CLI commands.

    Cron

HELPDATA;
      return $help ;
    }

}