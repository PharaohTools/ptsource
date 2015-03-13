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

    public function getAllBuilders() {
        $builders = array();
        $names = $this->getBuilderNames() ;
        $builderFactory = new \Model\Builder() ;
        $builder = $builderFactory->getModel($this->params);
        foreach ($names as $name) {
            $builders[$name] = $builder->getBuilder($name); }
        return $builders ;
    }

    public function getAllBuildersFormFields() {
        $formFields = array();
        $names = $this->getBuilderNames() ;
        $builderFactory = new \Model\Builder() ;
        $builder = $builderFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $builder->getBuilder($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getStepBuildersFormFields() {
        $formFields = array();
        $names = $this->getBuilderNames(array("buildSteps")) ;
        $builderFactory = new \Model\Builder() ;
        $builder = $builderFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $builder->getBuilder($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getBuilderNames($includeTypes = array()) {
        $builderNames = array() ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        $types = (count($includeTypes)>0) ? $includeTypes : array( "buildSteps", "buildSettings", "events") ;
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