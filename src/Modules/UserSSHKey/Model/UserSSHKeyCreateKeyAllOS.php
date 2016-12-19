<?php

Namespace Model;

class KeySSHKeyCreateKeyAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("CreateKey") ;

    public function getData() {
        $ret["data"] = $this->createKey();
        return $ret ;
    }

    public function createKey() {

//        $create_perms = $this->checkCreationPermissions() ;
//        if ($create_perms !== true) { return $create_perms ; }

        $valid = $this->validateKeyDetails() ;
        if ($valid !== true) { return $valid ; }

        $createdKey = $this->makeTheKey() ;
        if ($createdKey !== true) { return $createdKey ; }

        $return = array(
            "status" => true ,
            "message" => "Key Created",
            "user" => $this->getOneKeyDetails($this->params["create_username"]) );
        return $return ;

    }

    public function validateKeyDetails() {
        if ($this->userAlreadyExists()) {
            $return = array(
                "status" => false ,
                "message" => "This username already exists" );
            return $return ; }
        $presult = $this->passwordInvalid() ;
        if ($presult !== true) {
            $return = array(
                "status" => false ,
                "message" => $presult );
            return $return ; }
        return true ;
    }

    private function userAlreadyExists() {
        $allusers = $this->getAllKeyDetails() ;
        foreach ($allusers as $oneuser) {
            if ($oneuser->username == $this->params["create_username"]) {
                return true ; } }
        return false ;
    }

    private function passwordInvalid() {

        if ($this->params["update_password"] !== $this->params["update_password_match"]) {
            $return =  "Passwords must match" ;
            return $return ; }

        if (strlen($this->params["update_password"]) <3 ) {
            $return = "Password must be longer than three characters" ;
            return $return ; }

        return true ;
    }

    private function getAllKeyDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInKeyData() ;
        $rid = $signup->getKeyRole($me->email);
        if ($rid == 1) {
            $au =$signup->getKeysData();
            return $au; }
        return array() ;
    }

    private function getOneKeyDetails($username) {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $au =$signup->getKeysData();
        foreach ($au as $oneuser) {
            if ($oneuser->username == $this->params["create_username"]) {
                $return = new \StdClass();
                $return->username = $oneuser->username ;
                $return->email = $oneuser->email ;
                return $return ; } }
        return array() ;
    }

    private function makeTheKey() {

        $newKey["username"] = $this->params["create_username"] ;
        $newKey["password"] = $this->params["update_password"] ;
        $newKey["email"] = $this->params["create_email"] ;
        $newKey["status"] = 1 ;
        $newKey["role"] = 1 ;

        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $cu = $signup->createNewKey($newKey);

        if ($cu == false) {
            $return = array(
                "status" => false ,
                "message" => "Unable to create this user" );
            return $return ; }

        return true ;
    }

}
