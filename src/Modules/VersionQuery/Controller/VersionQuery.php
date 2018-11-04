<?php

Namespace Controller ;

class VersionQuery extends Base {

    public function execute($pageVars) {

        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Base") ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

        $action = $pageVars["route"]["action"];
        if (in_array($action, array('current', 'next'))) {
            // @todo output format change not being implemented
            $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Default") ;
            $this->content["params"]["output-format"] = "JSON";
            $this->content['route']["extraParams"]["output-format"] = "JSON";
            $this->content["data"] = $thisModel->findRepositoryVersion($action);
            return array ("type"=>"view", "view"=>"VersionQueryAPHAX", "pageVars"=>$this->content);
        }

        if (in_array($action, array('show'))) {
            // @todo output format change not being implemented
            $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Default") ;
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"VersionQuery", "pageVars"=>$this->content);
        }

        if ($action=="help") {
            $helpModel = new \Model\Help();
            $this->content["helpData"] = $helpModel->getHelpData($pageVars["route"]["control"]);
            return array ("type"=>"view", "view"=>"help", "pageVars"=>$this->content); }

        $this->content["messages"][] = "$action is not a valid VersionQuery Action";
        return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

    }

}