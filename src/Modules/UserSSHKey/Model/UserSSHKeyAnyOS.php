<?php

Namespace Model;

class UserSSHKeyAnyOS extends BasePHPApp {

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
        $ret['allusers'] = $this->getAllUserDetails();
        $ret['public_ssh_keys'] = $this->getAllKeyDetails();
        return $ret ;
    }

    public function getAllUserDetails() {
        $userAccountFactory = new \Model\UserAccount();
        $userAccount = $userAccountFactory->getModel($this->params);
        $me = $userAccount->getLoggedInUserData() ;
        $rid = $userAccount->getUserRole($me['email']);
        if ($rid == 1) {
            $au = $userAccount->getUsersData();
            return $au;  }
        return false ;
    }


    public function getAllKeyDetails($uname = null) {

        if ($uname === null) {
            $userAccountFactory = new \Model\UserAccount();
            $userAccount = $userAccountFactory->getModel($this->params);
            $me = $userAccount->getLoggedInUserData() ;
            $uname = $me['username'];
        }

        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;

        $loggingFactory = new \Model\Logging() ;
        $logging = $loggingFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "user_id", '=', $uname ) ;

        if ($datastore->collectionExists('user_ssh_keys')==false){
            $column_defines = array(
                'key_id' => 'INTEGER PRIMARY KEY ASC',
                'key_hash' => 'string',
                'user_id' => 'string',
                'created_on' => 'string',
                'enabled' => 'string',
                'last_used' => 'string',
                'title' => 'string',
                'key_data' => 'string',
                'fingerprint' => 'string'
            );
            $logging->log("Creating User SSH Keys Collection in Datastore", $this->getModuleName()) ;
            $datastore->createCollection('user_ssh_keys', $column_defines) ; }

        $data = $datastore->findAll('user_ssh_keys', $parsed_filters) ;
        $data = $this->dataDecorator($data) ;
        return $data ;
    }

    public function dataDecorator($data) {
        foreach ($data as &$onerow) {
            $onerow['created_on_format'] = date('H:i d/m/Y', $onerow['created_on']);
            $onerow['last_used_format'] = date('H:i d/m/Y', $onerow['last_used']);
        }
        return $data ;
    }

    public function keyAlreadyExists($title) {
        $allkeys = $this->getAllKeyDetails() ;
        foreach ($allkeys as $onekey) {
            if ($onekey->keyname == $title) {
                return true ; } }
        return false ;
    }

    public function getUserDetails() {
        $userAccountFactory = new \Model\UserAccount();
        $userAccount = $userAccountFactory->getModel($this->params);
        $retuser = $userAccount->getLoggedInUserData();
        return $retuser;
    }

    public function checkLoginSession() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        return $signup->checkLoginSession();
    }

}
