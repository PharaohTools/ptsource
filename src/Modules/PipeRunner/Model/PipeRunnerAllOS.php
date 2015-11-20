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
        $run_id = (isset($this -> params["run-id"])) ? $this -> params["run-id"] : null ;
		$ret["historic_build"] = $this -> getOneBuild($run_id);
		$ret["pipeline"] = $this -> getPipeline();
		$ret["item"] = $this -> params["item"];
		$ret["history_count"] = $this -> getBuildNumber("last");
		return $ret;
	}

	public function getChildData() {
		$this -> setPipeDir();
		$ret["tempfile"] = PIPEDIR . DS . $this -> params["item"] . DS .'tmp'.DS. 'tmpfile_'.$this -> params["run-id"];
		return $ret;
	}

    public function getServiceData() {
        $ret["output"] = $this -> getExecutionOutput();
        $ret["status"] = $this -> getExecutionStatus();
        return $ret;
    }

    public function getTermServiceData() {
        $ret["output"] = $this -> getTerminationOutput();
        $ret["status"] = $this -> getTerminationStatus();
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

	public function runPipe($start_execution = true) {
		if ($this -> checkPipeVariables()) {
			return "getParamValue"; }
        else {
			// set build dir
            if ($start_execution==true) {
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
                $this -> runPipeForkCommand($run); }
            else {
                $run = (isset($this->params["run-id"])) ?
                    $this->params["run-id"] :
                    $this->getBuildNumber("last") ; }
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
        if (!in_array(PHP_SAPI, array("cli")))  { return true ; }
        return false ;
    }

    private function runPipeForkCommand($run) {
        $switch = $this->getSwitchUser() ;
        $cmd = "" ;
        if ($switch != false) { $cmd .= 'sudo -u '.$switch.' -c '."'" ; }
        // this should be a phrank piperunner@cli and it should save the log to a named history
        $cmd .= PTBCOMM.' piperunner child --pipe-dir="'.$this->params["pipe-dir"].'" ' ;
        if (isset($this->params["build-request-source"])) {
            $cmd .= '--build-request-source="'.$this->params["build-request-source"].'" '; }
        else if ($this->isWebSapi()==true) {
            $cmd .= '--build-request-source="web" '; }
        $cmd .= '--item="'.$this->params["item"].'" --run-id="'.$run.'" > '.PIPEDIR.DS.$this->params["item"].DS ;
        $cmd .= 'tmp'.DS.'tmpfile_'.$run.' &';
        if ($switch != false) { $cmd .= "'" ; }

        //error_log($cmd);
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

    public function runPipeTerminateCommand() {
        $switch = $this->getSwitchUser() ;
        $cmd = "" ;
        if ($switch != false) { $cmd .= 'sudo -u '.$switch.' -c '."'" ; }
        // this should be a phrank piperunner@cli and it should save the log to a named history
        $cmd .= PTBCOMM.' piperunner terminate-child ' ;
        $cmd .= '--item="'.$this->params["item"].'" --run-id="'.$this->params["run-id"].'" > ' ;
        $cmd .= PIPEDIR.DS.$this->params["item"].DS.'tmp'.DS ;
        $cmd .= 'tmpfile_terminate_'.$this->params["run-id"] ;
        if ($switch != false) { $cmd .= "'" ; }

        error_log("terminate: " . $cmd);
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
        $tmpfile = PIPEDIR.DS.$this->params["item"].DS.'tmp'.DS.'tmpfile_'.$this->params["run-id"] ;
        if (!is_writable(dirname($tmpfile))) {
            $logging->log("Unable to write to temp file {$tmpfile}", $this->getModuleName()) ;
            return false ; }
        $logging->log("Writing to temp file ".$tmpfile , $this->getModuleName()) ;
        $logging->log("Executing as ".self::executeAndLoad("whoami"), $this->getModuleName()) ;
        $ws_avail = $this->buildWorkspace();
        if ($ws_avail == false) { return $this->failBuild() ; }
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

    protected function buildWorkspace(){
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $workspace = $this->getWorkspace() ;
        $res = array() ;
        $res[] = $workspace->createWorkspaceIfNeeded();
        $dir = $workspace->getWorkspaceDir()  ;
        $logging->log("Changing to workspace directory $dir", $this->getModuleName()) ;
        $res[] = chdir($dir);
        return ($res[0]==true && $res[1]==true) ? true : false ;
    }

    public function terminateChild() {

        $this->params["echo-log"] = true ;
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($this->params) ;
        $ev = $eventRunner->eventRunner("beforeTermination") ;

        $run_id = $this->params["run-id"] ;// get the run id
        $item = $this->params["item"] ;// get the pipe id

        // if unable to get either, say unable to find parameters to terminate build
        if (!isset($item)) {
            $logging->log("Unable to find Pipeline ID to terminate", $this->getModuleName());
            \Core\BootStrap::setExitCode(1) ;
            return false ; }
        if (!isset($run_id)) {
            $logging->log("Unable to find Run ID to terminate", $this->getModuleName());
            \Core\BootStrap::setExitCode(1) ;
            return false ; }

        $pipeFactory = new \Model\PipeRunner();
        $pipeFindRunning = $pipeFactory->getModel($this->params, "FindRunning");
        $runningBuilds = $pipeFindRunning->getRunningBuilds() ; // find running pipes

        $killRes = array() ;

        foreach ($runningBuilds as $runningBuild) {
            if ($runningBuild["item"] == $item &&
                $runningBuild["runid"] == $run_id) {
                $logging->log("Found running build: Pipeline {$item} and Run ID {$run_id}", $this->getModuleName()); // if the pipe we want is in in the list, echo that it is
                $killCommands = $this->createChildTerminateCommand($item, $run_id); // create the kill command
                foreach ($killCommands as $killCommand) {
                    $logging->log("Executing $killCommand", $this->getModuleName()); // echo the proposed kill command
                    $rc = $this->executeAndGetReturnCode($killCommand, true, true) ;
                    if (strlen($rc["output"][0])>0) {
                        $logging->log($rc["output"][0], $this->getModuleName()); } } // issue the kill command
                $mod_config = \Model\AppConfig::getAppVariable("mod_config");
                $initial_termination_wait = 1 ; // @todo get this from the config
                sleep($initial_termination_wait); // wait a specified number of seconds for it to die (initial_termination_wait)
                $stillRunningBuilds = $pipeFindRunning->getRunningBuilds() ; // find running pipes
                foreach ($stillRunningBuilds as $stillRunningBuild) {
                    if ($stillRunningBuild["item"] == $item &&
                        $stillRunningBuild["runid"] == $run_id) {
                        $logging->log("PENDING TERMINATION", $this->getModuleName());    //     echo SUCCESSFUL TERMINATION ;
                        $stillAlive = true ; } }
                if (!isset($stillAlive)) { //   if its not in this list (killed)
                    $logging->log("SUCCESSFUL TERMINATION", $this->getModuleName());    //     echo SUCCESSFUL TERMINATION ;
                    $killRes[] = true ; }
                else { //   if it is in this list (still alive)
                    // if we have a conf setting for termination_attempts
                    $iterations = (isset($mod_config["PipeRunner"]["termination_attempts"])) //         $iterations = (isset($conf->iterations)) ? isset($conf->iterations) : 3 ;
                        ? $mod_config["PipeRunner"]["termination_attempts"]
                        : 3 ;
                    for ($iteration = 1; $iteration<=$iterations; $iteration++) {
                        foreach ($killCommands as $killCommand) {
                            $logging->log("Executing iteration {$iteration} of {$iterations}, $killCommand", $this->getModuleName()); // echo the proposed kill command
                            $rc = $this->executeAndGetReturnCode($killCommand, true, true) ;
                            if (strlen($rc["output"][0])>0) {
                                $logging->log($rc["output"][0], $this->getModuleName()); }} } // issue the kill command
                        $mod_config = \Model\AppConfig::getAppVariable("mod_config");
                        $iterate_termination_wait = 1 ; // @todo get this from the config
                        sleep($iterate_termination_wait); // wait a specified number of seconds for it to die (initial_termination_wait)
                        $stillIteratingRunningBuilds = $pipeFindRunning->getRunningBuilds() ; // find running pipes
                        foreach ($stillIteratingRunningBuilds as $stillIteratingRunningBuild) {
                            if ($stillIteratingRunningBuild["item"] == $item &&
                                $stillIteratingRunningBuild["runid"] == $run_id) {
                                $logging->log("PENDING TERMINATION", $this->getModuleName());    //     echo SUCCESSFUL TERMINATION ;
                                $evenStillAlive = true ; } }
                        if (!isset($evenStillAlive)) { //   if its not in this list (killed)
                            $logging->log("SUCCESSFUL TERMINATION", $this->getModuleName());    //     echo SUCCESSFUL TERMINATION ;
                            $killRes[] = true ;  } } } }


        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($this->params) ;
        $ev = $eventRunner->eventRunner("afterTermination") ;

        if (in_array(false, $killRes)) {
            $logging->log("COMPLETE FAILED TERMINATION", $this->getModuleName());    //     echo SUCCESSFUL TERMINATION ;
            return false ; }
        $logging->log("COMPLETE SUCCESSFUL TERMINATION", $this->getModuleName());    //     echo SUCCESSFUL TERMINATION ;
        return true ;

    }


    public function createChildTerminateCommand($item, $run_id) {
        // create the kill command
        $switch = $this->getSwitchUser() ;
        $cmd = "" ;
        if ($switch != false) { $cmd .= 'sudo su '.$switch.' -c '."'" ; }
        $cmd .= 'ps aux | grep "piperunner child" ' ;
        $cmd .= '| grep \''.PTBCOMM.'\' ' ;
        $cmd .= '| grep \''.$item.'\' ' ;
        $cmd .= '| grep \''.$run_id.'\' ' ;
//        $cmd .= '| awk \'{print $2}\' ' ;
        if ($switch != false) { $cmd .= "'" ; }
        $all = $this->executeAndLoad($cmd) ;
        $lines = explode("\n", $all) ;
        $termcomms = array() ;
        foreach($lines as &$line) {
            if ($line == '') {
                unset ($line);
                continue ; }
            else if (strpos($line, 'grep')!==false) {
                unset ($line);
                continue ; }
            else {
                $pieces = preg_split('/\s+/', $line);
//                $pieces = array_diff($pieces, array("")) ;
                $termcomms[] = "kill {$pieces[1]}" ; } }
        return $termcomms  ;
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
        $ofile = PIPEDIR.DS.$this->params["item"].DS.'tmp'.DS.'tmpfile_'.$this->params["run-id"];
        $o = file_get_contents($ofile) ;
        return $o ;
    }

    private function getExecutionStatus() {
        $ts = $this->getTerminationStatus() ;
//        $reverse_ts = ($ts==true) ? false : true ;
//        var_dump($reverse_ts) ;
//        return $reverse_ts ;
        return $ts ;
    }


    private function getTerminationOutput() {
        $ofile = PIPEDIR.DS.$this->params["item"].DS.'tmp'.DS.'tmpfile_terminate_'.$this->params["run-id"];
        $o = file_get_contents($ofile) ;
        return $o ;
    }

    private function getTerminationStatus() {
        $pipeFactory = new \Model\PipeRunner();
        $pipeFindRunning = $pipeFactory->getModel($this->params, "FindRunning");
        $runningBuilds = $pipeFindRunning->getRunningBuilds() ; // find running pipes
        $found = array();
        foreach ($runningBuilds as $runningBuild) {
            if ($runningBuild["item"]==$this->params["item"] &&
                $runningBuild["runid"]==$this->params["run-id"]){
                $found[] = $runningBuild ; } }
        if (count($found)==0) { return true ; }
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
//        chmod($file, 0777) ;
		if (file_exists($file)) { return $run; }
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
			return $this -> params["run-id"]; }
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
