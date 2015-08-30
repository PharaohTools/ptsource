<?php

Namespace Controller ;

class UserProfile extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { 
			return $this->failDependencies($pageVars, $this->content, $thisModel) ;
		}
        if (in_array($pageVars["route"]["action"], array("show"))) {
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"UserProfile", "pageVars"=>$this->content); }
        if (in_array($pageVars["route"]["action"], array("save"))) {
            $thisModel->saveData();
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"UserProfile", "pageVars"=>$this->content); }
        if (in_array($pageVars["route"]["action"], array("get-user"))) {
            // @todo output format change not being implemented
            $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "GetUser") ;
            $this->content["params"]["output-format"] = "JSON";
            $this->content["route"]["extraParams"]["output-format"] = "JSON";
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"userProfileGetUser", "pageVars"=>$this->content); }
    }

}
