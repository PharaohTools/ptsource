<?php

Namespace Model;

class UserProfileGetUserAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("GetUser") ;

    public function getData() {
        $ret["user"] = $this->getUser();
        return $ret ;
    }

    public function getUser() {
        $username = $this->params["username"] ;
        $allusers = $this->getAllUserDetails() ;
        foreach ($allusers as $oneuser) {
            if ($oneuser->username == $username) {
                return $oneuser ; } }
        return false ;
    }

    private function getAllUserDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $rid = $signup->getUserRole($me->email);
        if ($rid == 1) {
            $au =$signup->getUsersData();
            return $au; }
        return array() ;
    }

}
