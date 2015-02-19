<?php

Namespace Model;

class ClearWorkspaceLinuxUnix extends Base {

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
            "clearworkspace" => array(
                "type" => "boolean",
                "name" => "Clear Workspace",
                "slug" => "boolean" ),
        );

        return $ff ;
    }

    public function executeStep($step, $item) {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        if ($step["steptype"] == "clearworkspace") {
            $logging->log("Running Workspace Clear...", $this->getModuleName()) ;
            $xcw = $this->executeClearWorkspace($step, $item) ;
            return $xcw ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in ClearWorkspace Module", $this->getModuleName()) ;
            return false ; }
    }

    private function executeClearWorkspace($step, $item) {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        if ($step["data"]=="on") {
            $logging->log("Execution flag is set to on, executing...", $this->getModuleName()) ;
            $workspace = $this->getWorkspace($item) ;
            $dir = $workspace->getWorkspaceDir()  ;
            $comm = "rm -rf $dir*" ;
            $logging->log("Executing $comm...", $this->getModuleName()) ;
            echo self::executeAndLoad($comm) ;
            $rc1 = self::executeAndLoad("echo $?") ;
            $comm = "ls -lah $dir" ;
            $logging->log("Executing $comm...", $this->getModuleName()) ;
            echo self::executeAndLoad($comm) ;
            $rc2 = self::executeAndLoad("echo $?") ;
            return ($rc1==true && $rc2==true) ? true : false  ; }
        else {
            $logging->log("Execution flag is set to off, so not executing...", $this->getModuleName()) ;
            return true ; }
    }

    public function getWorkspace($item) {
        $workspaceFactory = new \Model\Workspace() ;
        $wsparams = $this->params ;
        unset($wsparams["guess"]) ;
        $wsparams["item"] = $item ;
        $workspace = $workspaceFactory->getModel($wsparams);
        $workspace->setPipeDir();
        return $workspace ;
    }

}