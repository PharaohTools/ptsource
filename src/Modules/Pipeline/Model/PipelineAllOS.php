<?php

Namespace Model;

class PipelineAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getPipelines() {
        $ret = array(
            "pipeline_1" => array(
                "project_title" => array("label" => "Project Title:", "value" => "My Project Title"),
                "project_description" => array("label" => "Project Description:", "value" => "My Project Description. What's the point of this one."),
                "steps" =>
                    array(
                        array(
                            "title" => "Build Step 1",
                            "type" => "BashShell",
                            // "title" => "Build Step 1",
                            "value" => "Lets do a git clone or something" ),
                        array(
                            "title" => "Build Step 2",
                            "type" => "Xvfb",
                            // "title" => "Build Step 1",
                            "value" => "The second build step. Lets start Xvfb, for instance" ), ), ),
            "other_project" => array(
                "project_title" => array("label" => "Project Title:", "value" => "Other Project"),
                "project_description" => array("label" => "Project Description:", "value" => "Some Other Project Description. What's the point of this one next."),
                "steps" =>
                array(
                    array(
                        "title" => "Build Step 1",
                        "type" => "BashShell",
                        // "title" => "Build Step 1",
                        "value" => "Lets do a git clone or something" ),
                    array(
                        "title" => "Build Step 2",
                        "type" => "Xvfb",
                        // "title" => "Build Step 1",
                        "value" => "The second build step. Lets start Xvfb, for instance" ), ), ),
        ) ;
        return $ret ;
    }

    public function getPipeline($line) {
        $pipelines = $this->getPipelines() ;
        $ret = $pipelines[$line] ;
        $r = (isset($ret) && is_array($ret)) ? $ret : false ;
        return $r ;
    }

    public function getPipelineNames() {
        $pipelines = $this->getPipelines() ;
        $names = array_keys($pipelines) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

}