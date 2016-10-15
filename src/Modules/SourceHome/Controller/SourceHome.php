<?php

Namespace Controller ;

class SourceHome extends Base {

    public function execute($pageVars) {
      $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
      // if we don't have an object, its an array of errors
      $this->content = $pageVars ;
      if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

        if (in_array($pageVars["route"]["action"], array("get-all-issue-counts"))) {
            $this->content["params"]["output-format"] = "JSON";
            $this->content["route"]["extraParams"]["output-format"] = "JSON";
            $ajaxMod = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "AjaxData") ;
            $this->content["data"] = $ajaxMod->getData("all");
            return array ("type"=>"view", "view"=>"sourceHomeGetData", "pageVars"=>$this->content);
        }
        if (in_array($pageVars["route"]["action"], array("get-watching-issue-counts"))) {
            $this->content["params"]["output-format"] = "JSON";
            $this->content["route"]["extraParams"]["output-format"] = "JSON";
            $ajaxMod = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "AjaxData") ;
            $this->content["data"] = $ajaxMod->getData("watching");
            return array ("type"=>"view", "view"=>"sourceHomeGetData", "pageVars"=>$this->content);
        }
        if (in_array($pageVars["route"]["action"], array("get-submitted-issue-counts"))) {
            $this->content["params"]["output-format"] = "JSON";
            $this->content["route"]["extraParams"]["output-format"] = "JSON";
            $ajaxMod = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "AjaxData") ;
            $this->content["data"] = $ajaxMod->getData("submitted");
            return array ("type"=>"view", "view"=>"sourceHomeGetData", "pageVars"=>$this->content);
        }
        if (in_array($pageVars["route"]["action"], array("get-assigned-issue-counts"))) {
            $this->content["params"]["output-format"] = "JSON";
            $this->content["route"]["extraParams"]["output-format"] = "JSON";
            $ajaxMod = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "AjaxData") ;
            $this->content["data"] = $ajaxMod->getData("assigned");
            return array ("type"=>"view", "view"=>"sourceHomeGetData", "pageVars"=>$this->content);
        }

        // @todo output format change not being implemented
        $this->content["data"] = $thisModel->getData();
        return array ("type"=>"view", "view"=>"sourceHome", "pageVars"=>$this->content);
    }

}