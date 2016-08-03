<?php

Namespace Info;

class GitServerInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Git Server Implementation";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "GitServer" => array("serve") );
    }

    public function routeAliases() {
      return array("gitServer"=>"GitServer");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Git Server Module
HELPDATA;
      return $help ;
    }

}