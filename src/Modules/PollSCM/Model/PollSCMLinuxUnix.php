<?php

Namespace Model;

class PollSCMLinuxUnix extends Base {

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
            "poll_scm_enabled" =>
                array(
                    "type" => "boolean",
                    "optional" => true,
                    "name" => "Enable Polling of SCM Server?"
                ),
            "git_repository_url" =>
            array(
                "type" => "text",
                "optional" => true,
                "name" => "Git Repository URL?"
            ),
            "git_branch" =>
            array(
                "type" => "text",
                "optional" => true,
                "name" => "Git Branch?"
            ),
            "cron_string" =>
            array(
                "type" => "textarea",
                "optional" => true,
                "name" => "Crontab Values"
            ),
        );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterSettings" => array(
                "pollSCMChanges",
            ),
        );
        return $ff ;
    }

    public function pollSCMChanges() {

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $run = $this->params["run-id"];
        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = new \ArrayObject(json_decode($defaults));

        $file = PIPEDIR.DS.$this->params["item"].DS.'settings';
        $settings = file_get_contents($file) ;
        $settings = json_decode($settings, true);

        $pipeline = $this->getPipeline() ;
        $workspace = $this->getWorkspace() ;

        $mn = $this->getModuleName() ;

        if ($pipeline["settings"][$mn]["poll_scm_enabled"] == "on") {
            $logging->log ("SCM Polling Enabled, attempting...", $this->getModuleName() ) ;
            try {
                $logging->log ("Polling SCM Server", $this->getModuleName() ) ;
                $logging->log ("Changing Directory to workspace ".$workspace, $this->getModuleName() ) ;
                chdir("Changing Directory to workspace ".$workspace);
                // @todo other scm tpes
                $repo = $pipeline["settings"][$mn]["git_repository_url"] ;
                $branch = $pipeline["settings"][$mn]["git_branch"] ;
                $lastSha = (isset($pipeline["settings"][$mn]["last_sha"])) ? $pipeline["settings"][$mn]["last_sha"] : null ;
                if ($lastSha !== null) {
                    $initCommand = 'git init';
                    self::executeAndOutput($initCommand) ;
                    $branchMakeCommand = 'git remote add ptbuild-temp-polling-branch '.$repo ;
                    self::executeAndOutput($branchMakeCommand) ;
                    $pollCommand = 'git diff --name-only ptbuild-temp-polling-branch/'.$branch.' '.$lastSha;
                    self::executeAndOutput($pollCommand) ;
                    $pollCommand = 'git diff --name-only origin/master '.$lastSha;
                    self::executeAndOutput($pollCommand) ;
                    $branchDelCommand = 'git branch -D ptbuild-temp-polling-branch ';
                    self::executeAndOutput($branchDelCommand) ;
                    // an arra of resuls should all be rue
                    $result = true ; }
                else {
                    $logging->log ("No last commit stored", $this->getModuleName() ) ;
                    $result = true ;}
                if ($result == true) {
                    $_ENV["BUILD_SCM_CHANGE"] = true ;
                    $logging->log ("SCM polled successfully", $this->getModuleName() ) ; }
                else { $logging->log ("Error polling scm", $this->getModuleName() ) ; }
                return $result; }
            catch (\Exception $e) {
                $logging->log ("Error polling scm", $this->getModuleName() ) ;
                return false; } }
        else {
            $logging->log ("SCM Polling Disabled, ignoring...", $this->getModuleName() ) ;
            return true ; }

    }

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

    private function getWorkspace() {
        $workspaceFactory = new \Model\Workspace() ;
        $workspace = $workspaceFactory->getModel($this->params);
        return $workspace->getWorkspaceDir();
    }

}