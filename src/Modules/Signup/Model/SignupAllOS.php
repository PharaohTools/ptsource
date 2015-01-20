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
        $ret="get Login";
        return $ret ;
    }
    // @todo need to check login credential from datastore or PAM/LDAP
    public function Checklogin($username, $password) {
        return "aasd" ;
    }
    // @todo need to destroy all login credential or anything related to login
    public function allLogininfodestroy() {
        session_destroy();
        return;
    }

}
