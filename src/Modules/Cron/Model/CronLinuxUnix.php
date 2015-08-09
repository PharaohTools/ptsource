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
            "afterApplicationConfigureSave" => array("crontabParent",),
        );
        return $ff ;
    }

    public function crontabParent() {
        $loggingFactory = new \Model\Logging();
        $this->params["php-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $mn = $this->getModuleName() ;
        $this->params["app-settings"] = \Model\AppConfig::getAppVariable("mod_config");
        if ($this->params["app-settings"][$mn]["cron_enable"] == "on") {
            $logging->log ("Cron Enabled as scheduled task driver, running cron create command...", $this->getModuleName() ) ;

            $switch = $this->getSwitchUser() ;
            $cmd = "" ;
            if ($switch != false) { $cmd .= 'sudo su '.$switch.' -c '."'" ; }
            $cmd .= PHRCOMM.' Cron set-crontab --yes --guess --frequency="'.$this->params["app-settings"][$mn]["cron_frequency"].
                '"';
            if ($switch != false) { $cmd .= "'" ; }
            // error_log($cmd) ;

            $cmd2 = "echo $?" ;
            $result = self::executeAndLoad($cmd2) ;
            if ($result == true) { $logging->log ("Cron job installed successfully", $this->getModuleName() ) ; }
            else { $logging->log ("Cron job install error", $this->getModuleName() ) ; }
            return $result; }
        else {
            $logging->log ("Cron disabled, deleting current crontab...", $this->getModuleName() ) ;
            $this->removeCrontab() ;
            return true ; }
    }

    public function crontabChild() {
        $this->params["app-settings"] = \Model\AppConfig::getAppVariable("mod_config");
        $loggingFactory = new \Model\Logging();
        $this->params["php-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $mn = $this->getModuleName() ;
        if ($this->params["app-settings"][$mn]["cron_enable"] == "on") {
            $logging->log ("Cron Enabled as scheduled task driver, creating...", $this->getModuleName() ) ;
            $this->removeCrontab() ;
            $this->addCrontab() ;
            return true; }
        else {
            $logging->log ("Cron disabled, deleting current crontab...", $this->getModuleName() ) ;
            $this->removeCrontab() ;
            return true ; }
    }

    private function getSwitchUser() {
        if ($this->params["app-settings"]["Cron"]["cron_switch"] == "on") {
            if (isset($this->params["app-settings"]["UserSwitching"]["switching_user"])) {
                return $this->params["app-settings"]["UserSwitching"]["switching_user"] ; }
            else {
                return false ; } }
    }

    private function addCrontab() {
        $cronFactory = new \Model\Cron();
        $cronModify = $cronFactory->getModel($this->params, "CrontabModify");
        $cronModify->addCronjob();
    }

    private function removeCrontab() {
        $cronFactory = new \Model\Cron();
        $cronModify = $cronFactory->getModel($this->params, "CrontabModify");
        $cronModify->removeCronjob();
    }

}