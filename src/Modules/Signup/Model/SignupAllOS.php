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

    //check login
    public function checkLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $this->checkLoginInfo($username, $password);
    }

    //check login status
    public function checkLoginStatus() {
        $url = $_POST['url'];
        $this->checkLoginStatusInfo($url);
    }


    // @todo need to check login credential from datastore or PAM/LDAP
    public function checkLoginInfo($usr, $pass) {
        // List of users and their password.
        $users = array(1 => 'test1', 2 => 'test2', 3 => 'test3', 4 => 'test4');
        $passwords = array(1 => 'e10adc3949ba59abbe56e057f20f883e', 2 => 'e10adc3949ba59abbe56e057f20f883e', 3 => 'e10adc3949ba59abbe56e057f20f883e', 4 => 'e10adc3949ba59abbe56e057f20f883e');
        if (in_array($usr, $users) && in_array(md5($pass), $passwords))
        {

            $_SESSION["login-status"]=TRUE;
            $_SESSION["username"] = $users;
            echo json_encode(array("status" => TRUE));
            return;
        }
        else{
            echo json_encode(array("status" => FALSE, "msg" => "Sorry!! Wrong User name Or Password"));
            return;
        }

    }

    public function checkLoginStatusInfo($url) {
        // login status check
        $url_split = explode("?", $url);
        if(isset($url_split[1])){
            $url_spl = explode("&", $url_split[1]);
            if(isset($url_spl[0])){
                $url_sp = explode("=", $url_spl[0]);
                if(isset($url_sp[1]) && $url_sp[1] =="Signup"){
                    $url_s = explode("=", $url_spl[1]);
                    if(isset($url_s[1]) && ($url_s[1] =="login" || $url_s[1] =="logout" || $url_s[1] =="login-submit")){
                        echo json_encode(array("status" => TRUE));
                        return;
                    }
                    else
                        $this->checkLoginSession();

                }
                else
                    $this->checkLoginSession();
            }
            else
                $this->checkLoginSession();

        }
        else
            $this->checkLoginSession();

    }
    //@todo we can do autoload.php file before load a controller
    public function checkLoginSession() {
        if(isset($_SESSION["login-status"]) && $_SESSION["login-status"] == TRUE){
            echo json_encode(array("status" => TRUE));
            return;
        }
        else{
            echo json_encode(array("status" => FALSE));
            return;
        }
    }


    public function allLoginInfoDestroy() {
        session_destroy();
        // return array ("type"=>"control", "control"=>"Signup");
        //return array ("type"=>"control", "control"=>"Signup", "action"=>"login");
         //return array( "Signup" => array("login") );
        header("Location: /index.php?control=Signup&action=login");
    }

}
