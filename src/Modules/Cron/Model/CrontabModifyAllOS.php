<?php

Namespace Model;

class CrontabModifyAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("CrontabModify") ;

    public function addCronjob() {
        $cronCmd = $this->getCronCommand();
        $loggingFactory = new \Model\Logging();
        $this->params["php-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $cronJobs = $this->getCronjobs() ;
        $cronJobs[] = $cronCmd ;
        $this->saveCronjobs($cronJobs) ;
    }

    public function removeCronjob() {
        $loggingFactory = new \Model\Logging();
        $this->params["php-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $cronJobs = $this->getCronjobs() ;
        $cronJobSave = array() ;
        if (count($cronJobs)==0) {
            $logging->log ("Nothing to remove! The cronTab is already empty.", $this->getModuleName() ) ;
            return true ; }
        for ($i=0; $i<count($cronJobs); $i++) {
            if ($cronJobs[$i] =="") {
                $logging->log ("Removing Empty Cron entry", $this->getModuleName() ) ;
                unset($cronJobs[$i]) ; }
            else if (strpos($cronJobs[$i], $this->params["app-settings"]["Cron"]["cron_command"])) {
                $logging->log ("Removing Cron entry $cronJobs[$i]", $this->getModuleName() ) ;
                unset($cronJobs[$i]) ; }
            else { $cronJobSave[] = $cronJobs[$i] ; }}
        $this->saveCronjobs($cronJobSave) ;
    }

    private function getCronjobs() {
        $cronJobs = explode("\n", self::executeAndLoad("crontab -l"));
        return $cronJobs;
    }
    private function getCronCommand() {
        $cronCmd = $this->params["app-settings"]["Cron"]["cron_frequency"].' '.$this->params["app-settings"]["Cron"]["cron_command"] ;
        return $cronCmd;
    }

    private function saveCronjobs($cj) {
        file_put_contents("/tmp/crontemp.txt", implode("\n", $cj)."\n");
        self::executeAndOutput("crontab < /tmp/crontemp.txt") ;
        $rc = self::executeAndLoad("echo $?") ;
        return $rc ;
    }

}