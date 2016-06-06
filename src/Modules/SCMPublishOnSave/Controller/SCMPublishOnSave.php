<?php

Namespace Controller ;

class CopyOnSave extends Base {

     public function execute($pageVars) {

        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

        $action = $pageVars["route"]["action"];

         if (in_array($pageVars["route"]["action"], array("report"))) {
             $this->content["data"] = $thisModel->getReportData();
             return array ("type"=>"view", "view"=>"copyOnSave", "pageVars"=>$this->content); }

        if ($action=="help") {
            $helpModel = new \Model\Help();
            $this->content["helpData"] = $helpModel->getHelpData($pageVars["route"]["control"]);
            return array ("type"=>"view", "view"=>"help", "pageVars"=>$this->content); }

        $this->content["messages"][] = "Help is the only valid HTML reports Action";
        return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

    }

}
