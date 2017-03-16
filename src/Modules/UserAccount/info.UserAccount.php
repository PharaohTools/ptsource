<?php

Namespace Info;

class UserAccountInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "UserAccount and Login Functionality";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
        return array( "UserAccount" => array("login","logout","login-submit","login-status","registration","registration-submit") );
    }

    public function ignoredAuthenticationRoutes() {
        return array( "UserAccount" => array("login","logout","login-submit","login-status","registration-submit") );
    }

    public function routeAliases() {
      return array("signup"=>"UserAccount");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}
