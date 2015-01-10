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
        include("demopipelines.php") ;
        $ret = $demoPipelines ;
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

}