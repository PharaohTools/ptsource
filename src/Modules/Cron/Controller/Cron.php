<?php

Namespace Controller ;

class Cron extends Base {

    public function execute($pageVars) {

        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

        $action = $pageVars["route"]["action"];

        if ($action=="help") {
            $helpModel = new \Model\Help();
            $this->content["helpData"] = $helpModel->getHelpData($pageVars["route"]["control"]);
            return array ("type"=>"view", "view"=>"help", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("set-crontab"))) {
            $this->content["data"] = $thisModel->crontabChild();
            $this->content["route"]["extraParams"]["output-format"] = "CLI";
            return array ("type"=>"view", "view"=>"cronChild", "pageVars"=>$this->content); }

        $this->content["messages"][] = "Help and set-crontab are the only valid Cron Action";
        return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

    }

}