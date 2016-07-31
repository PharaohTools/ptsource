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

}
