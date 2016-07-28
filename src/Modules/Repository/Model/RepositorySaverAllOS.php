<?php

Namespace Model;

class RepositorySaverAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("RepositorySaver") ;

    public function saveRepository($save) {
        $r = $this->saveStates($save);
        return $r ;
    }

    public function getRepositoryNames() {
        $repositories = $this->getRepositories() ;
        $names = array_keys($repositories) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

    private function saveStates($save) {
        $saveRes = array() ;
        $saveRes["statuses"] = $this->saveStatuses($save) ;
        $saveRes["defaults"] = $this->saveDefaults($save) ;
        $saveRes["settings"] = $this->saveSettings($save) ;
        $saveRes["steps"] = $this->saveSteps($save) ;
        return $saveRes ;
    }

    private function saveStatuses($save) {
        $statuses = array( "last_status" => true, "has_parents" => true, "has_children" => true ) ;
        return $statuses ;
    }

    private function saveDefaults($save) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (isset($save["type"]) && $save["type"] == "Defaults") {
            $defaultsFile = REPODIR.DS.$this->params["item"].DS.'defaults' ;
            $logging->log("Storing defaults file in Repository at $defaultsFile", $this->getModuleName()) ;
            $defaults = json_encode($save["data"], JSON_PRETTY_PRINT) ;
            return file_put_contents($defaultsFile, $defaults) ; }
        return false ;
    }

    private function saveSteps($save) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (isset($save["type"]) && $save["type"] == "Steps") {
            $stepsFile = REPODIR.DS.$this->params["item"].DS.'steps' ;
            $logging->log("Storing steps file in Repository at $stepsFile", $this->getModuleName()) ;
            $steps = json_encode($save["data"], JSON_PRETTY_PRINT) ;
            return file_put_contents($stepsFile, $steps) ; }
        $statuses = array() ;
        return $statuses ;
    }

    private function saveSettings($save) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (isset($save["type"]) && $save["type"] == "Settings") {
            $stepsFile = REPODIR.DS.$this->params["item"].DS.'settings' ;
            $logging->log("Storing settings file in Repository at $stepsFile", $this->getModuleName()) ;
            $steps = json_encode($save["data"], JSON_PRETTY_PRINT) ;
            return file_put_contents($stepsFile, $steps) ; }
        $statuses = array() ;
        return $statuses ;
    }

}