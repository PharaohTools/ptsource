<?php

Namespace Controller ;

class PipeRunner extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if ($pageVars["route"]["action"] == "service") {
            $this->content["data"] = $thisModel->getServiceData();
            $this->content["route"]["extraParams"]["output-format"] = "service";
            return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content); }
        $this->content["data"] = $thisModel->getData();
        return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content);
    }

}