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

    private function getUserFileLocation() {
        return dirname(__DIR__).DS."Data".DS."users.txt" ;
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
        $registrationData = array('username'=>$_POST['username'],'email'=>$_POST['email'],'password'=>md5($this->getSalt().$_POST['password']),'verificationcode'=> hash('sha512', 'aDv@4gtm%7rfeEg4!gsFe'),'status'=> 0,'role'=>3);
        if ($myfile = fopen($this->getUserFileLocation(), "r")) { }
        else {
            return array("status" => false, "id"=>"registration_error_msg", "msg" => "Unable to read users datastore. Contact Administrator."); }
        $oldData='';
        while(!feof($myfile))
            $oldData.=fgets($myfile);
        fclose($myfile);
        $oldData=json_decode($oldData);

        foreach($oldData as $data) {
            if ($data['username']==$_POST['username']) {
                return array("status" => false,"id"=>"login_username_alert", "msg" => "User Name Already Exist!!!");}
            if ($data->email==$_POST['email']) {
                return array("status" => false,"id"=>"login_email_alert", "msg" => "Email Already Exist!!!"); } }

        if ($myfile = fopen($this->getUserFileLocation(), "w")) { }
        else {
            return array("status" => false, "id"=>"registration_error_msg", "msg" => "Unable to write to users datastore. Contact Administrator.");  }
        if($oldData==null) {
            fwrite($myfile, json_encode(array($registrationData))); }
        else{
            fwrite($myfile, json_encode(array_merge($oldData, array($registrationData))));
            // @todo dont hardcode url?
            $message = 'Hi <br /> <a href="/index.php?control=Signup&action=verify&verificationCode=verify">Click here to activate account</a>';
            mail($_POST['email'], 'Verification mail from '.PHARAOH_APP, $message); }
        // print_r(array_merge($oldData, array($registrationData)));
        fclose($myfile);
        // @todo dont output from model?
        return array("status" => true, "id"=>"registration_error_msg", "msg" => "Registration Successful!!") ;
    }

    public function allLoginInfoDestroy() {
        session_destroy();
        header("Location: /index.php?control=Signup&action=login");
    }

    public function mailVerification() {
        $file = $this->getUserFileLocation();;
        $accountsJson = file_get_contents($file);
        $accounts = json_decode($accountsJson);
        $verified = false;
        foreach($accounts as $index=>$account) {
            if ($account->verificationcode == $this->params['verificationCode']) {
                $verified = true;
                $accounts[$index][$account->status] = 1; } }
        if ($verified === true) {
            $accountsJson = json_encode($accounts);
            file_put_contents($file, $accountsJson); }
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
