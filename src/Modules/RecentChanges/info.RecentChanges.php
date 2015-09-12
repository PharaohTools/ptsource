<?php

Namespace Info;

class RecentChangesInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Recent Changes for a build";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "RecentChanges" => array_merge(parent::routesAvailable(), array("help", "report") ) );
    }

    public function routeAliases() {
        return array("recentChanges"=>"RecentChanges","recentchanges"=>"RecentChanges","recent-changes"=>"RecentChanges");
    }

    public function pipeFeatures() {
        return array("recentChanges");
    }

    public function buildSettings() {
        return array("recent_changes_enabled");
    }


    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension displays Recent Changes for a build. It provides code
    functionality, but no extra CLI commands.

    RecentChanges

HELPDATA;
      return $help ;
    }

}
