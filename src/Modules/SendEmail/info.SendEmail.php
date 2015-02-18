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
        return array("afterBuildComplete");
    }

    public function configuration() {
        return array(
            "smtp_server"=> array(
                "type" => "text",
                "default" => "SMTP Server",
                "label" => "Enter SMTP Server Address?",
            ),
            "username"=> array(
                "type" => "text",
                "default" => "example@mail.com",
                "label" => "Email Username",
            ),
            "password"=> array(
                "type" => "text",
                "default" => "none",
                "label" => "Email Password",
            ),
            "port"=> array(
                "type" => "text",
                "default" => "25",
                "label" => "Email Server Port",
            ),
        );
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