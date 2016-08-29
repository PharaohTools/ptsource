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


        if (in_array($pageVars["route"]["action"], array("new"))) {
            if($thisModel->checkLoginSession() == TRUE){
                $this->content["data"] = $thisModel->getData();
//                $this->content["userdata"] = $thisModel->getUserDetails();
                return array ("type"=>"view", "view"=>"UserProfile", "pageVars"=>$this->content); }
            return array ("type"=>"view", "view"=>"UserProfileAlert", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("create"))) {
            if($thisModel->checkLoginSession() == TRUE){
                // @todo output format change not being implemented
                $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "CreateUser") ;
                $this->content["params"]["output-format"] = "JSON";
                $this->content["route"]["extraParams"]["output-format"] = "JSON";
                $this->content["data"] = $thisModel->getData();
                return array ("type"=>"view", "view"=>"userProfileCreateUser", "pageVars"=>$this->content);  }
            return array ("type"=>"view", "view"=>"UserProfileAlert", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("update"))) {
            if($thisModel->checkLoginSession() == TRUE){
                // @todo output format change not being implemented
                $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "UpdateUser") ;
                $this->content["params"]["output-format"] = "JSON";
                $this->content["route"]["extraParams"]["output-format"] = "JSON";
                $this->content["data"] = $thisModel->getData();
                return array ("type"=>"view", "view"=>"userProfileUpdateUser", "pageVars"=>$this->content);  }
            return array ("type"=>"view", "view"=>"UserProfileAlert", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("delete"))) {
            if($thisModel->checkLoginSession() == TRUE){
                // @todo output format change not being implemented
                $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "DeleteUser") ;
                $this->content["params"]["output-format"] = "JSON";
                $this->content["route"]["extraParams"]["output-format"] = "JSON";
                $this->content["data"] = $thisModel->getData();
                return array ("type"=>"view", "view"=>"userProfileDeleteUser", "pageVars"=>$this->content);  }
            return array ("type"=>"view", "view"=>"UserProfileAlert", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("show"))) {
            if($thisModel->checkLoginSession() == TRUE){
                $this->content["data"] = $thisModel->getData();
                $this->content["userdata"] = $thisModel->getUserDetails();
                return array ("type"=>"view", "view"=>"UserProfile", "pageVars"=>$this->content); }
            return array ("type"=>"view", "view"=>"UserProfileAlert", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("save"))) {
            if($thisModel->checkLoginSession() == TRUE){
                $thisModel->saveData();
                $this->content["data"] = $thisModel->getData();
                $this->content["userdata"] = $thisModel->getUserDetails();
                return array ("type"=>"view", "view"=>"UserProfile", "pageVars"=>$this->content); }
            return array ("type"=>"view", "view"=>"UserProfileAlert", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("get-user"))) {
            // @todo output format change not being implemented
            $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "GetUser") ;
            $this->content["params"]["output-format"] = "JSON";
            $this->content["route"]["extraParams"]["output-format"] = "JSON";
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"userProfileGetUser", "pageVars"=>$this->content); }
    }

}
