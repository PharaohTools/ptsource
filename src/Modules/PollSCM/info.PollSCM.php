<?php

Namespace Info;

class PollSCMInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Poll SCM for code changes Functionality";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "PollSCM" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("pollscm"=>"PollSCM");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("poll_scm_enabled", "scm_always_allow_web", "git_repository_url", "git_branch", "git_privkey_path",
            "cron_string");
    }

    public function configuration() {
        return array(
            "exec_delay"=> array( "type" => "text", "default" => "180", "label" => "Minimum execution delay between SCM Poll runs", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with PollSCM as a Build Step. It provides code
    functionality, but no extra CLI commands.

    PollSCM

HELPDATA;
      return $help ;
    }

}