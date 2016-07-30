<?php

Namespace Model;

class RepositoryCommitsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("RepositoryCommits") ;

    public function getCommits($repository=null, $amount=null, $page=null) {
        if ($repository != null) { $this->params["item"] = $repository ; }
        if ($amount != null) { $this->params["amount"] = $amount ; }
        if ($page != null) { $this->params["page"] = $page ; }
        $r = $this->collate();
        return $r ;
    }

    private function collate() {
        $collated = array() ;
        $collated = array_merge($collated, $this->getItem()) ;
        $collated = array_merge($collated, $this->getAmount()) ;
        $collated = array_merge($collated, $this->getPage()) ;
        $collated = array_merge($collated, $this->getCommitsData()) ;
        return $collated ;
    }

    public function getItem() {
        $item = array("item" => $this->params["item"]);
        return $item ;
    }

    public function getAmount() {
        if (!isset($this->params["amount"])) { $this->params["amount"] = 1 ; }
        $amount = array("amount" => $this->params["amount"]);
        return $amount ;
    }

    public function getPage() {
        if (!isset($this->params["page"])) { $this->params["page"] = 1 ; }
        $page = array("page" => $this->params["page"]);
        return $page ;
    }

    private function getLastRun() {
        $file = REPODIR.DS.$this->params["item"].DS.'historyIndex';
        if ($historyIndex = file_get_contents($file)) {
            $historyIndex = json_decode($historyIndex, true);
            krsort($historyIndex);
            // @todo this foreach doesn't make sense, kinda, but is it actually any quicker to change, it loops once anyway
            foreach ($historyIndex as $run=>$val) {
                return array('time' => $historyIndex[$run]['start'], 'repository' => $run) ; } }
        return array('time' => false, 'repository' => 0) ;
    }

    private function getCommitsData() {




        $command = "cd {$fileBrowserRootDir} && git ls-tree -d -t --name-only {$identifier} . {$fileBrowserRelativePath}/" ;
        $dirs = $this->executeAndLoad($command) ;
        $dirs_ray = explode("\n", $dirs) ;

        $settings = array();
        $settingsFile = REPODIR.DS.$this->params["item"].DS.'settings' ;
        if (file_exists($settingsFile)) {
            $settingsFileData =  file_get_contents($settingsFile) ;
            $settings = json_decode($settingsFileData, true) ; }
        else {
            $loggingFactory = new \Model\Logging() ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("No settings file available in repository ".$this->params["item"], $this->getModuleName()) ; }
        return array("commits" => $commits) ;
    }

}
