<?php

Namespace Info;

class BuildConfigureInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Build Configuration Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array("BuildConfigure" => array("show", "save", "new", "template", "copy"));
    }

    public function routeAliases() {
      return array("buildConfigure"=>"BuildConfigure", "build-configure"=>"BuildConfigure", "buildconfigure"=>"BuildConfigure");
    }

//    public function events() {
//        return array("beforePipelineSave", "beforeCopiedPipelineSave", "afterPipelineSave", "afterCopiedPipelineSave");
//    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}