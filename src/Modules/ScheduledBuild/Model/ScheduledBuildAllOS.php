<?php

Namespace Model;

class ScheduledBuildAllOS extends Base {

	// Compatibility
	public $os = array("any");
	public $linuxType = array("any");
	public $distros = array("any");
	public $versions = array("any");
	public $architectures = array("any");

	// Model Group
	public $modelGroup = array("Default");

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "scheduled_build_enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable running builds via schedule?"
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

    public function getData() {
        $ret["scheduled"] = $this->getPipelinesRequiringExecution();
        $ret["executions"] = $this->executePipes($ret["scheduled"]);
        return $ret ;
    }

    private function executePipes($pipes) {
        $prFactory = new \Model\PipeRunner() ;
        $results = array();
        foreach ($pipes as $pipe) {
            $params = $this->params ;
            $params["item"] = $pipe["project-slug"] ;
            $params["build-request-source"] = "schedule" ;
            $pr = $prFactory->getModel($params) ;
            $results[$pipe["project-slug"]] =
                array(
                    "name" => $pipe["project-name"],
                    "result" => $pr->runPipe()
                ) ;
        }
        return $results ;
    }

    public function getPipelinesRequiringExecution() {
        $psts = $this->getPipelinesWithScheduledTasks() ;
        $psrxs = array() ;
        foreach ($psts as $pst) {
            $prx = $this->pipeRequiresExecution($pst) ;
            if ($prx == true) {
                $psrxs[] = $pst ; } }
        return $psrxs;
    }

    public function pipeRequiresExecution($pst) {
        $cronString = $pst["settings"]["PollSCM"]["cron_string"] ;
        $cronString = rtrim($cronString) ;
        $cronString = ltrim($cronString) ;
        $lastRun = (isset($pst["settings"]["PollSCM"]["last_scheduled"]))
            ? $pst["settings"]["PollSCM"]["last_scheduled"]
            : 0 ;
        $cronParts = explode(" ", $cronString) ;
        $slots = array("minute", "hour", "dow", "dom", "month");
        $prx = array();
        for ($i=0; $i<count($cronParts); $i++) {
            $prx[$slots[$i]] = $this->slotShouldRun($slots[$i], $cronParts[$i], $lastRun) ; }
        return !in_array(false, $prx);
    }

    private function slotShouldRun($slot, $value, $lastRun) {
        $time = time();
        switch ($slot) {
            case "minute" :
                if ($value == "*" && (($time - $lastRun) > 60)) { return true ; }
                else if (is_int($value) == "*" && date('i')==$value) { return true ; }
                else { return false ; }
                break ;
            case "hour" :
                if ($value == "*" && (($time - $lastRun) > 1800)) { return true ; }
                else if ($value == "*" && date('H')==$value) { return true ; }
                else { return false ; }
                break ;
            case "dow" :
                //@todo
                if ($value == "*" && (($time - $lastRun) > 60)) { return true ; }
                else { return false ; }
                break ;
            case "dom" :
                //@todo
                if ($value == "*" && (($time - $lastRun) > 60)) { return true ; }
                else { return false ; }
                break ;
            case "month" :
                //@todo
                if ($value == "*" && (($time - $lastRun) > 60)) { return true ; }
                else { return false ; }
                break ;
            default :
                return false ; }
    }

    public function getPipelinesWithScheduledTasks() {
        $allPipelines = $this->getPipelines() ;
        $pst = array() ;
        foreach ($allPipelines as $onePipeline) {
            //@todo this should not be tied to only poll scm, so that we can cron/etc builds without polling
            if (isset($onePipeline["settings"]["PollSCM"]["poll_scm_enabled"]) &&
                $onePipeline["settings"]["PollSCM"]["poll_scm_enabled"] == "on") {
                $pst[] = $onePipeline ; } }
        return $pst;
    }

    public function getPipelines() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipelines();
    }

}
