<?php

Namespace Model;

class PipeRunnerAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $this->setPipeDir();
        $ret["historic_builds"] = $this->getOldBuilds();
        $ret["historic_build"] = $this->getOneBuild($this->params["run-id"]);
        $ret["pipeline"] = $this->getPipeline();
        $ret["item"] = $this->params["item"];
        $ret["history_count"] = $this->getBuildNumber("last");
        $ret["plugin"] = $this->getInstalledPlugins();
        $ret["pluginsenabled"] = $this->getEnabledPlugins();
        return $ret ;
    }

    public function getChildData() {
        $this->setPipeDir();
        $ret["tempfile"] = PIPEDIR.DS.$this->params["item"].DS.'tmpfile' ;
        return $ret ;
    }

    public function getServiceData() {
        $ret["output"] = $this->getExecutionOutput();
        $ret["status"] = $this->getExecutionStatus();
        return $ret ;
    }

    public function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

    public function runPipe() {
        // set build dir
        $this->setPipeDir();
        // ensure build dir exists
        // run pipe fork command
        $run = $this->saveRunPlaceHolder();
        $this->setRunStartTime($run);
        // save run
		$this->runPipeForkCommand($run);
        return $run ;
    }

    public function apiRunPipe() {
        /*$stepRunnerFactory = new \Model\StepRunner() ;
        $stepRunner = $stepRunnerFactory->getModel($this->params) ;
        $pipeline = $this->getPipeline();
        $ressys = array() ;
        foreach ($pipeline["steps"] as $hash => $stepDetails) { $hash = $hash; }
        if (md5($hash) == $this->params["accesscode"])
        return $this->runPipe();
        else
                echo "Access Failed";
        die();*/
    }

    private function setRunStartTime($run) {
		$file = PIPEDIR.DS.$this->params["item"].DS.'historyIndex';
        if($historyIndex = file_get_contents($file))
			$historyIndex = json_decode($historyIndex, true);
		$historyIndex[intval($run)]['start'] = time();
        $historyIndex = json_encode($historyIndex);
		file_put_contents($file, $historyIndex) ;
    }

    private function setRunEndTime($status) { 
		$run = $this->params["run-id"];
		$file = PIPEDIR.DS.$this->params["item"].DS.'historyIndex';
        if($historyIndex = file_get_contents($file))
			$historyIndex = json_decode($historyIndex, true);
		$historyIndex[intval($run)]['end'] = time();
		$historyIndex[intval($run)]['status'] = $status;
        $historyIndex = json_encode($historyIndex);
		file_put_contents($file, $historyIndex) ;
    }

    private function setPipeDir() {
        if (isset($this->params["guess"]) && $this->params["guess"]==true) {
            $this->params["pipe-dir"] = PIPEDIR ; }
        else {
            // @todo should probably ask a question here
            $this->params["pipe-dir"] = PIPEDIR ; }
    }

    private function runPipeForkCommand($run) {
        // this should be a phrank piperunner@cli and it should save the log to a named history
        $cmd  = "sudo su golden -c'".PHRCOMM.' piperunner child --pipe-dir="'.$this->params["pipe-dir"].'" ' ;
        $cmd .= '--item="'.$this->params["item"].'" --run-id="'.$run.'" > '.PIPEDIR.DS.$this->params["item"].DS ;
        $cmd .= 'tmpfile &'."'" ;
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
        $stepRunnerFactory = new \Model\StepRunner() ;
        $stepRunner = $stepRunnerFactory->getModel($this->params) ;
        $pipeline = $this->getPipeline();
        //  @todo this should become an event called beforeSettings
        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($this->params) ;
        $eventRunner->eventRunner("beforeSettings") ;
        echo "Writing to temp file ". PIPEDIR.DS.$this->params["item"].DS.'tmpfile'."\n" ;
        echo "Executing as ".self::executeAndLoad("whoami")."\n" ;
        $workspace = $this->getWorkspace() ;
        $dir = $workspace->getWorkspaceDir()  ;
        echo "Changing to workspace directory $dir\n" ;
        chdir($dir);
        $ressys = array() ;
        $eventRunner->eventRunner("beforeBuild") ;
        foreach ($pipeline["steps"] as $hash => $stepDetails) {
            echo "Executing step id $hash\n" ;
            $res = $stepRunner->stepRunner($stepDetails, $this->params["item"]) ;
            $evar  = "Step execution " ;
            $evar .= ($res) ? "Success" : "Failed" ;
            $evar .= ", ID $hash" ;
            echo $evar."\n\n" ;
            $ressys[] = $res ;
            if ($res==false) break ; }

        //  @todo this should become an event called buildComplete
        $eventRunner->eventRunner("beforeBuildComplete") ;

        $ret = (in_array(false, $ressys)) ? "FAILED EXECUTION\n" : "SUCCESSFUL EXECUTION\n" ;
        $status = (in_array(false, $ressys)) ? "FAIL" : "SUCCESS" ;
        $this->params["run-status"] = (in_array(false, $ressys)) ? "FAIL" : "SUCCESS" ;
        echo $ret;

        //  @todo this should become an event called buildComplete
        $eventRunner->eventRunner("afterBuildComplete") ;

        $this->setRunEndTime($status);
        // $this->sendEmail($status);
        return $this->saveRunLog();
    }

    private function getExecutionOutput() {
        $ofile = PIPEDIR.DS.$this->params["item"].DS.'tmpfile';
        $o = file_get_contents($ofile) ;
        return $o ;
    }

    private function getExecutionStatus() {
        $o = $this->getExecutionOutput() ;
        if (strpos($o, "SUCCESSFUL EXECUTION") !== false || (strpos($o, "FAILED EXECUTION") !== false)) { return true ; }
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
		if (file_exists($file)){
            return $run ; }
        return false ;
    }

    public function saveRunLog() {
        $file = PIPEDIR.DS.$this->params["item"].DS.'history'.DS.$this->params["run-id"] ;
        $buildOut = $this->getExecutionOutput() ;
        file_put_contents($file, $buildOut) ;
        if (file_exists($file)){
            $f = PIPEDIR.DS.$this->params["item"].DS.$this->params["run-id"] ;
            self::executeAndOutput("rm -f $f", "Removing temp log file");
			return $this->params["run-id"] ; }
        return false ;
    }

    public function getWorkspace() {
        $workspaceFactory = new \Model\Workspace() ;
        $wsparams = $this->params ;
        unset($wsparams["guess"]) ;
        $workspace = $workspaceFactory->getModel($wsparams);
        $workspace->setPipeDir();
        return $workspace ;
    }
    
    public function getInstalledPlugins()
    {
    $plugin = scandir(str_replace('pipes','plugins/installed',PIPEDIR)) ;
        for ($i=0; $i<count($plugin); $i++) {
            if (!in_array($plugin[$i], array(".", "..", "tmpfile"))){
                if(is_dir(str_replace('pipes','plugins/installed',PIPEDIR).DS.$plugin[$i])) {
                    // @todo if this isnt definitely a build dir ignore maybe
                    $detail['details'][$plugin[$i]] = $this->getInstalledPlugin($plugin[$i]);
                    $detail['data'][$plugin[$i]] = $this->getInstalledPluginData($plugin[$i]); } } }
        return (isset($detail) && is_array($detail)) ? $detail : array() ;
    }

    public function getInstalledPlugin($plugin) {
	$defaultsFile = str_replace('pipes','plugins/installed',PIPEDIR).DS.$plugin.DS.'details' ;
        if (file_exists($defaultsFile)) {
            $defaultsFileData =  file_get_contents($defaultsFile) ;
            $defaults = json_decode($defaultsFileData, true) ; }
        return  (isset($defaults) && is_array($defaults)) ? $defaults : array() ;
    }

    public function getInstalledPluginData($plugin) {
        $file = PIPEDIR . DS . $this->params["item"] . DS . 'pluginData';
        if ($pluginData = file_get_contents($file)) {
            $pluginData = json_decode($pluginData, true);
        }
        $defaultsFile = str_replace('pipes','plugins/installed',PIPEDIR).DS.$plugin.DS.'data' ;
        if (file_exists($defaultsFile)) {
            $defaultsFileData =  file_get_contents($defaultsFile) ;
            $defaults = json_decode($defaultsFileData, true) ; 
        }
        foreach ($defaults['buildconf'] as $key=>$val) {
            if (isset ($pluginData[$plugin][$val['name']]) ) {
                $value = $pluginData[$plugin][$val['name']];
                $defaults['buildconf'][$key]['value'] = $value;
            }
        }
        return  (isset($defaults) && is_array($defaults)) ? $defaults : array() ;
    }
    
    public function getEnabledPlugins() {
        $file = PIPEDIR . DS . $this->params["item"] . DS . 'pluginData';
        $pluginData = array();
        if ($pluginData = file_get_contents($file)) {
            $pluginData = json_decode($pluginData, true);
        }
        $enabledplugins = array();
        foreach ($pluginData as $key=>$val) {
           array_push($enabledplugins, $key);
        }
        return $enabledplugins;
    }

}
