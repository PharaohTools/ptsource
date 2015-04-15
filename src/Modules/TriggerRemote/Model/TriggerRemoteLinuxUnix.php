<?php

Namespace Model;

class TriggerRemoteLinuxUnix extends Base {

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
            "trigger-remote-http" => array(
                "type" => "boolean",
                "name" => "Allow Trigger By Remote HTTP?",
                "optional" => true ),
            "trigger-remote-cli" => array(
                "type" => "boolean",
                "name" => "Allow Trigger By CLI?",
                "optional" => true ),
            "trigger-web" => array(
                "type" => "boolean",
                "name" => "Allow Trigger By Web Interface?",
                "optional" => true ),
        );
        return $ff ;
    }

	public function getStepTypes() {
        return array_keys($this->getFormFields());
    }
	
	public function getFormFields() {
        $ff = array(
            "shelldata" => array(
                "type" => "textarea",
                "name" => "Trigger Remote Shell Data",
                "slug" => "data" ),
            "shellscript" => array(
                "type" => "text",
                "name" => "Trigger Remote Shell Script",
                "slug" => "script" ),
        );
        return $ff ;
    }

    public function executeStep($step) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if ( $step["steptype"] == "trigger-remote-data") {
            $logging->log("Running TriggerRemote from Data...") ;
			$output = array();
			$rc = -1;
			exec($step["data"], $output, $rc);
			foreach ($output as $val) { echo $val.'<br />'; }
            return (intval($rc) === 0) ? true : false ; }
        else if ( $step["steptype"] == "trigger-remote-script") {
            $logging->log("Running TriggerRemote from Script...") ;
            $this->executeAsTriggerRemote($step["script"]) ;
            return true ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in TriggerRemote Module") ;
            return false ; }
    }

}
