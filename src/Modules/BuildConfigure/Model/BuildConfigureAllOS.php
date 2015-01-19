<?php

Namespace Model;

class BuildConfigureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret["pipeline"] = $this->getPipeline();
        $ret["builders"] = $this->getBuilders();
        return $ret ;
    }

    public function saveState() {
        return $this->savePipeline();
    }

    public function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

    public function getBuilders() {
        $builderFactory = new \Model\Builder() ;
        $builder = $builderFactory->getModel($this->params);
        return $builder->getBuilders();
    }

    public function savePipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params, "PipelineSaver");
        return $pipeline->savePipeline(array("type" => "Defaults", "data" => array(
            "project-name" => $this->params["project-name"],
            "project-description" => $this->params["project-description"],
            "default-scm-url" => $this->params["default-scm-url"],
        )));
    }

}