<?php

Namespace Info;

class AssetLoaderInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Asset Loader";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "AssetLoader" => array("show", "delete") );
    }

    public function routeAliases() {
      return array("assetLoader"=>"AssetLoader");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Repository Home page module for a single Repository...
HELPDATA;
      return $help ;
    }

}