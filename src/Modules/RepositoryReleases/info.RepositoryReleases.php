<?php

Namespace Info;

class RepositoryReleasesInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "RepositoryReleases/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "RepositoryReleases" => array("show") );
    }

    public function routeAliases() {
      return array("repositoryReleases"=>"RepositoryReleases");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - Display or find historys of commits...
HELPDATA;
      return $help ;
    }

}