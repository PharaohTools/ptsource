<?php

Namespace Model;

class LDAPLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function ldapSubmit(){
		$ldaphost = $_POST['servername'];
		$ldapUsername  = $_POST['username'];
		$ldapPassword = $_POST['password'];
		//echo json_encode(array('status'=>false, 'msg' => 'cannot c'.$ldaphost.$ldapUsername.$ldapPassword));
		$ds = ldap_connect($ldaphost);
		if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)){
		     echo json_encode(array('status'=>false, 'msg' => 'Could not set LDAPv3'));	 }
		else {
		    $bth = ldap_bind($ds, $ldapUsername, $ldapPassword) or
                die(json_encode(array("status" => FALSE, "msg" => "Sorry!! Invalid Credential")));
                // @todo don't die
            echo json_encode(array('status'=>true));
            $signupFactory = new \Model\Signup() ;
            $signup = $signupFactory->getModel($this->params);
            $signup->loginByLDAP('',$ldapUsername,''); }
    }

 }
