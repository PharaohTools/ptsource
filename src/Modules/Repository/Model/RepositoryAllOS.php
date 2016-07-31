<?php

Namespace Model;

class RepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getRepositories() {
        $repositoryFactory = new Repository();
        $repositoryRepository = $repositoryFactory->getModel($this->params, "RepositoryRepository") ;
        $repositories = $repositoryRepository->getAllRepositories();
        $ret = $repositories ;
        return $ret ;
    }

    public function getRepository($line) {
        $repositoryFactory = new Repository();
        $repositoryCollater = $repositoryFactory->getModel($this->params, "RepositoryCollater") ;
        $repository = $repositoryCollater->getRepository($line);
        $ret = $repository ;
        return $ret ;
    }

    public function saveRepository($line) {
        $repositoryFactory = new Repository();
        $repositorySaver = $repositoryFactory->getModel($this->params, "RepositorySaver") ;
        $repository = $repositorySaver->getRepository($line);
        $ret = $repository ;
        return $ret ;
    }

    public function getRepositoryNames() {
        $repositories = $this->getRepositories() ;
        $names = array_keys($repositories) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

    public function getRepositoryFeatures() {
        $repositoryFeatureFactory = new \Model\RepositoryFeature();
        $repositoryFeatureRepository = $repositoryFeatureFactory->getModel($this->params, "RepositoryFeatureRepository") ;
        $names = $repositoryFeatureRepository->getRepositoryFeatureNames();
        $repository = $this->getRepository($this->params["item"]);
        $this->params["repository-settings"] = $repository["settings"];
        $enabledFeatures = array() ;
        $i = 0;
        foreach ($repository["settings"] as $key => $values) {

            if (in_array($key, $names) && $values["enabled"] =="on") {
                $cname = '\Model\\'.$key ;
                $moduleFactory = new $cname();
                $moduleRepositoryFeature = $moduleFactory->getModel($this->params, "RepositoryFeature");
                // @ todo maybe an interface check? is object something?
                if (!is_array($values)) {
                    $values=array("default_fieldset" =>array(0 => array($values))) ; }

                foreach ($values as $fieldSetTitle => $fieldSets) {
                    foreach ($fieldSets as $hash => $valueset) {
                        if ($hash !== 0) { $valueset["hash"] = $hash ; }
                        $moduleRepositoryFeature->setValues($valueset) ;
                        $moduleRepositoryFeature->setRepository($repository) ;
                        $collated = $moduleRepositoryFeature->collate();
                        $enabledFeatures[$i]["module"] = $key  ;
                        $enabledFeatures[$i]["values"] = $valueset  ;
                        $enabledFeatures[$i]["model"] = $collated  ;
                        $i++; } } }
        }
        return $enabledFeatures ;
    }

    public function deleteRepository($name) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists(REPODIR.DS.$name)) {
            $logging->log("Directory exists at ".REPODIR.DS."{$name}. Attempting removal.", $this->getModuleName()) ;
            $rc = self::executeAndGetReturnCode('rm -rf '.REPODIR.DS.$name);
            return $rc ; }
        else  {
            $logging->log("No directory exists at ".REPODIR.DS."$name to delete", $this->getModuleName()) ;
            return true ; }
    }

    public function createRepository($name) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists(REPODIR.DS.$name)) {
            $logging->log("Directory already exists at ".REPODIR.DS."{$name}. Exiting with failure.", $this->getModuleName()) ;
            return false ; }
        else  {
            $logging->log("Attempting to create directory ".REPODIR.DS."$name ", $this->getModuleName()) ;
            // @todo cross os
            $rc = self::executeAndGetReturnCode('mkdir -p '.REPODIR.DS.$name);
            self::executeAndGetReturnCode('mkdir -p '.REPODIR.DS.$name.DS.'history');
            self::executeAndGetReturnCode('mkdir -p '.REPODIR.DS.$name.DS.'workspace');
            self::executeAndGetReturnCode('mkdir -p '.REPODIR.DS.$name.DS.'stepsHistory');
            self::executeAndGetReturnCode('mkdir -p '.REPODIR.DS.$name.DS.'tmp');
            self::executeAndGetReturnCode('touch '.REPODIR.DS.$name.DS.'historyIndex');
            return $rc ; }
    }

}
