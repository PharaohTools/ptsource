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
        $ret["pipeline"] = $this->getPipeline();
        $ret["item"] = $this->params["item"];
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
        $this->runPipeForkCommand();
        // save run
        return $this->saveRun();
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
        return $stat["pid"] ;
    }

    public function runChild() {
        file_put_contents(PIPEDIR.DS.$this->params["item"].DS.'tmpfile',"") ; //empty file
        echo PIPEDIR.DS.$this->params["item"].DS.'tmpfile'."\n" ;
        for ($i = 0; $i < 30; $i++ ) {
            sleep(1);
            echo "writing line $i to temp log\n";
            file_put_contents(PIPEDIR.DS.$this->params["item"].DS.'tmpfile', "\nThis many lines: $i \n", FILE_APPEND) ; }
        echo "done\n";
        file_put_contents(PIPEDIR.DS.$this->params["item"].DS.'tmpfile', "DONE\n", FILE_APPEND) ;
        return array("flozz");
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
        var_dump($builds) ;
        $buildCount = count($builds) + 1 ;
        return $buildCount ;
    }

    public function saveRun() {
        $file = $this->params["pipe-dir"].DS.$this->params["item"].DS.$this->getNextBuildNumber() ;
        $buildOut = $this->getExecutionOutput() ;
        $top = "THIS IS A PLACEHOLDER TO SHOW A FINISHED OUTPUT FILE\n\n" ;
        file_put_contents($file, $top.$buildOut) ;
        if (file_exists($file)){
            return true ; }
        return false ;
    }

}