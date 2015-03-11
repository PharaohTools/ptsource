<?php

Namespace Info;

class OAuthInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "login using OAuth/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "OAuth" => array("githublogin","googlelogin","fblogin","login-status","registration","registration-submit") );
    }

    public function routeAliases() {
      return array("oauth"=>"OAuth");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}
