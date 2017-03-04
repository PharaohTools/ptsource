<?php

Namespace Model;

class UserManagerAnyOS extends BasePHPApp {

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
        $this->autopilotDefiner = "UserManager";
        $this->programNameMachine = "usermanager"; // command and app dir name
        $this->programNameFriendly = " UserManager "; // 12 chars
        $this->programNameInstaller = "UserManager";
        $this->initialize();
    }

    public function getUserDetails() {
        $userAccountFactory = new \Model\UserAccount();
        $userAccount = $userAccountFactory->getModel($this->params);
        $oldData = $userAccount->getUsersData();
        return $oldData;
    }

    public function changeRole() {
        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $user = $ua->getUserDataByUsername($this->params["username"]);
        $data['role'] = $this->params["role"] ;
        $data['email'] = $user['email'] ;
        $result = $ua->updateUser($data);
        return $result ;
    }

    public function checkRole() {
        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $res = $ua->getLoggedInUserData();
        if ($res === false) {
            return false ; }
        else {
            return ($res['role'] == 1) ; }
    }

    public function getMyUserRoleId() {
        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $res = $ua->getLoggedInUserData();
        if ($res === false) {
            return false ; }
        else {
            return $res['role'] ; }
    }

    public function getMyUserSlug() {
        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $res = $ua->getLoggedInUserData();
        if ($res === false) {
            return false ; }
        else {
            return $res['username'] ; }
    }

    public function getRestrictionStatus($oneUser = null) {
        if (is_null($oneUser)) {
            $sess_un = (isset($_SESSION["username"])) ? $_SESSION["username"] : "guest" ;
            $oneUser = $sess_un ; }
        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $user = $ua->getUserDataByUsername($oneUser);
        if (isset($user['restrict']) && $user['restrict'] == 1) {
            return true; }
        return false ;
    }

    public function restrictUser(){
        // @TODO check that an admin is doing this
        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $user = $ua->getUserDataByUsername($this->params["username"]);
        $data['restrict'] = 1 ;
        $data['email'] = $user['email'] ;
        $result = $ua->updateUser($data);
        return $result ;
    }

}
