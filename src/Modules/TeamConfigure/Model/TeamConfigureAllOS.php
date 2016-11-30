<?php

Namespace Model;

class TeamConfigureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    private $builder ;
    private $builderRepository ;

    public function __construct($params) {
        parent::__construct($params) ;
    }

    public function getData() {
        if (isset($this->params["item"])) { $ret["team"] = $this->getTeam(); }
        $ret["builders"] = $this->getBuilders();
        $ret["settings"] = $this->getBuilderSettings();
        $ret["fields"] = $this->getBuilderFormFields();
        $ret["stepFields"] = $this->getStepBuildersFormFields();
        $ret["current_user_data"] = $this->getCurrentUserData();
        $ret["available_users"] = $this->getUserNamesData();
        return $ret ;
    }

    public function getUserNamesData() {
        $usernames =array() ;
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $users = $signup->getUsersData() ;
        foreach ($users as $user) { $usernames[] = $user->username ; }
        return $usernames ;
    }

    public function getCurrentUserData() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $user = $signup->getLoggedInUserData();
        if ($user == false) { return false ; }
        return $user ;
    }

    public function isAdmin() {
        $user = $this->getCurrentUserData() ;
        if ($user == false) { return false ; }
        if ($user->role == 1) { return true ; }
        return false ;
    }

    public function getCopyData() {
        if (isset($this->params["item"])) { $ret["team"] = $this->getTeam(); }
        $teamFactory = new \Model\Team() ;
        $team = $teamFactory->getModel($this->params, "TeamRepository");
        $ret["pipe_names"] = $team->getTeamNames() ;
        return $ret ;
    }

    public function saveState() {
        return $this->saveTeam();
    }

    public function getTeam() {
        $teamFactory = new \Model\Team() ;
        $team = $teamFactory->getModel($this->params);
        return $team->getTeam($this->params["item"]);
    }

    private function getBuilder() {
        if (isset($this->builder) && is_object($this->builder)) {
            return $this->builder ;  }
        $builder = RegistryStore::getValue("builderObject") ;
        if (isset($builder) && is_object($builder)) {
            $this->builder = $builder ;
            return $this->builder ;  }
        $builderFactory = new \Model\Builder() ;
        $this->builder = $builderFactory->getModel($this->params);
        RegistryStore::setValue("builderObject", $this->builder) ;
        return $this->builder ;
    }

    private function getBuilderRepository() {
        if (isset($this->builderRepository) && is_object($this->builderRepository)) {
            return $this->builderRepository ;  }
        $builderRepository = RegistryStore::getValue("builderRepositoryObject") ;
        if (isset($builderRepository) && is_object($builderRepository)) {
            $this->builderRepository = $builderRepository ;
            return $this->builderRepository ;  }
        $builderRepositoryFactory = new \Model\Builder() ;
        $this->builderRepository = $builderRepositoryFactory->getModel($this->params, "BuilderRepository");
        \Model\RegistryStore::setValue("builderRepositoryObject", $this->builderRepository) ;
        return $this->builderRepository ;
    }

    public function getBuilders() {
        $this->getBuilder() ;
        return $this->builder->getBuilders();
    }

    public function getBuilderSettings() {
        $this->getBuilder() ;
        return $this->builder->getBuilderSettings();
    }

    public function getBuilderFormFields() {
        $this->getBuilderRepository() ;
        return $this->builderRepository->getAllBuildersFormFields();
    }

    public function getStepBuildersFormFields() {
        $this->getBuilderRepository() ;
        return $this->builderRepository->getStepBuildersFormFields();
    }

    public function saveTeam() {
        $this->params["team_slug"] = $this->getFormattedSlug() ;
        $this->params["item"] = $this->params["team_slug"] ;
        $teamFactory = new \Model\Team() ;
        $data = array(
            "team_name" => $this->params["team_name"],
            "team_slug" => $this->params["team_slug"],
            "team_description" => $this->params["team_description"]
        ) ;
        if ($this->isAdmin()==true){
            $data["team_owner"] = $this->params["team_owner"] ;
        }

        $ev = $this->runBCEvent("beforeTeamSave") ;
        if ($ev == false) { return false ; }


        if ($this->params["creation"] == "yes") {
            $data["team_creator"] = $this->params["team_creator"] ;
            $data["team_owner"] = $this->params["team_creator"] ;
            $teamDefault = $teamFactory->getModel($this->params);
            $teamDefault->createTeam($this->params["team_slug"]) ; }
        $teamSaver = $teamFactory->getModel($this->params, "TeamSaver");
        // @todo dunno why i have to force this param
        $teamSaver->params["item"] = $this->params["item"];
        $teamSaver->saveTeam(array("type" => "Defaults", "data" => $data ));
        // $teamSaver->saveTeam(array("type" => "Steps", "data" => $this->params["steps"] ));
        $teamSaver->saveTeam(array("type" => "Settings", "data" => $this->params["settings"] ));

        $ev = $this->runBCEvent("afterTeamSave") ;
        if ($ev == false) { return false ; }

        return true ;
    }

    protected function guessPipeName($orig) {
        $teamFactory = new \Model\Team() ;
        $team = $teamFactory->getModel($this->params, "TeamRepository");
        $pipe_names = $team->getTeamNames() ;
        $req = (isset($this->params["team_name"])) ? $this->params["team_name"] : $orig ;
        if (!in_array($req, $pipe_names)) { return $req ; }
        $guess = $req." REPO" ;
        for ($i=1 ; $i<5001; $i++) {
            $guess = "Copied Team $orig $i" ;
            if (!in_array($guess, $pipe_names)) {
                break ; } }
        return $guess ;
    }

    public function saveCopiedTeam() {
        if (!isset($this->params["source_team"])) {
            // we dont need to save anything if we have no source
            return false ; }

        $teamFactory = new \Model\Team() ;
        $teamDefault = $teamFactory->getModel($this->params);
        $sourcePipe = $teamDefault->getTeam($this->params["source_team"]) ;

        $pname = $this->guessPipeName($sourcePipe["team_slug"]);
        $this->params["item"] = $this->getFormattedSlug($pname);

        $tempParams = $this->params ;
        $tempParams["item"]  = $this->params["source_team"] ;
        $teamDefault = $teamFactory->getModel($tempParams);
        $sourcePipe = $teamDefault->getTeam($this->params["source_team"]) ;

        $useParam = isset($this->params["team_description"]) && strlen($this->params["team_description"])>0 ;
        $pdesc = ($useParam) ?
            $this->params["team_description"] :
            $sourcePipe["team_description"] ;

        // @todo we need to put all of this into modules, as build settings.
        $data = array(
            "team_name" => $pname,
            "team_slug" => $this->params["item"],
            "team_description" => $pdesc,

        ) ;

        $ev = $this->runBCEvent("beforeTeamSave") ;
        if ($ev == false) { return false ; }
        $ev = $this->runBCEvent("beforeCopiedTeamSave") ;
        if ($ev == false) { return false ; }

        $teamDefault->createTeam($this->params["item"]) ;
        $teamSaver = $teamFactory->getModel($this->params, "TeamSaver");
        // @todo dunno y i have to force this param
        $teamSaver->params["item"] = $this->params["item"];
        $teamSaver->saveTeam(array("type" => "Defaults", "data" => $data ));
        // $teamSaver->saveTeam(array("type" => "Steps", "data" => $sourcePipe["steps"] ));
        $teamSaver->saveTeam(array("type" => "Settings", "data" => $sourcePipe["settings"] ));

        $ev = $this->runBCEvent("afterTeamSave") ;
        if ($ev == false) { return false ; }
        $ev = $this->runBCEvent("afterCopiedTeamSave") ;
        if ($ev == false) { return false ; }

        return $this->params["item"] ;
    }

    private function runBCEvent($name) {
        $this->params["echo-log"] = true ;
        $eventRunnerFactory = new \Model\EventRunner() ;
        $eventRunner = $eventRunnerFactory->getModel($this->params) ;
        $ev = $eventRunner->eventRunner($name) ;
        if ($ev == false) { return false ; }
        return true ;
    }

    private function getFormattedSlug($name = null) {
        $tpn = (!is_null($name)) ? $name : $this->params["team_name"] ;
        if ($this->params["team_slug"] == "") {
            $this->params["team_slug"] = str_replace(" ", "_", $tpn);
            $this->params["team_slug"] = str_replace("'", "", $this->params["team_slug"]);
            $this->params["team_slug"] = str_replace('"', "", $this->params["team_slug"]);
            $this->params["team_slug"] = str_replace("/", "", $this->params["team_slug"]);
            $this->params["team_slug"] = strtolower($this->params["team_slug"]); }
        return $this->params["team_slug"] ;
    }

}
