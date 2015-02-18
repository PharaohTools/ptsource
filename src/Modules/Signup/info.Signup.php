<?php

Namespace Info;

class SignupInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Signup/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "Signup" => array("login","logout","login-submit","login-status","registration","registration-submit") );
    }

    public function routeAliases() {
      return array("signup"=>"Signup");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}
