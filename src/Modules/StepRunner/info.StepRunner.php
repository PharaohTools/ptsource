<?php

Namespace Info;

class StepRunnerInfo extends PTConfigureBase {

  public $hidden = false;

  public $name = "StepRunner - Functionality for collating or executing Build Steps from any Module";

  public function __construct() {
    parent::__construct();
  }

  public function routesAvailable() {
    return array( "StepRunner" =>  array_merge( array("help") ) );
  }

  public function routeAliases() {
    return array("stepRunner"=>"StepRunner");
  }

  public function helpDefinition() {
    $help = 'This command allows you to Run a step in a Build

  StepRunner, stepRunner

        - now
        Wrapper functionality for running steps
        example: '.PHARAOH_APP.' stepRunner now ' ;
    return $help ;
  }

}