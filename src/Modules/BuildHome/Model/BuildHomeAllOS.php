<?php

Namespace Model;

class BuildHomeAllOS extends Base {

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
        $ret["features"] = $this->getPipelineFeatures();
        return $ret ;
    }

    public function deleteData() {
        $ret["pipeline"] = $this->deletePipeline();
        return $ret ;
    }

    public function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        $r = $pipeline->getPipeline($this->params["item"]);
        return $r ;
    }

    public function getPipelineFeatures() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        $r = $pipeline->getPipelineFeatures($this->params["item"]);
        return $r ;
    }

    public function deletePipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->deletePipeline($this->params["item"]);
    }

}