<?php

Namespace Model;

class PipeFeatureRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("PipeFeatureRepository") ;

    public function getAllPipeFeatures() {
        $builders = array();
        $names = $this->getPipeFeatureNames() ;
        $builderFactory = new \Model\PipeFeature() ;
        $builder = $builderFactory->getModel($this->params);
        foreach ($names as $name) {
            $builders[$name] = $builder->getPipeFeature($name); }
        return $builders ;
    }

    public function getAllPipeFeaturesFormFields() {
        $formFields = array();
        $names = $this->getPipeFeatureNames() ;
        $builderFactory = new \Model\PipeFeature() ;
        $builder = $builderFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $builder->getPipeFeature($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getStepPipeFeaturesFormFields() {
        $formFields = array();
        $names = $this->getPipeFeatureNames(array("buildSteps")) ;
        $builderFactory = new \Model\PipeFeature() ;
        $builder = $builderFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $builder->getPipeFeature($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getPipeFeatureNames($includeTypes = array()) {
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