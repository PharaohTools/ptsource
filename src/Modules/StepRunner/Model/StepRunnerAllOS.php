<?php

Namespace Model;

class StepRunnerAllOS extends BaseLinuxApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params);
        $this->initialize();
    }

    public function stepRunner($step) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params) ;
        // get build step module from step
        $stepModule = $step["module"] ;
        $modx = \Core\AutoLoader::moduleExists($stepModule) ;
        if ($modx == false) {
            $logging->log ("No Module {$stepModule} is installed", $this->getModuleName() ) ;
            return false ;  }
        // fire up the model for it
        $stepFactoryClass = '\Model\\'.$stepModule;
        $stepFactory = new $stepFactoryClass() ;
        $stepModel = $stepFactory->getModel($this->params);
        $modStepTypes = $stepModel->getStepTypes() ;
        // if type not supported return false
        if (!in_array($step["steptype"], $modStepTypes)) {
            $logging->log ("Module {$stepModule} does not support step type", $this->getModuleName() ) ;
            return false ; } ;
        echo "Module {$step["module"]}, step type {$step["steptype"]}\n" ;
        // send step data to method in question
        $stepResult = $stepModel->executeStep($step) ;
        // return the result of the step run (true or false, output should already be done)
        return $stepResult ;
    }

}