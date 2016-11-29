<?php

Namespace Model;

class TeamFeatureRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("TeamFeatureRepository") ;

    public function getAllTeamFeatures() {
        $teamFeatures = array();
        $names = $this->getTeamFeatureNames() ;
        $teamFeatureFactory = new \Model\TeamFeature() ;
        $teamFeature = $teamFeatureFactory->getModel($this->params);
        foreach ($names as $name) {
            $teamFeatures[$name] = $teamFeature->getTeamFeature($name); }
        return $teamFeatures ;
    }

    public function getAllTeamFeaturesFormFields() {
        $formFields = array();
        $names = $this->getTeamFeatureNames() ;
        $teamFeatureFactory = new \Model\TeamFeature() ;
        $teamFeature = $teamFeatureFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $teamFeature->getTeamFeature($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getStepTeamFeaturesFormFields() {
        $formFields = array();
        $names = $this->getTeamFeatureNames(array("buildSteps")) ;
        $teamFeatureFactory = new \Model\TeamFeature() ;
        $teamFeature = $teamFeatureFactory->getModel($this->params);
        foreach ($names as $name) {
            $bo = $teamFeature->getTeamFeature($name);
            $formFields[$name] = $bo["fields"] ; }
        return $formFields ;
    }

    public function getTeamFeatureNames($includeTypes = array()) {
        $teamFeatureNames = array() ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        $types = (count($includeTypes)>0) ? $includeTypes : array("teamFeatures") ;
        foreach ($infos as $info) {
            foreach ($types as $type) {
                if ( method_exists($info, $type)) {
                    $name = get_class($info);
                    $name = str_replace("Info\\", "", $name) ;
                    $name = substr($name, 0, strlen($name)-4) ;
                    $teamFeatureNames[] = $name; } } }
        return $teamFeatureNames ;
    }

}