<?php

Namespace Model;

class IntegrationsWebAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Web") ;

    public function getData() {
        $ret["installed_integrations"] = $this->findAllIntegrationNames();
        $ret["available_integrations"] = $this->getAvailableIntegrations();
        return $ret ;
    }

    private function findAllIntegrationNames() {
        $allInfoObjects = \Core\AutoLoader::getInfoObjects() ;
        $integrationNames = array() ;
        foreach ($allInfoObjects as $infoObject) {
            $array_keys = array_keys($infoObject->routesAvailable()) ;
            $miniRay = array() ;
            $miniRay["command"] = $array_keys[0] ;
            $miniRay["name"] = $infoObject->name ;
            $miniRay["hidden"] = $infoObject->hidden ;
            $integrationNames[] = $miniRay ; }
        return $integrationNames;
    }

    private function getAvailableIntegrations() {

        $ray = array(
            "TestIntegrationOne" => array(
                "repo_url" => "http://www.github.com/PharaohIntegrations/test-one.git",
                "description" => "This is the first test description",
                "name" => "Test Integration One",
                "group" => "test_integrations",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "TestIntegrationTwo" => array(
                "repo_url" => "http://www.github.com/PharaohIntegrations/test-two.git",
                "description" => "This is the second test description",
                "name" => "Test Integration Two",
                "group" => "test_integrations",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "TestIntegrationThree" => array(
                "repo_url" => "http://www.github.com/PharaohIntegrations/test-three.git",
                "description" => "This is the third test description",
                "name" => "Test Integration Three",
                "group" => "test_integrations",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "TestIntegrationFour" => array(
                "repo_url" => "http://www.github.com/PharaohIntegrations/test-four.git",
                "description" => "This is the fourth test description",
                "name" => "Test Integration Two",
                "group" => "test_integrations",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "DummyLinuxIntegration" => array(
                "repo_url" => "http://www.github.com/PharaohIntegrations/test-two.git",
                "description" => "This is the dummy linux integration test description",
                "name" => "Dummy Linux Integration",
                "group" => "dummy_integrations",
                "dependencies" => array("Logging", "SendEmail"),
            ),
        );
        return $ray ;
    }

}