<?php

Namespace Controller ;

class RepositoryPullRequests extends Base {

    public function execute($pageVars) {


        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) {
            return $this->failDependencies($pageVars, $this->content, $thisModel) ;
        }

        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($thisModel->params);
        $loginSession = $signup->checkLoginSession();

        if ($pageVars['route']['action'] === "new") {
            if($loginSession["status"] == TRUE){
                $this->content["data"] = $thisModel->getData();
                return array ("type"=>"view", "view"=>"RepositoryPullRequests", "pageVars"=>$this->content); }
            return array ("type"=>"view", "view"=>"RepositoryPullRequestsAlert", "pageVars"=>$this->content); }

        if ($pageVars['route']['action'] === "create") {
            if($loginSession["status"] == TRUE){
                // @todo output format change not being implemented
                $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "CreatePullRequest") ;
                $this->content["params"]["output-format"] = "JSON";
                $this->content['route']["extraParams"]["output-format"] = "JSON";
                $this->content["data"] = $thisModel->getData();
                return array ("type"=>"view", "view"=>"repositoryPullRequestsAPHAX", "pageVars"=>$this->content);  }
            return array ("type"=>"view", "view"=>"RepositoryPullRequestsAlert", "pageVars"=>$this->content); }

//        if ($pageVars['route']['action'] === "disable") {
//            if($loginSession["status"] == TRUE){
//                // @todo output format change not being implemented
//                $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "DisableKey") ;
//                $this->content["params"]["output-format"] = "JSON";
//                $this->content['route']["extraParams"]["output-format"] = "JSON";
//                $this->content["data"] = $thisModel->getData();
//                return array ("type"=>"view", "view"=>"repositoryPullRequestsAPHAX", "pageVars"=>$this->content);  }
//            return array ("type"=>"view", "view"=>"RepositoryPullRequestsAlert", "pageVars"=>$this->content); }
//
//        if ($pageVars['route']['action'] === "enable") {
//            if($loginSession["status"] == TRUE){
//                // @todo output format change not being implemented
//                $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "EnableKey") ;
//                $this->content["params"]["output-format"] = "JSON";
//                $this->content['route']["extraParams"]["output-format"] = "JSON";
//                $this->content["data"] = $thisModel->getData();
//                return array ("type"=>"view", "view"=>"repositoryPullRequestsAPHAX", "pageVars"=>$this->content);  }
//            return array ("type"=>"view", "view"=>"RepositoryPullRequestsAlert", "pageVars"=>$this->content); }

        if ($pageVars['route']['action'] === "delete") {
            if($loginSession["status"] == TRUE){
                // @todo output format change not being implemented
                $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "DeleteKey") ;
                $this->content["params"]["output-format"] = "JSON";
                $this->content['route']["extraParams"]["output-format"] = "JSON";
                $this->content["data"] = $thisModel->getData();
                return array ("type"=>"view", "view"=>"repositoryPullRequestsAPHAX", "pageVars"=>$this->content);  }
            return array ("type"=>"view", "view"=>"RepositoryPullRequestsAlert", "pageVars"=>$this->content); }

        if ($pageVars['route']['action'] === "show") {
            if($loginSession["status"] == TRUE){
                $this->content["data"] = $thisModel->getData();
                $this->content["userdata"] = $thisModel->getUserDetails();
                return array ("type"=>"view", "view"=>"RepositoryPullRequests", "pageVars"=>$this->content); }
            return array ("type"=>"view", "view"=>"RepositoryPullRequestsAlert", "pageVars"=>$this->content); }




    }

}