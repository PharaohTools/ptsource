<?php

Namespace Model;

class GitLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getStepTypes() {
        return array_keys($this->getFormFields());
    }

    public function getFormFields() {
        $ff = array(
            "gitclonedefault" => array(
                "type" => "boolean",
                "name" => "Git clone using default repo",
                "slug" => "defaultrepo" ),
            "gitclonedir" => array(
                "type" => "text",
                "name" => "Clone Directory",
                "slug" => "clonedir" ),
        );
        return $ff ;
    }

    public function executeStep($step) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if ( $step["steptype"] == "gitclonedefault") {
            $repo = $this->params["build-settings"]["PollSCM"]["git_repository_url"] ;
            $branch = $this->params["build-settings"]["PollSCM"]["git_branch"] ;
            $logging->log("Running Git clone from default repo $repo to ".getcwd()."...", $this->getModuleName()) ;

            $dn = dirname(dirname(__FILE__)).'/Libraries/git-wrapper/vendor/autoload.php';
            require_once $dn ;
            $wrapper = new \GitWrapper\GitWrapper();

// Clone a repo into `/path/to/working/copy`, get a working copy object.
            $git = $wrapper->clone($repo, getcwd());
            print $git->getOutput();
            return true ;}
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in Git Module", $this->getModuleName()) ;
            return false ; }
    }

}
