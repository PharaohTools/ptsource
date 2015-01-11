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
        $cwd='/tmp';
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("file", "/tmp/error-output.txt", "a") );
        proc_open("php /tmp/pipey.php > /tmp/error-output.txt &", $descriptorspec, $pipes, $cwd);
        $o = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        return $o ;
    }

    public function getExecutionOutput() {
        $ofile = "/tmp/error-output.txt" ;
        $o = file_get_contents($ofile) ;
        return $o ;
    }

    public function getExecutionStatus() {
        $o = false ;
        return $o ;
    }

}