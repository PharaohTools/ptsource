<?php

Namespace Model;

class EventCollaterAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("EventCollater") ;

    public function getEventMethodsFromModule($event, $module) {
        $eventFactoryClass = '\Model\\'.$module;
        $eventFactory = new $eventFactoryClass() ;
        $eventModel = $eventFactory->getModel($this->params);
        if (method_exists($eventModel, "getEvents")) {
            $modEvents = $eventModel->getEvents() ; }
        else {
            $modEvents = array() ; }
        return $modEvents[$event] ;
    }
}