<?php

Namespace Info;

class BinaryGroupsInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Allow multiple groups for single versions of a Binary";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "BinaryGroups" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("binarygroups"=>"BinaryGroups");
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
    This extension provides integration with BinaryGroups as a Build Step. It provides code
    functionality, but no extra CLI commands.

    BinaryGroups

HELPDATA;
      return $help ;
    }

}