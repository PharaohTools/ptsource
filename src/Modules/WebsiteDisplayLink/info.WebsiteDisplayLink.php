<?php

Namespace Info;

class WebsiteDisplayLinkInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Website Display Link for build";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "WebsiteDisplayLink" => array_merge(parent::routesAvailable(), array("help", "report") ) );
    }

    public function routeAliases() {
        return array("websitedisplaylink"=>"WebsiteDisplayLink","website-display-link"=>"WebsiteDisplayLink");
    }

    public function events() {
        return array("afterBuildComplete", "getBuildFeatures");
    }

    public function pipeFeatures() {
        return array("htmlReports");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension displays a Website Link for a pipeline. It provides code
    functionality, but no extra CLI commands.

    websitedisplaylink

HELPDATA;
      return $help ;
    }

}
