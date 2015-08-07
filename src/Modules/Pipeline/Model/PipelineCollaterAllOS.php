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
        $collated = array_merge($collated, $this->getSettings()) ;
        return $collated ;
    }

    private function getStatuses() {
		$successStatus = $this->getLastSuccess();
		$failStatus = $this->getLastFail();
		$statuses = array(
            "last_status" => $this->getLastStatus(),
			"last_success" => $successStatus['time'],
			"last_fail" => $failStatus['time'],
			"duration" =>  $this->getDuration(),
            "last_success_build" =>  $successStatus['build'],
            "last_fail_build" =>  $failStatus['build'],
            "has_parents" => true,
            "has_children" => true ) ;
        return $statuses ;
    }

    private function getLastStatus() {
        $allRuns = scandir(PIPEDIR.DS.$this->params["item"].DS.'history') ;
        foreach($allRuns as $i=>$run) {
            if (is_numeric($allRuns[$i])) { intval($allRuns[$i]) ; } else { unset($allRuns[$i]) ; } }
        $isRay = (is_array($allRuns) && count($allRuns)>0 ) ;
     	$runId = ($isRay) ? max($allRuns) : 0 ;
        return $this->getRunOutput($runId) ;
    }

    private function getLastSuccess() {
        $file = PIPEDIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
			$historyIndex = json_decode($historyIndex, true);
			krsort($historyIndex);
			foreach ($historyIndex as $run=>$val) {
				if (isset($historyIndex[$run]['status']) && $historyIndex[$run]['status'] == "SUCCESS") {
					return array('time' => $historyIndex[$run]['end'], 'build' => $run) ; } } }
        return array('time' => false, 'build' => 0) ;
    }

    private function getLastFail() {
        $file = PIPEDIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
			$historyIndex = json_decode($historyIndex, true);
			krsort($historyIndex);
			foreach ($historyIndex as $run=>$val) {
				if (isset($historyIndex[$run]['status']) && $historyIndex[$run]['status'] == "FAIL") {
					return array('time' => $historyIndex[$run]['end'], 'build' => $run) ; } } }
        return array('time' => false, 'build' => 0) ;
    }

    private function getDuration() {
        $file = PIPEDIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
			$historyIndex = json_decode($historyIndex, true);
			krsort($historyIndex);
			foreach ($historyIndex as $run=>$val) {
				if (isset($historyIndex[$run]['status'])) {
					return $historyIndex[$run]['end']-$historyIndex[$run]['start']; } } }
        return false ;
    }

    private function getBuild() {
        $file = PIPEDIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
			$historyIndex = json_decode($historyIndex, true);
			krsort($historyIndex);
			foreach ($historyIndex as $run=>$val) {
				if (isset($historyIndex[$run]['status'])) {
					return $run; } } }
        return false ;
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
        $stepsForRun = $steps = array();
        $stepsForRunFile = PIPEDIR.DS.$this->params["item"].DS.'stepsForRun' ;
        if (file_exists($stepsForRunFile)) {
            $stepsForRunFileData =  file_get_contents($stepsForRunFile) ;
            $stepsForRun = json_decode($stepsForRunFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("No steps For Run file available in build ".$this->params["item"], $this->getModuleName()) ; }
        $stepsFile = PIPEDIR.DS.$this->params["item"].DS.'steps' ;
        if (file_exists($stepsFile)) {
            $stepsFileData =  file_get_contents($stepsFile) ;
            $steps = json_decode($stepsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("No steps file available in build ".$this->params["item"], $this->getModuleName()) ; }
        return array("steps" => $steps, "steps-for-run" => $stepsForRun ) ;
    }

    private function getSettings() {
        $settings = array();
        $settingsFile = PIPEDIR.DS.$this->params["item"].DS.'settings' ;
        if (file_exists($settingsFile)) {
            $settingsFileData =  file_get_contents($settingsFile) ;
            $settings = json_decode($settingsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("No settings file available in build ".$this->params["item"], $this->getModuleName()) ; }
        return array("settings" => $settings) ;
    }

}
