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
		   if($thisModel->checkRole() == TRUE){
			$this->content["userdata"] = $thisModel->getUserDetails();		              
            return array ("type"=>"view", "view"=>"UserManager", "pageVars"=>$this->content);
			}
		 return array ("type"=>"view", "view"=>"UserManagerAlert", "pageVars"=>$this->content); 
        }
        if ($pageVars["route"]["action"] == "changerole") { 
            $thisModel->changeRole();
            $this->content["userdata"] = $thisModel->getUserDetails(); 
            return array ("type"=>"view", "view"=>"userManager", "pageVars"=>$this->content);     
       }
       if ($pageVars["route"]["action"] == "removeuser") { 
            $thisModel->removeUser();
            $this->content["userdata"] = $thisModel->getUserDetails(); 
            return array ("type"=>"view", "view"=>"userManager", "pageVars"=>$this->content);     
       }
        if ($pageVars["route"]["action"] == "adduser") { 
            $thisModel->addUser();
            $this->content["userdata"] = $thisModel->getUserDetails(); 
            return array ("type"=>"view", "view"=>"userManager", "pageVars"=>$this->content);     
       }
       if ($pageVars["route"]["action"] == "userprofile") {
            $this->content["currentuser"] = $thisModel->getCurrentUser();
            return array ("type"=>"view", "view"=>"userProfile", "pageVars"=>$this->content);
       }
       if ($pageVars["route"]["action"] == "changepassword") {
            $this->content["data"] = $thisModel->changePassword();
            $this->content["route"]["extraParams"]["output-format"] = "CLI" ;
            return array("type" => "view", "view" => "changePasswordResult", "pageVars" => $this->content);
        }
    }

}
