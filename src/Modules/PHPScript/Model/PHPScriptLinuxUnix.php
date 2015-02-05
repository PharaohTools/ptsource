<?php

Namespace Model;

class PHPScriptLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getStepTypes() {
        return array_keys($this->getFormFields());
    }

    public function getFormFields() {
        $ff = array(
            "phpscriptdata" => array(
                "type" => "textarea",
                "name" => "PHPScript Data",
                "slug" => "data" ),
            "phpscriptscript" => array(
                "type" => "text",
                "name" => "PHPScript Script",
                "slug" => "script" ),
        );

        return $ff ;
    }

    public function executeStep($step) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if ( $step["steptype"] == "phpscriptdata") {
            $logging->log("Running PHPScript from Data...") ;
            $this->executeAsPHPData($step["data"]) ;
            return true ; }
        else if ($step["steptype"] == "phpscriptfile") {
            $logging->log("Running PHPScript from Script...") ;
            $this->executeAsPHPScript($step["data"]) ;
            return true ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in PHPScript Module") ;
            return false ; }
    }

    private function executeAsPHPData($data) {
        eval($data) ;
    }

    private function executeAsPHPScript($data) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists($data)) {
            $logging->log("File found, executing...") ;
            self::executeAndOutput("php $data") ; }
        else {
            $logging->log("File not found, ignoring...") ;
            \Core\BootStrap::setExitCode(1);}
    }

}