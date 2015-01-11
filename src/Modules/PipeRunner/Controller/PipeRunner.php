<?php

Namespace Controller ;

class PipeRunner extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if (in_array($pageVars["route"]["action"], array("pipestatus","service"))) {
            $this->content["data"] = $thisModel->getServiceData();
            $this->content["route"]["extraParams"]["output-format"] = $pageVars["route"]["action"];
            return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content); }
        if (in_array($pageVars["route"]["action"], array("start"))) {
            $this->content["pipex"] = $thisModel->runPipe(); }
        $this->content["data"] = $thisModel->getData();
        return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content);
    }

}