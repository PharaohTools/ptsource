<?php

Namespace Info;

class PipeFeatureInfo extends PTConfigureBase {

    public $hidden = true;

    public $name = "PipeFeature Functionality";

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
  This module provides functionality for PipeFeatures. It provides no actions at the command line.
HELPDATA;
      return $help ;
    }

}