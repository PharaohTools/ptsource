<?php

Namespace Model;

class EventRunnerAllOS extends BaseLinuxApp {

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

    public function eventRunner($event) {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $logging->log("Executing event $event", $this->getModuleName()) ;
        $eventFactory = new \Model\Event() ;
        $eventModel = $eventFactory->getModel($this->params);
        $eventResult = $eventModel->runEvent($event) ;
        return $eventResult ;
    }

}
