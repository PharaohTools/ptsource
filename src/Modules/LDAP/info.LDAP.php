<?php

Namespace Info;

class LDAPInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "LDAP Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array("LDAP" => array("ldaplogin", "ldap-submit", "help") );
    }

    public function routeAliases() {
        return array("ldap"=>"LDAP");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with LDAP.

    LDAP

HELPDATA;
      return $help ;
    }

}
 
 
 
