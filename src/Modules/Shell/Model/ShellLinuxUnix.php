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
        return array("shelldata", "shellscript", "shellfile");
    }

    public function executeStep($step) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);

        $shellDataSpellings = array("shelldata");
        $shellScriptSpellings = array("shellscript", "shellfile");

        if (in_array($step["type"], $shellDataSpellings)) {
            $logging->log("Running Shell from Data...") ;
            $this->executeAsShell($step["data"]) ;
            $xc = $this->executeAndLoad("$?");
            if ($xc !== 0) { return false ; }
            return true ; }
        else if (in_array($step["type"], $shellScriptSpellings)) {
            $logging->log("Running Shell from Script...") ;
            $this->executeAsShell($step["data"]) ;
            $xc = $this->executeAndLoad("$?");
            if ($xc !== 0) { return false ; }
            return true ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in Shell Module") ;
            return null ; }
    }

}