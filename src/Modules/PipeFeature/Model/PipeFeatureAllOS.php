<?php

Namespace Model;

class PipeFeatureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getPipeFeatures() {
        $builderFactory = new PipeFeature();
        $builderRepository = $builderFactory->getModel($this->params, "PipeFeatureRepository") ;
        $builders = $builderRepository->getAllPipeFeatures();
        $ret = $builders ;
        return $ret ;
    }

    public function getPipeFeatureSettings() {
        $builders = $this->getPipeFeatures();
        // var_dump(1, $builders) ;
        $ret = array() ;
        foreach ($builders as $name => $builder) {
            if (isset($builder["settings"]) && count($builder["settings"])>0) {
                $ret[$name] = $builder ; } }
        // var_dump(2, $ret) ;
        return $ret ;
    }

    public function getPipeFeature($module) {
        $builderFactory = new PipeFeature();
        $builderCollater = $builderFactory->getModel($this->params, "PipeFeatureCollater") ;
        $builder = $builderCollater->getPipeFeature($module);
        $ret = $builder ;
        return $ret ;
    }

    public function savePipeFeature($line) {
        $builderFactory = new PipeFeature();
        $builderSaver = $builderFactory->getModel($this->params, "PipeFeatureSaver") ;
        $builder = $builderSaver->getPipeFeature($line);
        $ret = $builder ;
        return $ret ;
    }

    public function getPipeFeatureNames() {
        $builders = $this->getPipeFeatures() ;
        $names = array_keys($builders) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }
    public function deletePipeFeature($name) {
        $builders = $this->getPipeFeatures() ;
        $path = dirname(dirname(__FILE__)).DS."Data".DS."demobuilders.php" ;
        include($path) ;
        unset($builders[$name]);

//        $builders = $this->getPipeFeatures() ;
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