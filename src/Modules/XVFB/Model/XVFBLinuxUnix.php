<?php

Namespace Model;

class XVFBLinuxUnix extends Base {

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
            "xvfb_during_build" =>
                array(
                    "type" => "boolean",
                    "optional" => true,
                    "name" => "Start XVFB before the build, and shut it down after?"
                ),
            );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterSettings" => array("startXvnc",),
            "afterBuildComplete" => array("stopXvnc",),);
        return $ff ;
    }

    public function startXvnc() {
        $run = $this->params["run-id"];

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $mn = $this->getModuleName() ;
        if (isset($this->params["build-settings"][$mn]["xvfb_during_build"]) &&
            $this->params["build-settings"][$mn]["xvfb_during_build"] == "on") {
            $logging->log ("XVFB Enabled for build, starting...", $this->getModuleName() ) ;
            $xvfbCommand = "echo 'pretend to start xvfb'" ;
            $result = self::executeAndOutput($xvfbCommand) ;
            if ($result == true) { $logging->log ("XVFB started successfully", $this->getModuleName() ) ; }
            else { $logging->log ("XVFB start error", $this->getModuleName() ) ; }
            return $result; }
        else {
//            $logging->log ("XVFB Not enabled for build, ignoring...", $this->getModuleName() ) ;
            return true ; }
    }

    public function stopXvnc() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $mn = $this->getModuleName() ;
        if (isset($this->params["build-settings"][$mn]["xvfb_during_build"]) &&
            $this->params["build-settings"][$mn]["xvfb_during_build"] == "on") {
            $logging->log ("XVFB Enabled for build, stopping...", $this->getModuleName() ) ;
            $xvfbCommand = "echo 'pretend to stop xvfb'" ;
            $result = self::executeAndOutput($xvfbCommand) ;
            if ($result == true) { $logging->log ("XVFB stopped successfully", $this->getModuleName() ) ; }
            else { $logging->log ("XVFB stop error", $this->getModuleName() ) ; }
            return $result; }
        else {
//            $logging->log ("XVFB Not enabled for build, ignoring...", $this->getModuleName() ) ;
            return true ; }
    }

}