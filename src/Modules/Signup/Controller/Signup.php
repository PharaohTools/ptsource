<?php

Namespace Controller ;

class Signup extends Base {

    public function execute($pageVars) {
      $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
      // if we don't have an object, its an array of errors
      $this->content = $pageVars ;
      if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        // Start the session
        session_start();
      if($pageVars["route"]["action"] == "login"){
            $this->content["data"] = $thisModel->getlogin();
      }
      if($pageVars["route"]["action"] == "login-status"){
            return $thisModel->checkLoginStatus();
      }
      if($pageVars["route"]["action"] == "login-submit"){
          return $thisModel->checkLogin();
      }
      if($pageVars["route"]["action"] == "logout"){
         $thisModel->allLoginInfoDestroy();
      }
      return array ("type"=>"view", "view"=>"signup", "pageVars"=>$this->content);
    }
}
