<?php

Namespace Controller ;

class GitServer extends Base {

    public function execute($pageVars) {
      $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
      // if we don't have an object, its an array of errors
      $this->content = $pageVars ;
      if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
      if($pageVars["route"]["action"] == "clone"){ $this->content["data"] = $thisModel->cloneData(); }
        if($pageVars["route"]["action"] == "push"){ $this->content["data"] = $thisModel->cloneData(); }
        if($pageVars["route"]["action"] == "pull"){ $this->content["data"] = $thisModel->cloneData(); }

        $this->content["route"]["extraParams"] ;
        $this->content["output-format"] = "git" ;
      return array ("type"=>"view", "view"=>"gitServer", "pageVars"=>$this->content);
    }

}