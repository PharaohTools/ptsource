<?php

Namespace Info;

class UserSwitchingInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "User Switching Configurations";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "UserSwitching" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("xvnc"=>"UserSwitching");
    }

    public function configuration() {
        return array(
            "switching_user"=> array("type" => "text", "default" => "www-data", "label" => "Username to Switch to", ),
        );
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides User Switching Configuration It provides code
    functionality, but no extra CLI commands.

    UserSwitching

HELPDATA;
      return $help ;
    }

}