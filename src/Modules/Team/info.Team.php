<?php

Namespace Info;

class TeamInfo extends PTConfigureBase {

    public $hidden = true;

    public $name = "Team Functionality";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array();
    }

    public function routeAliases() {
      return array();
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This module provides functionality for Teams. It provides no actions at the command line.
HELPDATA;
      return $help ;
    }

}