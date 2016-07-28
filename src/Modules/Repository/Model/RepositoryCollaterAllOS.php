<?php

Namespace Model;

class RepositoryCollaterAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("repositoryCollater") ;

    public function getRepository($pipe = null) {
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

    public function getItem() {
        $item = array("item" => $this->params["item"]);
        return $item ;
    }

    private function getStatuses() {
        $lastRun = $this->getLastRun();
        $successStatus = $this->getLastSuccess();
		$failStatus = $this->getLastFail();
		$statuses = array(
            "last_run_repository" => $lastRun["repository"],
            "last_run_start" => $lastRun["start"],
            "last_status" => $this->getLastStatus(),
			"last_success" => $successStatus['time'],
			"last_fail" => $failStatus['time'],
			"duration" =>  $this->getDuration(),
            "last_success_repository" =>  $successStatus['repository'],
            "last_fail_repository" =>  $failStatus['repository'],
            "has_parents" => true,
            "has_children" => true ) ;
        return $statuses ;
    }

    private function getLastRun() {
        $file = REPODIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
            $historyIndex = json_decode($historyIndex, true);
            krsort($historyIndex);
            // @todo this foreach doesn't make sense, kinda, but is it actually any quicker to change, it loops once anyway
            foreach ($historyIndex as $run=>$val) {
                return array('time' => $historyIndex[$run]['start'], 'repository' => $run) ; } }
        return array('time' => false, 'repository' => 0) ;
    }

    private function getLastStatus() {
        $lr = $this->getLastRun() ;
//        var_dump($lr["repository"]) ;
        $ro = $this->getRunOutput($lr["repository"]) ;
        return $ro ;
    }

    private function getLastSuccess() {
        $file = REPODIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
			$historyIndex = json_decode($historyIndex, true);
			krsort($historyIndex);
			foreach ($historyIndex as $run=>$val) {
				if (isset($historyIndex[$run]['status']) && $historyIndex[$run]['status'] == "SUCCESS") {
					return array('time' => $historyIndex[$run]['end'], 'repository' => $run) ; } } }
        return array('time' => false, 'repository' => 0) ;
    }

    private function getLastFail() {
        $file = REPODIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
			$historyIndex = json_decode($historyIndex, true);
			krsort($historyIndex);
			foreach ($historyIndex as $run=>$val) {
				if (isset($historyIndex[$run]['status']) && $historyIndex[$run]['status'] == "FAIL") {
                    $arr = array('time' => $historyIndex[$run]['end'], 'repository' => $run) ;
//                    var_dump($arr) ;
					return $arr ; } } }
        return array('time' => false, 'repository' => 0) ;
    }

    private function getDuration() {
        $file = REPODIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
			$historyIndex = json_decode($historyIndex, true);
			krsort($historyIndex);
			foreach ($historyIndex as $run=>$val) {
				if (isset($historyIndex[$run]['status'])) {
					return $historyIndex[$run]['end']-$historyIndex[$run]['start']; } } }
        return false ;
    }

    private function getBuild() {
        $file = REPODIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
			$historyIndex = json_decode($historyIndex, true);
			krsort($historyIndex);
			foreach ($historyIndex as $run=>$val) {
				if (isset($historyIndex[$run]['status'])) {
					return $run; } } }
        return false ;
    }

    private function getRunOutput($runId) {
        $outFile = REPODIR.DS.$this->params["item"].DS.'history'.DS.$runId ;
        $out = (file_exists($outFile)) ? file_get_contents($outFile) : "" ;
        $successStatus = strpos($out, "SUCCESSFUL EXECUTION") ;
        if ($successStatus !== false) {
//            var_dump("ret true");
            return true ; }

//        var_dump($outFile, $out) ;

        $failStatus = strpos($out, "FAILED EXECUTION") ;
        if ($failStatus !== false) {
//            var_dump("ret false");
            return false ; }
//        var_dump("ret null");
        return null ;
    }

    private function getDefaults() {
        $defaults = array() ;
        $defaultsFile = REPODIR.DS.$this->params["item"].DS.'defaults' ;
        if (file_exists($defaultsFile)) {
            $defaultsFileData =  file_get_contents($defaultsFile) ;
            $defaults = json_decode($defaultsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("No defaults file available in repository", $this->getModuleName()) ; }
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
        $stepsForRunFile = REPODIR.DS.$this->params["item"].DS.'stepsForRun' ;
        if (file_exists($stepsForRunFile)) {
            $stepsForRunFileData =  file_get_contents($stepsForRunFile) ;
            $stepsForRun = json_decode($stepsForRunFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
//            $logging->log("No steps For Run file available in repository ".$this->params["item"], $this->getModuleName()) ;
            }
            $stepsFile = REPODIR.DS.$this->params["item"].DS.'steps' ;
        if (file_exists($stepsFile)) {
            $stepsFileData =  file_get_contents($stepsFile) ;
            $steps = json_decode($stepsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("No steps file available in repository ".$this->params["item"], $this->getModuleName()) ;}
        return array("steps" => $steps, "steps-for-run" => $stepsForRun ) ;
    }

    private function getSettings() {
        $settings = array();
        $settingsFile = REPODIR.DS.$this->params["item"].DS.'settings' ;
        if (file_exists($settingsFile)) {
            $settingsFileData =  file_get_contents($settingsFile) ;
            $settings = json_decode($settingsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("No settings file available in repository ".$this->params["item"], $this->getModuleName()) ; }
        return array("settings" => $settings) ;
    }

}
