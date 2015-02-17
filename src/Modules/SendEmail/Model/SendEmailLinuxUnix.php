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
        $subject = "Pharaoh Build Result - ". $defaults["project-name"]." ".", Run ID -".$run;
        $message = $this->params["run-status"];
        $to = $defaults["email-id"] ;

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'swift_required.php' ;
        // Create the Transport
        $transport = \Swift_SmtpTransport::newInstance(
                $this->params["build-settings"]["mod_config"]["SendEmail"]["config_smtp_server"],
            (int) $this->params["build-settings"]["mod_config"]["SendEmail"]["config_port"])
            ->setUsername($this->params["build-settings"]["mod_config"]["SendEmail"]["config_username"])
            ->setPassword($this->params["build-settings"]["mod_config"]["SendEmail"]["config_password"])
        ;
        // Create the Mailer using your created Transport
        $mailer = \Swift_Mailer::newInstance($transport);
        // Create the message
        $message = \Swift_Message::newInstance()
            // Give the message a subject
            ->setSubject($subject)
            // Set the From address with an associative array
            ->setFrom(array($to))
            // Set the To addresses with an associative array
            ->setTo(array($to))
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
        return $result;
    }

}