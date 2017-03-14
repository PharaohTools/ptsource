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
            'default' => array(
                '1.0.0' => array(
                    'git' => array('url' => 'http://google.com', 'title' => 'Git Clone', 'image' => 'http://source.pharaoh.tld/Assets/Modules/DefaultSkin/image/source-logo.png'),
                    'zip' => array('url' => 'http://google.com', 'title' => 'Zip Archive', 'image' => 'http://source.pharaoh.tld/Assets/Modules/DefaultSkin/image/source-logo.png'),
                    'tar' => array('url' => 'http://google.com', 'title' => 'Tar Archive', 'image' => 'http://source.pharaoh.tld/Assets/Modules/DefaultSkin/image/source-logo.png'),
                ) ,
                '1.0.1' => array(
                    'git' => array('url' => 'http://google.com', 'title' => 'Git Clone', 'image' => 'http://source.pharaoh.tld/Assets/Modules/DefaultSkin/image/source-logo.png'),
                    'zip' => array('url' => 'http://google.com', 'title' => 'Zip Archive', 'image' => 'http://source.pharaoh.tld/Assets/Modules/DefaultSkin/image/source-logo.png'),
                    'tar' => array('url' => 'http://google.com', 'title' => 'Tar Archive', 'image' => 'http://source.pharaoh.tld/Assets/Modules/DefaultSkin/image/source-logo.png'),
                ) ,
            ),
            'pharaoh_build_integration' => array(
                '1.0.0' => array(
                    'windows' => array('url' => 'http://google.com', 'title' => 'Windows Installer', 'image' => 'http://source.pharaoh.tld/Assets/Modules/RepositoryReleases/images/windows-logo.png'),
                    'linux' => array('url' => 'http://google.com', 'title' => 'Linux Installer', 'image' => 'http://source.pharaoh.tld/Assets/Modules/RepositoryReleases/images/linux-logo.png'),
                    'osx' => array('url' => 'http://google.com', 'title' => 'OSx Installer', 'image' => 'http://source.pharaoh.tld/Assets/Modules/RepositoryReleases/images/apple-logo.png'),
                ) ,
                '1.0.1' => array(
                    'windows' => array('url' => 'http://google.com', 'title' => 'Windows Installer', 'image' => 'http://source.pharaoh.tld/Assets/Modules/RepositoryReleases/images/windows-logo.png'),
                    'linux' => array('url' => 'http://google.com', 'title' => 'Linux Installer', 'image' => 'http://source.pharaoh.tld/Assets/Modules/RepositoryReleases/images/linux-logo.png'),
                    'osx' => array('url' => 'http://google.com', 'title' => 'OSx Installer', 'image' => 'http://source.pharaoh.tld/Assets/Modules/RepositoryReleases/images/apple-logo.png'),
                ) ,
            ),
        ) ;
        return $r ;
    }

    private function repoRootDir() {
        return REPODIR.DS.$this->params["item"].DS;
    }


}