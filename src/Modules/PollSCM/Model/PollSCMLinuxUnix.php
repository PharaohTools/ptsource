<?php

Namespace Model;

class PollSCMLinuxUnix extends Base {

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
            "poll_scm_enabled" =>
                array(
                    "type" => "boolean",
                    "optional" => true,
                    "name" => "Enable Polling of SCM Server?"
                ),
            "git_repository_url" =>
            array(
                "type" => "text",
                "optional" => true,
                "name" => "Git Repository URL?"
            ),
            "cron_string" =>
            array(
                "type" => "textarea",
                "optional" => true,
                "name" => "Crontab Values"
            ),
        );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterSettings" => array(
                "pollSCMChanges",
            ),
        );
        return $ff ;
    }

    public function pollSCMChanges() {

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $run = $this->params["run-id"];
        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = new \ArrayObject(json_decode($defaults));

        $file = PIPEDIR.DS.$this->params["item"].DS.'settings';
        $settings = file_get_contents($file) ;
        $settings = json_decode($settings, true);

        $mn = $this->getModuleName() ;

//        if ($settings[$mn]["poll_scm_enabled"] == "on" ) {
//            $logging->log ("Only Sending alert mail if poor stability", $this->getModuleName() ) ;
//            if ($this->params["run-status"] == "SUCCESS") {
//                $logging->log ("Build currently stable, not emailing", $this->getModuleName() ) ;
//                return true; }
//            else {
//                $logging->log ("Build unstable, emailing", $this->getModuleName() ) ; } }

        if ($settings[$mn]["poll_scm_enabled"] == "on") {
            $logging->log ("SCM Polling Enabled, attempting...", $this->getModuleName() ) ;
            try {
                $logging->log ("Polling SCM Server", $this->getModuleName() ) ;
                $result = true ;
                if ($result == true) { $logging->log ("SCM polled successfully", $this->getModuleName() ) ; }
                else { $logging->log ("Error polling scm", $this->getModuleName() ) ; }
                return $result; }
            catch (\Exception $e) {
                $logging->log ("Error polling scm", $this->getModuleName() ) ;
                return false; } }
        else {
            $logging->log ("SCM Polling Disabled, ignoring...", $this->getModuleName() ) ;
            return true ; }

    }

}