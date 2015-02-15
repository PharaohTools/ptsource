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
        return array("sendemail"=>"SendEmail");
    }

    public function events() {
        return array("beforeSettings", "beforeBuild", "afterBuildComplete");
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