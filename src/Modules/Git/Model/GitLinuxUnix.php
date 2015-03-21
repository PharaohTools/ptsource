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
            "gitclonepoll" => array(
                "type" => "boolean",
                "name" => "Git clone using Polling repo",
                "slug" => "pollrepo" ),
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
        if ( $step["steptype"] == "gitclonepoll") {
            $repo = $this->params["build-settings"]["PollSCM"]["git_repository_url"] ;
            $branch = $this->params["build-settings"]["PollSCM"]["git_branch"] ;
            $targetDir = (isset($this->params["build-settings"]["PollSCM"]["target_dir"]))
                ? $this->params["build-settings"]["PollSCM"]["target_dir"]
                : getcwd() ;
            $logging->log("Running Git clone from default repo $repo to ".$targetDir."...", $this->getModuleName()) ;

            $cmd = PTDCOMM." GitClone clone --yes --guess --change-owner-permissions=false ".
                ' --repository-url="'.$repo.'"' ;

            if (strlen($targetDir > 0)) {
                $cmd .= ' --custom-clone-dir="'.$targetDir.'" ' ; }

            if (strlen($branch > 0)) {
                $cmd .= ' --custom-branch="'.$branch.'" ' ; }

            if (isset($this->params["build-settings"]["PollSCM"]["git_privkey_path"]) &&
                $this->params["build-settings"]["PollSCM"]["git_privkey_path"] != "")  {
                $logging->log("Adding Private Key for cloning Git", $this->getModuleName()) ;
                $cmd .= ' --private-key="'.$this->params["build-settings"]["PollSCM"]["git_privkey_path"].'" ' ; }

            self::executeAndOutput($cmd) ;
            $rc = self::executeAndLoad('echo $?') ;
            return $rc ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in Git Module", $this->getModuleName()) ;
            return false ; }
    }

}
