<?php

Namespace Model;

class RepositoryRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("RepositoryRepository") ;

    public function getAllRepositories() {
        $repositories = array();
        $names = $this->getRepositoryNames() ;
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        foreach ($names as $name) { $repositories[$name] = $repository->getRepository($name); }
        return $repositories ;
    }

    public function getRepositoryNames() {
        $repositories = scandir(REPODIR) ;
        for ($i=0; $i<count($repositories); $i++) {
            if (!in_array($repositories[$i], array(".", "..", "tmpfile"))){
                if(is_dir(REPODIR.DS.$repositories[$i])) {
                    // @todo if this isnt definitely a build dir ignore maybe
                    $names[] = $repositories[$i] ; } } }
        return (isset($names) && is_array($names)) ? $names : array() ;
    }

}