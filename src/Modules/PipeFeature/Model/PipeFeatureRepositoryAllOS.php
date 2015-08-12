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
        $pipeFeatures = array();
        $names = $this->getPipeFeatureNames() ;
        $pipeFeatureFactory = new \Model\PipeFeature() ;
        $pipeFeature = $pipeFeatureFactory->getModel($this->params);
        foreach ($names as $name) {
            $pipeFeatures[$name] = $pipeFeature->getPipeFeature($name); }
        return $pipeFeatures ;
    }

    public function getAllPipeFeaturesFormFields() {
        $formFields = array();
        $names = $this->getPipeFeatureNames() ;
        $pipeFeatureFactory = new \Model\PipeFeature() ;
        $pipeFeature = $pipeFeatureFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $pipeFeature->getPipeFeature($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getStepPipeFeaturesFormFields() {
        $formFields = array();
        $names = $this->getPipeFeatureNames(array("buildSteps")) ;
        $pipeFeatureFactory = new \Model\PipeFeature() ;
        $pipeFeature = $pipeFeatureFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $pipeFeature->getPipeFeature($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getPipeFeatureNames($includeTypes = array()) {
        $pipeFeatureNames = array() ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        $types = (count($includeTypes)>0) ? $includeTypes : array("pipeFeatures") ;
        foreach ($infos as $info) {
            foreach ($types as $type) {
                if ( method_exists($info, $type)) {
                    $name = get_class($info);
                    $name = str_replace("Info\\", "", $name) ;
                    $name = substr($name, 0, strlen($name)-4) ;
                    $pipeFeatureNames[] = $name; } } }
        return $pipeFeatureNames ;
    }

}