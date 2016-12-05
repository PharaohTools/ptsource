<?php

Namespace Model;

class SourceHomeAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;


    public function getData() {
        $ret["all_repositories"] = $this->getRepositories();
        $ret["latest_commits"] = $this->getLatestCommits($ret["all_repositories"]);
        $ret["latest_issues"] = $this->getLatestIssueLinks($ret["all_repositories"]);
        $ret["user"] = $this->getLoggedInUser();
        if ($ret["user"] !== false) {
            $ret["my_owned_repositories"] = $this->getMyRepositoriesCount($ret["all_repositories"], $ret["user"]);
            $ret["my_member_repositories"] = $this->getMemberRepositoriesCount($ret["all_repositories"], $ret["user"]);
            $ret["all_teams"] = $this->getTeams();
            $ret["my_owned_teams"] = $this->getMyTeamsCount($ret["all_teams"], $ret["user"]);
            $ret["my_member_teams"] = $this->getMemberTeamsCount($ret["all_teams"], $ret["user"]); }
        return $ret ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }

    public function getRepositories() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $repos = $repository->getRepositories();
        return $repos ;
    }

    public function getLatestCommits($repos) {
        $repositoryFactory = new \Model\Repository() ;
        $repositoryCommits = $repositoryFactory->getModel($this->params, "RepositoryCommits");
        $cur_commits = array() ;
        foreach($repos as $repo_slug => $repo_details) {
            $rcv = $repositoryCommits->getCommits($repo_slug, 50000, null, null, true) ;
            $cur_commits[$repo_slug] = $rcv["commits"] ; }
        $timestamps = array() ;
        $all_in_list = array();
        foreach ($cur_commits as $slug => $commit_set) {
            foreach ($commit_set as $commit) {
                $new_commit = $commit ;
                $new_commit["repo_slug"] = $slug ;
                $new_commit["repo_name"] = $repos[$new_commit["repo_slug"]]["project-name"] ;
                $new_commit["timestamp"] = strtotime($commit["date"]) ;
                $timestamps[] = $new_commit["timestamp"] ;
                $all_in_list[] = $new_commit ; } }
        $sorted = array_multisort($timestamps, SORT_DESC, $all_in_list);
        $new_list = array_slice($all_in_list, 0, 25) ;
        return $new_list ;
//        return $all_in_list ;
    }



    public function getLatestIssueLinks($repos) {
        // track.pharaoh.tld/index.php?control=IssueList&action=show&item=5&output-format=JSON

        // it will be module, values, link
        // need a trackJobWatcher or something. We put in the server url and job id
        // it will create uniter code to pull the issues dynamically

        $repositoryFactory = new \Model\Repository() ;
        $all_features = array() ;
        foreach($repos as $repo_slug => $repo_details) {
            $tp = $this->params ;
            $tp["item"] = $repo_slug ;
            $repository = $repositoryFactory->getModel($tp);
            $features = $repository->getRepositoryFeatures();
            var_dump("<pre>", $repo_slug, $features, "</pre>") ; }
        return $all_features ;
    }

    public function getTeams() {
        $teamFactory = new \Model\Team() ;
        $team = $teamFactory->getModel($this->params);
        $repos = $team->getTeams();
        return $repos ;
    }

    public function getMyRepositoriesCount($all_repos, $user) {
        $my_repos = 0 ;
        foreach ($all_repos as $one_repo) {
            if ($one_repo["project-owner"] == $user->username) {
                $my_repos ++ ; } }
        return $my_repos ;
    }

    public function getMemberRepositoriesCount($all_repos, $user) {
        $member_repos = 0 ;
        foreach ($all_repos as $one_repo) {
            $repo_members = explode(",", $one_repo["project-members"]) ;
            if ( in_array($user->username, $repo_members)) {
                $member_repos ++ ; } }
        return $member_repos ;
    }

    public function getMyTeamsCount($all_teams, $user) {
        $my_teams = 0 ;
        foreach ($all_teams as $one_team) {
            if ($one_team["project-owner"] == $user->username) {
                $my_teams ++ ; } }
        return $my_teams ;
    }

    public function getMemberTeamsCount($all_teams, $user) {
        $member_teams = 0 ;
        foreach ($all_teams as $one_team) {
            $team_members = explode(",", $one_team["project-members"]) ;
            if ( in_array($user->username, $team_members)) {
                $member_teams ++ ; } }
        return $member_teams ;
    }

    public function findModuleNames($params) {
        if (isset($this->params["compatible-only"]) && $this->params["compatible-only"]=="true") {
            return $this->findOnlyCompatibleModuleNames($params); }
        if (isset($this->params["only-compatible"]) && $this->params["only-compatible"]=="true") {
            return $this->findOnlyCompatibleModuleNames($params); }
        return $this->findAllModuleNames() ;
    }

    private function findAllModuleNames() {
        $allInfoObjects = \Core\AutoLoader::getInfoObjects() ;
        $moduleNames = array() ;
        foreach ($allInfoObjects as $infoObject) {
            $array_keys = array_keys($infoObject->routesAvailable()) ;
            $miniRay = array() ;
            $miniRay["command"] = $array_keys[0] ;
            $miniRay["name"] = $infoObject->name ;
            $miniRay["hidden"] = $infoObject->hidden ;
            $moduleNames[] = $miniRay ; }
        return $moduleNames;
    }

    private function findOnlyCompatibleModuleNames($params) {
        $allModules = $this->findAllModuleNames() ;
        $controllerBase = new \Controller\Base();
        $errors = $controllerBase->checkForRegisteredModels($params, $allModules) ;
        $compatibleModules = array();
        foreach($allModules as $oneModule) {
            if (!in_array($oneModule["command"], $errors)) {
                $compatibleModules[] = $oneModule ; } }
        return $compatibleModules;
    }

}