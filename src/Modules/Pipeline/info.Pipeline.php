<?php

Namespace Info;

class PipelineInfo extends PTConfigureBase {

    public $hidden = true;

    public $name = "Pipeline Functionality";

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
  This module provides functionality for Pipelines. It provides no actions at the command line.
HELPDATA;
      return $help ;
    }

}