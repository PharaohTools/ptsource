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

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "enable_clear_workspace_before_build" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Clear Workspace Before Build"
            ),
            "enable_clear_workspace_after_build" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Clear Workspace After Build"
            ),
        );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "beforeBuild" => array("clearWorkspaceBeforeBuild"),
            "afterBuild" => array("clearWorkspaceAfterBuild"),
        );
        return $ff ;
    }

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
            $xcw = $this->executeClearWorkspaceForStep($step, $item) ;
            return $xcw ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in ClearWorkspace Module", $this->getModuleName()) ;
            return false ; }
    }

    public function clearWorkspaceBeforeBuild() {
        $item = $this->params["item"] ;
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $mn = $this->getModuleName() ;
        if ($this->params["build-settings"][$mn]["enable_clear_workspace_before_build"]=="on") {
            $logging->log("Clear Workspace Before build Execution flag is on, executing...", $this->getModuleName()) ;
            $this->clearTheWorkspaceForItem($item);
            return true ; }
        return true ;
    }

    public function clearWorkspaceAfterBuild() {
        $item = $this->params["item"] ;
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $mn = $this->getModuleName() ;
        if ($this->params["build-settings"][$mn]["enable_clear_workspace_after_build"]=="on") {
            $logging->log("Clear Workspace After build Execution flag is on, executing...", $this->getModuleName()) ;
            $this->clearTheWorkspaceForItem($item);
            return true ; }
        return true ;
    }

    private function executeClearWorkspaceForStep($step, $item) {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        if ($step["data"]=="on") {
            return $this->clearTheWorkspaceForItem($item); }
        else {
            $logging->log("Execution flag is set to off, so not executing...", $this->getModuleName()) ;
            return true ; }
    }

    private function clearTheWorkspaceForItem($item) {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $logging->log("Execution flag is set to on, executing...", $this->getModuleName()) ;
        $workspace = $this->getWorkspace($item) ;
        $dir = $workspace->getWorkspaceDir()  ;
        $comm = "rm -rf $dir*" ;
        $logging->log("Executing $comm...", $this->getModuleName()) ;
        echo self::executeAndLoad($comm) ;
        $comm = "rm -rf $dir.*" ;
        $logging->log("Executing $comm...", $this->getModuleName()) ;
        echo self::executeAndLoad($comm) ;
        $rc1 = self::executeAndLoad("echo $?") ;
        $comm = "ls -lah $dir" ;
        $logging->log("Executing $comm...", $this->getModuleName()) ;
        echo self::executeAndLoad($comm) ;
        $rc2 = self::executeAndLoad("echo $?") ;
        return ($rc1==true && $rc2==true) ? true : false  ;
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