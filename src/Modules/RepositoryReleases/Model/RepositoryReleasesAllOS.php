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
        $ret['release_packages'] = $this->getReleasePackages();
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

    public function getAvailableTags() {
        $filebrowserDir = $this->repoRootDir() ;
        $command = "cd {$filebrowserDir}/refs/tags && ls -1" ;
        $all_tags_string = $this->executeAndLoad($command) ;
        $all_tags_ray = explode("\n", $all_tags_string) ;
        $all_tags_ray = array_diff($all_tags_ray, array("")) ;
//        var_dump('all tags: ', 's', $all_tags_string,  'r', $all_tags_ray, 'c', $command) ;
        return $all_tags_ray ;
    }

    public function getReleasePackages() {
        $r = array(
            '1.0.0' => array(
                'git' => array('url' => 'http://google.com', 'title' => 'Git Clone'),
                'zip' => array('url' => 'http://google.com', 'title' => 'Zip Archive'),
                'tar' => array('url' => 'http://google.com', 'title' => 'Tar Archive'),
                'windows' => array('url' => 'http://google.com', 'title' => 'Windows Installer'),
            )
        ) ;
        return $r ;
    }

    private function repoRootDir() {
        return REPODIR.DS.$this->params["item"].DS;
    }


}