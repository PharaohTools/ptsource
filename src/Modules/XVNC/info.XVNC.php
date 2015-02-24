<?php

Namespace Info;

class XVNCInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "XVNC Virtual Desktop Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "XVNC" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("xvnc"=>"XVNC");
    }

    public function events() {
        return array("afterSettings", "afterBuildComplete");
    }

    public function buildSettings() {
        return array("xvnc_during_build");
    }

    public function configuration() {
        return array(
            "xvnc_command"=> array("type" => "text", "default" => "", "label" => "XVNC Command Location?", ),
            "xvnc_min_id"=> array("type" => "text", "default" => "0", "label" => "XVNC Minimum Desktop ID?", ),
            "xvnc_max_id"=> array("type" => "text", "default" => "99", "label" => "XVNC Maximum Desktop ID?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with XVNC as a Build Step. It provides code
    functionality, but no extra CLI commands.

    XVNC

HELPDATA;
      return $help ;
    }

}