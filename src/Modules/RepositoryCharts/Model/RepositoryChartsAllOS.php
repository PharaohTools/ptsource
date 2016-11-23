<?php

Namespace Model;

class RepositoryChartsAllOS extends Base {

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
        $ret["current_user_role"] = $this->getCurrentUserRole($ret["user"]);
        $ret["readme"] = $this->getReadmeData($ret["repository"]) ;
        $ret = array_merge($ret, $this->getIdentifier()) ;
        return $ret ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }


    public function getCurrentUserRole($user = null) {
        if ($user == null) { $user = $this->getLoggedInUser(); }
        if ($user == false) { return false ; }
        return $user->role ;
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

    protected function getReadmeData($repository) {
        $identifier = 'HEAD' ;
        $cur_dir = getcwd() ;
        chdir(REPODIR.DS.$repository["project-slug"]) ;
        $command = 'git ls-tree --full-tree '.$identifier ;
        exec($command, $output) ;
        $files = $this->parseLSTree($output) ;
        if (in_array("README.md", $files)) { $load_readme_res = true ; }
        else { $load_readme_res = false ; }
        if ($load_readme_res == false) {
            $rd_res["exists"] = false ; }
        else {
            $rd_res["exists"] = true ;
            $command = 'git show '.$identifier.':README.md ' ;
            $rd_res["raw"] = shell_exec($command) ;
            require_once(dirname(__DIR__).DS."Libraries".DS."parsedown".DS."Parsedown.php") ;
            $Parsedown = new \Parsedown();
            $rd_res["md"] = $Parsedown->text($rd_res["raw"]); }
        chdir($cur_dir);
        return $rd_res ;
    }

    protected function parseLSTree($output) {
        $files = array() ;
        foreach ($output as $line) {
            $parts = explode(' ', $line) ;
            $further_parts = explode("\t", $parts[2]) ;
            $files[] = $further_parts[1] ; }
        return $files ;
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
        $user = $this->getLoggedInUser() ;
        $repository = $this->getRepository() ;
        $settings = $this->getSettings() ;
        if (!isset($settings["PublicScope"]["enable_public"]) ||
            ( isset($settings["PublicScope"]["enable_public"]) && $settings["PublicScope"]["enable_public"] != "on" )) {
            // if enable public is set to off
            if ($user == false) {
                // and the user is not logged in
                return false ; }
            // if they are logged in continue on
            return true ; }
        else {
            // if enable public is set to on
            if ($user == false) {
                // and the user is not logged in
                if ($repository["settings"]["PublicScope"]["enabled"] == "on" &&
                    $repository["settings"]["PublicScope"]["public_pages"] == "on") {
                    // if public pages are on
                    return true ; }
                else {
                    // if no public pages are on
                    return false ; } }
            else {
                // and the user is logged in
                // @todo this is where repo specific perms go when ready
                return true ;
            }
        }
    }

    protected function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }

}