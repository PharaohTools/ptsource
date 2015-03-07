<?php

Namespace Info;

class SSHInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "SSH File transfer";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "SSH" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("ssh"=>"SSH");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("username", "password", "ipaddress", "sourcefilepath", "destinationfilepath");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with SSH.

    SSH

HELPDATA;
      return $help ;
    }

}
 
 
 
