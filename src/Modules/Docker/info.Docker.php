<?php

Namespace Info;

class DockerInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Publish HTML reports for build";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "PublishHTMLreports" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("publishhtmlreports"=>"PublishHTMLreports","PublishHTMLreports"=>"PublishHTMLreports");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension publish HTML reports of a build. It provides code
    functionality, but no extra CLI commands.

    publishhtmlreports

HELPDATA;
      return $help ;
    }

}
