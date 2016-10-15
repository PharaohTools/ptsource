<?php

Namespace Info;

class SourceHomeInfo extends PTConfigureBase {

    public $hidden = true;

    public $name = "SourceHome - an Improved Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "SourceHome" => array("show", "get-all-issue-counts", "get-submitted-issue-counts", "get-watching-issue-counts", "get-assigned-issue-counts") );
    }

    public function routeAliases() {
        return array("sourceHome"=>"SourceHome");
    }

    public function configuration() {
        return array(
            "index_override"=> array(
                "type" => "boolean",
                "default" => true,
                "label" => "Override your default Index Module with this Improved Home Page?",
            ),
        );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}