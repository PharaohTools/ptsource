<?php

Namespace Info;

class PullRequestInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Single Commit Details Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "PullRequest" => array("show", "delete") );
    }

    public function routeAliases() {
      return array("pullRequest"=>"PullRequest");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Repository Home page module for a single build...
HELPDATA;
      return $help ;
    }

}