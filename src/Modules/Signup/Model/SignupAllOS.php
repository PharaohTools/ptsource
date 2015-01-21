<?php

Namespace Model;

class SignupAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;


    public function getlogin() {
        $ret="get Login";
        return $ret ;
    }

    public function checkLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_info=$this->checkLoginInfo($username, $password);
        if ($user_info == NULL) {
            echo json_encode(array("status" => FALSE, "msg" => 'Sorry!! Wrong User name Or Password'));
            return;
        } else {
            // Start the session
            session_start();
            $_SESSION["username"] = $username;
            echo json_encode(array("status" => TRUE));
            return;
        }
    }
    // @todo need to check login credential from datastore or PAM/LDAP
    public function checkLoginInfo($username, $password) {
        return $username;
    }

    // @todo need to destroy all login credential or anything related to login
    public function allLoginInfoDestroy() {
        session_destroy();
        // return array ("type"=>"control", "control"=>"Signup");
        //return array ("type"=>"control", "control"=>"Signup", "action"=>"login");
         //return array( "Signup" => array("login") );
        header("Location: /index.php?control=Signup&action=login");
    }

}
