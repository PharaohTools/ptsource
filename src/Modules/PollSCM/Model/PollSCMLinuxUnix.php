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

    private $lm ;

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
            "scm_always_allow_web" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Always allow builds from web interface, even without remote changes?"
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
        $this->params["php-log"] = true ;
        $this->lm = $loggingFactory->getModel($this->params);
        if ($this->checkBuildSCMPollingEnabled()) {
            return $this->doBuildSCMPollingEnabled() ; }
        else {
            return $this->doBuildSCMPollingDisabled() ; }
    }

    private function checkBuildSCMPollingEnabled() {
        $mn = $this->getModuleName() ;
        return ($this->params["build-settings"][$mn]["poll_scm_enabled"] == "on") ? true : false ;
    }

    private function doBuildSCMPollingDisabled() {
        $this->lm->log ("SCM Polling Disabled, ignoring...", $this->getModuleName() ) ;
        return true ;
    }

    private function doBuildSCMPollingEnabled() {
        $mn = $this->getModuleName() ;
        $this->lm->log ("SCM Polling Enabled, attempting...", $this->getModuleName() ) ;
        $this->collateAndRun() ;
        $enoughTime = $this->pollIfEnoughTimePassed() ;
        if ($enoughTime == true) {
            try {
                // @todo other scm types @kevellcorp do svn
                $lastSha = (isset($this->params["build-settings"][$mn]["last_sha"])) ? $this->params["build-settings"][$mn]["last_sha"] : null ;
                if (strlen($lastSha)>0) { $result = $this->doLastCommitStored() ; }
                else { $result = $this->doNoLastCommitStored() ; }
                return $result; }
            catch (\Exception $e) {
                $this->lm->log ("Error polling scm", $this->getModuleName() ) ;
                return false; } }
        else {
            return $enoughTime ; }
    }

    private function pollIfEnoughTimePassed() {
        $mn = $this->getModuleName() ;
        $time = time() ;
        $last_poll = $this->params["build-settings"][$mn]["last_poll_timestamp"] ;
        $exec_delay = $this->params["app-settings"][$mn]["exec_delay"] ;
        // check now - last poll time > exec delay
        if (($time - $last_poll ) > $exec_delay) {
            $this->lm->log ("Enough time passed since last run...", $this->getModuleName() ) ;
            return true ; }
        else {
            $this->lm->log ("Not enough time passed since last run, aborting...", $this->getModuleName() ) ;
            return false ; }
    }

    private function collateAndRun() {
        /*
         * collate all cron jobs due to run between check now + last poll time
         */
    }

    private function collateWaitingJobs() {
        $jobs = array() ;
        $allPipes = $this->getAllPipelines() ;
        foreach ($allPipes as $onePipe) {
            $isWaiting = $this->isPipeWaiting();
        }
        return $jobs ;
    }

    private function getAllPipelines() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipelines();
    }

    private function doLastCommitStored() {
        $mn = $this->getModuleName() ;
        $lastSha = (isset($this->params["build-settings"][$mn]["last_sha"])) ? $this->params["build-settings"][$mn]["last_sha"] : null ;
        $repo = $this->params["build-settings"][$mn]["git_repository_url"] ;
        $this->lm->log ("Last commit built was $lastSha", $this->getModuleName() ) ;
        $lsCommand = 'git ls-remote '.$repo ;
        $all = self::executeAndLoad($lsCommand) ;
        $curSha = substr($all, 0, strpos($all, "HEAD")-1);
        $this->lm->log ("Current remote commit is $curSha", $this->getModuleName() ) ;
        if ($lastSha == $curSha) {
            if (isset($this->params["build-settings"][$mn]["scm_always_allow_web"]) &&
                $this->params["build-settings"][$mn]["scm_always_allow_web"] =="on") {
                if (isset($this->params["build-request-source"]) && $this->params["build-request-source"]=="web" ) {
                    $this->lm->log ("Always allowing builds executed from web", $this->getModuleName() ) ;
                    $result = true ; }
                else {
                    $result = false ; } }
            else {
                $this->lm->log ("No remote changes", $this->getModuleName() ) ;
                $this->lm->log ("ABORTED EXECUTION", $this->getModuleName() ) ;
                $result = false; } }
        else {
            $this->lm->log ("Remote changes available", $this->getModuleName() ) ;
            $result = true ; }
        return $result ;
    }

    private function doNoLastCommitStored() {
        $mn = $this->getModuleName() ;
        $repo = $this->params["build-settings"][$mn]["git_repository_url"] ;
        $this->lm->log ("No last commit stored, assuming all remote changes", $this->getModuleName() ) ;
        $lsCommand = 'git ls-remote '.$repo ;
        $all = self::executeAndLoad($lsCommand) ;
        $curSha = substr($all, 0, strpos($all, "HEAD")-1);
        $this->lm->log ("Storing current remote commit ID $curSha", $this->getModuleName() ) ;
        $pipelineFactory = new \Model\Pipeline() ;
        $pipelineSaver = $pipelineFactory->getModel($this->params, "PipelineSaver");
        $this->params["build-settings"][$mn]["last_sha"] = $curSha ;
        $pipelineSaver->savePipeline(array("type" => "Settings", "data" => $this->params["build-settings"] ));
        $result = true ;
        return $result ;
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