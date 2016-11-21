<?php

Namespace Info;

class WebsiteDisplayLinkInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Website Display Link for build";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "WebsiteDisplayLink" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("websitedisplaylink"=>"WebsiteDisplayLink","website-display-link"=>"WebsiteDisplayLink");
    }

    public function events() {
        return array("getRepositoryFeatures");
    }

    public function repositoryFeatures() {
        return array("standardFeatures");
    }

    public function repositorySettings() {
        return array("website_display_link");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension displays a Website Link for a repository. It provides code
    functionality, but no extra CLI commands.

    websitedisplaylink

HELPDATA;
      return $help ;
    }

}
