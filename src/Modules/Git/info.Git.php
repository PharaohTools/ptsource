<?php

Namespace Info;

class GitInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Git Provisioner Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "Git" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("git"=>"Git");
    }

    public function buildSteps() {
        return array("gitscript", "gitfile");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Git as a Build Step. It provides code
    functionality, but no extra commands.

    Git

HELPDATA;
      return $help ;
    }

}