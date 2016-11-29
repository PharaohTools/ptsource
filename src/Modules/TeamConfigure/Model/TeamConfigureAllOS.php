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
    private $builderTeam ;

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
        $team = $teamFactory->getModel($this->params, "TeamTeam");
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

//    public function getEventNames() {
//        return array_keys($this->getEvents());   }
//
//    public function getEvents() {
//        $ff = array(
//            "beforeTeamSave" => array(""),
//            "beforeCopiedTeamSave" => array(""),
//            "afterTeamSave" => array(""),
//            "afterCopiedTeamSave" => array(""),
//        );
//        return $ff ; }


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

    private function getBuilderTeam() {
        if (isset($this->builderTeam) && is_object($this->builderTeam)) {
            return $this->builderTeam ;  }
        $builderTeam = RegistryStore::getValue("builderTeamObject") ;
        if (isset($builderTeam) && is_object($builderTeam)) {
            $this->builderTeam = $builderTeam ;
            return $this->builderTeam ;  }
        $builderTeamFactory = new \Model\Builder() ;
        $this->builderTeam = $builderTeamFactory->getModel($this->params, "BuilderTeam");
        \Model\RegistryStore::setValue("builderTeamObject", $this->builderTeam) ;
        return $this->builderTeam ;
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
        $this->getBuilderTeam() ;
        return $this->builderTeam->getAllBuildersFormFields();
    }

    public function getStepBuildersFormFields() {
        $this->getBuilderTeam() ;
        return $this->builderTeam->getStepBuildersFormFields();
    }

    public function saveTeam() {
        $this->params["project-slug"] = $this->getFormattedSlug() ;
        $this->params["item"] = $this->params["project-slug"] ;
        $teamFactory = new \Model\Team() ;
        $data = array(
            "project-name" => $this->params["project-name"],
            "project-slug" => $this->params["project-slug"],
            "project-description" => $this->params["project-description"]
        ) ;
        if ($this->isAdmin()==true){
            $data["project-owner"] = $this->params["project-owner"] ;
        }

        $ev = $this->runBCEvent("beforeTeamSave") ;
        if ($ev == false) { return false ; }


        if ($this->params["creation"] == "yes") {
            $data["project-creator"] = $this->params["project-creator"] ;
            $data["project-owner"] = $this->params["project-creator"] ;
            $teamDefault = $teamFactory->getModel($this->params);
            $teamDefault->createTeam($this->params["project-slug"]) ; }
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
        $team = $teamFactory->getModel($this->params, "TeamTeam");
        $pipe_names = $team->getTeamNames() ;
        $req = (isset($this->params["project-name"])) ? $this->params["project-name"] : $orig ;
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

        $pname = $this->guessPipeName($sourcePipe["project-slug"]);
        $this->params["item"] = $this->getFormattedSlug($pname);

        $tempParams = $this->params ;
        $tempParams["item"]  = $this->params["source_team"] ;
        $teamDefault = $teamFactory->getModel($tempParams);
        $sourcePipe = $teamDefault->getTeam($this->params["source_team"]) ;

        $useParam = isset($this->params["project-description"]) && strlen($this->params["project-description"])>0 ;
        $pdesc = ($useParam) ?
            $this->params["project-description"] :
            $sourcePipe["project-description"] ;

        // @todo we need to put all of this into modules, as build settings.
        $data = array(
            "project-name" => $pname,
            "project-slug" => $this->params["item"],
            "project-description" => $pdesc,

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
        $tpn = (!is_null($name)) ? $name : $this->params["project-name"] ;
        if ($this->params["project-slug"] == "") {
            $this->params["project-slug"] = str_replace(" ", "_", $tpn);
            $this->params["project-slug"] = str_replace("'", "", $this->params["project-slug"]);
            $this->params["project-slug"] = str_replace('"', "", $this->params["project-slug"]);
            $this->params["project-slug"] = str_replace("/", "", $this->params["project-slug"]);
            $this->params["project-slug"] = strtolower($this->params["project-slug"]); }
        return $this->params["project-slug"] ;
    }

}
