<?php

Namespace Info;

class UserSSHKeyInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Edit SSH Keys for Users";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "UserSSHKey" =>  array("show", "save", "new", "create", "delete", "disable", "get-user", "update"));
    }

    public function routeAliases() {
      return array("user-sshkey"=>"UserSSHKey", "usersshkey"=>"UserSSHKey");
    }

    public function helpDefinition() {
      $help = 'The User profile allows you to edit Users.';
      return $help ;
    }

}
