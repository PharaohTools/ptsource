<?php

Namespace Controller ;

class BuildConfigure extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if (in_array($pageVars["route"]["action"], array("save"))) {
            $this->content["data"]["saveState"] = $thisModel->savePipeline();
            $thisModel->savePluginData();
        }
        $this->content["data"] = $thisModel->getData();
        return array ("type"=>"view", "view"=>"buildConfigure", "pageVars"=>$this->content);
    }

}