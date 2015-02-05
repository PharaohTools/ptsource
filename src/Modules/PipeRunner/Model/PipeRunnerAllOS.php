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
        // save run
        $this->runPipeForkCommand($run);
        return $run ;
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
        $cmd  = PHRCOMM.' piperunner child --pipe-dir="'.$this->params["pipe-dir"].'" ' ;
        $cmd .= '--item="'.$this->params["item"].'" --run-id="'.$run.'" > '.PIPEDIR.DS.$this->params["item"].DS ;
        $cmd .= 'tmpfile &' ;
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
        echo PIPEDIR.DS.$this->params["item"].DS.'tmpfile'."\n\n" ;
        $ressys = array() ;
        foreach ($pipeline["steps"] as $hash => $stepDetails) {
            echo "Executing step id $hash\n" ;
            $res = $stepRunner->stepRunner($stepDetails) ;
            $evar  = "Step execution " ;
            $evar .= ($res) ? "Success" : "Failed" ;
            $evar .= ", ID $hash" ;
            echo $evar."\n\n" ;
            $ressys[] = $res ;
            if ($res==false) break ; }
        $ret = (in_array(false, $ressys)) ? "FAILED EXECUTION\n" : "SUCCESSFUL EXECUTION\n" ;
        echo $ret;
        return $this->saveRunLog();
    }

    private function getExecutionOutput() {
        $ofile = PIPEDIR.DS.$this->params["item"].DS.'tmpfile';
        $o = file_get_contents($ofile) ;
        return $o ;
    }

    private function getExecutionStatus() {
        $o = $this->getExecutionOutput() ;
        if (strpos($o, "SUCCESSFUL EXECUTION") !== false) { return true ; }
        return false ;
    }

    private function getBuildNumber($nextorlast = "next") {
        $builds = $this->getOldBuilds() ;
        $highest = 1 ;
        foreach ($builds as $build) {
            $build = (int) $build ;
            if ($build > $highest) {
                $highest = $build ; } }
        $ret = ($nextorlast == "next") ? $highest + 2 : $highest + 1 ;
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
        file_put_contents($file, $top.$buildOut) ;
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

}