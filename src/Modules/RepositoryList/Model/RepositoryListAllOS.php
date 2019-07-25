<?php

Namespace Model;

class RepositoryListAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret["repositories"] = $this->getRepositories();
        $ret["user"] = $this->getLoggedInUser();
        $ret["is_https"] = $this->isSecure();
        return $ret ;
    }

    public function getRepositories() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $repos = $repository->getRepositories();
        $new_repos = [] ;
        foreach ($repos as $repo) {
            $single_repo = [] ;
            $single_repo['project-name'] = $repo['project-name'] ;
            $single_repo['project-slug'] = $repo['project-slug'] ;
            $single_repo['project-description'] = $repo['project-description'] ;
            $single_repo['project-type'] = $repo['project-type'] ;
            $single_repo['project-owner'] = $repo['project-owner'] ;
            $new_repos[] = $single_repo ;
        }
        return $new_repos ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }

    protected function isSecure() {
        return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
    }

}