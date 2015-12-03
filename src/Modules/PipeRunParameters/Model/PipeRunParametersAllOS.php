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
            "piperun_parameters_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable Run-time Parameters for this pipeline?"
            ),
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


    public function startXvnc() {
        $run = $this->params["run-id"];

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $mn = $this->getModuleName() ;
        if (isset($this->params["build-settings"][$mn]["xvfb_during_build"]) &&
            $this->params["build-settings"][$mn]["xvfb_during_build"] == "on") {
            $logging->log ("XVFB Enabled for build, starting...", $this->getModuleName() ) ;
            $xvfbCommand = "echo 'pretend to start xvfb'" ;
            $result = self::executeAndOutput($xvfbCommand) ;
            if ($result == true) { $logging->log ("XVFB started successfully", $this->getModuleName() ) ; }
            else { $logging->log ("XVFB start error", $this->getModuleName() ) ; }
            return $result; }
        else {
//            $logging->log ("XVFB Not enabled for build, ignoring...", $this->getModuleName() ) ;
            return true ; }
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
//            var_dump("object param") ;
            $logging->log ("parameters set by object paramters", $this->getModuleName() ) ;
            return true ; }
        if ( isset($_REQUEST["build-parameters"])) {
//            var_dump("req param") ;
            $logging->log ("parameters set by request", $this->getModuleName() ) ;
            return array("build-parameters"=>array("dave head")) ; }
//        var_dump("no params found") ;
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
   
