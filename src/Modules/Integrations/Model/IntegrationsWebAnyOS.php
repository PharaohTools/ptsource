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
        $ret["installed_integrations"] = $this->getEnabledIntegrations();
        $ret["available_integrations"] = $this->findAllIntegrationNames();
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

    private function getEnabledIntegrations() {

        $ray = array(
            "PharaohBuild" => array(
                "repo_url" => "http://www.github.com/PharaohTools/build.git",
                "description" =>
                    "This is the Pharaoh Build integration. This will allow you to integrate your repositories " .
                    "with your build processes and results published by one or more Pharaoh Build Servers. " ,
                "name" => "Pharaoh Build",
                "image" => "/Assets/Modules/DefaultSkin/image/build-logo.png",
                "manage_link" => "/index.php?control=ApplicationConfigure&action=show",
                "group" => "pharaoh_tools",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "PharaohTrack" => array(
                "repo_url" => "http://www.github.com/PharaohTools/track.git",
                "description" =>
                    "This is the Pharaoh Track integration. This will allow you to integrate your repositories " .
                    "with your issues, jobs, milestones and more that are published by one or more Pharaoh Track Servers. " ,
                "name" => "Pharaoh Track",
                "image" => "/Assets/Modules/DefaultSkin/image/track-logo.png",
                "manage_link" => "Pharaoh Track",
                "group" => "pharaoh_tools",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "PharaohManage" => array(
                "repo_url" => "http://www.github.com/PharaohTools/manage.git",
                "description" =>
                    "This is the Pharaoh Build integration. This will allow you to integrate your repositories " .
                    "with your build processes and results published by one or more Pharaoh Build Servers. " ,
                "name" => "Pharaoh Manage",
                "image" => "/Assets/Modules/DefaultSkin/image/manage-logo.png",
                "manage_link" => "/index.php?control=ApplicationConfigure&action=show#gitserver",
                "group" => "pharaoh_tools",
                "dependencies" => array("Logging", "SendEmail"),
            ),
//            "TestIntegrationFour" => array(
//                "repo_url" => "http://www.github.com/PharaohIntegrations/test-four.git",
//                "description" => "This is the fourth test description",
//                "name" => "Test Integration Two",
//                "group" => "test_integrations",
//                "dependencies" => array("Logging", "SendEmail"),
//            ),
//            "DummyLinuxIntegration" => array(
//                "repo_url" => "http://www.github.com/PharaohIntegrations/test-two.git",
//                "description" => "This is the dummy linux integration test description",
//                "name" => "Dummy Linux Integration",
//                "group" => "dummy_integrations",
//                "dependencies" => array("Logging", "SendEmail"),
//            ),
        );
        return $ray ;
    }

}