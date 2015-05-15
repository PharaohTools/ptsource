<?php

Namespace Controller ;

class AssetPublisher extends Base {

    public function execute($pageVars) {

        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

        $action = $pageVars["route"]["action"];
        if ($action == "publish") {
            $this->content["data"] = $thisModel->publishAssets();
            return array ("type"=>"view", "view"=>"assetPublisher", "pageVars"=>$this->content); }

        if ($action=="help") {
            $helpModel = new \Model\Help();
            $this->content["helpData"] = $helpModel->getHelpData($pageVars["route"]["control"]);
            return array ("type"=>"view", "view"=>"help", "pageVars"=>$this->content); }

        $this->content["messages"][] = "Help and Publish are the only valid AssetPublisher Actions";
        return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

    }

}