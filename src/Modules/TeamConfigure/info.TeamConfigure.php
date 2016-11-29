<?php

Namespace Info;

class RepositoryConfigureInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Build Configuration Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array("RepositoryConfigure" => array("show", "save", "new", "template", "copy"));
    }

    public function routeAliases() {
      return array("repositoryConfigure"=>"RepositoryConfigure", "build-configure"=>"RepositoryConfigure", "repositoryconfigure"=>"RepositoryConfigure");
    }

//    public function events() {
//        return array("beforeRepositorySave", "beforeCopiedRepositorySave", "afterRepositorySave", "afterCopiedRepositorySave");
//    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}