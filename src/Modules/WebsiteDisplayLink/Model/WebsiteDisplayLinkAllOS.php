<?php

Namespace Model;

class WebsiteDisplayLinkAllOS extends Base {

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
                	"name" => "Display Website Link?"
            ),
            "fieldsets" => array(
                "websites" => array(
                    "url" =>
                    array(   "type" => "text",
                        "name" => "Website URL",
                        "slug" => "siteurl"),
                    "title" =>
                    array(   "type" => "text",
                        "name" => "Website Title",
                        "slug" => "sitetitle"),
                )
            )
        );
          return $ff ;}
   
    public function getEventNames() {
        return array_keys($this->getEvents());   }

	public function getEvents() {
		$ff = array();
		return $ff ; }

}
