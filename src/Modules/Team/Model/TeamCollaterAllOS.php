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
        $defaults = array() ;
        $defaultsFile = REPODIR.DS.$this->params["item"].DS.'defaults' ;
        if (file_exists($defaultsFile)) {
            $defaultsFileData =  file_get_contents($defaultsFile) ;
            $defaults = json_decode($defaultsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            // @todo this should be a warn log or something
//            $logging->log("No defaults file available in team", $this->getModuleName()) ;
        }
        $defaults = $this->setDefaultSlugIfNeeded($defaults) ;
        return $defaults ;
    }

    private function setDefaultSlugIfNeeded($defaults) {
        if (!isset($defaults["project-slug"])) {
            $defaults["project-slug"] = $this->params["item"] ; }
        if (isset($defaults["project-slug"]) && $defaults["project-slug"] == "") {
            $defaults["project-slug"] = $this->params["item"] ; }
        return $defaults ;
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
        $this->params["team-settings"] = $teamSettings["settings"];
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
