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

    //check login
    public function getData() {
        $ret['user'] = $this->getUserDetails();
        $ret['allusers'] = $this->getAllUserDetails();
        return $ret ;
    }

    //check login
    public function saveData() {
        $user = new \stdClass() ;
        $user->username = $_REQUEST['update_username'];
        $user->email = $_REQUEST['update_email'];
        if (isset($_REQUEST['update_password']) &&
            ($_REQUEST['update_password'] == $_REQUEST['update_password_match'])) {
            $user->password = $_REQUEST['update_password']; }
        $this->saveUser($user);
    }

    public function getUserDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $oldData=$signup->getLoggedInUserData();
        return $oldData;
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

    public function checkLoginSession() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        return $signup->checkLoginSession();
    }

}
