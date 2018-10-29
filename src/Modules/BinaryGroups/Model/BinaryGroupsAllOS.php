<?php

Namespace Model;

class BinaryGroupsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    private $lm ;
    private $pipeline ;

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable use of Groups in Binary Repository?"
            ),
            "allow_all_or_specific" =>
            array(
                "type" => "options",
                "optional" => false,
                "name" => "Allow any or specific group names to be uploaded?",
                "options" => array('allow_all', 'specific'),
                'js_change_function' => 'switch_binary_allow',
                'js_change_function_code' => '
                
                    function switch_binary_allow (hash, option) {
                        target_id = "settings[BinaryGroups]"+hash+"[allow_all_or_specific]" ;
                        target_element = document.getElementById(target_id) ;
                        target_element.value = option ;
                    }
                    
                ',
            ),
            "allowed_groups" =>
            array(
                "type" => "textarea",
                "optional" => true,
                "name" => "Specify Group Names to allow. Default download group is first."
            ),
            "allow_all_default" =>
            array(
                "type" => "text",
                "optional" => true,
                "name" => "Specify default Group Name when any are allowed"
            ),
        );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    // @todo need thee cron execution event to do this
    public function getEvents() {
        $ff = array(
            "prepareBuild" => array(
                "pollSCMChanges",
            ),
        );
        return $ff ;
    }

    protected function isWebAndSetAllowed() {
        $mn = $this->getModuleName() ;
        if ($this->isWebSapi() &&
            isset($this->params["build-settings"][$mn]["scm_always_allow_web"]) &&
            $this->params["build-settings"][$mn]["scm_always_allow_web"]=="on") {
            $this->lm->log ("SCM Polling ignored for next build for {$this->pipeline["project-name"]}, as its from a Web Request", $this->getModuleName() ) ;
            return true ; }
        return false ;
    }

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

    private function isWebSapi() {
        if (!in_array(PHP_SAPI, array("cli")))  { return true ; }
        return false ;
    }

}