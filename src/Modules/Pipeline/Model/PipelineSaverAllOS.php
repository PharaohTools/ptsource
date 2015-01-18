<?php

Namespace Model;

class PipelineSaverAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("PipelineSaver") ;

    public function savePipeline($save) {
        $r = $this->saveStates($save);
        return $r ;
    }

    public function getPipelineNames() {
        $pipelines = $this->getPipelines() ;
        $names = array_keys($pipelines) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

    private function saveStates($save) {
        $saveRes = array() ;
        $saveRes["statuses"] = $this->saveStatuses($save) ;
        $saveRes["defaults"] = $this->saveDefaults($save) ;
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
            $defaultsFile = PIPEDIR.DS.$this->params["item"].DS.'defaults' ;
            $logging->log("Storing defaults file in pipe at $defaultsFile", $this->getModuleName()) ;
            $defaults = json_encode($save["data"]) ;
            return file_put_contents($defaultsFile, $defaults) ; }
        return false ;
    }

    private function saveSteps($save) {
        $statuses = array() ;
        return $statuses ;
    }

}