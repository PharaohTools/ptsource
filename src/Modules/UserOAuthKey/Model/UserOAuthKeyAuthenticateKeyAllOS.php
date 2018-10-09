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


    public function authenticateOauth($username, $key) {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
//        $loggingFactory = new \Model\Logging() ;
//        $logging = $loggingFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "oauth_user", '=', $username ) ;
        $parsed_filters[] = array("where", "oauth_key", '=', $key ) ;
        $keys = $datastore->findAll('user_oauth_keys', $parsed_filters) ;

//        file_put_contents('/tmp/pharaoh.log', "keys:\n", FILE_APPEND) ;
//        file_put_contents('/tmp/pharaoh.log', var_export($keys, true), FILE_APPEND) ;

        $key_exists = array() ;
        if (count($keys) === 1) {
            $key_exists['status'] = true ;
            $key_exists['user'] = $keys[0]['user_id'] ;
        }
        else {
            $key_exists['status'] = false ;
            $key_exists['msg'] = "Sorry!! Wrong User name Or Password" ;
        }
        return $key_exists ;
    }

}
