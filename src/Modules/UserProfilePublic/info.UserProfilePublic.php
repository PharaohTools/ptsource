<?php

Namespace Info;

class UserProfileInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Edit Users";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "UserProfile" =>  array("show", "save", "new", "create", "delete", "get-user", "update"));
    }

    public function routeAliases() {
      return array("user-profile"=>"UserProfile", "userprofile"=>"UserProfile");
    }

    public function helpDefinition() {
      $help = 'The User profile allows you to edit Users.';
      return $help ;
    }

}
