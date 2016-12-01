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
        $teamFeature = $teamFeatureFactory->getModel($this->params) ;
        $names = $teamFeature->getTeamFeatureNames();
        $team = $this->getTeam($this->params["item"]);
        $this->params["team_settings"] = $team["settings"];
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
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        if ($datastore->collectionExists('teams') == false) {
            $logging->log("Unable to delete team from non existent collection teams", $this->getModuleName()) ;
            return false ; }
        $res = $datastore->delete('teams', array("where", "team_slug", '=', $name)) ;
        return ($res==false) ? false : true ;
    }

    public function createTeam($name) {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $loggingFactory = new \Model\Logging() ;
        $this->params["echo-log"] = true ;
        $this->params["app-log"] = true ;
        $logging = $loggingFactory->getModel($this->params) ;

        if ($datastore->collectionExists('teams') == false) {
            $column_defines = array(
                'team_slug' => 'string',
                'team_name' => 'string',
                'team_description' => 'string',
                'team_client' => 'string',
                'team_creator' => 'string',
                'team_owner' => 'string',
                'team_members' => 'string',
                'milestones' => 'string',
                'team_source' => 'string',
                'current_state' => 'string',
                'team_public_scope_enabled' => 'string',
                'team_public_home_enabled' => 'string',
                'team_public_issue_enabled' => 'string',
                'team_public_comments_enabled' => 'string',
            );
            $logging->log("Creating Teams Collection in Datastore", $this->getModuleName()) ;

            $datastore->createCollection('teams', $column_defines) ; }

        $logging->log("Creating New Team {$name} in Collection ".'teams', $this->getModuleName()) ;

        $res = $datastore->insert('teams', array(
            "team_slug"=>$name,
            "team_owner"=>$name,
        )) ;

        return ($res==false) ? false : true ;

    }


}
