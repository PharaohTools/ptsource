<?php

Namespace Info;

class CommitDetailsInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "CommitDetails/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "CommitDetails" => array("show", "delete") );
    }

    public function routeAliases() {
      return array("commitDetails"=>"CommitDetails");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Repository Home page module for a single build...
HELPDATA;
      return $help ;
    }

}