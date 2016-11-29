<?php

Namespace Model;

class RepositoryFeatureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getRepositoryFeatures() {
        $builderFactory = new RepositoryFeature();
        $builderRepository = $builderFactory->getModel($this->params, "RepositoryFeatureRepository") ;
        $builders = $builderRepository->getAllRepositoryFeatures();
        $ret = $builders ;
        return $ret ;
    }

    public function getRepositoryFeatureSettings() {
        $builders = $this->getRepositoryFeatures();
        // var_dump(1, $builders) ;
        $ret = array() ;
        foreach ($builders as $name => $builder) {
            if (isset($builder["settings"]) && count($builder["settings"])>0) {
                $ret[$name] = $builder ; } }
        // var_dump(2, $ret) ;
        return $ret ;
    }

    public function getRepositoryFeature($module) {
        $builderFactory = new RepositoryFeature();
        $builderCollater = $builderFactory->getModel($this->params, "RepositoryFeatureCollater") ;
        $builder = $builderCollater->getRepositoryFeature($module);
        $ret = $builder ;
        return $ret ;
    }

    public function saveRepositoryFeature($line) {
        $builderFactory = new RepositoryFeature();
        $builderSaver = $builderFactory->getModel($this->params, "RepositoryFeatureSaver") ;
        $builder = $builderSaver->getRepositoryFeature($line);
        $ret = $builder ;
        return $ret ;
    }

    public function getRepositoryFeatureNames() {
        $builders = $this->getRepositoryFeatures() ;
        $names = array_keys($builders) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }
    public function deleteRepositoryFeature($name) {
        $builders = $this->getRepositoryFeatures() ;
        $path = dirname(dirname(__FILE__)).DS."Data".DS."demobuilders.php" ;
        include($path) ;
        unset($builders[$name]);

//        $builders = $this->getRepositoryFeatures() ;
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