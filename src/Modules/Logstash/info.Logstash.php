<?php

Namespace Info;

class LogstashInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Logstash";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "Logstash" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("logstash"=>"Logstash");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("username", "password", "ipaddress", "sourcefilepath", "destinationfilepath");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Logstash.

    Logstash

HELPDATA;
      return $help ;
    }

}
 
 
 
