<?php

Namespace Model;

class ModuleManagerWebAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Web") ;

    public function getData() {
        $ret["installed_modules"] = $this->findAllModuleNames();
        $ret["compatible_modules"] = $this->findOnlyCompatibleModuleNames();
        $ret["incompatible_modules"] = $this->findOnlyIncompatibleModuleNames();
        $ret["available_modules"] = $this->getAvailableModules();
        $ret["disabled_modules"] = $this->getDisabledModules();
        return $ret ;
    }

    private function findAllModuleNames() {
        $allInfoObjects = \Core\AutoLoader::getInfoObjects() ;
        $moduleNames = array() ;
        foreach ($allInfoObjects as $infoObject) {
            $array_keys = array_keys($infoObject->routesAvailable()) ;
            $miniRay = array() ;
            $miniRay["command"] = $array_keys[0] ;
            $miniRay["name"] = $infoObject->name ;
            $miniRay["hidden"] = $infoObject->hidden ;
            $moduleNames[] = $miniRay ; }
        return $moduleNames;
    }

    private function findOnlyCompatibleModuleNames() {
        $allModules = $this->findAllModuleNames() ;
        $controllerBase = new \Controller\Base();
        $errors = $controllerBase->checkForRegisteredModels($this->params, $allModules) ;
        $compatibleModules = array();
        foreach($allModules as $oneModule) {
            if (!in_array($oneModule["command"], $errors)) {
                $compatibleModules[] = $oneModule ; } }
        return $compatibleModules;
    }

    private function findOnlyIncompatibleModuleNames() {
        $allModules = $this->findAllModuleNames() ;
        $cModules = $this->findOnlyCompatibleModuleNames() ;
        $incom = array_diff($allModules, $cModules);
        return $incom;
    }

    private function getAvailableModules() {

        $ray = array(
            "TestModuleOne" => array(
                "repo_url" => "http://www.github.com/PharaohModules/test-one.git",
                "description" => "This is the first test description",
                "name" => "Test Module One",
                "group" => "test_modules",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "TestModuleTwo" => array(
                "repo_url" => "http://www.github.com/PharaohModules/test-two.git",
                "description" => "This is the second test description",
                "name" => "Test Module Two",
                "group" => "test_modules",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "TestModuleThree" => array(
                "repo_url" => "http://www.github.com/PharaohModules/test-three.git",
                "description" => "This is the third test description",
                "name" => "Test Module Three",
                "group" => "test_modules",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "TestModuleFour" => array(
                "repo_url" => "http://www.github.com/PharaohModules/test-four.git",
                "description" => "This is the fourth test description",
                "name" => "Test Module Two",
                "group" => "test_modules",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "DummyLinuxModule" => array(
                "repo_url" => "http://www.github.com/PharaohModules/test-two.git",
                "description" => "This is the dummy linux module test description",
                "name" => "Dummy Linux Module",
                "group" => "dummy_modules",
                "dependencies" => array("Logging", "SendEmail"),
            ),
        );
        return $ray ;
    }

    protected function getDisabledModules() {
        $appConfig = new \Model\AppConfig() ;
        $disabled_modules = $appConfig->getAppVariable("disabled_modules") ;
        return $disabled_modules;
    }

}