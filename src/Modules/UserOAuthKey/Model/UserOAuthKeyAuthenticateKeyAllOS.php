<?php

Namespace Model;

class UserOAuthKeyAuthenticateKeyAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("AuthenticateKey") ;

    public function getData() {
        $ret["data"] = $this->authenticateKey();
        return $ret ;
    }

    public function authenticateKey() {
        $valid = $this->validateKeyDetails() ;
        if ($valid !== true) {
            return $valid ; }
        $authenticatedKey = $this->addTheKey() ;
        if ($authenticatedKey !== true) {
            return $authenticatedKey ; }

        $keyBase = new \Model\UserOAuthKeyAnyOS($this->params) ;
        $all_keys = $keyBase->getAllKeyDetails() ;

        $return = array(
            "status" => true ,
            "message" => "Key Authenticated",
            "public_oauth_keys" => $all_keys );
        return $return ;

    }


    private function authenticateOauth() {


    }

    public function checkLoginInfo($usr, $pass, $start_session=true) {
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
        if (($verified== true) && ($start_session == false)) {
            return array("status" => true) ;
        }
        if ($verified === true) {
            session_start() ;
            $_SESSION["login-status"]=true;
            $_SESSION["username"] = $usr;
            return array("status" => true); }
        else {
            return array("status" => false, "msg" => "Sorry!! Wrong User name Or Password"); }
    }

}
