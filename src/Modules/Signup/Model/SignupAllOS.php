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
    public function allLogininfodestroy() {
        $ret="get Logout";
        return $ret ;
    }

}
