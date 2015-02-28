<?php

Namespace Info;

class ConditionalStepRunnerInfo extends PTConfigureBase {

  public $hidden = false;

  public $name = "ConditionalStepRunner - Functionality for collating or executing conditional Build Steps from any Module";

  public function __construct() {
    parent::__construct();
  }

  public function routesAvailable() {
    return array( "ConditionalStepRunner" =>  array_merge( array("help") ) );
  }

  public function routeAliases() {
    return array("conditionalStepRunner"=>"ConditionalStepRunner");
  }
  
  public function buildSteps() {
        
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