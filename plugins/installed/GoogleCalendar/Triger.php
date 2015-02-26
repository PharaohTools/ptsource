<?php

require __DIR__ . '/vendor/autoload.php';

class Triger {
	
	function __construct() {
		
	}
	
	public function startTriger($input)
	{
		
           $id = $input['service_account_id'];           
           $email = $input['service_account_Email'];           
           $key = $input['path_p12key'];           
           $mail = $input['your_email_id'];
           $sum = file_get_contents($input["tmpfile"]);
            
          		// require __DIR__ . '/vendor/autoload.php';

	   		//require_once 'Google/Client.php';
           //require_once 'Google/Service/Calendar.php';
           //require_once 'Google/Auth/AssertionCredentials.php';

           $client_id = $id;
           $Email_address = $email;
           $key_file_location = $key;
           $client = new Google_Client();
           $client->setApplicationName("Client_Library_Examples");
           $key = file_get_contents($key_file_location);
           //$calendarId = '';

           $scopes ="https://www.googleapis.com/auth/calendar";
           $cred = new Google_Auth_AssertionCredentials(
               $Email_address,
               array($scopes),
               $key
               );
          $client->setAssertionCredentials($cred);
          if($client->getAuth()->isAccessTokenExpired()) {
              $client->getAuth()->refreshTokenWithAssertion($cred);
          }



          $service = new Google_Service_Calendar($client);


          $event = new Google_Service_Calendar_Event();
          $event->setSummary($sum);
          $event->setLocation('Somewhere');
          $start = new Google_Service_Calendar_EventDateTime();
          //$start->setDateTime('2015-02-25T10:00:00.000-07:00');
          $start->setDateTime(date("Y-m-d\Th:i:s").'.000-06:30');

          $event->setStart($start);
 
          $end = new Google_Service_Calendar_EventDateTime();
          //$end->setDateTime('2015-02-25T10:25:00.000-07:00');
          $end->setDateTime(date("Y-m-d\Th:i:s").'.000-06:30');

          $event->setEnd($end);
          $attendee1 = new Google_Service_Calendar_EventAttendee();
          $attendee1->setEmail($mail);
          // ...
          $attendees = array($attendee1,
                             // ...
                         );
          $event->attendees = $attendees;
          $createdEvent = $service->events->insert('primary', $event);

          echo $createdEvent->getId();
           
          return true;

	}
} 



