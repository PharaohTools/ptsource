<?php

Namespace Controller ;

class UserManager extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { 
			return $this->failDependencies($pageVars, $this->content, $thisModel) ;
		}
        if (in_array($pageVars["route"]["action"], array("show"))) {
		    $webModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Web") ;
            $this->content["data"] = $thisModel->getUserDetails();          
            return array ("type"=>"view", "view"=>"userManager", "pageVars"=>$this->content); 
        }
        if (in_array($pageVars["route"]["action"], array("webaction"))) {
            $webActionModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "WebAction") ;
            $this->content["data"]["webAction"] = $webActionModel->getData();
            return array ("type"=>"view", "view"=>"userManagerWebAction", "pageVars"=>$this->content); 
		}
        if ($pageVars["route"]["action"] == "getuserdetails") { 
            $this->content["data"] = $thisModel->getUserDetails();
       }
    }

}
