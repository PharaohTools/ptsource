<?php

Namespace Model;

class RepositoryHistoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret["commits"] = $this->getCommitHistory();
        return $ret ;
    }

    public function getCommitHistory() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params, "RepositoryCommits");
        return $repository->getCommits();
    }

}