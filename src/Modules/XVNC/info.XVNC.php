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
            "xvfb_command"=> array("type" => "text", "default" => "", "label" => "XVFB Command Location?", ),
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