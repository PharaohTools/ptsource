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


    public function getData() {
        $ret["scheduled"] = $this->getPipelinesRequiringExecution();
        $ret["executions"] = $this->executePipes();
        return $ret ;
    }

    private function executePipes() {
        $psts = $this->getPipelinesWithScheduledTasks() ;
        $psrxs = array() ;
        foreach ($psts as $pst) {
            $prx = $this->pipeRequiresExecution($pst) ;
            if ($prx == true) {
                $psrxs[] = $pst ; } }
        return $psrxs;
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
                else { return false ; }
                break ;
            case "hour" :
                if ($value == "*" && (($time - $lastRun) > 1800)) { return true ; }
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
