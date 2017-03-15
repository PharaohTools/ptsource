<?php

Namespace Info;

class RepositoryHistoryInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "RepositoryHistory Module";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "RepositoryHistory" => array("show") );
    }

    public function routeAliases() {
      return array("repositoryHistory"=>"RepositoryHistory");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - Display or find historys of commits...
HELPDATA;
      return $help ;
    }

}