<?php

Namespace Info;

class UserOAuthKeyInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Edit OAuth Keys for Users";

    public function __construct() {
        parent::__construct();
    }

    public function routesAvailable() {
        return array( 'UserOAuthKey' =>  array("show", "new", "create", "delete", "enable", "disable", "update"));
    }

    public function routeAliases() {
        return array('user-oauthkey' => 'UserOAuthKey', 'useroauthkey' => 'UserOAuthKey');
    }

    public function helpDefinition() {
        $help = 'The User OAuth Key Module allows you to store and edit OAuth Keys.';
        return $help ;
    }

}
