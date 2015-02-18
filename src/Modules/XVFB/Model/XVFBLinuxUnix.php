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
            "xvnc_during_build" =>
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

        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = json_decode($defaults, true);

        $file = PIPEDIR.DS.$this->params["item"].DS.'settings';
        $settings = file_get_contents($file) ;
        $settings = json_decode($settings, true);

        $mn = $this->getModuleName() ;
        if ($settings[$mn]["xvnc_during_build"] == "on") {
            $logging->log ("XVFB Enabled for build, starting...", $this->getModuleName() ) ;
            $xvncCommand = "echo 'pretend to start xvnc'" ;
            $result = self::executeAndOutput($xvncCommand) ;
            if ($result == true) { $logging->log ("XVFB started successfully", $this->getModuleName() ) ; }
            else { $logging->log ("XVFB start error", $this->getModuleName() ) ; }
            return $result;
        }  else {
            $logging->log ("XVFB Not enabled for build, ignoring...", $this->getModuleName() ) ;
            return true ;
        }
    }

    public function stopXvnc() {
        $run = $this->params["run-id"];

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = json_decode($defaults, true);

        $file = PIPEDIR.DS.$this->params["item"].DS.'settings';
        $settings = file_get_contents($file) ;
        $settings = json_decode($settings, true);

        $mn = $this->getModuleName() ;
        if ($settings[$mn]["xvnc_during_build"] == "on") {
            $logging->log ("XVFB Enabled for build, stopping...", $this->getModuleName() ) ;
            $xvncCommand = "echo 'pretend to stop xvnc'" ;
            $result = self::executeAndOutput($xvncCommand) ;
            if ($result == true) { $logging->log ("XVFB stopped successfully", $this->getModuleName() ) ; }
            else { $logging->log ("XVFB stop error", $this->getModuleName() ) ; }
            return $result;
        }  else {
            $logging->log ("XVFB Not enabled for build, ignoring...", $this->getModuleName() ) ;
            return true ;
        }
    }

}