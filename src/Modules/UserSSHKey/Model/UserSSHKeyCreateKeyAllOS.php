<?php

Namespace Model;

class UserSSHKeyCreateKeyAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("CreateKey") ;

    public function getData() {
        $ret["data"] = $this->createKey();
        return $ret ;
    }

    public function createKey() {
        $valid = $this->validateKeyDetails() ;
        if ($valid !== true) {
            return $valid ; }
        $createdKey = $this->addTheKey() ;
        if ($createdKey !== true) {
            return $createdKey ; }
        $finger = $this->getFingerprint() ;

        $keyBase = new \Model\UserSSHKeyAnyOS($this->params) ;
        $all_keys = $keyBase->getAllKeyDetails() ;

        $return = array(
            "status" => true ,
            "message" => "Key Created",
            "public_ssh_keys" => $all_keys,
            "fingerprint" => $finger );
        return $return ;

    }

    public function validateKeyDetails() {
        $keyBase = new \Model\UserSSHKeyAnyOS($this->params) ;
        if ($keyBase->keyAlreadyExists($this->params["new_ssh_key_title"]) === true) {
            $return = array(
                "status" => false ,
                "message" => "This Key Name already exists" );
            return $return ; }
        $presult = $this->keyInvalid() ;
        if ($presult !== true) {
            $return = array(
                "status" => false ,
                "message" => $presult );
            return $return ; }
        return true ;
    }

    private function keyInvalid() {

        if (strlen($this->params["new_ssh_key"]) <7 ) {
            $return = "This does not appear to be an SSH Key. It's not long enough" ;
            return $return ; }

        $crypt_loc = dirname(__DIR__).DS.'Libraries'.DS.'phpseclib'.DS.'Crypt'.DS ;
        $crypt_files = scandir($crypt_loc) ;
        foreach ($crypt_files as $crypt_file) {
            if (!in_array($crypt_file, array('.', '..'))) {
                require_once $crypt_loc.$crypt_file ; } }

        $math_loc = dirname(__DIR__).DS.'Libraries'.DS.'phpseclib'.DS.'Math'.DS ;
        $math_files = scandir($math_loc) ;
        foreach ($math_files as $math_file) {
            if (!in_array($math_file, array('.', '..'))) {
                require_once $math_loc.$math_file ; } }

        $finger = $this->getFingerprint() ;
        if ($finger === false) {
            $msg = 'Unable to generate fingerprint. This key is invalid.' ;
            return $msg ; }

        return true ;
    }

    private function getFingerprint() {
        $rsa = new \Crypt_RSA() ;
        $rsa->setPublicKey($this->params["new_ssh_key"]) ;
        $finger = $rsa->getPublicKeyFingerprint() ;
        return $finger ;
    }

    private function addTheKey() {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;

        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $au =$signup->getLoggedInUserData();

        $rsa = new \Crypt_RSA() ;
        $rsa->setPublicKey($this->params["new_ssh_key"]) ;
        $finger = $rsa->getPublicKeyFingerprint() ;
        
        $res = $datastore->insert('user_ssh_keys', array(
            "user_id" => $au->username,
            "key_data" => $this->params["new_ssh_key"],
            "key_hash" => uniqid(),
            "title" => $this->params["new_ssh_key_title"],
            "fingerprint" => $finger
        )) ;

        if ($res == false) {
            $return = array(
                "status" => false ,
                "message" => "Unable to add this SSH Key to your account" );
            return $return ; }

        return true ;
    }

}
