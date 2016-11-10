<?php

Namespace Info;

class PublicScopeInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Integrate functions for making Repositories Public";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "PublicScope" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("publicscope"=>"PublicScope");
    }

    public function events() {
        return array("getPublicLinks");
    }

    public function repositorySettings() {
        return array("enabled", "public_pages", "public_read", "public_write");
    }

    public function configuration() {
        return array(
            "enable_public"=> array(
                "type" => "boolean",
                "default" => "",
                "label" => "Enable use of Public Access for Pages and Repositories?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with PublicScope as a Build Step. It provides code
    functionality, but no extra CLI commands.

    PublicScope

HELPDATA;
      return $help ;
    }

}