<?php

Namespace Info;

class RepositoryPullRequestsInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "RepositoryPullRequests/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "RepositoryPullRequests" => array("show") );
    }

    public function routeAliases() {
      return array("repositoryPullRequests"=>"RepositoryPullRequests");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - Display or find historys of commits...
HELPDATA;
      return $help ;
    }

}