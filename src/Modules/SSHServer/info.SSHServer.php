<?php

Namespace Info;

class SSHServerInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "SSH Server Integration";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( "SSHServer" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("SSHServer");
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
    This extension provides Git SSH Server Integration. It provides code
    functionality, but no extra CLI commands.

    SSHServer

HELPDATA;
      return $help ;
    }

}