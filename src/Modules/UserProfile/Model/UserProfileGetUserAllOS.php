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
        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $user = $ua->getUserDataByUsername($username);
        $userMod = array() ;
        $userMod['username'] = $user['username'] ;
        $userMod['email'] = $user['email'] ;
        return $userMod ;
    }

}
