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
        $run = $this->params["run-id"];
        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = new \ArrayObject(json_decode($defaults));
        // error_log(serialize($defaults)) ;

        $subject = "Pharaoh Build Result - ". $defaults["project-name"]." ".", Run ID -".$run;
        $message = $this->params["run-status"];
        $to = $defaults["email-id"] ;

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $xvncCommand = "" ;

        $result = self::executeAndOutput($xvncCommand) ;
        if ($result == true) { $logging->log ("Email sent successfully", $this->getModuleName() ) ; }
        else { $logging->log ("Email sending error", $this->getModuleName() ) ; }
        return $result;
    }

    public function stopXvnc() {
        $run = $this->params["run-id"];
        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = new \ArrayObject(json_decode($defaults));
        // error_log(serialize($defaults)) ;

        $subject = "Pharaoh Build Result - ". $defaults["project-name"]." ".", Run ID -".$run;
        $message = $this->params["run-status"];
        $to = $defaults["email-id"] ;

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $xvncCommand = "" ;

        $result = self::executeAndOutput($xvncCommand) ;
        if ($result == true) { $logging->log ("Email sent successfully", $this->getModuleName() ) ; }
        else { $logging->log ("Email sending error", $this->getModuleName() ) ; }
        return $result;
    }

}