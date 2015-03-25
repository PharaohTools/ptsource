<?php

Namespace Model;

class PipeRunnerAllOS extends Base {

	// Compatibility
	public $os = array("any");
	public $linuxType = array("any");
	public $distros = array("any");
	public $versions = array("any");
	public $architectures = array("any");

	// Model Group
	public $modelGroup = array("Default");

	public function getData() {
		$this -> setPipeDir();
		$ret["historic_builds"] = $this -> getOldBuilds();
		$ret["historic_build"] = $this -> getOneBuild($this -> params["run-id"]);
		$ret["pipeline"] = $this -> getPipeline();
		$ret["item"] = $this -> params["item"];
		$ret["history_count"] = $this -> getBuildNumber("last");
		return $ret;
	}

	public function getChildData() {
		$this -> setPipeDir();
		$ret["tempfile"] = PIPEDIR . DS . $this -> params["item"] . DS . 'tmpfile';
		return $ret;
	}

	public function getServiceData() {
		$ret["output"] = $this -> getExecutionOutput();
		$ret["status"] = $this -> getExecutionStatus();
		return $ret;
	}

	public function getPipeline() {
		$pipelineFactory = new \Model\Pipeline();
		$pipeline = $pipelineFactory -> getModel($this -> params);
		return $pipeline -> getPipeline($this -> params["item"]);
	}

	public function checkPipeVariables() {
		$file = PIPEDIR . DS . $this -> params["item"] . DS . 'defaults';
		if ($defaults = file_get_contents($file))
			$defaults = json_decode($defaults, true);
		if ($defaults["parameter-status"] == "on") {
			if (!$_POST["parameter-input"]) {
				return true; }
            else {
				$defaults["parameter-input"] = $_POST["parameter-input"];
				file_put_contents($file, json_encode($defaults));
				return false; } }
		return false;
	}

	public function runPipe() {
		if ($this -> checkPipeVariables()) {
			return "getParamValue"; }
        else {
			// set build dir
			$this -> setPipeDir();
			// ensure build dir exists
            $eventRunnerFactory = new \Model\EventRunner() ;
            $eventRunner = $eventRunnerFactory->getModel($this->params) ;
            $ev = $eventRunner->eventRunner("prepareBuild") ;
            if ($ev == false) { return $this->failBuild() ; }
			// run pipe fork command
			$run = $this -> saveRunPlaceHolder();
			$this -> setRunStartTime($run);
			// save run
			$this -> runPipeForkCommand($run);
			return $run; }
	}

	private function setRunStartTime($run) {
		$file = PIPEDIR . DS . $this -> params["item"] . DS . 'historyIndex';
		if ($historyIndex = file_get_contents($file))
			$historyIndex = json_decode($historyIndex, true);
		$historyIndex[intval($run)]['start'] = time();
		$historyIndex = json_encode($historyIndex);
		file_put_contents($file, $historyIndex);
	}

	private function setRunEndTime($status) {
		$run = $this -> params["run-id"];
		$file = PIPEDIR . DS . $this -> params["item"] . DS . 'historyIndex';
		if ($historyIndex = file_get_contents($file))
			$historyIndex = json_decode($historyIndex, true);
		$historyIndex[intval($run)]['end'] = time();
		$historyIndex[intval($run)]['status'] = $status;
		$historyIndex = json_encode($historyIndex);
		file_put_contents($file, $historyIndex);
	}

    private function setPipeDir() {
        if (isset($this -> params["guess"]) && $this -> params["guess"] == true) {
            $this -> params["pipe-dir"] = PIPEDIR; }
        else {
            // @todo should probably ask a question here
            $this -> params["pipe-dir"] = PIPEDIR; }
    }

    private function getSwitchUser() {
        $modConfig = \Model\AppConfig::getAppVariable("mod_config");
        if (isset($modConfig["UserSwitching"]["switching_user"])) {
            return $modConfig["UserSwitching"]["switching_user"] ; }
        else {
            return false ; }
    }

    private function isWebSapi() {
        if (!in_array(PHP_SAPI, array("cgi", "cli")))  { return true ; }
        return false ;
    }

    private function runPipeForkCommand($run) {
        $switch = $this->getSwitchUser() ;
        $cmd = "" ;
        if ($switch != false) { $cmd .= 'sudo su '.$switch.' -c '."'" ; }
        // this should be a phrank piperunner@cli and it should save the log to a named history
        $cmd .= PHRCOMM.' piperunner child --pipe-dir="'.$this->params["pipe-dir"].'" ' ;
        if (isset($this->params["build-request-source"])) {
            $cmd .= '--build-request-source="'.$this->params["build-request-source"].'" '; }
        else if ($this->isWebSapi()==true) {
            $cmd .= '--build-request-source="web" '; }
        $cmd .= '--item="'.$this->params["item"].'" --run-id="'.$run.'" > '.PIPEDIR.DS.$this->params["item"].DS ;
        $cmd .= 'tmpfile &';
        if ($switch != false) { $cmd .= "'" ; }

        error_log($cmd);
        $descr = array(
            0 => array(
                'pipe',
                'r'
            ) ,
            1 => array(
                'pipe',
                'w'
            ) ,
            2 => array(
                'pipe',
                'w'
            )
        );
        $pipes = array();
        $process = proc_open($cmd, $descr, $pipes);
        $stat = proc_get_status ( $process ) ;
        proc_close($process);
        return $stat["pid"]  ;
    }

    public function runChild() {
        // @todo this is 30 lines long
        $this->params["echo-log"] = true ;
        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($this->params) ;
        $ev = $eventRunner->eventRunner("beforeSettings") ;
        if ($ev == false) { return $this->failBuild() ; }
        $pipeline = $this->getPipeline();
        $this->params["build-settings"] = $pipeline["settings"];
        $this->params["app-settings"]["app_config"] = \Model\AppConfig::getAppVariable("app_config");
        $this->params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($this->params) ;
        $ev = $eventRunner->eventRunner("afterSettings") ;
        if ($ev == false) { return $this->failBuild() ; }
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $stepRunnerFactory = new \Model\StepRunner() ;
        $stepRunner = $stepRunnerFactory->getModel($this->params) ;
        $logging->log("Writing to temp file ". PIPEDIR.DS.$this->params["item"].DS.'tmpfile', $this->getModuleName()) ;
        $logging->log("Executing as ".self::executeAndLoad("whoami"), $this->getModuleName()) ;
        $workspace = $this->getWorkspace() ;
        $dir = $workspace->getWorkspaceDir()  ;
        $logging->log("Changing to workspace directory $dir", $this->getModuleName()) ;
        chdir($dir);
        $ressys = array() ;
        $ev = $eventRunner->eventRunner("beforeBuild") ;
        if ($ev == false) { return $this->failBuild() ; }
        foreach ($pipeline["steps"] as $hash => $stepDetails) {
            $logging->log("Executing step id $hash", $this->getModuleName()) ;
            $res = $stepRunner->stepRunner($stepDetails, $this->params["item"]) ;
            $evar  = "Step execution " ;
            $evar .= ($res) ? "Success" : "Failed" ;
            $evar .= ", ID $hash" ;
            $logging->log($evar, $this->getModuleName()) ;
            echo "\n" ;
            $ressys[] = $res ;
            if ($res==false) break ; }
        $ev = $eventRunner->eventRunner("beforeBuildComplete") ;
        if ($ev == false) { return $this->failBuild() ; }
        $ret = (in_array(false, $ressys)) ? "FAILED EXECUTION\n" : "SUCCESSFUL EXECUTION\n" ;
        $logging->log($ret, $this->getModuleName()) ;
        $this->params["run-status"] = (in_array(false, $ressys)) ? "FAIL" : "SUCCESS" ;
        $eventRunner->params = $this->params ;
        $eventRunner->eventRunner("afterBuildComplete") ;
		$this->setRunEndTime($this->params["run-status"]) ;
        return $this->saveRunLog() ;
    }

    private function failBuild() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $ret = "FAILED EXECUTION" ;
        $logging->log($ret, $this->getModuleName()) ;
        return false ;
    }

    private function getExecutionOutput() {
        $ofile = PIPEDIR.DS.$this->params["item"].DS.'tmpfile';
        $o = file_get_contents($ofile) ;
        return $o ;
    }

    private function getExecutionStatus($o = null) {
        $o = ($o==null) ? $this->getExecutionOutput() : $o ;
        if (strpos($o, "SUCCESSFUL EXECUTION") !== false ||
           (strpos($o, "FAILED EXECUTION") !== false || strpos($o, "ABORTED EXECUTION" )))
        { return true ; }
        return false ;
    }

    private function getBuildNumber($nextorlast = "next") {
        $builds = $this->getOldBuilds() ;
        $highest = 0 ;
        foreach ($builds as $build) {
            $build = (int) $build ;
            if ($build > $highest) {
                $highest = $build ; } }
		$ret = ($nextorlast == "next") ? $highest + 1 : $highest ;
        return $ret ;
    }

    private function getOldBuilds() {
        $builds = scandir($this->params["pipe-dir"].DS.$this->params["item"].DS.'history') ;
        $buildsRay = array();
        for ($i=0; $i<count($builds); $i++) {
            if (!in_array($builds[$i], array(".", "..", "tmpfile"))){
                $buildsRay[] = $builds[$i] ; } }
        rsort($buildsRay) ;
        return $buildsRay ;
    }

    private function getOneBuild($buildNum) {
        $file = $this->params["pipe-dir"].DS.$this->params["item"].DS.'history'.DS.$buildNum ;
        $o = file_get_contents($file) ;
        return array("run-id" => $buildNum, "out" => $o) ;
    }

    public function saveRunPlaceHolder() {
        $run = $this->getBuildNumber("next") ;
        $file = $this->params["pipe-dir"].DS.$this->params["item"].DS.'history'.DS.$run ;
        $buildOut = $this->getExecutionOutput() ;
        $top = "THIS IS A PLACEHOLDER TO SHOW A STARTED OUTPUT FILE\n\n" ;
		file_put_contents($file, "$top.$buildOut");
		if (file_exists($file)) {
			return $run;
		}
		return false;
	}

	public function saveRunLog() {
		$loggingFactory = new \Model\Logging();
		$this -> params["echo-log"] = true;
		$logging = $loggingFactory -> getModel($this -> params);
		$file = PIPEDIR . DS . $this -> params["item"] . DS . 'history' . DS . $this -> params["run-id"];
		$buildOut = $this -> getExecutionOutput();
		file_put_contents($file, $buildOut);
		if (file_exists($file)) {
			$f = PIPEDIR . DS . $this -> params["item"] . DS . $this -> params["run-id"];
			$logging -> log("Removing temp log file", $this -> getModuleName());
			self::executeAndOutput("rm -f $f");
			return $this -> params["run-id"];
		}
		return false;
	}

	public function getWorkspace() {
		$workspaceFactory = new \Model\Workspace();
		$wsparams = $this -> params;
		unset($wsparams["guess"]);
		$workspace = $workspaceFactory -> getModel($wsparams);
		$workspace -> setPipeDir();
		return $workspace;
	}

}
