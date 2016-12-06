<?php

Namespace Model;

class TrackIssuesAllOS extends Base {

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
            "enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable Following a Pharaoh Track Job?"
            ),
            "track_job_url" =>
            array(
                "type" => "text",
                "optional" => true,
                "name" => "Pharaoh Track Job URL?"
            ),
//            "use_credentials" =>
//            array(
//                "type" => "text",
//                "optional" => true,
//                "name" => "Use Credentials?"
//            ),
        );
        return $ff ;
    }

}