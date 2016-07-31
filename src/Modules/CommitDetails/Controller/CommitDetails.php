<?php

Namespace Controller ;

class CommitDetails extends Base {

    public function execute($pageVars) {
      $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
      // if we don't have an object, its an array of errors
      $this->content = $pageVars ;
      if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
      if($pageVars["route"]["action"] == "show"){ $this->content["data"] = $thisModel->getData(); }
      if($pageVars["route"]["action"] == "delete"){ $this->content["data"] = $thisModel->deleteData(); }
      return array ("type"=>"view", "view"=>"commitDetails", "pageVars"=>$this->content);
    }

}