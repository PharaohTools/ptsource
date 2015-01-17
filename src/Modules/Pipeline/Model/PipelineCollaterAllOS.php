<?php

Namespace Model;

class PipelineCollaterAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("PipelineCollater") ;

    public function getPipeline() {
        $r = $this->collate();
        return $r ;
    }

    public function getPipelineNames() {
        $pipelines = $this->getPipelines() ;
        $names = array_keys($pipelines) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

    private function collate() {
        $collated = array() ;
        $collated = array_merge($collated, $this->getStatuses()) ;
        $collated = array_merge($collated, $this->getDefaults()) ;
        $collated = array_merge($collated, $this->getSteps()) ;
        return $collated ;
    }

    private function getStatuses() {
        $statuses = array( "last_status" => true, "has_parents" => true, "has_children" => true ) ;
        return $statuses ;
    }

    private function getDefaults() {
        $defaults = array();
        $defaultsFile = PIPEDIR.DS.$this->params["item"].DS.'defaults' ;
        if (file_exists($defaultsFile)) {
            $defaultsFileData =  file_get_contents($defaultsFile) ;
            $defaults = json_decode($defaultsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("No defaults file available in build", $this->getModuleName()) ; }
        return $defaults ;
    }

    private function getSteps() {
        $statuses = array() ;
        return $statuses ;
    }

}