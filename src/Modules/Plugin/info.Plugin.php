<?php

Namespace Info;

class PluginInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Plugin Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "Plugin" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("plugin"=>"Plugin");
    }

    public function buildSteps() {
        return array("plugin");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration to run Plugins. It call plugin Triger.php in plugins folder.

    Shell

HELPDATA;
      return $help ;
    }

}