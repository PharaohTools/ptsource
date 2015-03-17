<?php

Namespace Model;

class UserManagerWebActionAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("WebAction") ;

    public function getData() {
        $ret["mod_install"] = $this->installUsers();
        return $ret ;
    }

    private function installUsers() {
        var_dump($_REQUEST["user-source"]);
        if (isset($_REQUEST["user-source"]) && strlen($_REQUEST["user-source"]) > 0) {
            $modFactory = new \Model\UserManager() ;
            $mmpr = $this->params ;
            $mmpr["user-source"] = $_REQUEST["user-source"] ;
            $mm = $modFactory->getModel($mmpr);
            $mm->install(); }
        return true ;
    }

}
