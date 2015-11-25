<?php

Namespace Info;

class CopyOnSaveInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Publish HTML reports for build";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "CopyOnSave" => array_merge(parent::routesAvailable(), array("help", "report") ) );
    }

    public function routeAliases() {
        return array("copyonsave"=>"CopyOnSave","CopyOnSave"=>"CopyOnSave");
    }

    public function events() {
        return array("afterBuildComplete", "getBuildFeatures");
    }

    public function pipeFeatures() {
        return array("htmlReports");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension publish HTML reports of a build. It provides code
    functionality, but no extra CLI commands.

    copyonsave

HELPDATA;
      return $help ;
    }

}
