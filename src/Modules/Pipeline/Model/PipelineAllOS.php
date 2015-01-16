<?php

Namespace Model;

class PipelineAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getPipelines() {
        $path = dirname(dirname(__FILE__)).DS."Data".DS."demopipelines.php" ;
        include($path) ;
        $ret = $demopipelines ;
        return $ret ;
    }

    public function getPipeline($line) {
        $pipelines = $this->getPipelines() ;
        $ret = $pipelines[$line] ;
        $r = (isset($ret) && is_array($ret)) ? $ret : false ;
        return $r ;
    }

    public function getPipelineNames() {
        $pipelines = $this->getPipelines() ;
        $names = array_keys($pipelines) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }
    public function deletePipeline($name) {
        $pipelines = $this->getPipelines() ;
        $path = dirname(dirname(__FILE__)).DS."Data".DS."demopipelines.php" ;
        include($path) ;
        unset($demopipelines[$name]);

//        $pipelines = $this->getPipelines() ;
//        $path = dirname(dirname(__FILE__)).DS."Data".DS."demopipelines.php" ;
//
//        $file = fopen($path,"w");
//        fwrite($file,$pipelines);
//        fclose($file);
        $ret = $pipelines[$name] ;
        $r = (isset($ret) && is_array($ret)) ? $ret : false ;
        return $r ;
        return ;
    }

}