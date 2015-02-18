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

    public function runEvent($event) {
        $modules = $this->getsModulesOfEvent($event) ;
        // echo "in event module: count ".count($modules)."\n" ;
        // echo implode(" ", $modules) ;
        foreach ($modules as $module ) {            echo $module;
            $eventModuleFactoryClass = '\Model\\'.$module;
            $eventModuleFactory = new $eventModuleFactoryClass() ;
            $eventModel = $eventModuleFactory->getModel($this->params) ;
            $eventMethods = $eventModel->getEvents() ;
            foreach ($eventMethods as $availableEventName => $availableEventMethods) {
                if ($event == $availableEventName) { // if the module provides an event for this
                    foreach ($availableEventMethods as $oneMethod) {
                        if (method_exists($eventModel, $oneMethod)) {
                            echo "Running ".get_class($eventModel)." with method $oneMethod\n" ;
                            $eventModel->$oneMethod() ; }
                        else {
                            echo "No method exists in ".get_class($eventModel)." with name $oneMethod\n" ; } } } } }
        $ret = $event ;
        return $ret ;
    }

    public function getsModulesOfEvent($event) {
        $eventFactory = new Event();
        $eventRepository = $eventFactory->getModel($this->params, "EventRepository") ;
        $events = $eventRepository->getModulesWithEvent($event);
        return $events ;
    }

}