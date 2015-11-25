<?php

Namespace Model;

class PipeRunnerFindRunningAllOS extends Base {

	// Compatibility
	public $os = array("any");
	public $linuxType = array("any");
	public $distros = array("any");
	public $versions = array("any");
	public $architectures = array("any");

	// Model Group
	public $modelGroup = array("FindRunning");

	public function getData() {
		$ret["running_builds"] = $this->getRunningBuilds();
		return $ret;
	}

    private function getSwitchUser() {
        $modConfig = \Model\AppConfig::getAppVariable("mod_config");
        if (isset($modConfig["UserSwitching"]["switching_user"])) {
            return $modConfig["UserSwitching"]["switching_user"] ; }
        else {
            return false ; }
    }

    public function getRunningBuilds() {
        $runningBuilds = $newRunningBuilds = $this->getAllRunningBuilds() ;
        if (isset($this->params["pipeline"])) {
            $newRunningBuilds = array() ;
            foreach ($runningBuilds as $runningBuild) {
                if ($runningBuild["item"] == $this->params["pipeline"]) {
                    $newRunningBuilds[] = $runningBuild ; } } }
        return $newRunningBuilds  ;
    }

    public function getAllRunningBuilds() {
        $switch = $this->getSwitchUser() ;
        $cmd = "" ;
        if ($switch != false) { $cmd .= 'sudo su '.$switch.' -c '."'" ; }
        $cmd .= 'ps aux | grep "piperunner child" ' ;
        if ($switch != false) { $cmd .= "'" ; }
        $all = $this->executeAndLoad($cmd) ;
        $lines = explode("\n", $all) ;
        $runningBuilds = array() ;
        foreach($lines as &$line) {
            if ($line == '') {
                unset ($line);
                continue ; }
            if (strpos($line, 'grep piperunner child')) {
                unset ($line);
                continue ; }
            if (strpos($line, 'grep "piperunner child"')) {
                unset ($line);
                continue ; }
            $runningBuilds[] = $this->getRunningBuildArrayFromLine($line) ; }
        return $runningBuilds  ;
    }

    public function getRunningBuildArrayFromLine($line) {

        // @todo look at php strpos syntax
        $pdstart = strpos($line, "--pipe-dir=")+11;
        $pdend = strpos($line, " ", $pdstart);
        $pds = substr($line, $pdstart, ($pdend - $pdstart));

        $userstart = 0;
        $userend = strpos($line, " ");
        $users = substr($line, $userstart, ($userend - $userstart));

        // @todo this logic is wrong
//        $pidstart = strpos($line, "--pipe-dir=")+11;
//        $pidend = strpos($line, " ", $pidstart);
//        $pids = substr($line, $pidstart, ($pidend - $pidstart));
//        error_log(implode("\n\n", $thisPipe["settings"])) ;

        $ridstart = strpos($line, "--run-id=")+9;
        //$ridend = strpos($line, " ", $ridstart);
        $rids = substr($line, $ridstart ); //, ($ridend - $ridstart));

        $brsstart = strpos($line, "--build-request-source=")+23;
        $brsend = strpos($line, " ", $brsstart);
        $brss = substr($line, $brsstart, ($brsend - $brsstart));

        $itemstart = strpos($line, "--item=")+7;
        $itemend = strpos($line, " ", $itemstart);
        $items = substr($line, $itemstart, ($itemend - $itemstart));

        $timestart = strpos($line, 'S')+2;
        //$timeend = strpos($line, " /", $timestart);
        $time = substr($line, $timestart, 8);

        $pipeFactory = new \Model\Pipeline() ;
        $pipe = $pipeFactory->getModel($this->params) ;
        $thisPipe = $pipe->getPipeline($items) ;
        $thisPipeName =  $thisPipe["project-name"] ;

        return array(
            "runuser" => $users,
            "pipedir" => $pds,
            "pipename" => $thisPipeName,
            "brs" => $brss,
            "item" => $items,
            "runid" => $rids,
            "starttime" => $time
        ) ;
    }

}
