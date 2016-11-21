<?php

Namespace Info;

class HiddenScopeInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Integrate functions for making Repositories Public";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "HiddenScope" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("hiddenscope"=>"HiddenScope");
    }

    public function repositorySettings() {
        return array("enabled");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with HiddenScope as a Repository Setting. It provides code
    functionality, but no extra CLI commands.

    HiddenScope

HELPDATA;
      return $help ;
    }

}