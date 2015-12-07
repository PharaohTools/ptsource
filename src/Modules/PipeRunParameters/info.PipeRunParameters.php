<?php

Namespace Info;

class PipeRunParametersInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Functionality to provide runtime parameters to your build";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "PipeRunParameters" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("piperunparameters"=>"PipeRunParameters");
    }

    public function buildSettings() {
        return array("piperun_parameters_enabled");
    }

    public function events() {
        return array("pipeRunParameterEnable", "pipeRunParameterLoad", "beforeBuild", "prepareBuild");
    } 
    
    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides Functionality to provide runtime parameters to your build.
    It provides code functionality, but no extra commands.

    PipeRunParameters

HELPDATA;
      return $help ;
    }

}
