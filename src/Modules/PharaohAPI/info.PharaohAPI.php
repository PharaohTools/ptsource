<?php

Namespace Info;

class PharaohAPIInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Publish functionality through the API";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "PharaohAPI" => array_merge(parent::routesAvailable(), array("help", "call", "request") ) );
    }

    public function routeAliases() {
        return array("pharaohapi"=>"PharaohAPI","PharaohAPI"=>"PharaohAPI");
    }

    public function events() {
        return array("afterBuildComplete", "getBuildFeatures");
    }

    public function pipeFeatures() {
        return array("pharaohAPI");
    }

    public function buildSettings() {
        return array("pharaohAPI");
    }

    public function ignoredAuthenticationRoutes() {
        return array( "PharaohAPI" => array("call") );
    }

    public function configuration() {
        return array(
            "enabled"=> array(
                "type" => "boolean",
                "default" => "",
                "label" => "Enable Inbound Pharaoh API?", ),
            "api_key_0"=> array(
                "type" => "text",
                "default" => "",
                "label" => "API Key 0?", ),
            "api_key_1"=> array(
                "type" => "text",
                "default" => "",
                "label" => "API Key 1?", ),
            "api_key_2"=> array(
                "type" => "text",
                "default" => "",
                "label" => "API Key 2?", ),
            "api_key_3"=> array(
                "type" => "text",
                "default" => "",
                "label" => "API Key 3?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides API Publishing functionality. It provides code
    functionality, but no extra CLI commands.

    pharaohapi

HELPDATA;
      return $help ;
    }

}
