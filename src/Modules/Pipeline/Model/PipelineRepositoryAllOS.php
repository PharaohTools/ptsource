<?php

Namespace Model;

class PipelineRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("PipelineRepository") ;

    public function getAllPipelines() {

        $pipelines = array();
        $names = $this->getPipelineNames() ;
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);

        $ret = $this->getPipelines() ;
        $r = (isset($ret) && is_array($ret)) ? $ret : false ;
        return $r ;
    }

    public function getPipelineNames() {

            # mkdir($this->params["pipe-dir"].DS.$this->params["item"], true) ;
        $pipelines = scandir($this->params["pipe-dir"]) ;
            for ($i=0; $i<count($pipelines); $i++) {
                if (in_array($pipelines, array(".", "..", "tmpfile"))){
                    // @todo if this isnt defrinitely a build dir ignore maybe
                    // unset($pipelines[$i]) ;
                } }
        $names = array_keys($pipelines) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

}