<?php

Namespace Model;

class UserSSHKeyDeleteKeyAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("DeleteKey") ;

    public function getData() {
        $ret["data"] = $this->deleteKey();
        return $ret ;
    }

    public function deleteKey() {

        $key = $this->keyExists() ;
        if ($key === false) {
            $return = array(
                "status" => false ,
                "message" => "You do not own a key with this hash, so cannot be deleted",
                "key_hash" => $this->params["key_hash"] );
            return $return ; }

        $deletedKey = $this->deleteTheKey() ;
        if ($deletedKey === false) {
            $return = array(
                "status" => false ,
                "message" => "Unable to delete this Key.",
                "key_hash" => $this->params["key_hash"] );
            return $return ; }

        $keyBase = new \Model\UserSSHKeyAnyOS($this->params) ;
        $all_keys = $keyBase->getAllKeyDetails() ;

        $return = array(
            "status" => true ,
            "message" => "Key Deleted",
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

    private function deleteTheKey() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $uname = $me->username;
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $parsed_filters = array( "key_hash" => $this->params["key_hash"] ) ;
//        $parsed_filters[] = array("where", "user_id", '=', $uname ) ;
        $res = $datastore->delete('user_ssh_keys', $parsed_filters) ;
        return $res ;
    }

}
