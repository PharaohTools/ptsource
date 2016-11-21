<?php

Namespace Model;

class StandardFeaturesLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    private $lm ;

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable Standard Features for this Project?"
            ),
            "php_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Is PHP code a part of this Source Code Project?"
            ),
            "html_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Is HTML a part of this Source Code Project?"
            ),
            "ptvirtualize_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Is configuration for Pharaoh Virtualize a part of this Source Code Project?"
            ),
            "ptconfigure_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Is configuration for Pharaoh Configure a part of this Source Code Project?"
            ),
            "pttest_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Is configuration for Pharaoh Test a part of this Source Code Project?"
            ),
            "pttrack_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Is configuration for Pharaoh Track a part of this Source Code Project?"
            ),
            "ptbuild_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Is configuration for Pharaoh Build a part of this Source Code Project?"
            ),
            "ptdeploy_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Is configuration for Pharaoh Deploy a part of this Source Code Project?"
            ),
            "ptmanage_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Is configuration for Pharaoh Manage a part of this Source Code Project?"
            ),
        );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());   }

    public function getEvents() {
        $ff = array();
        return $ff ; }


}