<?php

Namespace Info;

class AssetPublisherInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Publish Assets to Web Server";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "AssetPublisher" => array_merge(parent::routesAvailable(), array("help", "publish") ) );
    }

    public function routeAliases() {
        return array("assetpublisher"=>"AssetPublisher");
    }

    public function events() {
        return array("publish-assets");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with AssetPublisher as a Track Step. It provides code
    functionality, and the publish CLI command.

    AssetPublisher

HELPDATA;
      return $help ;
    }

}