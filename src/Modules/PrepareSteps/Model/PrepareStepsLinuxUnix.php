<?php

Namespace Model;

class PrepareStepsLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "beforeBuild" => array(
            "stepPrepare",
            ),
        );
        return $ff ;
    }

    public function stepPrepare() {
        //get input data
        $parameterData = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaultsFile = file_get_contents($parameterData) ;
        $defaultsFile = new \ArrayObject(json_decode($defaultsFile)); 
        $paraName = $defaultsFile["parameter-name"];
        $paraInput = $defaultsFile["parameter-input"];
        $paraDesc = $defaultsFile["parameter-description"];

        //get stepfile data
        $stepFile = PIPEDIR.DS.$this->params["item"].DS.'steps';    
        $stepFileData = file_get_contents($stepFile) ;       

        $result = str_replace('$'.$paraName, $paraInput, $stepFileData);
        file_put_contents(PIPEDIR.DS.$this->params["item"].DS.'stepsHistory'.DS.$this->params["run-id"], $result);
        $stepFileForRun = $stepFile.'ForRun';
        file_put_contents($stepFileForRun, $result);
        return $result;	                 
    }

}
   
