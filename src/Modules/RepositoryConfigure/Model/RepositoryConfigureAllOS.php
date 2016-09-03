<?php

Namespace Model;

class RepositoryConfigureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    private $builder ;
    private $builderRepository ;

    public function __construct($params) {
        parent::__construct($params) ;
    }

    public function getData() {
        if (isset($this->params["item"])) { $ret["repository"] = $this->getRepository(); }
        $ret["builders"] = $this->getBuilders();
        $ret["settings"] = $this->getBuilderSettings();
        $ret["fields"] = $this->getBuilderFormFields();
        $ret["stepFields"] = $this->getStepBuildersFormFields();
        return $ret ;
    }

    public function getCopyData() {
        if (isset($this->params["item"])) { $ret["repository"] = $this->getRepository(); }
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params, "RepositoryRepository");
        $ret["pipe_names"] = $repository->getRepositoryNames() ;
        return $ret ;
    }

    public function saveState() {
        return $this->saveRepository();
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        return $repository->getRepository($this->params["item"]);
    }

//    public function getEventNames() {
//        return array_keys($this->getEvents());   }
//
//    public function getEvents() {
//        $ff = array(
//            "beforeRepositorySave" => array(""),
//            "beforeCopiedRepositorySave" => array(""),
//            "afterRepositorySave" => array(""),
//            "afterCopiedRepositorySave" => array(""),
//        );
//        return $ff ; }


    private function getBuilder() {
        if (isset($this->builder) && is_object($this->builder)) {
            return $this->builder ;  }
        $builder = RegistryStore::getValue("builderObject") ;
        if (isset($builder) && is_object($builder)) {
            $this->builder = $builder ;
            return $this->builder ;  }
        $builderFactory = new \Model\Builder() ;
        $this->builder = $builderFactory->getModel($this->params);
        RegistryStore::setValue("builderObject", $this->builder) ;
        return $this->builder ;
    }

    private function getBuilderRepository() {
        if (isset($this->builderRepository) && is_object($this->builderRepository)) {
            return $this->builderRepository ;  }
        $builderRepository = RegistryStore::getValue("builderRepositoryObject") ;
        if (isset($builderRepository) && is_object($builderRepository)) {
            $this->builderRepository = $builderRepository ;
            return $this->builderRepository ;  }
        $builderRepositoryFactory = new \Model\Builder() ;
        $this->builderRepository = $builderRepositoryFactory->getModel($this->params, "BuilderRepository");
        \Model\RegistryStore::setValue("builderRepositoryObject", $this->builderRepository) ;
        return $this->builderRepository ;
    }

    public function getBuilders() {
        $this->getBuilder() ;
        return $this->builder->getBuilders();
    }

    public function getBuilderSettings() {
        $this->getBuilder() ;
        return $this->builder->getBuilderSettings();
    }

    public function getBuilderFormFields() {
        $this->getBuilderRepository() ;
        return $this->builderRepository->getAllBuildersFormFields();
    }

    public function getStepBuildersFormFields() {
        $this->getBuilderRepository() ;
        return $this->builderRepository->getStepBuildersFormFields();
    }

    public function saveRepository() {
        $this->params["project-slug"] = $this->getFormattedSlug() ;
        $this->params["item"] = $this->params["project-slug"] ;
        $repositoryFactory = new \Model\Repository() ;
        $data = array(
            "project-name" => $this->params["project-name"],
            "project-slug" => $this->params["project-slug"],
            "project-description" => $this->params["project-description"]
        ) ;

        $ev = $this->runBCEvent("beforeRepositorySave") ;
        if ($ev == false) { return false ; }

        if ($this->params["creation"] == "yes") {
            $repositoryDefault = $repositoryFactory->getModel($this->params);
            $repositoryDefault->createRepository($this->params["project-slug"]) ; }
        $repositorySaver = $repositoryFactory->getModel($this->params, "RepositorySaver");
        // @todo dunno why i have to force this param
        $repositorySaver->params["item"] = $this->params["item"];
        $repositorySaver->saveRepository(array("type" => "Defaults", "data" => $data ));
        // $repositorySaver->saveRepository(array("type" => "Steps", "data" => $this->params["steps"] ));
        $repositorySaver->saveRepository(array("type" => "Settings", "data" => $this->params["settings"] ));

        $ev = $this->runBCEvent("afterRepositorySave") ;
        if ($ev == false) { return false ; }

        return true ;
    }

    protected function guessPipeName($orig) {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params, "RepositoryRepository");
        $pipe_names = $repository->getRepositoryNames() ;
        $req = (isset($this->params["project-name"])) ? $this->params["project-name"] : $orig ;
        if (!in_array($req, $pipe_names)) { return $req ; }
        $guess = $req." REPO" ;
        for ($i=1 ; $i<5001; $i++) {
            $guess = "Copied Repository $orig $i" ;
            if (!in_array($guess, $pipe_names)) {
                break ; } }
        return $guess ;
    }

    public function saveCopiedRepository() {
        if (!isset($this->params["source_repository"])) {
            // we dont need to save anything if we have no source
            return false ; }

        $repositoryFactory = new \Model\Repository() ;
        $repositoryDefault = $repositoryFactory->getModel($this->params);
        $sourcePipe = $repositoryDefault->getRepository($this->params["source_repository"]) ;

        $pname = $this->guessPipeName($sourcePipe["project-slug"]);
        $this->params["item"] = $this->getFormattedSlug($pname);

        $tempParams = $this->params ;
        $tempParams["item"]  = $this->params["source_repository"] ;
        $repositoryDefault = $repositoryFactory->getModel($tempParams);
        $sourcePipe = $repositoryDefault->getRepository($this->params["source_repository"]) ;

        $useParam = isset($this->params["project-description"]) && strlen($this->params["project-description"])>0 ;
        $pdesc = ($useParam) ?
            $this->params["project-description"] :
            $sourcePipe["project-description"] ;

        // @todo we need to put all of this into modules, as build settings.
        $data = array(
            "project-name" => $pname,
            "project-slug" => $this->params["item"],
            "project-description" => $pdesc,

        ) ;

        $ev = $this->runBCEvent("beforeRepositorySave") ;
        if ($ev == false) { return false ; }
        $ev = $this->runBCEvent("beforeCopiedRepositorySave") ;
        if ($ev == false) { return false ; }

        $repositoryDefault->createRepository($this->params["item"]) ;
        $repositorySaver = $repositoryFactory->getModel($this->params, "RepositorySaver");
        // @todo dunno y i have to force this param
        $repositorySaver->params["item"] = $this->params["item"];
        $repositorySaver->saveRepository(array("type" => "Defaults", "data" => $data ));
        // $repositorySaver->saveRepository(array("type" => "Steps", "data" => $sourcePipe["steps"] ));
        $repositorySaver->saveRepository(array("type" => "Settings", "data" => $sourcePipe["settings"] ));

        $ev = $this->runBCEvent("afterRepositorySave") ;
        if ($ev == false) { return false ; }
        $ev = $this->runBCEvent("afterCopiedRepositorySave") ;
        if ($ev == false) { return false ; }

        return $this->params["item"] ;
    }

    private function runBCEvent($name) {
        $this->params["echo-log"] = true ;
        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($this->params) ;
        $ev = $eventRunner->eventRunner($name) ;
        if ($ev == false) { return false ; }
        return true ;
    }

    private function getFormattedSlug($name = null) {
        $tpn = (!is_null($name)) ? $name : $this->params["project-name"] ;
        if ($this->params["project-slug"] == "") {
            $this->params["project-slug"] = str_replace(" ", "_", $tpn);
            $this->params["project-slug"] = str_replace("'", "", $this->params["project-slug"]);
            $this->params["project-slug"] = str_replace('"', "", $this->params["project-slug"]);
            $this->params["project-slug"] = str_replace("/", "", $this->params["project-slug"]);
            $this->params["project-slug"] = strtolower($this->params["project-slug"]); }
        return $this->params["project-slug"] ;
    }

}
