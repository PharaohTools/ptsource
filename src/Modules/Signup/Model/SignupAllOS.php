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
        $ret["settings"] = $this->getSettings() ;
        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($this->params) ;
        $ret["events"] = $eventRunner->eventRunner("getPublicLinks") ;
        if ($ret["events"] == false) {
         // should probably do sometihing here
        }
        return $ret ;
    }

    private function getSalt() {
        // @todo this is a security risk
        // @todo a proper salt
        $salt = "12345678" ;
        return $salt ;
    }

    //check login
    public function checkLogin($user = null, $pass = null) {
        $user = (is_null($user)) ? $_POST['username'] : $user ;
        $pass = (is_null($pass)) ? $_POST['password'] : $pass ;
        $uaf = new \Model\UserAccount() ;
        $ua = $uaf->getModel($this->params) ;
        $res = $ua->checkLoginInfo($user, $pass);
        return $res ;
    }

    public function checkLoginSession() {
        // @TODO if user is on CLI assume a logged in admin. Is that OK?
        $auth = new \Model\Authentication();
        $is_web = $auth->isWebSapi() ;
        if ($is_web == false) {
            $res = array("status" => true);
            return $res ;
        }
        if ( isset($_SESSION) && is_array($_SESSION) && (count($_SESSION)==0) ) {
            $res = array("status" => false); }
        else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if(isset($_SESSION["login-status"]) && $_SESSION["login-status"] == true){
                $res = array("status" => true); }
            else{
                $res = array("status" => false); } }
        return $res ;
    }

    public function registrationSubmit() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params, "Registration") ;
        $res = $signup->registrationSubmit();
        return $res ;
    }

    public function allLoginInfoDestroy() {
        session_destroy();
        header("Location: /index.php?control=Signup&action=login");
    }

    public function mailVerification() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params, "Registration") ;
        $res = $signup->mailVerification();
        return $res ;
    }

    public function loginByOAuth($name, $email, $user){
        $_SESSION["login-status"] = true;
        $_SESSION["username"] = $email;
        if ($this->userExist($email) == true) {
            $_SESSION["userrole"] = $this->getUserRole($email);
            header("Location: /index.php?control=Index&action=index");
            return; }
        else {
            $newUser = array('name' => $name, 'username'=>$email, 'email'=>$email, 'password'=>mt_rand(5, 15), 'verificationcode'=> hash('sha512', 'aDv@4gtm%7rfeEg4!gsFe'), 'data'=>$user,'role'=>3,'status'=> 1);
            $this->createNewUser($newUser);
            $_SESSION["userrole"] = 3; }
        header("Location: /index.php?control=Index&action=index");
    }

    public function loginByLDAP($name, $email, $user){
        $_SESSION["login-status"] = true ;
        $_SESSION["username"] = $email ;
        if ($this->userExist($email) == true) {

            $_SESSION["userrole"] = $this->getUserRole($email);
            header("Location: /index.php?control=Index&action=index");
            return; }
        else {
            $newUser = array(
                'name' => $name,
                'username'=>$email,
                'email'=>$email,
                'password'=> mt_rand(5, 15),
                'verificationcode'=> hash('sha512', 'aDv@4gtm%7rfeEg4!gsFe'),
                'data'=>$user,'role'=>3,
                'status'=> 1);
            $this->createNewUser($newUser);
            $_SESSION["userrole"] = 3; }
    }

    public function getLoggedInUserData() {
        $userAccountFactory = new \Model\UserAccount();
        $userAccount = $userAccountFactory->getModel($this->params);
        $retuser = $userAccount->getLoggedInUserData();
        return $retuser ;
    }

    public function getSaltWord($word) {
        return md5($this->getSalt().$word) ;
    }

    public function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }

    public function registrationEnabled() {
        $mod_config = \Model\AppConfig::getAppVariable("mod_config");
        $is_enabled = (isset($mod_config["Signup"]["registration_enabled"]) &&
            $mod_config["Signup"]["registration_enabled"]==true ) ? true : false ;
        return $is_enabled ;
    }

}
