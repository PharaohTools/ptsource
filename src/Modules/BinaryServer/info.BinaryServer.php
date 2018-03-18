<?php

Namespace Info;

class BinaryServerInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "HTTP Binary Server Implementation";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "BinaryServer" => array("serve") );
    }

    public function routeAliases() {
        return array("binaryServer"=>"BinaryServer");
    }

    public function ignoredAuthenticationRoutes() {
        return array("BinaryServer"=>array("serve"));
    }

    public function events() {
        return array("afterApplicationConfigurationSave");
    }

    public function configuration() {
        return array(
//            "enable_ssh_server"=> array("type" => "boolean", "label" => "Enable OpenSSH Server Integration?", ),
//            "server_port"=> array("type" => "text", "default" => "22", "label" => "Binary SSH Server Port?", ),
        );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Binary Server Module
HELPDATA;
      return $help ;
    }

}