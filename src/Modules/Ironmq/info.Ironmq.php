<?php

Namespace Info;

class IronmqInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Ironmq Message transfer";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array("Ironmq" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("ironmq"=>"Ironmq");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("token", "projectid", "queuename");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Ironmq.

    Ironmq

HELPDATA;
      return $help ;
    }

}
 
 
 
