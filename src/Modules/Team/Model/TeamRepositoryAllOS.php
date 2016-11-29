<?php

Namespace Model;

class TeamRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("TeamRepository") ;

    public function getAllTeams() {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $teams = array() ;
        if ($datastore->collectionExists('teams')){
            $teams = $datastore->findAll('teams') ; }
        return $teams ;
    }

    public function getTeamNames() {
        $teams = $this->getAllTeams() ;
        $names = array() ;
        for ($i=0; $i<count($teams); $i++) { $names[] = $teams[$i]["team_name"] ; }
        return (isset($names) && is_array($names)) ? $names : array() ;
    }

    public function getTeamIDs() {
        $teams = $this->getAllTeams() ;
        $slugs = array() ;
        for ($i=0; $i<count($teams); $i++) { $slugs[] = $teams[$i]["team_slug"] ; }
        return (isset($slugs) && is_array($slugs)) ? $slugs : array() ;
    }

    public function getTeamCount() {
        $names = $this->getTeamNames() ;
        $team_count = count($names) ;
        return array("team_count" => $team_count) ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }

}