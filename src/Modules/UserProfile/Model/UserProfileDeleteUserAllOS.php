<?php

Namespace Model;

class UserProfileDeleteUserAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("DeleteUser") ;

    public function getData() {
        $ret["data"] = $this->deleteUser();
        return $ret ;
    }

    public function deleteUser() {

//        $create_perms = $this->checkCreationPermissions() ;
//        if ($create_perms !== true) { return $create_perms ; }

        $valid = $this->validateUserDetails() ;
        if ($valid !== true) { return $valid ; }

        $deletedUser = $this->deleteTheUser() ;
        if ($deletedUser !== true) { return $deletedUser ; }

        $return = array(
            "status" => true ,
            "message" => "User Deleted",
            "user" => $this->getOneUserDetails($this->params["create_username"]) );
        return $return ;

    }

    public function validateUserDetails() {
        if ($this->userAlreadyExists() == false) {
            $return = array(
                "status" => false ,
                "message" => "This user does not exist" );
            return $return ; }
        return true ;
    }

    private function userAlreadyExists() {
        $allusers = $this->getAllUserDetails() ;
        foreach ($allusers as $oneuser) {
            if ($oneuser->username == $this->params["create_username"]) {
                return true ; } }
        return false ;
    }

    private function getAllUserDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $au =$signup->getUsersData();
        return $au;
    }

    private function getOneUserDetails($username) {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $au =$signup->getUsersData();
        foreach ($au as $oneuser) {
            if ($oneuser->username == $username) {
                return $oneuser ; } }
        return array() ;
    }

    private function deleteTheUser() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $liu = $signup->getLoggedInUserData();
        if ($liu->username == $this->params["create_username"]) {
            $return = array(
                "status" => false ,
                "message" => "You cannot delete your own user" );
            return $return ; }
        $cu = $signup->deleteUser($this->params["create_username"]);
        if ($cu == false) {
            $return = array(
                "status" => false ,
                "message" => "Unable to delete this user" );
            return $return ; }
        return true ;
    }

}
