<?php

Namespace Info;

class RepositoryScopeInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Poll SCM for code changes Functionality";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "RepositoryScope" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("repositoryscope"=>"RepositoryScope");
    }

    public function events() {
        return array("prepareBuild");
    }

    public function repositorySettings() {
        return array("enabled", "public_pages", "public_read", "public_write");
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
    This extension provides integration with RepositoryScope as a Build Step. It provides code
    functionality, but no extra CLI commands.

    RepositoryScope

HELPDATA;
      return $help ;
    }

}