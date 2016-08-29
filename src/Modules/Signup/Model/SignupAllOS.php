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
        return $ret ;
    }

    private function getUserFileLocation() {
        return dirname(dirname(__FILE__)).DS."Data".DS."users.txt" ;
    }

    private function getSalt() {
        // @todo this is a security risk
        // @todo a proper salt
        $salt = "12345678" ;
        return $salt ;
    }

    //check login
    public function checkLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $res = $this->checkLoginInfo($username, $password);
        return $res ;
    }

    //check login status
    public function checkLoginStatus() {
        $url = $_POST['url'];
        return $this->checkLoginStatusInfo($url);
    }


    // @todo need to check login credential from datastore or PAM/LDAP
    public function checkLoginInfo($usr, $pass) {
        $file = $this->getUserFileLocation();
        $accountsJson = file_get_contents($file);
        $accounts = json_decode($accountsJson);
        $verified = false;
        foreach($accounts as $account) {
            // @todo SECURITY if acccount group is restricted, refuse the login
            if ($account->username == $usr &&
                $account->password == $this->getSaltWord($pass) &&
                $account->status == 1) {
                $verified = true; } }
        if ($verified === true) {
            session_start() ;
            $_SESSION["login-status"]=true;
            $_SESSION["username"] = $usr;
            return array("status" => true); }
        else {
            return array("status" => false, "msg" => "Sorry!! Wrong User name Or Password"); }
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
                    if(isset($url_s[1]) && ($url_s[1] =="login" || $url_s[1] =="logout" || $url_s[1] =="login-submit" || $url_s[1] =="registration" || $url_s[1] =="registration-submit")){
                        return array("status" => true); }
                    else
                        return $this->checkLoginSession(); }
                else
                    return $this->checkLoginSession(); }
            else
                return $this->checkLoginSession(); }
        else
            return $this->checkLoginSession();
    }

    public function checkLoginSession() {
        if ( isset($_SESSION) && is_array($_SESSION) && (count($_SESSION)==0) ) {
            $res = array("status" => false); }
        else {
            session_start() ;
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
            if ($data->username==$_POST['username']) {
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

    public function getUsersData() {
        $myfile = fopen($this->getUserFileLocation(), "r") ;
        if (!$myfile) {
            echo json_encode(array(
                "status" => false,
                "id"=>"registration_error_msg",
                "msg" => "Unable to read users Datastore. Contact Administrator.")); }
        $oldData='';
        while(!feof($myfile))
            $oldData .= fgets($myfile);
        fclose($myfile);
        $oldData=json_decode($oldData);
        return $oldData;
    }

    public function getLoggedInUserData() {
        $users = $this->getUsersData() ;
        $retuser = false ;
        foreach ($users as $user) {
            if ($user->username == $_SESSION["username"]) {
                $retuser = $user ;
                break ; } }
        return $retuser ;
    }

    public function createNewUser($newUser) {

        $passEncrypted = $this->getSaltWord($newUser["password"]) ;
        $newUser["password"] = $passEncrypted ;

        if (!$this->userExist($newUser['email'])) {
            $oldData=$this->getUsersData();
            if ($myfile = fopen($this->getUserFileLocation(), "w")) { }
            else {
                echo json_encode(array("status" => false, "id"=>"registration_error_msg", "msg" => "Unable to write to users datastore. Contact Administrator.")); }
            if ($oldData==null) {
                //@todo change format of saved data.
                fwrite($myfile, json_encode(array($newUser))); }
            else {
                //@todo change the format of saved data.
                fwrite($myfile, json_encode(array_merge($oldData, array($newUser)))) ; }
            return true ; }
        else {
            return false ;
        }
    }

    public function updateUser($user) {
        $oldData = $this->getUsersData();
        if ($myfile = fopen($this->getUserFileLocation(), "w")) { }
        else {
            echo json_encode(array("status" => false,
                "id"=>"registration_error_msg",
                "msg" => "Unable to write to users datastore. Contact Administrator.")); }
        if ($oldData==null) {
            //@todo change format of saved data.
            fwrite($myfile, json_encode(array($user))); }
        else {
            $nray = array();
            foreach ($oldData as $one) {
                if ($user->username == $one->username) {
                    $two = new \stdClass();
                    $two->username = $one->username ;
                    $two->email = $one->email ;
                    if (isset($user->password)) {
                        $two->password = $this->getSaltWord($user->password) ; }
                    else {
                        $two->password = $one->password ; }
                    $two->role = $one->role ;
                    $two->status = $one->status ;
                    $nray[] = $two ; }
                else {
                    $nray[] = $one ; } }
            //@todo change the format of saved data.
            fwrite($myfile, json_encode($nray)); }
        return true ; // @todo this should be based on fwrite return value
    }

    public function deleteUser($username) {
        $oldData = $this->getUsersData();
        if ($myfile = fopen($this->getUserFileLocation(), "w")) { }
        else {
            echo json_encode(array("status" => false,
                "id"=>"registration_error_msg",
                "msg" => "Unable to write to users datastore. Contact Administrator.")); }
        $nray = array();
        foreach ($oldData as $one) {
            if ($username !== $one->username) {
                $nray[] = $one ; } }
        //@todo change the format of saved data.
        fwrite($myfile, json_encode($nray));
        return true ;
    }

    public function getSaltWord($word) {
        return md5($this->getSalt().$word) ;
    }

    public function userExist($email) {
        $users = $this->getUsersData();
        foreach ($users as $user) {
            if ($user->email== $email)
                return true; }
        return false;
    }

    public function getUserRole($email) {
        if ($this->userExist($email)) {
            $users = $this->getUsersData();
            foreach ($users as $user) {
                if ($user->email== $email)
                    return $user->role; } }
        return false;
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

    public function settingEnabled($setting) {
        $mod_config = \Model\AppConfig::getAppVariable("mod_config");

        $providers = array("github", "fb", "li", "google") ;

        foreach ($providers as $provider) {

            if ($mod_config["OAuth"]["{$provider}_enabled"]) {

            }

        }

        $github_client_id = "github_client_id";

        $is_enabled = (isset($mod_config["Signup"]["registration_enabled"]) &&
            $mod_config["Signup"]["registration_enabled"]==true ) ? true : false ;
        return $is_enabled ;
    }

}
