<?php

Namespace Model;

class UserManagerWebAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Web") ;

    public function getData() {
        $ret["installed_users"] = $this->findAllUserNames();
        $ret["compatible_users"] = $this->findOnlyCompatibleUserNames();
        $ret["incompatible_users"] = $this->findOnlyIncompatibleUserNames();
        $ret["available_users"] = $this->getAvailableUsers();
        return $ret ;
    }

    private function findAllUserNames() {
        $allInfoObjects = \Core\AutoLoader::getInfoObjects() ;
        $userNames = array() ;
        foreach ($allInfoObjects as $infoObject) {
            $array_keys = array_keys($infoObject->routesAvailable()) ;
            $miniRay = array() ;
            $miniRay["command"] = $array_keys[0] ;
            $miniRay["name"] = $infoObject->name ;
            $miniRay["hidden"] = $infoObject->hidden ;
            $userNames[] = $miniRay ; }
        return $userNames;
    }

    private function findOnlyCompatibleUserNames() {
        $allUsers = $this->findAllUserNames() ;
        $controllerBase = new \Controller\Base();
        $errors = $controllerBase->checkForRegisteredModels($this->params, $allUsers) ;
        $compatibleUsers = array();
        foreach($allUsers as $oneUser) {
            if (!in_array($oneUser["command"], $errors)) {
                $compatibleUsers[] = $oneUser ; } }
        return $compatibleUsers;
    }

    private function findOnlyIncompatibleUserNames() {
        $allUsers = $this->findAllUserNames() ;
        $cUsers = $this->findOnlyCompatibleUserNames() ;
        $incom = array_diff($allUsers, $cUsers);
        return $incom;
    }

    private function getAvailableUsers() {

        $ray = array(
            "TestUserOne" => array(
                "repo_url" => "http://www.github.com/PharaohUsers/test-one.git",
                "description" => "This is the first test description",
                "name" => "Test User One",
                "group" => "test_users",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "TestUserTwo" => array(
                "repo_url" => "http://www.github.com/PharaohUsers/test-two.git",
                "description" => "This is the second test description",
                "name" => "Test User Two",
                "group" => "test_users",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "TestUserThree" => array(
                "repo_url" => "http://www.github.com/PharaohUsers/test-three.git",
                "description" => "This is the third test description",
                "name" => "Test User Three",
                "group" => "test_users",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "TestUserFour" => array(
                "repo_url" => "http://www.github.com/PharaohUsers/test-four.git",
                "description" => "This is the fourth test description",
                "name" => "Test User Two",
                "group" => "test_users",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "DummyLinuxUser" => array(
                "repo_url" => "http://www.github.com/PharaohUsers/test-two.git",
                "description" => "This is the dummy linux user test description",
                "name" => "Dummy Linux User",
                "group" => "dummy_users",
                "dependencies" => array("Logging", "SendEmail"),
            ),
        );
        return $ray ;
    }

}
