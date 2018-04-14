<?php

Namespace Controller ;

class FileBrowser extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if (in_array($pageVars["route"]["action"], array("show"))) {
            $this->content["data"] = $thisModel->getData(); }
        return array ("type"=>"view", "view"=>"fileBrowser", "pageVars"=>$this->content);
    }

}