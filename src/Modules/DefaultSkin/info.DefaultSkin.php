<?php

Namespace Info;

class DefaultSkinInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Default Skin Files";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "DefaultSkin" => array("help") );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This module is part of Core - its the default skin files...
HELPDATA;
      return $help ;
    }

}