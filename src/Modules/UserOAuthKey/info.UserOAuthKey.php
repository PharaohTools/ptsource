<?php

Namespace Info;

class UserSSHKeyInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Edit SSH Keys for Users";

    public function __construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( 'UserSSHKey' =>  array("show", "new", "create", "delete", "enable", "disable", "update"));
    }

    public function routeAliases() {
        return array('user-sshkey' => 'UserSSHKey', 'usersshkey' => 'UserSSHKey');
    }

    public function helpDefinition() {
        $help = 'The User SSH Key Module allows you to store and edit SSH Keys.';
        return $help ;
    }

}
