<?php

Namespace Info;

class RepositoryListInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "RepositoryList Module";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "RepositoryList" => array("show") );
    }

    public function routeAliases() {
      return array("repositoryList"=>"RepositoryList");
    }

    public function configuration() {
        return array(
            "index_override"=> array(
                "type" => "boolean",
                "default" => true,
                "label" => "Override your default Index Module with Repository Listing as a Home Page?",
            ),
        );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - Display or find lists of repositories...
HELPDATA;
      return $help ;
    }

}