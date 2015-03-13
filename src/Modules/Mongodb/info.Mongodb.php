<?php

Namespace Info;

class MongodbInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Mongodb Document upload";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array("Mongodb" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("mongodb"=>"Mongodb");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("host", "dbname", "collection", "path", "title");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Mongodb.

    Mongodb

HELPDATA;
      return $help ;
    }

}
 
 
 
