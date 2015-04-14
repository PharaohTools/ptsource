<?php

Namespace Info;

class UserManagerInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Manage the Users in PTConfigure";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "UserManager" =>  array("show","getuserdetails","changerole","removeuser","adduser","userprofile","changepassword",));
    }

    public function routeAliases() {
      return array("user-manager"=>"UserManager", "usermanager"=>"UserManager");
    }

    public function helpDefinition() {
      $help = 'The User Manager allows you to manage Users.';
      return $help ;
    }

}
