<?php

Namespace Model;

class BuilderRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("BuilderRepository") ;
    private $builder ;


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

    public function getAllBuilders() {
        $builders = array();
        $names = $this->getBuilderNames() ;
        $this->getBuilder() ;
        foreach ($names as $name) { $builders[$name] = $this->builder->getBuilder($name);}
        return $builders ;
    }

    public function getAllBuildersFormFields() {
        $formFields = array();
        $names = $this->getBuilderNames() ;

        $this->getBuilder() ;

//        $builderFactory = new \Model\Builder() ;
//        $builder = $builderFactory->getModel($this->params);

        foreach ($names as $name) {
            $bo = $this->builder->getBuilder($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getStepBuildersFormFields() {
        $formFields = array();
        $names = $this->getBuilderNames(array("buildSteps")) ;

//        $builderFactory = new \Model\Builder() ;
//        $builder = $builderFactory->getModel($this->params);

        foreach ($names as $name) {
            $bo = $this->builder->getBuilder($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getBuilderNames($includeTypes = array()) {
        $builderNames = array() ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        $types = (count($includeTypes)>0) ? $includeTypes : array( "repositorySettings" ) ;
        foreach ($infos as $info) {
            foreach ($types as $type) {
                if ( method_exists($info, $type)) {
                    $name = get_class($info);
                    $name = str_replace("Info\\", "", $name) ;
                    $name = substr($name, 0, strlen($name)-4) ;
                    $builderNames[] = $name; } } }
        return $builderNames ;
    }

}