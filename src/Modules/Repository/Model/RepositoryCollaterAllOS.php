<?php

Namespace Model;

class RepositoryCollaterAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("RepositoryCollater") ;

    public function getRepository($pipe = null) {
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
            $logging->log("No defaults file available in repository", $this->getModuleName()) ; }
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
            $logging->log("No settings file available in repository ".$this->params["item"], $this->getModuleName()) ; }
        return array("settings" => $settings) ;
    }

    private function getFeatures() {

        $repositoryFeatureFactory = new \Model\RepositoryFeature();
        $repositoryFeatureRepository = $repositoryFeatureFactory->getModel($this->params, "RepositoryFeatureRepository") ;
        $names = $repositoryFeatureRepository->getRepositoryFeatureNames();
        $repositorySettings = $this->getSettings();
        $repositoryDefaults = $this->getDefaults();
        $this->params["repository-settings"] = $repositorySettings["settings"];
        $repository = array() ;
        $repository = array_merge($repository, $repositorySettings);
        $repository = array_merge($repository, $repositoryDefaults);
        $enabledFeatures = array() ;
        $i = 0;
        // error_log("collating 1") ;
        foreach ($repositorySettings["settings"] as $key => $values) {
            // error_log("collating 2") ;
            if (in_array($key, $names) && $values["enabled"] =="on") {
                $cname = '\Model\\'.$key ;
                $moduleFactory = new $cname();
                $moduleRepositoryFeature = $moduleFactory->getModel($this->params, "RepositoryFeature");
                // @ todo maybe an interface check? is object something?
//                $values=array("default_fieldset" =>array(0 => array($values))) ; }
                if (!isset($values["hash"])) { $values["hash"] = "12345" ; }
                $moduleRepositoryFeature->setValues($values) ;
                $moduleRepositoryFeature->setRepository($repository) ;
                $collated = $moduleRepositoryFeature->collate();
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
