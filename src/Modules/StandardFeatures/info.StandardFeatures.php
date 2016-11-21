<?php

Namespace Info;

class StandardFeaturesInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Standard Features for code changes Functionality";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "StandardFeatures" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("standardfeatures"=>"StandardFeatures");
    }

    public function repositorySettings() {
        return array("php_enabled", "html_enabled", "ptvirtualize_enabled", "ptconfigure_enabled",
            "pttest_enabled", "pttrack_enabled", "ptbuild_enabled", "ptdeploy_enabled", "ptmanage_enabled");
    }

    public function events() {
        return array("getRepositoryFeatures");
    }

    public function repositoryFeatures() {
        return array("standardFeatures");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Standard Features for Projects. It provides code
    functionality, but no extra CLI commands.

    StandardFeatures

HELPDATA;
      return $help ;
    }

}