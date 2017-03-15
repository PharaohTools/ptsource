<?php

Namespace Info;

class RepositoryReleasesInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Repository Releases Module";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "RepositoryReleases" => array("show") );
    }

    public function routeAliases() {
      return array("repositoryReleases"=>"RepositoryReleases");
    }

    public function repositorySettings() {
        return array("stdrel_enabled", "stdrel_zip_enabled", "stdrel_tar_enabled", "pharaoh_build_rel_enabled");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - Display or find history of Release packages...
HELPDATA;
      return $help ;
    }

}