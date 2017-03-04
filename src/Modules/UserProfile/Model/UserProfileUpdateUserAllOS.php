<?php

Namespace Model;

class UserProfileUpdateUserAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("UpdateUser") ;

    public function getData() {
        $ret["data"] = $this->updateUser();
        return $ret ;
    }

    public function updateUser() {

        $valid = $this->validateUserDetails() ;
        if ($valid !== true) {
            return $valid ; }

        $check_password = $this->passwordIncluded() ;
        if ($check_password === true) {
            $createdUser = $this->updateTheUserPassword() ;
            if ($createdUser !== true) {
                return $createdUser ; } }
        else {
            $createdUser = $this->updateTheUserDetails() ;
            if ($createdUser !== true) {
                return $createdUser ; } }

        $return = array(
            "status" => true ,
            "message" => "User Details Updated for {$this->params["create_username"]}",
            "user" => $this->getOneUserDetails($this->params["create_username"]) );
        return $return ;

    }

    public function validateUserDetails() {
        if ($this->userAlreadyExists() == false) {
            $return = array(
                "status" => false ,
                "message" => "This username does not exist" );
            return $return ; }
        $check_password = $this->passwordIncluded() ;
        if ($check_password === true) {
            $presult = $this->passwordInvalid() ;
            if ($presult !== true) {
                $return = array(
                    "status" => false ,
                    "message" => $presult );
                return $return ; } }
        return true ;
    }

    private function userAlreadyExists() {
        $allusers = $this->getAllUserDetails() ;
//        var_dump($allusers) ;
        foreach ($allusers as $oneuser) {
//            var_dump($oneuser['username']) ;
            if ($oneuser['username'] == $this->params["create_username"]) {
                return true ; } }
        return false ;
    }

    private function passwordIncluded() {
        if (isset($this->params["update_password"])) {
            return true ; }
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

    private function getAllUserDetails() {
        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $au = $ua->getUsersData();
        return $au;
    }

    private function getOneUserDetails($username) {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $au =$signup->getUsersData();
        foreach ($au as $oneuser) {
            if ($oneuser['username'] === $this->params["create_username"]) {
                return $oneuser ; } }
        return array() ;
    }

    private function updateTheUserPassword() {

        $userMod = new \StdClass() ;
        $userMod['username'] = $this->params["create_username"] ;
        $userMod->password = $this->params["update_password"] ;

        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $cu = $signup->updateUser($userMod);

        if ($cu !== true) {
            $return = array(
                "status" => false ,
                "message" => "Unable to update this user." );
            return $return ; }

        return true ;
    }

    private function updateTheUserDetails() {

        $userMod = array() ;
        $userMod['username'] = $this->params["create_username"] ;
        if (isset($this->params["update_user_bio"])) {
            $userMod['user_bio'] = $this->params["update_user_bio"] ; }
        if (isset($this->params["update_full_name"])) {
            $userMod['full_name'] = $this->params["update_full_name"] ;}
        if (isset($this->params["update_website"])) {
            $userMod['website'] = $this->params["update_website"] ;}
        if (isset($this->params["update_location"])) {
            $userMod['location'] = $this->params["update_location"] ; }
        if (isset($this->params["update_avatar"])) {
            $userMod['avatar'] = $this->params["update_avatar"] ; }
        if (isset($this->params["update_show_location"])) {
            $userMod['show_location'] = $this->params["update_show_location"] ; }
        if (isset($this->params["update_show_website"])) {
            $userMod['show_website'] = $this->params["update_show_website"] ; }
        if (isset($this->params["update_show_email"])) {
            $userMod['show_email'] = $this->params["update_show_email"] ; }


        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $cu = $ua->updateUser($userMod);

        if ($cu !== true) {
            $return = array(
                "status" => false ,
                "message" => "Unable to update this user." );
            return $return ; }

        return true ;
    }

}
