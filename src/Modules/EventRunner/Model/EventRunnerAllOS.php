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

    public function eventRunner($event, $allResults=false) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $logging->log("Executing event $event", $this->getModuleName()) ;
        $this->params["app-settings"]["app_config"] = \Model\AppConfig::getAppVariable("app_config");
        $this->params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
//         $logging->log("Loading application settings during event $event", $this->getModuleName()) ;
        $eventFactory = new \Model\Event() ;
        $eventModel = $eventFactory->getModel($this->params);
        $eventResult = $eventModel->runEvent($event, $allResults) ;
        return $eventResult ;
    }

}
