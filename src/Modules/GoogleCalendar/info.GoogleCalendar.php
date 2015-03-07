<?php

Namespace Info;

class GoogleCalendarInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "GoogleCalendar Event Notification";

    public function _construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array("GoogleCalendar" => array_merge(parent::routesAvailable(), array("help") ) );
    }

    public function routeAliases() {
        return array("Googlecalendar"=>"GoogleCalendar", "googlecalendar"=>"GoogleCalendar");
    }

    public function events() {
        return array("afterBuildComplete");
    }

    public function buildSettings() {
        return array("clientid", "emailaddress", "keyfilelocation", "youremailid");
    }

    public function helpDefinition() {
       $help = <<<"HELPDATA"
    This extension provides integration with GoogleCalendar.

    GoogleCalendar

HELPDATA;
      return $help ;
    }

}
 
 
 
