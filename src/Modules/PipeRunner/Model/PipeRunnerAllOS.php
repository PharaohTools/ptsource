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
        $cmd = "php /tmp/pipey.php > /tmp/error-output.txt &" ;

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

    private function getExecutionOutput() {
        $ofile = "/tmp/error-output.txt" ;
        $o = file_get_contents($ofile) ;
        return $o ;
    }

    private function getExecutionStatus() {
        $ofile = "/tmp/error-output.txt" ;
        $o = file_get_contents($ofile) ;
        if (strpos($o, "DONE") !== false) {
            return true ; }
        return false ;
    }

}