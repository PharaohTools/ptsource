<?php

Namespace Info;

class IndexInfo extends CleopatraBase {

    public $hidden = true;

    public $name = "Index/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "Index" => array("index") );
    }

    public function routeAliases() {
        return array("index"=>"Index");
    }

    public function configuration() {
        return array(
            "allow_override"=> array(
                "type" => "boolean",
                "default" => true,
                "label" => "Allow your home page to be overridden by other modules?",
            ),
            "text_param"=> array(
                "type" => "text",
                "default" => "Example Answer",
                "label" => "Example Text Conf Param",
            ),
        );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}