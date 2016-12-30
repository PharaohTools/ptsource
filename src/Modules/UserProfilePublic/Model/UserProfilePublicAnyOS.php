<?php

Namespace Model;

class UserProfilePublicAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params);
	}

    public function getData() {
        $ret['user'] = $this->getUserDetails();
        $ret['email_users_enabled'] = $this->getEnabledStatus();
        $ret['all_repositories'] = $this->getRepositories();
        $ret['my_repositories'] = $this->getMyRepositories($ret['all_repositories'], $ret['user']);
        $ret['my_member_repositories'] = $this->getMemberRepositories($ret['all_repositories'], $ret['user']);
        $ret['recent_contributions'] = array();
        $ret['contribution_activity'] = array();
        return $ret ;
    }

    public function getUserDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $oldData=$signup->getLoggedInUserData();
        return $oldData;
    }

    public function getRepositories() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $repos = $repository->getRepositories();
        return $repos ;
    }

    public function getMyRepositories($all_repos, $user) {
        foreach ($all_repos as $one_repo) {
            if ($one_repo["project-owner"] == $user->username) {
                $my_repos[] = $one_repo ; } }
        return $my_repos ;
    }

    public function getMemberRepositories($all_repos, $user) {
        foreach ($all_repos as $one_repo) {
            $repo_members = explode(",", $one_repo["project-members"]) ;
            if ( in_array($user->username, $repo_members)) {
                $member_repos[] = $one_repo ; } }
        return $member_repos ;
    }

    public function getEnabledStatus() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $rid = $signup->getUserRole($me->email);
        if ($rid == 1) {
            $au =$signup->getUsersData();
            return $au;  }
        return false ;
    }

    public function getAllUserDetails() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        $me = $signup->getLoggedInUserData() ;
        $rid = $signup->getUserRole($me->email);
        if ($rid == 1) {
            $au =$signup->getUsersData();
            return $au;  }
        return false ;
    }

    public function checkLoginSession() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params);
        return $signup->checkLoginSession();
    }

}
