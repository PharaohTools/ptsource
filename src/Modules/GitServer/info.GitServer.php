<?php

Namespace Info;

class GitServerInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Git Server Implementation";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "GitServer" => array("serve") );
    }

    public function routeAliases() {
        return array("gitServer"=>"GitServer");
    }

    public function ignoredAuthenticationRoutes() {
        return array("GitServer"=>array("serve"));
    }

    public function events() {
        return array("afterApplicationConfigurationSave");
    }

    public function configuration() {
        return array(
            "enable_ssh_server"=> array("type" => "boolean", "label" => "Enable Git SSH Server?", ),
            "server_port"=> array("type" => "text", "default" => "22", "label" => "Git SSH Server Port?", ),
//            "force_ssl"=> array("type" => "boolean", "label" => "Force SSL?", ),
        );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is the Git Server Module
HELPDATA;
      return $help ;
    }

}