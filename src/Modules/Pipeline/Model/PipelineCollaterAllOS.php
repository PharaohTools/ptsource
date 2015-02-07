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

    public function getPipeline($pipe = null) {
        if ($pipe != null) { $this->params["item"] = $pipe ; }
        $r = $this->collate();
        return $r ;
    }

    private function collate() {
        $collated = array() ;
        $collated = array_merge($collated, $this->getStatuses()) ;
        $collated = array_merge($collated, $this->getDefaults()) ;
        $collated = array_merge($collated, $this->getSteps()) ;
        return $collated ;
    }

    private function getStatuses() {
        $statuses = array(
            "last_status" => $this->getLastStatus(),
            "has_parents" => true,
            "has_children" => true ) ;
        return $statuses ;
    }

    private function getLastStatus() {
        $allRuns = scandir(PIPEDIR.DS.$this->params["item"].DS.'history') ;
        /*foreach($allRuns as &$run) {
            if (!is_int($run)) { unset($run) ; } }*/
        foreach($allRuns as $i=>$run) {
            if (is_numeric($allRuns[$i])) { intval($allRuns[$i]) ; } else { unset($allRuns[$i]) ; } 
		}
     	$runId = max($allRuns) ;
        /*$lastStatus = strpos($out, "SUCCESSFUL EXECUTION") ;*/
        return $this->getRunOutput($runId) ; /*$out; (is_int($lastStatus)) ? true : false ;*/
    }

    private function getRunOutput($runId) {
        $outFile = PIPEDIR.DS.$this->params["item"].DS.'history'.DS.$runId ;
        $out = file_get_contents($outFile) ;
        $lastStatus = strpos($out, "SUCCESSFUL EXECUTION") ;
        return ($lastStatus) ? true : false ;
    }

    private function getDefaults() {
        $defaults = array() ;
        $defaultsFile = PIPEDIR.DS.$this->params["item"].DS.'defaults' ;
        if (file_exists($defaultsFile)) {
            $defaultsFileData =  file_get_contents($defaultsFile) ;
            $defaults = json_decode($defaultsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("No defaults file available in build", $this->getModuleName()) ; }
        $defaults = $this->setDefaultSlugIfNeeded($defaults) ;
        return $defaults ;
    }

    private function setDefaultSlugIfNeeded($defaults) {
        if (!isset($defaults["project-slug"])) {
            $defaults["project-slug"] = $this->params["item"] ; }
        if (isset($defaults["project-slug"]) && $defaults["project-slug"] == "") {
            $defaults["project-slug"] = $this->params["item"] ; }
        return $defaults ;
    }

    private function getSteps() {
        $steps = array();
        $stepsFile = PIPEDIR.DS.$this->params["item"].DS.'steps' ;
        if (file_exists($stepsFile)) {
            $stepsFileData =  file_get_contents($stepsFile) ;
            $steps = json_decode($stepsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("No steps file available in build", $this->getModuleName()) ; }
        return array("steps" => $steps) ;
    }

}
