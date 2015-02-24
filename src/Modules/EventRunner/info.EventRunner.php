<?php

Namespace Info;

class EventRunnerInfo extends PTConfigureBase {

  public $hidden = false;

  public $name = "EventRunner - Functionality for collating or executing Events";

  public function __construct() {
    parent::__construct();
  }

  public function routesAvailable() {
    return array( "EventRunner" =>  array_merge( array("help") ) );
  }

  public function routeAliases() {
    return array("eventRunner"=>"EventRunner");
  }

  public function helpDefinition() {
    $help = 'This command allows you to Run a event in a Build

  EventRunner, eventRunner

        - now
        Wrapper functionality for running events
        example: '.PHARAOH_APP.' eventRunner now ' ;
    return $help ;
  }

}