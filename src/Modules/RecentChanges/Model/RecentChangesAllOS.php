<?php

Namespace Model;

class RecentChangesAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "recent_changes_enabled" =>
            	array(
                	"type" => "boolean",
                	"optional" => true,
                	"name" => "Enable Recent Change Tracking" ),
          );
          return $ff ; }

    public function getEventNames() {
        return array_keys($this->getEvents());   }

    public function getEvents() {
        $ff = array("recentChanges" => array("runRecentChanges"));
        return $ff ; }

    public function getReportData() {
        $pipeFactory = new \Model\Pipeline();
        $pipeline = $pipeFactory->getModel($this->params);
        $thisPipe = $pipeline->getPipeline($this->params["item"]);
        $settings = $thisPipe["settings"];
        $mn = $this->getModuleName() ;
        $dir = $settings[$mn]["Report_Directory"];
        $data = 'Here\'s the report of recent changes' ;
        $ff = array("report" => $data);
        return $ff ;
    }

    public function runRecentChanges() {
        return true ;
    }

}
