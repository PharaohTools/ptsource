<?php

Namespace Info;

class XVNCInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "XVNC Provisioner Integration";

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
        return array(
            "xvnc_during_build"
            // "xvnc_during_build"=> array("type" => "boolean", "default" => false, "label" => "Start Xvfb before the build, and shut it down after.", ),
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