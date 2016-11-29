<?php

Namespace Model;

class TeamListAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret["teams"] = $this->getTeams();
        return $ret ;
    }

    public function getTeams() {
        $teamFactory = new \Model\Team() ;
        $team = $teamFactory->getModel($this->params);
        $repos = $team->getTeams();
        return $repos ;
    }

}