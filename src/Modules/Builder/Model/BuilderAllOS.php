<?php

Namespace Model;

class BuilderAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    private $builderCollater ;
    private $builderRepository ;

    private function getBuilderCollater() {
        if (isset($this->builderCollater) && is_object($this->builderCollater)) {
            return $this->builderCollater ;  }
        $builderCollater = RegistryStore::getValue("builderCollaterObject") ;
        if (isset($builderCollater) && is_object($builderCollater)) {
            $this->builderCollater = $builderCollater ;
            return $this->builderCollater ;  }
        $builderFactory = new \Model\Builder() ;
        $this->builderCollater = $builderFactory->getModel($this->params, "BuilderCollater");
        RegistryStore::setValue("builderCollaterObject", $this->builderCollater) ;
        return $this->builderCollater ;
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
        RegistryStore::setValue("builderRepositoryObject", $this->builderRepository) ;
        return $this->builderRepository ;
    }


    public function getBuilders() {
        $this->getBuilderRepository() ;
        $builders = $this->builderRepository->getAllBuilders();
        $ret = $builders ;
        return $ret ;
    }

    public function getBuilderSettings() {
        $builders = $this->getBuilders();
        // var_dump(1, $builders) ;
        $ret = array() ;
        foreach ($builders as $name => $builder) {
//            var_dump("bn", $name) ;
            if (isset($builder["settings"]) && count($builder["settings"])>0) {
                $ret[$name] = $builder ; } }
        // var_dump(2, $ret) ;
        return $ret ;
    }

    public function getBuilder($module) {
        $this->getBuilderCollater();
        $builder = $this->builderCollater->getBuilder($module);
        $ret = $builder ;
        return $ret ;
    }

    public function saveBuilder($line) {
        $builderFactory = new Builder();
        $builderSaver = $builderFactory->getModel($this->params, "BuilderSaver") ;
        $builder = $builderSaver->getBuilder($line);
        $ret = $builder ;
        return $ret ;
    }

    public function getBuilderNames() {
        $builders = $this->getBuilders() ;
        $names = array_keys($builders) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

}