<?php

Namespace Info;

class PullRequestInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Pull Request Details Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "PullRequest" => array("show", "delete", "add-comment") );
    }

    public function routeAliases() {
      return array("pullRequest"=>"PullRequest");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Repository Pull Request page module...
HELPDATA;
      return $help ;
    }

}