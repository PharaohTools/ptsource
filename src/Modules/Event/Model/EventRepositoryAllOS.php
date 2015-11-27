<?php

Namespace Model;

class EventRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("EventRepository") ;

    public function getAllEvents() {
        $events = array() ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        foreach ($infos as $info) {
            if (method_exists($info, "events")) {
                $name = get_class($info);
                $name = str_replace("Info\\", "", $name) ;
                $name = substr($name, 0, strlen($name)-4) ;
                $events[$name] = $info->events(); } }
        return $events ;
    }

    public function getModulesWithEvent($wantedEvent) {
        $allEvents = $this->getAllEvents();
        $modulesWithEvent = array() ;
        foreach ($allEvents as $moduleName => $eventDetails) {
            $eventsForModule = $eventDetails ; // array_keys($eventDetails) ;
            if (in_array($wantedEvent, $eventsForModule)) {
                $modulesWithEvent[] = $moduleName ; } }
        return $modulesWithEvent ;
    }

}