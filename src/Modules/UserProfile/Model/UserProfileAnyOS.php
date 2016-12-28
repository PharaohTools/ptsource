<?php

Namespace Model;

class UserProfileAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params);
	}

    public function getData() {
        $ret['user'] = $this->getUserDetails();
        $ret['allusers'] = $this->getAllUserDetails();
        $ret['email_users_enabled'] = $this->getEnabledStatus();
        $ret['extra_fieldsets'] = $this->getExtraFieldsets();
        return $ret ;
    }

    public function saveData() {
        $user = new \stdClass() ;
        // @todo sanitize these request vars. Use Params?
        $user->username = $this->params['update_username'];
        $user->email = $this->params['update_email'];
        if (isset($this->params['update_password']) &&
            ($this->params['update_password'] == $this->params['update_password_match'])) {
            $user->password = $this->params['update_password']; }
        if (isset($this->params['update_user_bio']) ) {
            $user->user_bio = $this->params['update_user_bio']; }
        if (isset($this->params['update_location']) ) {
            $user->user_bio = $this->params['update_location']; }
        if (isset($this->params['update_website']) ) {
            $user->user_bio = $this->params['update_website']; }
        if (isset($this->params['update_full_name']) ) {
            $user->user_bio = $this->params['update_full_name']; }
        $this->saveUser($user);
    }

    public function getUserDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $oldData=$signup->getLoggedInUserData();
        return $oldData;
    }

    public function getExtraFieldsets() {

        $fieldsets = array(
            array ( 'title' => "Full Name", 'slug' => "full_name", 'type' => "text" ),
            array ( 'title' => "avatar", 'slug' => "avatar", 'type' => "text" ),
            array ( 'title' => "User Bio", 'slug' => "user_bio", 'type' => "textarea" ),
            array ( 'title' => "Website", 'slug' => "website", 'type' => "text" ),
            array ( 'title' => "Location", 'slug' => "location", 'type' => "text" ),
            array ( 'title' => "Show Email", 'slug' => "show_email", 'type' => "boolean" ),
            array ( 'title' => "Show Website", 'slug' => "show_website", 'type' => "boolean" ),
            array ( 'title' => "Show Location", 'slug' => "show_location", 'type' => "boolean" ),
        ) ;
        return $fieldsets ;
    }

    public function getEnabledStatus() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $rid = $signup->getUserRole($me->email);
        if ($rid == 1) {
            $au =$signup->getUsersData();
            return $au;  }
        return false ;
    }

    public function getAllUserDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $rid = $signup->getUserRole($me->email);
        if ($rid == 1) {
            $au =$signup->getUsersData();
            return $au;  }
        return false ;
    }

    private function saveUser($user) {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $oldData=$signup->updateUser($user);
        return $oldData;
    }

    private function createUser($user) {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $oldData=$signup->updateUser($user);
        return $oldData;
    }

    public function checkLoginSession() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        return $signup->checkLoginSession();
    }

}
