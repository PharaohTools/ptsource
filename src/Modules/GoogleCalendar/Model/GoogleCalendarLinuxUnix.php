<?php

Namespace Model;

class GoogleCalendarLinuxUnix extends Base {

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
           "googlecalendar_enabled" =>
            	array(
                	"type" => "boolean",
                	"optional" => true,
                	"name" => "googlecalendar on Build Completion?"
            ),
            "clientid" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Service Account Client Id" ),
            "emailaddress" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Service Account Email Address" ),
            "keyfilelocation" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Path for P12 Key File" ),
            "youremailid" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Your Email Address" ),
         );

        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterBuildComplete" => array(
                "setEvents",
            ),
        );
        return $ff ;
    }

     public function setEvents() {

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

        $file = PIPEDIR.DS.$this->params["item"].DS.'tmpfile';
        $tmpfile = file_get_contents($file) ;
        //$tmpfile = json_decode($tmpfile, true);
           
        $pipeline = $this->getPipeline() ;
        //$buildsettings = $pipeline->getData();

        $mn = $this->getModuleName() ;
	    if (isset($pipeline["settings"][$mn]["googlecalendar_enabled"]) && $pipeline["settings"][$mn]["googlecalendar_enabled"] == "on") {
        require __DIR__ . '/../Libraries/vendor/autoload.php';

	       //require_once 'Google/Client.php';
           //require_once 'Google/Service/Calendar.php';
           //require_once 'Google/Auth/AssertionCredentials.php';

           $client_id = $pipeline["settings"][$mn]["clientid"];
           $Email_address = $pipeline["settings"][$mn]["emailaddress"];
           $key_file_location = $pipeline["settings"][$mn]["keyfilelocation"];
           $client = new \Google_Client();
           $client->setApplicationName("Client_Library_Examples");
           $key = file_get_contents($key_file_location);
           //$calendarId = '';

           $scopes ="https://www.googleapis.com/auth/calendar";
           $cred = new \Google_Auth_AssertionCredentials(
               $Email_address,
               array($scopes),
               $key
               );
          $client->setAssertionCredentials($cred);
          if($client->getAuth()->isAccessTokenExpired()) {
              $client->getAuth()->refreshTokenWithAssertion($cred);
          }

          $service = new \Google_Service_Calendar($client);

          $event = new \Google_Service_Calendar_Event();
          $event->setSummary($tmpfile);
          $event->setLocation('Somewhere');
          $start = new \Google_Service_Calendar_EventDateTime();
          //$start->setDateTime('2015-02-25T10:00:00.000-07:00');
          $start->setDateTime(date("Y-m-d\Th:i:s").'.190-05:30');

          $event->setStart($start);
 
          $end = new \Google_Service_Calendar_EventDateTime();
          //$end->setDateTime('2015-02-25T10:25:00.000-07:00');
          $end->setDateTime(date("Y-m-d\Th:i:s").'.190-05:30');

          $event->setEnd($end);
          $attendee1 = new \Google_Service_Calendar_EventAttendee();
          $attendee1->setEmail($pipeline["settings"][$mn]["youremailid"]);
          // ...
          $attendees = array($attendee1,
                             // ...
                         );
          $event->attendees = $attendees;
          $createdEvent = $service->events->insert('primary', $event);

          echo $createdEvent->getId();
           
          return true; }
        else {
// @todo this should do something at max level debugging
//          echo "googlecalendar not run\n";
            return true ;
        }
	}

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}
