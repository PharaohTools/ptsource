<?php

Namespace Info;

class TrackIssuesInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Provides Functionality to integrate Pharaoh Track Issues with a Repository";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "TrackIssues" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("trackissues"=>"TrackIssues");
    }

    public function repositorySettings() {
        return array();
    }

    public function events() {
        return array("getRepositoryFeatures");
    }

    public function repositoryFeatures() {
        return array("trackIssues");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with Pharaoh Track Issues for a Repository ,
    but no extra CLI commands.

    TrackIssues

HELPDATA;
      return $help ;
    }

}