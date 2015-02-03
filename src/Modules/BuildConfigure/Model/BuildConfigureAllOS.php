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
        $ret["fields"] = $this->getBuilderFormFields();
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

    public function getBuilderFormFields() {
        $builderFactory = new \Model\Builder() ;
        $builder = $builderFactory->getModel($this->params, "BuilderRepository");
        return $builder->getAllBuildersFormFields();
    }
    #

    public function savePipeline() {
        $this->params["project-slug"] = $this->getFormattedSlug() ;
        $this->params["item"] = $this->params["project-slug"] ;
        $pipelineFactory = new \Model\Pipeline() ;
        $data = array(
            "project-name" => $this->params["project-name"],
            "project-slug" => $this->params["project-slug"],
            "project-description" => $this->params["project-description"],
            "default-scm-url" => $this->params["default-scm-url"] ) ;
        if ($this->params["creation"] == "yes") {
            $pipelineDefault = $pipelineFactory->getModel($this->params);
            $pipelineDefault->createPipeline($this->params["project-slug"]) ; }
        $pipelineSaver = $pipelineFactory->getModel($this->params, "PipelineSaver");
        // @todo  dunno y i have to force thi sparam
        $pipelineSaver->params["item"] = $this->params["item"];
        $pipelineSaver->savePipeline(array("type" => "Defaults", "data" => $data ));
        return true ;
    }

    private function getFormattedSlug() {
        if ($this->params["project-slug"] == "") {
            $this->params["project-slug"] = str_replace(" ", "_", $this->params["project-name"]);
            $this->params["project-slug"] = str_replace("'", "", $this->params["project-slug"]);
            $this->params["project-slug"] = str_replace('"', "", $this->params["project-slug"]);
            $this->params["project-slug"] = str_replace("/", "", $this->params["project-slug"]);
            $this->params["project-slug"] = strtolower($this->params["project-slug"]); }
        return $this->params["project-slug"] ;
    }

}