<?php

Namespace Controller ;

class PipeRunner extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if (in_array($pageVars["route"]["action"], array("pipestatus", "service"))) {
            // @todo output format change not being implemented
            $this->content["params"]["output-format"] = strtoupper($pageVars["route"]["action"]);
            $this->content["route"]["extraParams"]["output-format"] = strtoupper($pageVars["route"]["action"]);
            $this->content["data"] = $thisModel->getServiceData();
            return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("termstatus", "termservice"))) {
            $this->content["params"]["output-format"] = strtoupper($pageVars["route"]["action"]);
            $this->content["route"]["extraParams"]["output-format"] = strtoupper($pageVars["route"]["action"]);
            $this->content["data"] = $thisModel->getTermServiceData();
            return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("findrunning"))) {
            // @todo output format change not being implemented
            $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "FindRunning") ;
            $this->content["params"]["output-format"] = "JSON";
            $this->content["route"]["extraParams"]["output-format"] = "JSON";
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"pipeRunnerFindRunning", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("history", "summary"))) {
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("child"))) {
            $this->content["pid"] = $thisModel->runChild();
            $this->content["data"] = $thisModel->getChildData();
            $this->content["route"]["extraParams"]["output-format"] = "CLI";
            return array ("type"=>"view", "view"=>"pipeRunnerChild", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("terminate"))) {
            $this->content["pid"] = $thisModel->runPipeTerminateCommand();
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"pipeRunnerTerminator", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("terminate-child"))) {
            $this->content["pid"] = $thisModel->terminateChild();
            $this->content["data"] = $thisModel->getChildData();
            $this->content["route"]["extraParams"]["output-format"] = "CLI";
            return array ("type"=>"view", "view"=>"pipeRunnerChild", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("show"))) {
            $result=$thisModel->runPipe(false);
            $this->content["pipex"] = $result;
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content); }

        if (in_array($pageVars["route"]["action"], array("start"))) {
            $result=$thisModel->runPipe();
            if ($result == "getParamValue") {
                $this->content["data"] = $thisModel->getData();
                return array ("type"=>"view", "view"=>"pipeRunnerGetValue", "pageVars"=>$this->content); }
            $this->content["pipex"] = $result;
            $this->content["data"] = $thisModel->getData();
            return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content); }


        return array ("type"=>"view", "view"=>"pipeRunner", "pageVars"=>$this->content);

    }

}
