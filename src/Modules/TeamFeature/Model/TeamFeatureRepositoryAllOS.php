<?php

Namespace Model;

class RepositoryFeatureRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("RepositoryFeatureRepository") ;

    public function getAllRepositoryFeatures() {
        $repositoryFeatures = array();
        $names = $this->getRepositoryFeatureNames() ;
        $repositoryFeatureFactory = new \Model\RepositoryFeature() ;
        $repositoryFeature = $repositoryFeatureFactory->getModel($this->params);
        foreach ($names as $name) {
            $repositoryFeatures[$name] = $repositoryFeature->getRepositoryFeature($name); }
        return $repositoryFeatures ;
    }

    public function getAllRepositoryFeaturesFormFields() {
        $formFields = array();
        $names = $this->getRepositoryFeatureNames() ;
        $repositoryFeatureFactory = new \Model\RepositoryFeature() ;
        $repositoryFeature = $repositoryFeatureFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $repositoryFeature->getRepositoryFeature($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getStepRepositoryFeaturesFormFields() {
        $formFields = array();
        $names = $this->getRepositoryFeatureNames(array("buildSteps")) ;
        $repositoryFeatureFactory = new \Model\RepositoryFeature() ;
        $repositoryFeature = $repositoryFeatureFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $repositoryFeature->getRepositoryFeature($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getRepositoryFeatureNames($includeTypes = array()) {
        $repositoryFeatureNames = array() ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        $types = (count($includeTypes)>0) ? $includeTypes : array("repositoryFeatures") ;
        foreach ($infos as $info) {
            foreach ($types as $type) {
                if ( method_exists($info, $type)) {
                    $name = get_class($info);
                    $name = str_replace("Info\\", "", $name) ;
                    $name = substr($name, 0, strlen($name)-4) ;
                    $repositoryFeatureNames[] = $name; } } }
        return $repositoryFeatureNames ;
    }

}