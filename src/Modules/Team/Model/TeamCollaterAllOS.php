<?php

Namespace Model;

class TeamCollaterAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("TeamCollater") ;

    public function getTeam($pipe = null) {
        if ($pipe != null) { $this->params["item"] = $pipe ; }
        $r = $this->collate();
        return $r ;
    }

    private function collate() {
        $collated = array() ;
        $collated = array_merge($collated, $this->getDefaults()) ;
        $collated = array_merge($collated, $this->getSettings()) ;
        $collated = array_merge($collated, $this->getFeatures()) ;
        return $collated ;
    }

    public function getItem() {
        $item = array("item" => $this->params["item"]);
        return $item ;
    }

    private function getDefaults() {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $defaults = array() ;
        if (isset($this->params["item"])){
            $defaults = $datastore->findOne('teams', array(array("where", 'team_slug', "=", $this->params["item"]))) ;
            if ($this->userCanAccessTeam($defaults) === true) {
                return $defaults ; } }
        return $defaults ;
    }

    private function userCanAccessTeam($team) {
        $settings = $this->getSettings() ;
        if (isset($settings["Signup"]["signup_enabled"]) && $settings["Signup"]["signup_enabled"]=="on") {
            $signupFactory = new \Model\Signup() ;
            $signup = $signupFactory->getModel($this->params);
            $user = $signup->getLoggedInUserData();
            if ($user['role'] == 1) { return true ; }
            if ($team["team_owner"] == $user['username']) { return true ; }
            if (strpos($team["team_members"], $user['username'].',') !== false) { return true ; }
            if (strpos($team["team_members"], ','.$user['username']) !== false) { return true ; }
            return false ; }
        return true ;
    }

    private function getSettings() {
        $settings = array();
        $settingsFile = REPODIR.DS.$this->params["item"].DS.'settings' ;
        if (file_exists($settingsFile)) {
            $settingsFileData =  file_get_contents($settingsFile) ;
            $settings = json_decode($settingsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            // @todo this should be a warn log or something
//            $logging->log("No settings file available in team ".$this->params["item"], $this->getModuleName()) ;
        }
        return array("settings" => $settings) ;
    }

    private function getFeatures() {

        $teamFeatureFactory = new \Model\TeamFeature();
        $teamFeature = $teamFeatureFactory->getModel($this->params) ;
        $names = $teamFeature->getTeamFeatureNames();
        $teamSettings = $this->getSettings();
        $teamDefaults = $this->getDefaults();
        $this->params["team_settings"] = $teamSettings["settings"];
        $team = array() ;
        $team = array_merge($team, $teamSettings);
        $team = array_merge($team, $teamDefaults);
        $enabledFeatures = array() ;
        $i = 0;
        // error_log("collating 1") ;
        foreach ($teamSettings["settings"] as $key => $values) {
            // error_log("collating 2") ;
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
                //  error_log("collating 3") ;
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

        return array("features" => $enabledFeatures) ;
    }

}
