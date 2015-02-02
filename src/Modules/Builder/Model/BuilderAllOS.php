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

    public function getBuilders() {
        $builderFactory = new Builder();
        $builderRepository = $builderFactory->getModel($this->params, "BuilderRepository") ;
        $builders = $builderRepository->getAllBuilders();
        $ret = $builders ;
        return $ret ;
    }

    public function getBuilder($module) {
        $builderFactory = new Builder();
        $builderCollater = $builderFactory->getModel($this->params, "BuilderCollater") ;
        $builder = $builderCollater->getBuilder($module);
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

//    public function getBuilder($line) {
//        $builders = $this->getBuilders() ;
//        $ret = $builders[$line] ;
//        $r = (isset($ret) && is_array($ret)) ? $ret : false ;
//        return $r ;
//    }

    public function getBuilderNames() {
        $builders = $this->getBuilders() ;
        $names = array_keys($builders) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }
    public function deleteBuilder($name) {
        $builders = $this->getBuilders() ;
        $path = dirname(dirname(__FILE__)).DS."Data".DS."demobuilders.php" ;
        include($path) ;
        unset($demobuilders[$name]);

//        $builders = $this->getBuilders() ;
//        $path = dirname(dirname(__FILE__)).DS."Data".DS."demobuilders.php" ;
//
//        $file = fopen($path,"w");
//        fwrite($file,$builders);
//        fclose($file);
        $ret = $builders[$name] ;
        $r = (isset($ret) && is_array($ret)) ? $ret : false ;
        return $r ;
        return ;
    }

}