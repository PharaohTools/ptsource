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
        return $ret ;
    }

    public function deleteData() {
        $ret["repository"] = $this->deleteRepository();
        return $ret ;
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepository($this->params["item"]);
        return $r ;
    }

    public function getRepositoryFeatures() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepositoryFeatures($this->params["item"]);
        return $r ;
    }

    public function deleteRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        return $repository->deleteRepository($this->params["item"]);
    }

}