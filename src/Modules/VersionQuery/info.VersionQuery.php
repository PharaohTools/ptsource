<?php

Namespace Info;

class VersionQueryInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Retrieve the Current or Next Version";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "VersionQuery" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("versionquery"=>"VersionQuery");
    }

    public function repositorySettings() {
        return array("enabled", "git_repository_url", "git_branch");
    }

//    public function configuration() {
//        return array(
//            "exec_delay"=> array(
//                "type" => "text",
//                "default" => "180",
//                "label" => "Minimum execution delay between Repository Mirroring Polling runs", ),
//        );
//    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with VersionQuery as a Build Step. It provides code
    functionality, but no extra CLI commands.

    VersionQuery

HELPDATA;
      return $help ;
    }

}