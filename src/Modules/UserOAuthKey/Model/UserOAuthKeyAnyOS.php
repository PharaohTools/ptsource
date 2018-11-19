<?php

Namespace Model;

class UserOAuthKeyAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params);
	}

    public function getData() {
        $ret['user'] = $this->getUserDetails();
        $ret['public_oauth_keys'] = $this->getAllKeyDetails();
        return $ret ;
    }

    public function getAllKeyDetails() {

        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $uname = $me['username'];

        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;

        $loggingFactory = new \Model\Logging() ;
        $logging = $loggingFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "user_id", '=', $uname ) ;

        if ($datastore->collectionExists('user_oauth_keys')==false){
            $column_defines = array(
                'key_id' => 'INTEGER PRIMARY KEY ASC',
                'key_hash' => 'string',
                'user_id' => 'string',
                'created_on' => 'string',
                'enabled' => 'string',
                'last_used' => 'string',
                'title' => 'string',
                'oauth_user' => 'string',
                'oauth_key' => 'string',
                'fingerprint' => 'string'
            );
            $logging->log("Creating User OAuth Keys Collection in Datastore", $this->getModuleName()) ;
            $datastore->createCollection('user_oauth_keys', $column_defines) ; }

        $keys = $datastore->findAll('user_oauth_keys', $parsed_filters) ;
        $keys = $this->keyDecorator($keys) ;
        return $keys ;
    }

    public function keyDecorator($keys) {
        foreach ($keys as &$onekey) {
            $onekey['created_on_format'] = date('H:i d/m/Y', $onekey['created_on']);
            $onekey['last_used_format'] = date('H:i d/m/Y', $onekey['last_used']);
        }
        return $keys ;
    }

    public function keyAlreadyExists($title) {
        $allkeys = $this->getAllKeyDetails() ;
        foreach ($allkeys as $onekey) {
            if ($onekey->keyname == $title) {
                return true ; } }
        return false ;
    }

    public function getUserDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $oldData=$signup->getLoggedInUserData();
        return $oldData;
    }

    public function checkLoginSession() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        return $signup->checkLoginSession();
    }

    public function findUsernameFromKey($oauth_user) {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;

        $loggingFactory = new \Model\Logging() ;
        $logging = $loggingFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "oauth_user", '=', $oauth_user ) ;

        $user = $datastore->findOne('user_oauth_keys', $parsed_filters) ;
        if ($user === false) {
            return false ;
        }
        $username = $user['user_id'] ;
        return $username ;
    }

}
