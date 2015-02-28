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
            $logging->log("Running Git clone from default repo...", $this->getModuleName()) ;
            $repo = $this->params["build-settings"]["PollSCM"]["git_repository_url"] ;
            $branch = $this->params["build-settings"]["PollSCM"]["git_branch"] ;
            $branchMakeCommand = 'git clone '.$repo.' .';
            self::executeAndOutput($branchMakeCommand, $branchMakeCommand) ;
            $initCommand = 'echo $?';
            $rc1 = self::executeAndOutput($initCommand) ;
            $branchMakeCommand = 'git checkout '.$branch ;
            self::executeAndOutput($branchMakeCommand, $branchMakeCommand) ;
            $initCommand = 'echo $?';
            $rc2 = self::executeAndOutput($initCommand) ;
            return (strpos($rc1, 0)==0 && strpos($rc2, 0)==0) ? true : false ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in Git Module", $this->getModuleName()) ;
            return false ; }
    }

}
