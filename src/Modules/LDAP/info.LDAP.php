<?php

Namespace Info;

class LDAPInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "LDAP Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array("LDAP" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("ldap"=>"LDAP");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("enable", "server", "base DN", "cn", "user", "pass");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with SVN.

    SVN

HELPDATA;
      return $help ;
    }

}
 
 
 
