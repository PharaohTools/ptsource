<?php

Namespace Info;

class QuickLinksInfo extends PTConfigureBase {

    public $hidden = true;

    public $name = "QuickLinks - an Improved Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "QuickLinks" => array("show", "get-all-issue-counts", "get-submitted-issue-counts", "get-watching-issue-counts", "get-assigned-issue-counts") );
    }

    public function routeAliases() {
        return array("quickLinks"=>"QuickLinks");
    }

    public function configuration() {
        return array(
            "index_override"=> array(
                "type" => "boolean",
                "default" => true,
                "label" => "Override your default index page with Quick Links?",
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