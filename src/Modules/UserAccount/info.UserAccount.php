<?php

Namespace Info;

class SignupInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Signup and Login Functionality";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
        return array( "Signup" => array("login","logout","login-submit","login-status","registration","registration-submit") );
    }

    public function ignoredAuthenticationRoutes() {
        return array( "Signup" => array("login","logout","login-submit","login-status","registration-submit") );
    }

    public function routeAliases() {
      return array("signup"=>"Signup");
    }

    public function configuration() {
        return array(
            "signup_enabled"=> array("type" => "boolean", "default" => "off", "label" => "Signups Enabled?", ),
            "registration_enabled"=> array("type" => "boolean", "default" => "off", "label" => "User Self Registration Enabled?", ),
        );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}
