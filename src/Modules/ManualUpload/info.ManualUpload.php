<?php

Namespace Info;

class ManualUploadInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "ManualUpload/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "ManualUpload" => array("show", "fileupload", "filedelete") );
    }

    public function routeAliases() {
      return array("documents"=>"ManualUpload");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}