<?php

Namespace Model;

class HiddenScopeAnyOS extends Base {

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
                "name" => "Hide this Repo?"
            ),
//            "hidden_to_all" =>
//            array(
//                "type" => "boolean",
//                "optional" => true,
//                "name" => "Hide from members also?"
//            ),
        );
        return $ff ;
    }


}