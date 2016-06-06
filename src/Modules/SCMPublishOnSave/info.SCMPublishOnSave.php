<?php

Namespace Info;

class SCMPublishOnSaveInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Copy build configuration after Pipeline Save";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "SCMPublishOnSave" => array_merge(parent::routesAvailable(), array() ) );
    }

    public function routeAliases() {
        return array("copyonsave"=>"SCMPublishOnSave","copy-on-save"=>"SCMPublishOnSave");
    }

    public function buildSettings() {
        return array("enabled", "target_directory");
    }

    public function events() {
        return array("afterPipelineSave", "afterCopiedPipelineSave");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension Copies a build configuration to another location when saving.
    It provides code functionality, but no extra CLI commands.

    copyonsave

HELPDATA;
      return $help ;
    }

}
