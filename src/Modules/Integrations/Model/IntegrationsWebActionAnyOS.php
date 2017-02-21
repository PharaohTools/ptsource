<?php

Namespace Model;

class IntegrationsWebActionAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("WebAction") ;

    public function getData() {
        $ret["mod_installed"] = $this->installModules();
        $ret["mod_enabled"] = $this->enableModule();
        $ret["mod_disabled"] = $this->disableModule();
        return $ret ;
    }

    public function installModules() {
        //var_dump($_REQUEST["module-source"]);
        if (isset($_REQUEST["module-source"]) && strlen($_REQUEST["module-source"]) > 0) {
            $modFactory = new \Model\Integrations() ;
            $mmpr = $this->params ;
            $mmpr["module-source"] = $_REQUEST["module-source"] ;
            $mm = $modFactory->getModel($mmpr);
            $mm->install();
            return array("installed-status" => true, "module-install" => $this->params["module-install"]) ; }
        return array() ;
    }

    public function enableModule() {
        if (isset($_REQUEST["module-enable"]) && strlen($_REQUEST["module-enable"]) > 0) {
            $modFactory = new \Model\Integrations() ;
            $mmpr = $this->params ;
            $mmpr["module-enable"] = $_REQUEST["module-enable"] ;
            $mm = $modFactory->getModel($mmpr);
            $mm->enableModule();
            return array("enabled-status" => true, "module-enable" => $this->params["module-enable"]) ; }
        return array() ;
    }

    public function disableModule() {
        if (isset($_REQUEST["module-disable"]) && strlen($_REQUEST["module-disable"]) > 0) {
            $modFactory = new \Model\Integrations() ;
            $mmpr = $this->params ;
            $mmpr["module-disable"] = $_REQUEST["module-disable"] ;
            $mm = $modFactory->getModel($mmpr);
            $mm->disableModule();
            return array("disabled-status" => true, "module-disable" => $this->params["module-disable"]) ; }
        return array() ;
    }

}