<?php

Namespace Controller ;

class ManualUpload extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if (in_array($pageVars["route"]["action"], array("show"))) {
            $this->content["data"] = $thisModel->getData();}
        else if (in_array($pageVars["route"]["action"], array("fileupload"))) {
            $this->content["data"] = $thisModel->uploadFile(); }
        else if (in_array($pageVars["route"]["action"], array("filedelete"))) {
            $this->content["data"] = $thisModel->deleteFile(); }
        return array ("type"=>"view", "view"=>"manualUpload", "pageVars"=>$this->content);
    }

}