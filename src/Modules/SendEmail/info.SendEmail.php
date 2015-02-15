<?php

Namespace Info;

class SendEmailInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "SendEmail Provisioner Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "SendEmail" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("clearworkspace"=>"SendEmail");
    }

    public function buildSteps() {
        return array("clearworkspacefile");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with SendEmail as a Build Step. It provides code
    functionality, but no extra commands.

    SendEmail

HELPDATA;
      return $help ;
    }

}