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
    private $pipeline ;

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
            "git_privkey_path" =>
            array(
                "type" => "text",
                "optional" => true,
                "name" => "Git Private Key Path?"
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
            "prepareBuild" => array(
                "pollSCMChanges",
            ),
        );
        return $ff ;
    }

    public function pollSCMChanges() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $this->params["php-log"] = true ;
        $this->pipeline = $this->getPipeline();
        $this->params["build-settings"] = $this->pipeline["settings"];
        $this->params["app-settings"]["app_config"] = \Model\AppConfig::getAppVariable("app_config");
        $this->params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
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
        $this->lm->log ("SCM Polling Enabled for {$this->pipeline["project-name"]}, attempting...", $this->getModuleName() ) ;
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
        $last_poll = isset($this->params["build-settings"][$mn]["last_poll_timestamp"])
            ? $this->params["build-settings"][$mn]["last_poll_timestamp"]
            : 0 ;
        $exec_delay = isset($this->params["app-settings"]["mod_config"][$mn]["exec_delay"])
            ? $this->params["app-settings"]["mod_config"][$mn]["exec_delay"]
            : 0 ;
        // check now - last poll time > exec delay
        if (($time - $last_poll ) > $exec_delay) {
            $this->lm->log ("Enough time passed since last run...", $this->getModuleName() ) ;
            return true ; }
        else {
            $this->lm->log ("Not enough time passed since last run, aborting...", $this->getModuleName() ) ;
            return false ; }
    }

    private function doLastCommitStored() {
        $mn = $this->getModuleName() ;
        $lastSha = (isset($this->params["build-settings"][$mn]["last_sha"])) ? $this->params["build-settings"][$mn]["last_sha"] : null ;
        $repo = $this->params["build-settings"][$mn]["git_repository_url"] ;
        $branch = $this->params["build-settings"][$mn]["git_branch"] ;
        $this->lm->log ("Last commit built was $lastSha", $this->getModuleName() ) ;

        $iString = "" ;
        $gitc = "git" ;
        if (isset($this->params["build-settings"]["PollSCM"]["git_privkey_path"]) &&
            $this->params["build-settings"]["PollSCM"]["git_privkey_path"] != "")  {
            $this->lm->log("Adding Private Key for cloning Git", $this->getModuleName()) ;
            $iString .= ' -i="'.$this->params["build-settings"]["PollSCM"]["git_privkey_path"].'" ' ;
            $gitc = "git-key-safe" ;}

        $lsCommand = $gitc.' '.$iString.' ls-remote '.$repo.' '.$branch ;
        $all = self::executeAndLoad($lsCommand) ;
        $curSha = substr($all, 0, strpos($all, "refs")-1);
        var_dump($all, $lsCommand, $curSha);
        $this->savePollSHAAndTimestamp($curSha);
        $this->lm->log ("Current remote commit is $curSha", $this->getModuleName() ) ;
        if ($lastSha == $curSha) {
            if (isset($this->params["build-settings"][$mn]["scm_always_allow_web"]) &&
                $this->params["build-settings"][$mn]["scm_always_allow_web"] =="on") {
                if (isset($this->params["build-request-source"]) && $this->params["build-request-source"]=="web" ) {
                    $this->lm->log ("Always allowing builds executed from web", $this->getModuleName() ) ;
                    $result = true ; }
                else {
                    $this->lm->log ("No remote changes", $this->getModuleName() ) ;
                    $result = false ; } }
            else {
                $this->lm->log ("No remote changes", $this->getModuleName() ) ;
                $result = false; } }
        else {
            $this->lm->log ("Remote changes available", $this->getModuleName() ) ;
            $result = true ; }
        return $result ;
    }

    private function doNoLastCommitStored() {
        $mn = $this->getModuleName() ;
        $repo = $this->params["build-settings"][$mn]["git_repository_url"] ;
        $branch = $this->params["build-settings"][$mn]["git_branch"] ;
        $this->lm->log ("No last commit stored, assuming all remote changes", $this->getModuleName() ) ;

        $iString = "" ;
        $gitc = "git" ;
        if (isset($this->params["build-settings"]["PollSCM"]["git_privkey_path"]) &&
            $this->params["build-settings"]["PollSCM"]["git_privkey_path"] != "")  {
            $this->lm->log("Adding Private Key for cloning Git", $this->getModuleName()) ;
            $iString .= ' -i "'.$this->params["build-settings"]["PollSCM"]["git_privkey_path"].'" ' ;
            $gitc = "git-key-safe" ;}

        $lsCommand = $gitc.' '.$iString.' ls-remote '.$repo.' '.$branch ;
        $all = self::executeAndLoad($lsCommand) ;

        $curSha = substr($all, 0, strpos($all, "refs")-1);
        $this->lm->log("dump $all, $lsCommand, $curSha", $this->getModuleName()) ;
        $this->savePollSHAAndTimestamp($curSha);
        $result = true ;
        return $result ;
    }

    private function savePollSHAAndTimestamp($curSha) {
        $this->lm->log ("Storing current remote commit ID $curSha", $this->getModuleName() ) ;
        $time = time();
        $this->lm->log ("Storing last poll timestamp $time", $this->getModuleName() ) ;
        $pipelineFactory = new \Model\Pipeline() ;
        $pipelineSaver = $pipelineFactory->getModel($this->params, "PipelineSaver");
        $this->params["build-settings"]["PollSCM"]["last_sha"] = $curSha ;
        $this->params["build-settings"]["PollSCM"]["last_poll_timestamp"] = $time ;
        $pipelineSaver->savePipeline(array("type" => "Settings", "data" => $this->params["build-settings"] ));
        $result = true ;
        return $result ;
    }

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}