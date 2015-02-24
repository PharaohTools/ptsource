<?php

Namespace Info;

class XVFBInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "XVFB Virtual Desktop Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "XVFB" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("xvfb"=>"XVFB");
    }

    public function events() {
        return array("afterSettings", "afterBuildComplete");
    }

    public function buildSettings() {
        return array("xvfb_during_build");
    }

    public function configuration() {
        return array(
            "xvfb_command"=> array("type" => "text", "default" => "", "label" => "XVFB Command Location?", ),
            "xvfb_min_id"=> array("type" => "text", "default" => "0", "label" => "XVFB Minimum Desktop ID?", ),
            "xvfb_max_id"=> array("type" => "text", "default" => "99", "label" => "XVFB Maximum Desktop ID?", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with XVFB as a Build Step. It provides code
    functionality, but no extra CLI commands.

    XVFB

HELPDATA;
      return $help ;
    }

}