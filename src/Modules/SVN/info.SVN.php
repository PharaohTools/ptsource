<?php

Namespace Info;

class SVNInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "SVN File transfer";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "SVN" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("svn"=>"SVN");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("Url", "Username", "Password");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with SVN.

    Hipchat

HELPDATA;
      return $help ;
    }

}
 
 
 
