<?php

Namespace Info;

class UserPermissionInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "User Permission Configurations";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "UserPermission" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("userpermission"=>"UserPermission", "user-permission"=>"UserPermission");
    }

    public function events() {
        return array("authenticate");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides User Permission Configuration It provides code
    functionality, but no extra CLI commands.

HELPDATA;
      return $help ;
    }

}