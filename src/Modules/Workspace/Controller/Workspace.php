<?php

Namespace Controller ;

class Workspace extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if (in_array($pageVars["route"]["action"], array("pipestatus", "service"))) {
            // @todo output format change not being implemented
            $this->content["params"]["output-format"] = strtoupper($pageVars["route"]["action"]);
            $this->content["route"]["extraParams"]["output-format"] = strtoupper($pageVars["route"]["action"]);
            $this->content["data"] = $thisModel->getServiceData();
            return array ("type"=>"view", "view"=>"workspace", "pageVars"=>$this->content); }
        if (in_array($pageVars["route"]["action"], array("child"))) {
            $this->content["pid"] = $thisModel->runChild();
            $this->content["data"] = $thisModel->getChildData();
            $this->content["route"]["extraParams"]["output-format"] = "CLI";
            return array ("type"=>"view", "view"=>"workspaceChild", "pageVars"=>$this->content); }
        if (in_array($pageVars["route"]["action"], array("show"))) {
            $this->content["pipex"] = $thisModel->runPipe(); }
        $this->content["data"] = $thisModel->getData();
        return array ("type"=>"view", "view"=>"workspace", "pageVars"=>$this->content);
    }

}