<?php

Namespace Info;

class FileBrowserInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "FileBrowser Module";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "FileBrowser" => array("show") );
    }

    public function routeAliases() {
      return array("filebrowser"=>"FileBrowser");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}