<?php

Namespace Model;

class RepositoryReleasesAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret = $this->getReleaseHistory();
        $ret["repository"] = $this->getRepository();
        $ret["tags"] = $this->getAvailableTags();
//        var_dump($ret["commits"]) ;
        return $ret ;
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepository($this->params["item"]);
        return $r ;
    }

    public function getReleaseHistory() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params, "RepositoryCommits");
        return $repository->getCommits();
    }

    private function getAvailableBranches() {
        $filebrowserDir = $this->repoRootDir() ;
        $command = "cd {$filebrowserDir} && git branch" ;
        $all_branches_string = $this->executeAndLoad($command) ;
        $all_branches_string = str_replace('* ', "", $all_branches_string) ;
        $all_branches_string = str_replace(' ', "", $all_branches_string) ;
        $all_branches_ray = explode("\n", $all_branches_string) ;
        return $all_branches_ray ;
    }

    public function getAvailableTags() {
        $filebrowserDir = $this->repoRootDir() ;
        $command = "cd {$filebrowserDir} && git tag" ;
        $all_tags_string = $this->executeAndLoad($command) ;
        $all_tags_string = str_replace('* ', "", $all_tags_string) ;
        $all_tags_string = str_replace(' ', "", $all_tags_string) ;
        $all_tags_ray = explode("\n", $all_tags_string) ;
        return $all_tags_ray ;
    }

    private function repoRootDir() {
        return REPODIR.DS.$this->params["item"].DS;
    }


}