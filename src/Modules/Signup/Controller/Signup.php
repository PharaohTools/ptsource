<?php

Namespace Controller ;

class Signup extends Base {

    public function execute($pageVars) {
      $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
      // if we don't have an object, its an array of errors
      $this->content = $pageVars ;
      if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
      if($pageVars["route"]["action"] == "login"){
            $this->content["data"] = $thisModel->getlogin();
      }
      if($pageVars["route"]["action"] == "logout"){
          $thisModel->allLogininfodestroy();
          header("Location: /index.php?control=Signup&action=login");
          die();
      }
      return array ("type"=>"view", "view"=>"signup", "pageVars"=>$this->content);
    }
}
