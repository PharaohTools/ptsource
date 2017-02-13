<?php

Namespace Model;

class RepositoryPullRequestsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret = $this->getRepositoryPullRequests();
        $ret["repository"] = $this->getRepository();
        $ret["branches"] = $this->getAvailableBranches();
        $ret["pull_requests"] = $this->getRepositoryPullRequests();
        return $ret ;
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepository($this->params["item"]);
        return $r ;
    }

    public function getRepositoryPullRequests($uname = null) {

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
        $parsed_filters[] = array("where", "repo_pr_id", '=', $this->params["item"] ) ;

        if ($datastore->collectionExists('pull_requests') === false) {
            $column_defines = array(
                'pr_id' => 'INTEGER PRIMARY KEY ASC',
                'title' => 'string',
                'repo_pr_id' => 'string',
                'requestor' => 'string',
                'created_on' => 'string',
                'last_changed' => 'string',
                'source_branch' => 'string',
                'source_commit' => 'string',
                'target_branch' => 'string',
                'description' => 'string',
            );
            $logging->log("Creating Pull Requests Collection in Datastore", $this->getModuleName()) ;
            $datastore->createCollection('pull_requests', $column_defines) ; }

        $keys = $datastore->findAll('pull_requests', $parsed_filters) ;
//        $keys = $this->keyDecorator($keys) ;
        return $keys ;
    }

    public function getUserDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $oldData = $signup->getLoggedInUserData();
        return $oldData;
    }

    private function getAvailableBranches() {
        $filebrowserDir = $this->repoRootDir() ;
        $command = "cd {$filebrowserDir} && git branch" ;
        $all_branches_string = $this->executeAndLoad($command) ;
        $all_branches_string = str_replace('* ', "", $all_branches_string) ;
        $all_branches_string = str_replace(' ', "", $all_branches_string) ;
        $all_branches_ray = explode("\n", $all_branches_string) ;
        return $all_branches_ray ;
    }

    private function repoRootDir() {
        return REPODIR.DS.$this->params["item"].DS;
    }

}