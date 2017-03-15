<?php

Namespace Info;

class TeamListInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "TeamList Module";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "TeamList" => array("show") );
    }

    public function routeAliases() {
      return array("teamList"=>"TeamList");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - Display or find lists of teams...
HELPDATA;
      return $help ;
    }

}