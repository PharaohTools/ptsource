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
        $logging = $loggingFactory->getModel($this->params);

        $workspace = $this->getWorkspace() ;

        $mn = $this->getModuleName() ;

        if ($this->params["build-settings"][$mn]["poll_scm_enabled"] == "on") {
            $logging->log ("SCM Polling Enabled, attempting...", $this->getModuleName() ) ;
            try {
                $logging->log ("Polling SCM Server", $this->getModuleName() ) ;
                $logging->log ("Changing Directory to workspace ".$workspace, $this->getModuleName() ) ;
                chdir("Changing Directory to workspace ".$workspace);
                // @todo other scm tpes
                $repo = $this->params["build-settings"][$mn]["git_repository_url"] ;
                $branch = $this->params["build-settings"][$mn]["git_branch"] ;
                $lastSha = (isset($this->params["build-settings"][$mn]["last_sha"])) ? $this->params["build-settings"][$mn]["last_sha"] : null ;
                if (strlen($lastSha)>0) {
                    $logging->log ("Last commit built was $lastSha", $this->getModuleName() ) ;
                    $lsCommand = 'git ls-remote '.$repo ;
                    $all = self::executeAndLoad($lsCommand) ;
                    $curSha = substr($all, 0, strpos($all, "HEAD")-1);
                    $logging->log ("Current remote commit is $curSha", $this->getModuleName() ) ;
                    if ($lastSha == $curSha) {
                        if (isset($this->params["build-settings"][$mn]["scm_always_allow_web"]) &&
                            $this->params["build-settings"][$mn]["scm_always_allow_web"] =="on") {
                            if (isset($this->params["build-request-source"]) && $this->params["build-request-source"]=="web" ) {
                                $logging->log ("Alwas allowing builds execued from web", $this->getModuleName() ) ;
                                $result = true ; }
                            else {
                                $result = false ; } }
                        else {
                            $logging->log ("No remote changes", $this->getModuleName() ) ;
                            $logging->log ("ABORTED EXECUTION", $this->getModuleName() ) ;
                            $result = false; }}
                    else {
                        $logging->log ("Remote changes available", $this->getModuleName() ) ;
                        $result = true ; } }
                else {
                    $logging->log ("No last commit stored, assuming all remote changes", $this->getModuleName() ) ;
                    $lsCommand = 'git ls-remote '.$repo ;
                    $all = self::executeAndLoad($lsCommand) ;
                    $curSha = substr($all, 0, strpos($all, "HEAD")-1);
                    $logging->log ("Storing current remote commit ID $curSha", $this->getModuleName() ) ;
                    $pipelineFactory = new \Model\Pipeline() ;
                    $pipelineSaver = $pipelineFactory->getModel($this->params, "PipelineSaver");
                    $this->params["build-settings"][$mn]["last_sha"] = $curSha ;
                    $pipelineSaver->savePipeline(array("type" => "Settings", "data" => $this->params["build-settings"] ));
                    $result = true ;}
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