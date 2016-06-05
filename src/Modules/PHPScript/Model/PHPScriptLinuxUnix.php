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
            $logging->log("Running PHPScript from Data...", $this->getModuleName()) ;
            $res = $this->executeAsPHPData($step["data"]) ;
//            var_dump("res", $res) ;
            return $res ; }
        else if ($step["steptype"] == "phpscriptfile") {
            $logging->log("Running PHPScript from Script...", $this->getModuleName()) ;
            $res = $this->executeAsPHPScript($step["data"]) ;
            return $res ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in PHPScript Module", $this->getModuleName()) ;
            return false ; }
    }

    private function executeAsPHPData($data) {
        if (isset($this->params["env-vars"]) && is_array($this->params["env-vars"])) {
            $loggingFactory = new \Model\Logging();
            $logging = $loggingFactory->getModel($this->params);
            $logging->log("PHP Extracting Environment Variables...", $this->getModuleName()) ;
            $ext_vars = implode(", ", array_keys($this->params["env-vars"])) ;
            $count = extract($this->params["env-vars"]) ;
            $logging->log("PHP Successfully Extracted {$count} Environment Variables into PHP Variables {$ext_vars}...", $this->getModuleName()) ; }
        $ressy = eval($data) ;
//        var_dump('ressy', $ressy) ;
        // @todo need to return actual status
        return true ;
    }

    private function executeAsPHPScript($scr_loc) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists($scr_loc)) {
            $logging->log("File found, loading...", $this->getModuleName()) ;
            $data = file_get_contents($scr_loc) ;
            if (!$data) {
                $logging->log("Unable to load file...", $this->getModuleName()) ;
                return false ; }
            return $this->executeAsPHPData($data) ; }
        else {
            $logging->log("File not found, ignoring...", $this->getModuleName()) ;
            \Core\BootStrap::setExitCode(1);
            return false ;}
    }

}