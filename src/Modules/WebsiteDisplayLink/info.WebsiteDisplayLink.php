<?php

Namespace Info;

class WebsiteDisplayLinkInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Publish HTML reports for build";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "WebsiteDisplayLink" => array_merge(parent::routesAvailable(), array("help", "report") ) );
    }

    public function routeAliases() {
        return array("publishhtmlreports"=>"WebsiteDisplayLink","WebsiteDisplayLink"=>"WebsiteDisplayLink");
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

    publishhtmlreports

HELPDATA;
      return $help ;
    }

}
