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
        foreach ($names as $name) { $pipelines[$name] = $pipeline->getPipeline($name); }
        return $pipelines ;
    }

    public function getPipelineNames() {
        $pipelines = scandir(PIPEDIR) ;
        for ($i=0; $i<count($pipelines); $i++) {
            if (!in_array($pipelines[$i], array(".", "..", "tmpfile"))){
                if(is_dir(PIPEDIR.DS.$pipelines[$i])) {
                    // @todo if this isnt definitely a build dir ignore maybe
                    $names[] = $pipelines[$i] ; } } }
        return (isset($names) && is_array($names)) ? $names : array() ;
    }

}