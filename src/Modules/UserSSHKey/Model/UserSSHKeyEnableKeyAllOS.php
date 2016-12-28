<?php

Namespace Model;

class UserSSHKeyEnableKeyAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("EnableKey") ;

    public function getDataFromEnable() {
        $ret["data"] = $this->disableKey();
        return $ret ;
    }

    public function disableKey() {

        $key = $this->keyExists() ;
        if ($key === false) {
            $return = array(
                "status" => false ,
                "message" => "You do not own a key with this hash, so cannot be disabled",
                "key_hash" => $this->params["key_hash"] );
            return $return ; }

        $disabledKey = $this->disableTheKey() ;
        if ($disabledKey === false) {
            $return = array(
                "status" => false ,
                "message" => "Unable to disable this Key.",
                "key_hash" => $this->params["key_hash"] );
            return $return ; }



        $keyBase = new \Model\UserSSHKeyAnyOS($this->params) ;
        $all_keys = $keyBase->getAllKeyDetails() ;

        $return = array(
            "status" => true ,
            "message" => "Key Enabled",
            "public_ssh_keys" => $all_keys,
            "key_hash" => $this->params["key_hash"]  );

        return $return ;

    }

    private function keyExists() {

        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $uname = $me->username;

        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;

        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "key_hash", '=', $this->params["key_hash"] ) ;
        $parsed_filters[] = array("where", "user_id", '=', $uname ) ;
        $keys = $datastore->findAll('user_ssh_keys', $parsed_filters) ;
        if (count($keys)>0) {
            return $keys ;
        }
        return false ;
    }

    private function disableTheKey() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $uname = $me->username;

        $key = $this->keyExists() ;
        $new_key = $key[0] ;
        $new_key["enabled"] = 'off' ;

        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $clause = array("where", "key_hash", '=', $this->params["key_hash"] ) ;
        $parsed_filters[] = array("where", "user_id", '=', $uname ) ;
        $res = $datastore->update('user_ssh_keys', $clause, $new_key) ;
//        $table, $clause, $rowData
        return $res ;
    }

    private function enableTheKey() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $uname = $me->username;

        $key = $this->keyExists() ;
        $new_key = $key[0] ;
        $new_key["enabled"] = 'off' ;

        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $clause = array("where", "key_hash", '=', $this->params["key_hash"] ) ;
        $parsed_filters[] = array("where", "user_id", '=', $uname ) ;
        $res = $datastore->update('user_ssh_keys', $clause, $new_key) ;
//        $table, $clause, $rowData
        return $res ;
    }

}
