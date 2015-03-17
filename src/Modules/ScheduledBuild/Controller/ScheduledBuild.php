<?php

Namespace Controller ;

class ScheduledBuild extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

        if (in_array($pageVars["route"]["action"], array("run-cycle"))) {
            $this->content["route"]["extraParams"]["output-format"] = "CLI";
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"ScheduledBuildChild", "pageVars"=>$this->content); }

        return array ("type"=>"view", "view"=>"ScheduledBuild", "pageVars"=>$this->content);
    }

}
