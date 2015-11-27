<?php

Namespace Model;

class EventAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function runEvent($event, $allResults=false) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $res = array();
        $modules = $this->getsModulesOfEvent($event) ;
        foreach ($modules as $module) {
            $eventModuleFactoryClass = '\Model\\'.$module;
            $eventModuleFactory = new $eventModuleFactoryClass() ;
            $eventModel = $eventModuleFactory->getModel($this->params) ;
            $eventMethods = $eventModel->getEvents() ;
            foreach ($eventMethods as $availableEventName => $availableEventMethods) {
                if ($event == $availableEventName) { // if the module provides an event for this
                    foreach ($availableEventMethods as $oneMethod) {
                        if (method_exists($eventModel, $oneMethod)) {
//                            $logging->log("Running ".get_class($eventModel)." with method $oneMethod", $this->getModuleName()) ;
                            $oneres = $eventModel->$oneMethod() ;
                            $res[] = $oneres ; }
                        else {
                            $logging->log("No method exists in ".get_class($eventModel)." with name $oneMethod", $this->getModuleName()) ;
                            $res[] = false ; } } } } }
        if ($allResults==true) {
            return $res ; }
        else {
            return (in_array(false, $res)) ? false : true ; }
    }

    public function getsModulesOfEvent($event) {
        $eventFactory = new Event();
        $eventRepository = $eventFactory->getModel($this->params, "EventRepository") ;
        $events = $eventRepository->getModulesWithEvent($event);
        return $events ;
    }

}