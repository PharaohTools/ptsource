<?php

Namespace Info;

class XVFBInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "XVFB Provisioner Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "XVFB" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("xvnc"=>"XVFB");
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
    This extension provides integration with XVFB as a Build Step. It provides code
    functionality, but no extra CLI commands.

    XVFB

HELPDATA;
      return $help ;
    }

}