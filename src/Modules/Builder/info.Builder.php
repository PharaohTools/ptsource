<?php

Namespace Info;

class BuilderInfo extends CleopatraBase {

    public $hidden = true;

    public $name = "Builder Functionality";

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
  This module provides functionality for Builders. It provides no actions at the command line.
HELPDATA;
      return $help ;
    }

}