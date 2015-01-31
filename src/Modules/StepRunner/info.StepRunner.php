<?php

Namespace Info;

class StepRunnerInfo extends CleopatraBase {

  public $hidden = false;

  public $name = "StepRunner - Functionality for collating or executing Build Steps from any Module";

  public function __construct() {
    parent::__construct();
  }

  public function routesAvailable() {
    return array( "StepRunner" =>  array_merge( array("now", "hard", "pause") ) );
  }

  public function routeAliases() {
    return array("stepRunner"=>"StepRunner");
  }

  public function helpDefinition() {
    $help = <<<"HELPDATA"
  This command allows you to stepRunner a phlagrant box

  StepRunner, stepRunner

        - now
        StepRunner a box now
        example: phlagrant stepRunner now

HELPDATA;
    return $help ;
  }

}