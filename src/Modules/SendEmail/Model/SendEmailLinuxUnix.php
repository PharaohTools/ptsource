<?php

Namespace Model;

class SendEmailLinuxUnix extends Base {

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
            "beforeSettings" => array(
                "doAnEcho",
            ),
            "beforeBuild" => array(
                "doAnEcho",
            ),
            "afterBuildComplete" => array(
                "sendAlertMail",
            ),
        );

        return $ff ;
    }

    public function sendAlertMail() {
        $run = $this->params["run-id"];
        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = new \ArrayObject(json_decode($defaults));
        // error_log(serialize($defaults)) ;
        $subject = $defaults["project-name"]." "."build-".$run;
        $message = $this->params["run-status"];
        $to = $defaults["email-id"];
        mail($to, $subject, $message);
        return;
    }

    public function doAnEcho($step, $item) {
        echo "done an echo \n\n" ;
    }

}