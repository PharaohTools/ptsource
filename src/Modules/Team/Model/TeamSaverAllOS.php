<?php

Namespace Model;

class TeamSaverAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("TeamSaver") ;

    public function saveTeam($save) {
        $r = $this->saveStates($save);
        return $r ;
    }

    public function getTeamNames() {
        $teams = $this->getTeams() ;
        $names = array_keys($teams) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

    private function saveStates($save) {
        $saveRes = array() ;
        $saveRes["defaults"] = $this->saveDefaults($save) ;
        return $saveRes ;
    }

    private function saveDefaults($save) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (isset($save["type"]) && $save["type"] == "Defaults") {

            $eventRunnerFactory = new \Model\EventRunner() ;
            $eventRunner = $eventRunnerFactory->getModel($this->params) ;
            $ev = $eventRunner->eventRunner("saveTeamDefaults") ;
            // @todo handle this
            if ($ev == false) {
                // return $this->failTrack() ;
            }

            $datastoreFactory = new \Model\Datastore() ;
            $datastore = $datastoreFactory->getModel($this->params) ;

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
                'team_public_issue_enabled' => 'string',
                'team_public_comments_enabled' => 'string',
                'team_public_scope_enabled' => 'string',
                'team_public_home_enabled' => 'string',
            );

            $newData = array() ;
            $columns = array_keys($column_defines) ;
            foreach ($columns as $column) {
                if (array_key_exists($column, $save["data"])) {
                    $newData[$column] = (isset($save["data"][$column])) ? $save["data"][$column] : "" ; } }

            $loggingFactory = new \Model\Logging() ;
            $this->params["echo-log"] = true ;
            $this->params["app-log"] = true ;
            $logging = $loggingFactory->getModel($this->params) ;

            if ($datastore->collectionExists('teams') == false) {
                $logging->log("Creating Teams Collection in Datastore", $this->getModuleName()) ;
                $datastore->createCollection('teams', $column_defines) ; }

            $clause = array("team_slug" => $save["data"]["team_slug"]) ;

            return $datastore->update('teams', $clause, $newData) ;

            // return $datastore->insert('teams', $newdata) ;
        }
        return false ;
    }

}