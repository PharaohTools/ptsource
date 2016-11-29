<?php

Namespace Info;

class DatastoreSQLLiteInfo extends PTConfigureBase {

    public $hidden = true;

    public $name = "SQLLite Datastore Settings and Functionality";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "Datastore" => array("index") );
    }

    public function routeAliases() {
        return array("datastore"=>"Datastore");
    }

    public function configuration() {
        return array(
            "ds_sqllite_enabled"=> array(
                "type" => "boolean",
                "default" => true,
                "label" => "Allow use of SQLLite as a Datastore (Requires allow Datastores)?",
            ),
        );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}