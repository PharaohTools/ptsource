<?php

Namespace Model;

class TeamAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getTeams() {
        $teamFactory = new Team();
        $teamTeam = $teamFactory->getModel($this->params, "TeamRepository") ;
        $repositories = $teamTeam->getAllTeams();
        $ret = $repositories ;
        return $ret ;
    }

    public function getTeam($line) {
        $teamFactory = new Team();
        $teamCollater = $teamFactory->getModel($this->params, "TeamCollater") ;
        $team = $teamCollater->getTeam($line);
        $ret = $team ;
        return $ret ;
    }

    public function saveTeam($line) {
        $teamFactory = new Team();
        $teamSaver = $teamFactory->getModel($this->params, "TeamSaver") ;
        $team = $teamSaver->getTeam($line);
        $ret = $team ;
        return $ret ;
    }

    public function getTeamNames() {
        $repositories = $this->getTeams() ;
        $names = array_keys($repositories) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

    public function getTeamFeatures() {
        $teamFeatureFactory = new \Model\TeamFeature();
        $teamFeature = $teamFeatureFactory->getModel($this->params, "TeamFeature") ;
        $names = $teamFeature->getTeamFeatureNames();
        $team = $this->getTeam($this->params["item"]);
        $this->params["team-settings"] = $team["settings"];
        $enabledFeatures = array() ;
        $i = 0;
        foreach ($team["settings"] as $key => $values) {
            if (in_array($key, $names) && $values["enabled"] =="on") {
                $cname = '\Model\\'.$key ;
                $moduleFactory = new $cname();
                $moduleTeamFeature = $moduleFactory->getModel($this->params, "TeamFeature");
                // @ todo maybe an interface check? is object something?
//                $values=array("default_fieldset" =>array(0 => array($values))) ; }
                if (!isset($values["hash"])) { $values["hash"] = "12345" ; }
                $moduleTeamFeature->setValues($values) ;
                $moduleTeamFeature->setTeam($team) ;
                $collated = $moduleTeamFeature->collate();
                if (array_key_exists(0, $collated)==true) {
                    foreach ($collated as $one_collated) {
                        $enabledFeatures[$i]["module"] = $key  ;
                        $enabledFeatures[$i]["values"] = $values  ;
                        $enabledFeatures[$i]["model"] = $one_collated ;
                        $i++; } }
                else {
                    $enabledFeatures[$i]["module"] = $key  ;
                    $enabledFeatures[$i]["values"] = $values  ;
                    $enabledFeatures[$i]["model"] = $collated  ;
                    $i++; } } }

        return $enabledFeatures ;
    }

    public function deleteTeam($name) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists(REPODIR.DS.$name)) {
            $logging->log("Directory exists at ".REPODIR.DS."{$name}. Attempting removal.", $this->getModuleName()) ;
            $rc = self::executeAndGetReturnCode('rm -rf '.REPODIR.DS.$name);
            return $rc ; }
        else  {
            $logging->log("No directory exists at ".REPODIR.DS."$name to delete", $this->getModuleName()) ;
            return true ; }
    }

    public function createTeam($name) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists(REPODIR.DS.$name)) {
            $logging->log("Directory already exists at ".REPODIR.DS."{$name}. Exiting with failure.", $this->getModuleName()) ;
            return false ; }
        else  {
            $logging->log("Attempting to create directory ".REPODIR.DS."$name ", $this->getModuleName()) ;
            // @todo cross os
            $comms = array(
                'mkdir -p '.REPODIR.DS.$name,
                'git init --bare '.REPODIR.DS.$name,
                'cd '.REPODIR.DS.$name.'; git config http.recievepack true ;' ) ;
            $results = array() ;
            foreach ($comms as $comm) {
                $rc = self::executeAndGetReturnCode($comm);
                $results[] = ($rc["rc"] == 0) ? true : false ;
                if ($rc["rc"] != 0) {
                    $logging->log("Team creation command failed ".REPODIR.DS."$name ", $this->getModuleName(), LOG_FAILURE_EXIT_CODE) ;
                    $logging->log("Failed command was {$comm}", $this->getModuleName()) ;
                    return false ; } }
            return (in_array(false, $results)) ? false : true ; }
    }

}
