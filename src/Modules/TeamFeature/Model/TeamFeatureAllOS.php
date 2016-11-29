<?php

Namespace Model;

class TeamFeatureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getTeamFeatures() {
        $builderFactory = new TeamFeature();
        $builderRepository = $builderFactory->getModel($this->params, "TeamFeatureRepository") ;
        $builders = $builderRepository->getAllTeamFeatures();
        $ret = $builders ;
        return $ret ;
    }

    public function getTeamFeatureSettings() {
        $builders = $this->getTeamFeatures();
        // var_dump(1, $builders) ;
        $ret = array() ;
        foreach ($builders as $name => $builder) {
            if (isset($builder["settings"]) && count($builder["settings"])>0) {
                $ret[$name] = $builder ; } }
        // var_dump(2, $ret) ;
        return $ret ;
    }

    public function getTeamFeature($module) {
        $builderFactory = new TeamFeature();
        $builderCollater = $builderFactory->getModel($this->params, "TeamFeatureCollater") ;
        $builder = $builderCollater->getTeamFeature($module);
        $ret = $builder ;
        return $ret ;
    }

    public function saveTeamFeature($line) {
        $builderFactory = new TeamFeature();
        $builderSaver = $builderFactory->getModel($this->params, "TeamFeatureSaver") ;
        $builder = $builderSaver->getTeamFeature($line);
        $ret = $builder ;
        return $ret ;
    }

    public function getTeamFeatureNames() {
        $builders = $this->getTeamFeatures() ;
        $names = array_keys($builders) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }
    public function deleteTeamFeature($name) {
        $builders = $this->getTeamFeatures() ;
        $path = dirname(dirname(__FILE__)).DS."Data".DS."demobuilders.php" ;
        include($path) ;
        unset($builders[$name]);

//        $builders = $this->getTeamFeatures() ;
//        $path = dirname(dirname(__FILE__)).DS."Data".DS."demobuilders.php" ;
//
//        $file = fopen($path,"w");
//        fwrite($file,$builders);
//        fclose($file);
        $ret = $builders[$name] ;
        $r = (isset($ret) && is_array($ret)) ? $ret : false ;
        return $r ;
    }

}