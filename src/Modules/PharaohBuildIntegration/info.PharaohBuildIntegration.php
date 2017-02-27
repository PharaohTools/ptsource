<?php

Namespace Info;

class PharaohBuildIntegrationInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Provides Functionality to integrate Pharaoh Track Issues with a Repository";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "PharaohBuildIntegration" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("pharaohbuildintegration"=>"PharaohBuildIntegration");
    }

    public function repositorySettings() {
        return array();
    }

    public function events() {
        return array("getRepositoryFeatures");
    }

    public function repositoryFeatures() {
        return array("pharaohBuildIntegration");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Pharaoh Track Issues for a Repository ,
    but no extra CLI commands.

    PharaohBuildIntegration

HELPDATA;
      return $help ;
    }

}