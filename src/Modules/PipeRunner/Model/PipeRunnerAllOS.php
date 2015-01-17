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
        $ret["history_count"] = $this->getNextBuildNumber();
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
        $this->runPipeForkCommand();
        return $run ;
    }

    private function setPipeDir() {
        if (isset($this->params["guess"]) && $this->params["guess"]==true) {
            $this->params["pipe-dir"] = PIPEDIR ; }
        else {
            // @todo should probably ask a question here
            $this->params["pipe-dir"] = PIPEDIR ; }
    }

    private function runPipeForkCommand() {
        // this should be a phrank piperunner@cli and it should save the log to a named history
        $cmd  = PHRCOMM.' piperunner child --pipe-dir="'.$this->params["pipe-dir"].'" ' ;
        $cmd .= '--item="'.$this->params["item"].'" > '.PIPEDIR.DS.$this->params["item"].DS ;
        $cmd .= 'tmpfile &' ;
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
        //$f = PIPEDIR.DS.$this->params["item"].DS."tmpfile" ;
        //if (file_exists($f)) { self::executeAndOuput("rm -f $f", "Temp log file exists here, removing"); }
        echo PIPEDIR.DS.$this->params["item"].DS.'tmpfile'."\n" ;
        for ($i = 0; $i < 15; $i++ ) {
            sleep(1);
            echo "write $i This many lines: $i , Time: ".time()."\n" ;
        }
        echo "DONE\n";
        return $this->saveRunLog();
    }

    private function getExecutionOutput() {
        $ofile = PIPEDIR.DS.$this->params["item"].DS.'tmpfile';
        $o = file_get_contents($ofile) ;
        return $o ;
    }

    private function getExecutionStatus() {
        $o = $this->getExecutionOutput() ;
        if (strpos($o, "DONE") !== false) { return true ; }
        return false ;
    }

    private function getNextBuildNumber() {
        # mkdir($this->params["pipe-dir"].DS.$this->params["item"], true) ;
        $builds = scandir($this->params["pipe-dir"].DS.$this->params["item"]) ;
        for ($i=0; $i<count($builds); $i++) {
            if (in_array($builds, array(".", "..", "tmpfile"))){
                unset($builds[$i]) ; } }
        $buildCount = count($builds) + 1 ;
        return $buildCount ;
    }

    private function getOldBuilds() {
        $builds = scandir($this->params["pipe-dir"].DS.$this->params["item"]) ;
        $buildsRay = array();
        for ($i=0; $i<count($builds); $i++) {
            if (!in_array($builds[$i], array(".", "..", "tmpfile"))){
                $buildsRay[] = $builds[$i] ; } }
        rsort($buildsRay) ;
        return $buildsRay ;
    }

    private function getOneBuild($buildNum) {
        $file = $this->params["pipe-dir"].DS.$this->params["item"].DS.$buildNum ;
        $o = file_get_contents($file) ;
        return array("run-id" => $buildNum, "out" => $o) ;
    }

    public function saveRunPlaceHolder() {
        $run = $this->getNextBuildNumber() ;
        $file = $this->params["pipe-dir"].DS.$this->params["item"].DS.$run ;
        $buildOut = $this->getExecutionOutput() ;
        error_log("bo: ".$buildOut) ;
        $top = "THIS IS A PLACEHOLDER TO SHOW A STARTED OUTPUT FILE\n\n" ;
        file_put_contents($file, $top.$buildOut) ;
        if (file_exists($file)){
            return $run ; }
        return false ;
    }

    public function saveRunLog() {
        $file = PIPEDIR.DS.$this->params["item"].DS.$this->params["run-id"] ;
        $buildOut = $this->getExecutionOutput() ;
        error_log("box: ".$buildOut) ;
        file_put_contents($file, $buildOut) ;
        if (file_exists($file)){
            $f = PIPEDIR.DS.$this->params["item"].DS.$this->params["run-id"] ;
            self::executeAndOutput("rm -f $f", "Removing temp log file");
            return $this->params["run-id"] ; }
        return false ;
    }

}