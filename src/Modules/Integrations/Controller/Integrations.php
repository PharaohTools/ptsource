<?php

Namespace Controller ;

class Integrations extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) {
            return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

        if ($pageVars["route"]["action"] === "webaction") {
            $webActionModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "WebAction") ;
            $webModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Web") ;
            $webAction = $webActionModel->getData();
            $this->content["data"] = $webModel->getData();
            $this->content["data"]["webAction"] = $webAction ;
            return array ("type"=>"view", "view"=>"integrations", "pageVars"=>$this->content);  }

        if ($pageVars["route"]["action"] === "show") {
            $webModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Web") ;
            $this->content["data"] = $webModel->getData();
            return array ("type"=>"view", "view"=>"integrations", "pageVars"=>$this->content);  }

    }

}