<?php

Namespace Model;

class ShellLinuxUnix extends Base {

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
            "shelldata" => array(
                "type" => "textarea",
                "name" => "Shell Data",
                "slug" => "data" ),
            "shellscript" => array(
                "type" => "text",
                "name" => "Shell Script",
                "slug" => "script" ),
        );
        return $ff ;
    }

    public function executeStep($step) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if ( $step["steptype"] == "shelldata") {
            $logging->log("Running Shell from Data...") ;
            $output = array();
            $rc = -1;
            exec($step["data"], $output, $rc);
            foreach ($output as $val) { echo $val.'<br />'; }
            return (intval($rc) === 0) ? true : false ; }
        else if ( $step["steptype"] == "shellscript") {
            $logging->log("Running Shell from Script...") ;
            $this->executeAsShell($step["data"]) ;
            return true ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in Shell Module") ;
            return false ; }
    }

}
