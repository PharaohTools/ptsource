<?php

Namespace Controller ;

class BuildConfigure extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if (in_array($pageVars["route"]["action"], array("copy"))) {
            if ($thisModel->saveCopiedPipeline()==true) {
                $this->content["route"]["action"] = "show" ;
                $this->content["item"] = $_REQUEST["source_pipeline"] ;
                return array ("type"=>"control", "control"=>"buildConfigure", "pageVars"=>$this->content); }
            $this->content["data"] = $thisModel->getCopyData();
            return array ("type"=>"view", "view"=>"buildConfigureCopy", "pageVars"=>$this->content); }
        if (in_array($pageVars["route"]["action"], array("save"))) {
            $this->content["data"]["saveState"] = $thisModel->savePipeline();  }
        if (in_array($pageVars["route"]["action"], array("new", "show"))) {
            $this->content["data"] = $thisModel->getData(); }
        return array ("type"=>"view", "view"=>"buildConfigure", "pageVars"=>$this->content);
    }

}