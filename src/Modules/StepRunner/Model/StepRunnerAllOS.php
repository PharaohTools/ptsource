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

    public function stepRunnerNow($hook = "") {
        $this->stepRunner->stepRunner($hook);
    }

    public function stepRunnerHook($hook, $type) {
        $this->stepRunner->stepRunnerHook($hook, $type);
    }

    protected function loadStepRunner() {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params) ;
        $provFile = dirname(dirname(__FILE__)).DS."StepRunners".DS.$this->phlagrantfile->config["vm"]["ostype"].".php" ;
        if (file_exists($provFile)) {
            require_once ($provFile) ;
            $logging->log("Step Runner found for {$this->phlagrantfile->config["vm"]["ostype"]}") ;
            $osp = new \Model\StepRunner($this->params) ;
            $osp->phlagrantfile = $this->phlagrantfile;
            $osp->papyrus = $this->papyrus;
            return $osp ; }
        $logging->log("No suitable Step Runner found");
        return null ;
    }

}