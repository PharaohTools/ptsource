<?php

Namespace Info;

class PHPScriptInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "PHPScript Provisioner Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "PHPScript" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("phpscript"=>"PHPScript");
    }

    public function buildSteps() {
        return array("phpscriptfile");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with PHPScript as a Build Step. It provides code
    functionality, but no extra commands.

    PHPScript

HELPDATA;
      return $help ;
    }

}