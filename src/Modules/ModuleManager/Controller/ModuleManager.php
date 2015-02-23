<?php

Namespace Controller ;

class ModuleManager extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if (in_array($pageVars["route"]["action"], array("show"))) {
            $webModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Web") ;
            $this->content["data"] = $webModel->getData();  }
        if (in_array($pageVars["route"]["action"], array("save"))) {
            $saveModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Saver") ;
            $this->content["data"]["saveState"] = $saveModel->saveAllConfigs();  }
        return array ("type"=>"view", "view"=>"moduleManager", "pageVars"=>$this->content);
    }

}