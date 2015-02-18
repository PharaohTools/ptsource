<?php

Namespace Info;

class PluginInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Plugin Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "Shell" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("shell"=>"Shell");
    }

    public function buildSteps() {
        return array("shellscript", "shellfile");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration to run Plugins. It call plugin Triger.php in plugins folder.

    Shell

HELPDATA;
      return $help ;
    }

}