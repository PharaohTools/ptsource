<?php

Namespace Model;

class RepositoryPullRequestsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret = $this->getRepositoryPullRequests();
        $ret["repository"] = $this->getRepository();
        return $ret ;
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepository($this->params["item"]);
        return $r ;
    }

    public function getRepositoryPullRequests() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params, "RepositoryCommits");
        return $repository->getCommits();
    }

}