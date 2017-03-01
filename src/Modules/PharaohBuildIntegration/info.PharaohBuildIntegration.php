<?php

Namespace Info;

class PharaohBuildIntegrationInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Provides Functionality to integrate Pharaoh Build Reports with a Repository";

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

    public function configuration() {
        return array(
            "enabled"=> array(
                "type" => "boolean",
                "default" => "",
                "label" => "Enable Pharaoh Build Integration?", ),
            "build_instance_url_0"=> array(
                "type" => "text",
                "default" => "",
                "label" => "Home page of Build Instance 0?", ),
            "build_instance_key_0"=> array(
                "type" => "text",
                "default" => "",
                "label" => "API Key of Build Instance 0?", ),
            "build_instance_url_1"=> array(
                "type" => "text",
                "default" => "",
                "label" => "Home page of Build Instance 1?", ),
            "build_instance_key_1"=> array(
                "type" => "text",
                "default" => "",
                "label" => "API Key of Build Instance 1?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Pharaoh Build Reports for a Repository ,
    but no extra CLI commands.

    PharaohBuildIntegration

HELPDATA;
      return $help ;
    }

}