<?php

Namespace Model;

class UserAccountAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

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
        $res = $this->checkLoginInfo($user, $pass);
        return $res ;
    }

    public function checkLoginInfo($usr, $pass, $start_session=true) {
        $verified = false;
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "username", '=', $usr ) ;
        $parsed_filters[] = array("where", "password", '=', $this->getSaltWord($pass) ) ;
        $parsed_filters[] = array("where", "status", '=', 1 ) ;
        $retuser = $datastore->findOne('user_accounts', $parsed_filters) ;
        if (is_array($retuser) && count($retuser) > 0) {
            $verified = true;
        }
        if (($verified == true) && ($start_session == false)) {
            return array("status" => true) ;
        }
        if ($verified === true) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION["login-status"]=true;
            $_SESSION["username"] = $usr;
            return array("status" => true); }
        else {
            return array("status" => false, "msg" => "Sorry!! Wrong User name Or Password"); }
    }

    //check login status
    public function checkLoginStatus() {
        $url = $_POST['url'];
        return $this->checkLoginStatusInfo($url);
    }

    public function checkLoginStatusInfo($url) {
        // login status check
        $url_split = explode("?", $url);
        if(isset($url_split[1])){
            $url_spl = explode("&", $url_split[1]);
            if(isset($url_spl[0])){
                $url_sp = explode("=", $url_spl[0]);
                if(isset($url_sp[1]) && $url_sp[1] =="UserAccount"){
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

    public function allLoginInfoDestroy() {
        session_destroy();
        header("Location: /index.php?control=UserAccount&action=login");
    }

    public function getUsersData() {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $parsed_filters = array() ;
//        $parsed_filters[] = array("where", "user_id", '=', $uname ) ;
        if ($datastore->collectionExists('user_accounts')==false){
            $this->ensureDataCollection();
        }
        $accounts = $datastore->findAll('user_accounts', $parsed_filters) ;
        return $accounts ;
    }

    protected function ensureDataCollection() {

        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;

        $loggingFactory = new \Model\Logging() ;
        $logging = $loggingFactory->getModel($this->params) ;

        $column_defines = array(
            'user_id' => 'INTEGER PRIMARY KEY ASC',
            'username' => 'string',
            'email' => 'string',
            'password' => 'string',
            'role' => 'string',
            'status' => 'string',
            'created_on' => 'string',
            'user_bio' => 'string',
            'location' => 'string',
            'website' => 'string',
            'full_name' => 'string',
            'avatar' => 'string',
            'show_email' => 'string',
            'show_website' => 'string',
            'show_location' => 'string',
        );
        $logging->log("Creating User Accounts Collection in Datastore", $this->getModuleName()) ;
        $datastore->createCollection('user_accounts', $column_defines) ;
    }

    public function getLoggedInUserData() {
        $retuser = false ;
//        var_dump($_SESSION) ;
//        die() ;
        if (isset($_SESSION["username"])) {
            $datastoreFactory = new \Model\Datastore() ;
            $datastore = $datastoreFactory->getModel($this->params) ;
            $parsed_filters = array() ;
            $parsed_filters[] = array("where", "username", '=', $_SESSION["username"] ) ;
            $retuser = $datastore->findOne('user_accounts', $parsed_filters) ; }
        return $retuser ;
    }

    public function getUserData($email) {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "email", '=', $email ) ;
        $retuser = $datastore->findOne('user_accounts', $parsed_filters) ;
        return $retuser ;
    }

    public function getUserDataByUsername($username) {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "username", '=', $username ) ;
        $retuser = $datastore->findOne('user_accounts', $parsed_filters) ;
        return $retuser ;
    }

    public function createNewUser($newUser) {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        if ($datastore->collectionExists('user_accounts')==false){
            $this->ensureDataCollection(); }
        $passEncrypted = $this->getSaltWord($newUser["password"]) ;
        $newUser["password"] = $passEncrypted ;
        $newUser["created_on"] = time() ;
        if (!$this->userExist($newUser['email'])) {
            $datastoreFactory = new \Model\Datastore() ;
            $datastore = $datastoreFactory->getModel($this->params) ;
            $retuser = $datastore->insert('user_accounts', $newUser) ;
            if ($retuser === false) {
                return false ; }
            return true ; }
        else {
            return false ;
        }
    }

    public function updateUser($user) {

        $one = $this->getUserData($user['email']) ;

        $two = array();
        $two['username'] = $one['username'] ;

        if (isset($user['email'])) {
            $two['email'] = $user['email'] ; }
        else {
            $two['email'] = $one['email'] ; }

        if (isset($user['password'])) {
            $two['password'] = $this->getSaltWord($user['password']) ; }
        else {
            $two['password'] = $one['password'] ; }

        // role and status cant be updated here
        $two['role'] = $one['role'] ;
        $two['status'] = $one['status'] ;

        if (!isset($one['created_on'])) {
            $two['created_on'] = time() ; }
        else {
            $two['created_on'] = $one['created_on'] ; }

        if (isset($user['user_bio']) ) {
            $two['user_bio'] = $user['user_bio']; }
        else if (isset($one['user_bio']) ) {
            $two['user_bio'] = $one['user_bio']; }
        else {
            $two['user_bio'] = '' ; }

        if (isset($user['location']) ) {
            $two['location'] = $user['location']; }
        else if (isset($one['location']) ) {
            $two['location'] = $one['location']; }
        else {
            $two['location'] ='' ; }

        if (isset($user['website']) ) {
            $two['website'] = $user['website']; }
        else if (isset($one['website']) ) {
            $two['website'] = $one['website']; }
        else {
            $two['website'] = '' ; }

        if (isset($user['full_name']) ) {
            $two['full_name'] = $user['full_name']; }
        else if (isset($one['full_name']) ) {
            $two['full_name'] = $one['full_name']; }
        else {
            $two['full_name'] = '' ; }

        if (isset($user['avatar']) ) {
            $two['avatar'] = $user['avatar']; }
        else if (isset($one['avatar']) ) {
            $two['avatar'] = $one['avatar']; }
        else {
            $two['avatar'] = '' ; }

        if (isset($user['show_email']) ) {
            $two['show_email'] = $user['show_email']; }
        else if (isset($one['show_email']) ) {
            $two['show_email'] = $one['show_email']; }
        else {
            $two['show_email'] = '' ; }

        if (isset($user['show_website']) ) {
            $two['show_website'] = $user['show_website']; }
        else if (isset($one['show_website']) ) {
            $two['show_website'] = $one['show_website']; }
        else {
            $two['show_website'] = '' ; }

        if (isset($user['show_location']) ) {
            $two['show_location'] = $user['show_location']; }
        else if (isset($one['show_location']) ) {
            $two['show_location'] = $one['show_location']; }
        else {
            $two['show_location'] = '' ;
        }

        $clause = array(
            'email' => $user['email'],
        ) ;
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $res = $datastore->update('user_accounts', $clause, $two) ;
        return $res ;

    }

    public function deleteUser($username) {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "user_id", '=', $username ) ;
        $retuser = $datastore->delete('user_accounts', $parsed_filters) ;
        return $retuser ;
    }

    public function getSaltWord($word) {
        return md5($this->getSalt().$word) ;
    }

    public function userExist($email) {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "email", '=', $email ) ;
        $user_found = $datastore->findOne('user_accounts', $parsed_filters) ;
        return ($user_found === false) ? false : true ;
    }

    public function userNameExist($name) {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "username", '=', $name ) ;
        $user_found = $datastore->findOne('user_accounts', $parsed_filters) ;
        return ($user_found === false) ? false : true ;
    }

    public function getUserRole($email) {
        if ($this->userExist($email)) {
            $user = $this->getUserData($email) ;
            return $user['role'];
        }
        return false;
    }

    public function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }

}
