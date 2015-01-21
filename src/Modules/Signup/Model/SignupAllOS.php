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
            echo json_encode(array("status" => FALSE, "msg" => "Sorry!! Wrong User name Or Password"));
            return;
        } else {
            $_SESSION["login-status"]=TRUE;
            $_SESSION["username"] = $user_info;
            echo json_encode(array("status" => TRUE));
            return;
        }
    }
    // @todo need to check login credential from datastore or PAM/LDAP
    public function checkLoginInfo($usr, $pass) {
        // List of users and their password.
        $users = array(1 => 'test1', 2 => 'test2', 3 => 'test3', 4 => 'test4');
        $passwords = array(1 => 'e10adc3949ba59abbe56e057f20f883e', 2 => 'e10adc3949ba59abbe56e057f20f883e', 3 => 'e10adc3949ba59abbe56e057f20f883e', 4 => 'e10adc3949ba59abbe56e057f20f883e');
        if (in_array($usr, $users) && in_array(md5($pass), $passwords))
        {
            return $usr;
        }
        else{
            return null;
        }

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
