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

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "send_postbuild_email" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Send Email on Build Completion?"
            ),
            "send_postbuild_email_stability" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Only notify on failing, or first stable after failed Build?"
            ),
            "send_postbuild_email_address" =>
            array(
                "type" => "text",
                "optional" => true,
                "name" => "Email Address(es) to send to?"
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
                "sendCompletionAlertMail",
            ),
        );
        return $ff ;
    }

    public function sendCompletionAlertMail() {
        $this->sendAlertMail(true);
    }

    public function sendAlertMail($completion) {

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $run = $this->params["run-id"];
        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = new \ArrayObject(json_decode($defaults));

        $file = PIPEDIR.DS.$this->params["item"].DS.'settings';
        $settings = file_get_contents($file) ;
        $appsettings = json_decode($settings, true);

        $pipeline = $this->getPipeline() ;
        $buildsettings = $pipeline->getData();

        $mn = $this->getModuleName() ;

        if ($buildsettings[$mn]["send_postbuild_email"] == "on" &&
            $buildsettings[$mn]["send_postbuild_email_stability"]=="on" &&
            $completion ==true ) {
            $logging->log ("Only Sending alert mail if poor stability", $this->getModuleName() ) ;
            if ($this->params["run-status"] == "SUCCESS") {
                $logging->log ("Build currently stable, not emailing", $this->getModuleName() ) ;
                return true; }
            else {
                $logging->log ("Build unstable, emailing", $this->getModuleName() ) ; } }

        if ($buildsettings[$mn]["send_postbuild_email"] == "on") {
            // error_log(serialize($defaults)) ;
            $subject = "Pharaoh Build Result - ". $defaults["project-name"]." ".", Run ID -".$run;
            $message = "";
            $message .= ($completion==true) ? "Your build has completed\n" : "";
            $message .= ($buildsettings[$mn]["send_postbuild_email_stability"]==true) ? "Your build has completed\n" : "";
            $message .= $this->params["run-status"];
            $to = explode(",", $buildsettings[$mn]["send_postbuild_email_address"]) ;
            require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'swift_required.php' ;
            // Create the Transport
            try {
                $transport = \Swift_SmtpTransport::newInstance(
                    $appsettings["mod_config"]["SendEmail"]["config_smtp_server"],
                    (int) $appsettings["mod_config"]["SendEmail"]["config_port"])
                    ->setUsername($appsettings["mod_config"]["SendEmail"]["config_username"])
                    ->setPassword($appsettings["mod_config"]["SendEmail"]["config_password"]) ;
                // Create the Mailer using your created Transport
                $mailer = \Swift_Mailer::newInstance($transport);
                // Create the message
                $message = \Swift_Message::newInstance()
                    // Give the message a subject
                    ->setSubject($subject)
                    // Set the From address with an associative array
                    ->setFrom(array($appsettings["mod_config"]["SendEmail"]["from_email"] => "Pharaoh Build Server"))
                    // Set the To addresses with an associative array
                    ->setTo($to)
                    // Give it a body
                    ->setBody($message)
                    // And optionally an alternative body
                    //->addPart("<q>$message</q>", 'text/html')
                    // Optionally add any attachments
                    //->attach(Swift_Attachment::fromPath('my-document.pdf'))
                ;

                $logging->log ("Sending alert mail", $this->getModuleName() ) ;
                // Send the message
                $result = $mailer->send($message);
                if ($result == true) { $logging->log ("Email sent successfully", $this->getModuleName() ) ; }
                else { $logging->log ("Email sending error", $this->getModuleName() ) ; }
                return $result; }
            catch (\Exception $e) {
                $logging->log ("Error sending mail", $this->getModuleName() ) ;
                return false; }

        }  else {
            $logging->log ("Send Alert Mail ignoring...", $this->getModuleName() ) ;
            return true ;
        }

    }

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        var_dump($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}