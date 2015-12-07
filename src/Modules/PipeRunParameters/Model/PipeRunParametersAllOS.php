<?php

Namespace Model;

class PipeRunParametersAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "piperun_parameters_enabled" => array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable Run-time Parameters for this pipeline?" ),
            "fieldsets" => array(
                "parameters" => array(
                    "param_type" => array(
                        "type" => "text",
                        "optional" => true,
                        "name" => "Parameter Type" ),
                    "param_name" => array(
                        "type" => "text",
                        "optional" => true,
                        "name" => "Parameter Name (Alphanumeric)?" ), ), )
        );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "pipeRunParameterEnable" => array("checkEnableParametersForBuild", ),
            "pipeRunParameterLoad" => array("checkFindParametersForBuild", ), );
        return $ff ;
    }

    public function checkEnableParametersForBuild() {
        if ( $this->params["build-settings"]["PipeRunParameters"]["piperun_parameters_enabled"] == "on") {
//            var_dump("Build settings are enabled") ;
            return true ; }
        return false ;
    }

    public function checkFindParametersForBuild() {
        // implement some silent loading or default loading methods
        // like for scheduled build or something
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        if ( isset($this->params["build-parameters"])) {
//            $logging->log ("parameters set by object parameters", $this->getModuleName() ) ;
            return array("build-parameters"=>$this->params["build-parameters"]) ;  }
//        if ( isset($_REQUEST["build-parameters"])) {
//            var_dump($_REQUEST["build-parameters"]) ;
//            $logging->log ("parameters set by request", $this->getModuleName() ) ;
//            return array("build-parameters"=>$_REQUEST["build-parameters"]) ; }
        return false ;
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

        if ($this->params["build-settings"]["PipeRunParameters"]["piperun_parameters_enabled"] == "on") {

            if (isset($run_parameters)) {

            }

            return true ;
        }

        return false ;

        //@todo ask karthik what this does
//        $result = str_replace('$'.$paraName, $paraInput, $stepFileData);
//        file_put_contents(PIPEDIR.DS.$this->params["item"].DS.'stepsHistory'.DS.$this->params["run-id"], $result);
//        $stepFileForRun = $stepFile.'ForRun';
//        file_put_contents($stepFileForRun, $result);
//        return $result;
    }

}
   
