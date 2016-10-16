<?php

Namespace Info;

class MirrorRepositoryInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Poll SCM for code changes Functionality";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "MirrorRepository" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("mirrorepository"=>"MirrorRepository");
    }

    public function events() {
        return array("prepareBuild");
    }

    public function repositorySettings() {
        return array("enabled", "git_repository_url", "git_branch", "git_privkey_path", "cron_string");
    }

    public function configuration() {
        return array(
            "exec_delay"=> array(
                "type" => "text",
                "default" => "180",
                "label" => "Minimum execution delay between Repository Mirroring Polling runs", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with MirrorRepository as a Build Step. It provides code
    functionality, but no extra CLI commands.

    MirrorRepository

HELPDATA;
      return $help ;
    }

}