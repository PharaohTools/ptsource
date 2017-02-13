<?php

Namespace Model;

class RepositoryPullRequestsCreatePullRequestAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("CreatePullRequest") ;

    public function getData() {
        $ret["data"] = $this->createPullRequest();
        return $ret ;
    }

    public function createPullRequest() {
        $valid = $this->validatePullRequestDetails() ;
        if ($valid !== true) {
            return $valid ; }
        $createdPullRequest = $this->addThePullRequest() ;
        if ($createdPullRequest !== true) {
            return $createdPullRequest ; }

        $prBase = new \Model\RepositoryPullRequests() ;
        $temp_params = $this->params ;
        $temp_params['item'] = $this->params["repository_slug"] ;
        $prOb = $prBase->getModel($temp_params) ;
        $all_prs = $prOb->getRepositoryPullRequests() ;

        $return = array(
            "status" => true ,
            "message" => "Pull Request Created",
            "pull_requests" => $all_prs);
        return $return ;

    }

    public function validatePullRequestDetails() {
        // TODO i dont think this needs explaining
        return true ;
    }

    private function addThePullRequest() {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;

        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $au =$signup->getLoggedInUserData();

        $res = $datastore->insert('pull_requests', array(
            "title" => $this->params["new_pull_request_title"],
            'repo_pr_id' => $this->params["repository_slug"],
            'requestor' => $au->username,
            'created_on' => time(),
            'last_changed' => time(),
            'source_branch' => $this->params["source_branch"],
            'source_commit' => $this->params["source_commit"],
            'target_branch' => $this->params["target_branch"],
            'description' => $this->params["new_pull_request_description"],
        )) ;

        if ($res === false) {
            $return = array(
                "status" => false ,
                "message" => "Unable to add this Pull Request to the Repository" );
            return $return ; }

        return true ;
    }

}
