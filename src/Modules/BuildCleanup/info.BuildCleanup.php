<?php

Namespace Info;

class BuildCleanupInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Build Cleanup Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "BuildCleanup" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("buildcleanup"=>"BuildCleanup");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("build_cleanup_enabled", "no_to_keep");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with BuildCleanup as Build Settings. It provides code
    functionality, but no extra CLI commands. This is used for removing old build files.

    BuildCleanup

HELPDATA;
      return $help ;
    }

}