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
        $ret["pipelines"] = "" ; //$this->getPipelines();
        return $ret ;
    }

    public function getPipelinesRequiringExecution() {
        $psts = $this->getPipelinesWithScheduledTasks() ;
        $psrxs = array() ;
        foreach ($psts as $pst) {
            if ($this->pipeRequiresExecution($pst) == true) {
                $psrxs[] = $pst ; } }
        return $psrxs;
    }

    public function pipeRequiresExecution($pst) {
        $cronString = $pst["settings"]["PollSCM"]["poll_scm_enabled"] ;
        $lastRun = $pst["settings"]["PollSCM"]["last_poll_timestamp"] ;
        $cronParts = explode(" ", $cronString) ;
        $slots = array("minute", "hour", "dow", "dom", "month");
        $partsDone = array() ;
        for ($i=0; $i<count($cronParts); $i++) {
            $partsDone[$slots[$i]] = $cronParts[$i] ;
            var_dump($partsDone[$slots[$i]]) ; }
        return false;
    }

    /*
     *
     * This field follows the syntax of cron (with minor differences). Specifically, each line consists of 5 fields separated by TAB or whitespace:
MINUTE HOUR DOM MONTH DOW
MINUTE	Minutes within the hour (0–59)
HOUR	The hour of the day (0–23)
DOM	The day of the month (1–31)
MONTH	The month (1–12)
DOW	The day of the week (0–7) where 0 and 7 are Sunday.
To specify multiple values for one field, the following operators are available. In the order of precedence,

* specifies all valid values
M-N specifies a range of values
M-N/X or * / m       X steps by intervals of X through the specified range or whole valid range
A,B,...,Z enumerates multiple values
To allow periodically scheduled tasks to produce even load on the system, the symbol H (for “hash”) should be used wherever possible. For example, using 0 0 * * * for a dozen daily jobs will cause a large spike at midnight. In contrast, using H H * * * would still execute each job once a day, but not all at the same time, better using limited resources.
     *
     */

    public function getPipelinesWithScheduledTasks() {
        $allPipelines = $this->getPipelines() ;
        $pst = array() ;
        foreach ($allPipelines as $onePipeline) {
            if ($onePipeline["settings"]["poll_scm_enabled"] == "on") {
                $pst[] = $onePipeline ; } }
        return $pst;
    }

    public function getPipelines() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipelines();
    }

}
