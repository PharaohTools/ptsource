<?php

Namespace Model;

class BuildCleanupLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    private $lm ;
    private $pipeline ;

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "build_cleanup_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable Removal of Old Builds?"
            ),
            "no_to_keep" =>
            array(
                "type" => "text",
                "optional" => true,
                "name" => "Number of builds to keep?"
            ),
        );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterBuildComplete" => array(
                "buildCleanup",
            ),
        );
        return $ff ;
    }

    public function buildCleanup() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $this->params["php-log"] = true ;
        $this->pipeline = $this->getPipeline();
        $this->params["build-settings"] = $this->pipeline["settings"];
        $this->params["app-settings"]["app_config"] = \Model\AppConfig::getAppVariable("app_config");
        $this->params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
        $this->lm = $loggingFactory->getModel($this->params);
        if ($this->checkBuildCleanupsEnabled()) {
            return $this->doBuildCleanupsEnabled() ; }
        else {
            return $this->doBuildCleanupsDisabled() ; }
    }

    private function checkBuildCleanupsEnabled() {
        $mn = $this->getModuleName() ;
        return ($this->params["build-settings"][$mn]["build_cleanup_enabled"] == "on") ? true : false ;
    }

    private function doBuildCleanupsDisabled() {
        $this->lm->log ("Build Cleanup Disabled, ignoring...", $this->getModuleName() ) ;
        return true ;
    }

    private function doBuildCleanupsEnabled() {
        $this->lm->log ("Build Cleanup Enabled for {$this->pipeline["project-name"]}, attempting...", $this->getModuleName() ) ;
        try {
            $this->removeHistoryFiles() ;
            $this->removeStepsHistoryFiles() ;
            $this->trimHistoryIndex() ;
            return true; }
        catch (\Exception $e) {
            $this->lm->log ("Error polling scm", $this->getModuleName() ) ;
            return false; }
    }

    private function removeHistoryFiles() {
        $historyFiles = scandir(PIPEDIR.DS.$this->params["item"].DS.'history') ;
        asort($historyFiles);
        $arr = array_reverse($historyFiles);
        $mn = $this->getModuleName() ;
        if (isset($this->params["build-settings"][$mn]["no_to_keep"]) &&
            is_int($this->params["build-settings"][$mn]["no_to_keep"])) {
            $nk = $this->params["build-settings"][$mn]["no_to_keep"]; }
        else {
            $this->lm->log ("No amount of builds to keep has ben set, defaulting to three", $this->getModuleName() ) ;
            $nk = 3; }
        $keeps = array_slice($arr, 0, $nk);
        $drops = array_diff($historyFiles, $keeps);
        foreach ($drops as $dropfile) {
            $this->lm->log ("Removing History file {$dropfile}", $this->getModuleName() ) ;
            $rmCommand = 'rm -f '.PIPEDIR.DS.$this->params["item"].DS.'history'.DS.$dropfile ;
            self::executeAndOutput($rmCommand) ; }
        $result = true ;
        return $result ;
    }

    private function removeStepsHistoryFiles() {
        $historyFiles = scandir(PIPEDIR.DS.$this->params["item"].DS.'stepsHistory') ;
        asort($historyFiles);
        $arr = array_reverse($historyFiles);
        $mn = $this->getModuleName() ;
        if (isset($this->params["build-settings"][$mn]["no_to_keep"]) &&
            is_int($this->params["build-settings"][$mn]["no_to_keep"])) {
            $nk = $this->params["build-settings"][$mn]["no_to_keep"]; }
        else {
            $this->lm->log ("No amount of builds to keep has ben set, defaulting to three", $this->getModuleName() ) ;
            $nk = 3; }
        $keeps = array_slice($arr, 0, $nk);
        $drops = array_diff($historyFiles, $keeps);
        foreach ($drops as $dropfile) {
            $this->lm->log ("Removing History file {$dropfile}", $this->getModuleName() ) ;
            $rmCommand = 'rm -f '.$dropfile ;
            self::executeAndOutput($rmCommand) ; }
        $result = true ;
        return $result ;
    }

    private function trimHistoryIndex() {
//        $historyFiles = scandir(PIPEDIR.DS.$this->params["item"].DS.'history') ;
//        asort($historyFiles);
//        $arr = array_reverse($historyFiles);
//        $keeps = array_slice($arr, 0, 3);
//        $drops = array_diff($historyFiles, $keeps);
//        foreach ($drops as $dropfile) {
//            $this->lm->log ("Removing History file {$dropfile}", $this->getModuleName() ) ;
//            $rmCommand = 'rm '.$dropfile ;
//            self::executeAndOutput($rmCommand) ; }
        $result = true ;
        return $result ;
    }

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}