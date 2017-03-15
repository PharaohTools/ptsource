<?php

Namespace Info;

class RepositoryListInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "RepositoryList Module";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "RepositoryList" => array("show") );
    }

    public function routeAliases() {
      return array("repositoryList"=>"RepositoryList");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - Display or find lists of repositories...
HELPDATA;
      return $help ;
    }

}