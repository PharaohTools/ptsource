<?php

Namespace Model;

class PullRequestCommentsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Comments") ;

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepository($this->params["item"]);
        return $r ;
    }

    public function getPullRequestComments($uname = null) {

        if ($uname === null) {
            $signupFactory = new \Model\Signup();
            $signup = $signupFactory->getModel($this->params);
            $me = $signup->getLoggedInUserData() ;
            $uname = $me->username;
        }

        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;

        $loggingFactory = new \Model\Logging() ;
        $logging = $loggingFactory->getModel($this->params) ;
        $parsed_filters = array() ;
//        $parsed_filters[] = array("where", "requestor", '=', $uname ) ;
        $parsed_filters[] = array("where", "pr_id", '=', $this->params["pr_id"] ) ;
        $parsed_filters[] = array("where", "repo_id", '=', $this->params["repository_slug"] ) ;

        if ($datastore->collectionExists('pull_request_comments') === false) {
            $column_defines = array(
                'id' => 'INTEGER PRIMARY KEY ASC',
                'title' => 'string',
                'pr_id' => 'string',
                'repo_id' => 'string',
                'requestor' => 'string',
                'created_on' => 'string',
                'last_changed' => 'string',
                'data' => 'string',
            );
            $logging->log("Creating Pull Request Comments Collection in Datastore", $this->getModuleName()) ;
            $datastore->createCollection('pull_request_comments', $column_defines) ; }

        $keys = $datastore->findAll('pull_request_comments', $parsed_filters) ;
//        $keys = $this->keyDecorator($keys) ;
        return $keys ;
    }


    public function attemptCreatePullRequestComment() {
        $valid = $this->validatePullRequestCommentDetails() ;
        if ($valid !== true) {
            return $valid ; }
        $createdPullRequestComment = $this->addThePullRequestComment() ;
        if ($createdPullRequestComment !== true) {
            return $createdPullRequestComment ; }

//        $prBase = new \Model\PullRequest() ;
//        $temp_params = $this->params ;
//        $temp_params['item'] = $this->params["repository_slug"] ;
//        $prOb = $prBase->getModel($temp_params) ;
        $all_prs = $this->getPullRequestComments() ;

        $return = array(
            "status" => true ,
            "message" => "Pull Request Comment Created",
            "pull_requests" => $all_prs);
        return $return ;

    }

    public function validatePullRequestCommentDetails() {
        // TODO i dont think this needs explaining
        return true ;
    }

    private function addThePullRequestComment() {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;

        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $au =$signup->getLoggedInUserData();

        $res = $datastore->insert('pull_requests', array(
//            "title" => $this->params["title"],
            "title" => '',
            'pr_id' => $this->params["pr_id"],
            'repo_pr_id' => $this->params["repository_slug"],
            'requestor' => $au->username,
            'created_on' => time(),
            'last_changed' => time(),
            'data' => $this->params["new_pull_request_comment"],
        )) ;

        if ($res === false) {
            $return = array(
                "status" => false ,
                "message" => "Unable to add this Pull Request to the Repository" );
            return $return ; }

        return true ;
    }

}