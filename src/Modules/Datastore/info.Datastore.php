<?php

Namespace Info;

class DatastoreInfo extends PTConfigureBase {

    public $hidden = true;

    public $name = "Datastore Settings and Functionality";

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
            "allow_datastores"=> array(
                "type" => "boolean",
                "default" => true,
                "label" => "Allow alternate Datastores?",
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