<?php

Namespace Model;

class CronLinuxUnix extends Base {

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
            "afterApplicationConfigureSave" => array("applyCrontab",),
        );
        return $ff ;
    }

    public function applyCrontab() {
        $loggingFactory = new \Model\Logging();
        $this->params["php-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $mn = $this->getModuleName() ;
        if ($this->params["app-settings"][$mn]["cron_enabled"] == "on") {
            $logging->log ("Cron Enabled as scheduled task driver, creating...", $this->getModuleName() ) ;

            $switch = $this->getSwitchUser() ;
            $cmd = "" ;
            if ($switch != false) { $cmd .= 'sudo su '.$switch.' -c '."'" ; }
            // this should be a phrank piperunner@cli and it should save the log to a named history
            $cmd .= PHRCOMM.' piperunner child --pipe-dir="'.$this->params["pipe-dir"].'" ' ;
            $cmd .= '--item="'.$this->params["item"].'" --run-id="'.$run.'" > '.PIPEDIR.DS.$this->params["item"].DS ;
            $cmd .= 'tmpfile &';
            if ($switch != false) { $cmd .= "'" ; }

            $currentSavedCrontabString = "" ; // get from settings like poll scm

            $currentActualCrontabString = "" ; // get from settings like poll scm

            if (strpos($currentActualCrontabString, $currentSavedCrontabString) !== false) {
                $logging->log ("Crontab $currentSavedCrontabString already exists", $this->getModuleName() ) ;
            }
            else {

                $logging->log ("Crontab $currentSavedCrontabString already exists", $this->getModuleName() ) ;
            }

            $result = self::executeAndOutput($cronCommand) ;
            if ($result == true) { $logging->log ("Cron started successfully", $this->getModuleName() ) ; }
            else { $logging->log ("Cron start error", $this->getModuleName() ) ; }
            return $result; }
        else {
            $logging->log ("Cron disabled, deleting current crontab...", $this->getModuleName() ) ;
            $this->removeCrontabs() ;
            return true ; }
    }

    private function getSwitchUser() {
        $modConfig = \Model\AppConfig::getAppVariable("mod_config");
        if (isset($modConfig["UserSwitching"]["switching_user"])) {
            return $modConfig["UserSwitching"]["switching_user"] ; }
        else {
            return false ; }
    }

    private function getCurrentActualCrontab() {
        $crontab->get();
    }

    private function addCrontab() {
        $crontab->add();
    }

}