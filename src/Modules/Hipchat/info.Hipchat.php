<?php

Namespace Info;

class HipchatInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Hipchat File transfer";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "Hipchat" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("hipchat"=>"Hipchat");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("Token", "Room Id or Name", "From");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Hipchat.

    Hipchat

HELPDATA;
      return $help ;
    }

}
 
 
 
