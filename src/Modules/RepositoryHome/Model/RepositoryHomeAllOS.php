<?php

Namespace Model;

class RepositoryHomeAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret["repository"] = $this->getRepository();
        $ret["features"] = $this->getRepositoryFeatures();
        $ret["history"] = $this->getCommitHistory();
        $ret["is_https"] = $this->isSecure();
        $ret["user"] = $this->getLoggedInUser();
        $ret = array_merge($ret, $this->getIdentifier()) ;
        return $ret ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }

    public function deleteData() {
        $ret["repository"] = $this->deleteRepository();
        return $ret ;
    }

    protected function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepository($this->params["item"]);
        return $r ;
    }

    public function getIdentifier() {
        // @todo get default branch if there is one
        if (!isset($this->params["identifier"])) { $this->params["identifier"] = "master" ; }
        $identifier = array("identifier" => $this->params["identifier"]);
        return $identifier ;
    }

    protected function getRepositoryFeatures() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepositoryFeatures($this->params["item"]);
        return $r ;
    }

    protected function getCommitHistory() {
        $repositoryFactory = new \Model\Repository() ;
        $commitParams = $this->params ;
        $commitParams["amount"] = 10 ;
        $repository = $repositoryFactory->getModel($commitParams, "RepositoryCommits");
        return $repository->getCommits();
    }

    protected function isSecure() {
        return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
    }

    public function deleteRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        return $repository->deleteRepository($this->params["item"]);
    }

    public function userIsAllowedAccess() {
        $repository = $this->getRepository();
        $user = $this->getLoggedInUser() ;

        $settings = $this->getSettings() ;
        if (!isset($settings["RepositoryScope"]["enable_public"]) ||
            ( isset($settings["RepositoryScope"]["enable_public"]) && $settings["RepositoryScope"]["enable_public"]=="off" )) {
            // if enable public is set to off
            if ($user == false) {
                // and the user is not logged in
                return false ; }
            // if they are logged in continue on
        }
        else {
            // if enable public is set to on
            if ($user == false) {
                // and the user is not logged in
                if ($repository["repository_public_scope_enabled"] == "on" && $repository["repository_public_home_enabled"] == "on") {
                    return true ; }
                else {
                    // and the user is not logged in
                    return false ; } } }
        if (isset($settings["Signup"]["signup_enabled"]) && $settings["Signup"]["signup_enabled"]=="on") {
            if ($user==false) { return false; }
            if ($user->role == 1) { return true ; }

            // @todo anyone logged in can read or write currently, update this when adding repo based perms
            return true ;
//            if ($repository["repository_creator"] == $user->username) { return true ; }
//            if (strpos($repository["repository_members"], $user->username.',') !== false) { return true ; }
//            if (strpos($repository["repository_members"], ','.$user->username) !== false) { return true ; }
//            return false ;
        }
        // should never get here i think but be safe
        return false ;
    }

    protected function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }

}