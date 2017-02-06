<?php

Namespace Info;

class TeamConfigureInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Build Configuration Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array("TeamConfigure" => array("show", "save", "new", "template", "copy"));
    }

    public function routeAliases() {
      return array("teamConfigure"=>"TeamConfigure", "teamconfigure"=>"TeamConfigure");
    }

//    public function events() {
//        return array("beforeTeamSave", "beforeCopiedTeamSave", "afterTeamSave", "afterCopiedTeamSave");
//    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}