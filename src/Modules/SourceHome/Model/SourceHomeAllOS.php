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