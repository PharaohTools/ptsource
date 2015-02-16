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
        echo "Sending alert mail" ;

        $run = $this->params["run-id"];
        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = new \ArrayObject(json_decode($defaults));
        // error_log(serialize($defaults)) ;
        $subject = $defaults["project-name"]." "."build-".$run;
        $message = $this->params["run-status"];
        $to = $defaults["email-id"];

        require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'swift_required.php' ;


        // Create the Transport
        $transport = \Swift_SmtpTransport::newInstance('mail.golden-contact-computing.co.uk', 25)
            ->setUsername('bigboss')
            ->setPassword('codeblue041291?')
        ;

        // Create the Mailer using your created Transport
        $mailer = \Swift_Mailer::newInstance($transport);

        // Create the message
        $message = \Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject('Pharaoh Build Alert Email')

            // Set the From address with an associative array
            ->setFrom(array('phpengine@pharaohtools.com' => 'David Amanshia'))

            // Set the To addresses with an associative array
            //->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'))
            ->setTo(array('phpengine@pharaohtools.com' => 'David Amanshia'))

            // Give it a body
            ->setBody('Dave version one of the message')

            // And optionally an alternative body
            ->addPart("<q>Dave is rinsing the email thing here fam</q> $subject, $message, $to ", 'text/html')

            // Optionally add any attachments
            //->attach(Swift_Attachment::fromPath('my-document.pdf'))
        ;



        // Send the message
        $result = $mailer->send($message);



        return $result;
    }

}