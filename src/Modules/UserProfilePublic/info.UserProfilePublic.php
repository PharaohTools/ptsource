<?php

Namespace Info;

class UserProfilePublicInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "View a Users Public Profile";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "UserProfilePublic" =>  array("show", "save", "new", "create", "delete", "get-user", "update"));
    }

    public function routeAliases() {
      return array("user-profile-public"=>"UserProfilePublic", "userprofilepublic"=>"UserProfilePublic");
    }

    public function helpDefinition() {
      $help = 'The User Public profile allows you to View Users.';
      return $help ;
    }

}
