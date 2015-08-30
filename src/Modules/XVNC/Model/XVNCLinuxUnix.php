<?php

Namespace Model;

class XVNCLinuxUnix extends Base {

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
                    "name" => "Start XVNC before the build, and shut it down after?"
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
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $mn = $this->getModuleName() ;
        if (isset($this->params["build-settings"][$mn]["xvnc_during_build"]) &&
            $this->params["build-settings"][$mn]["xvnc_during_build"] == "on") {
            $logging->log ("XVNC Enabled for build, starting...", $this->getModuleName() ) ;
            $xvncCommand = "echo 'pretend to start xvnc'" ;
            $result = self::executeAndOutput($xvncCommand) ;
            if ($result == true) { $logging->log ("XVNC started successfully", $this->getModuleName() ) ; }
            else { $logging->log ("XVNC start error", $this->getModuleName() ) ; }
            return $result;
        }  else {
//            $logging->log ("XVNC Not enabled for build, ignoring...", $this->getModuleName() ) ;
            return true ;
        }
    }

    public function stopXvnc() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $mn = $this->getModuleName() ;
        if (isset($this->params["build-settings"][$mn]["xvnc_during_build"]) &&
            $this->params["build-settings"][$mn]["xvnc_during_build"] == "on") {
            $logging->log ("XVNC Enabled for build, stopping...", $this->getModuleName() ) ;
            $xvncCommand = "echo 'pretend to stop xvnc'" ;
            $result = self::executeAndOutput($xvncCommand) ;
            if ($result == true) { $logging->log ("XVNC stopped successfully", $this->getModuleName() ) ; }
            else { $logging->log ("XVNC stop error", $this->getModuleName() ) ; }
            return $result;
        }  else {
//            $logging->log ("XVNC Not enabled for build, ignoring...", $this->getModuleName() ) ;
            return true ;
        }
    }

}