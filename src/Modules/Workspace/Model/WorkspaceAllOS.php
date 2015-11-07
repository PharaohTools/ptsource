<?php

Namespace Model;

class WorkspaceAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $this->setPipeDir();
        $ret["directory"] = $this->getCurrentDirectory();
        $ret["pipeline"] = $this->getPipeline();
        $ret["item"] = $this->params["item"];
        $ret["wsdir"] = $this->getWorkspaceDir();
        $ret["relpath"] = $this->getRelPath();
        return $ret ;
    }

    public function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

    public function getRelPath() {
        $relPath = isset($this->params["relpath"]) ? $this->params["relpath"] : "" ;
        return $relPath ;
    }

    public function getWorkspaceDir() {
        $relPath = $this->getRelPath() ;
        return $this->params["pipe-dir"].DS.$this->params["item"].DS.'workspace'.DS.$relPath;
    }

    public function createWorkspaceIfNeeded() {
        $workspace_path = $this->getWorkspaceDir() ;
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (is_dir($workspace_path)) {
            $logging->log("Workspace directory exists... " , $this->getModuleName()) ;
            if(is_writable($workspace_path)) {
                $logging->log("Workspace is writable " , $this->getModuleName()) ;
                return true ; }
            else {
                $logging->log("Workspace is not writable " , $this->getModuleName()) ; } }
        else {
            $logging->log("No Workspace directory exists " , $this->getModuleName()) ; }
        $logging->log("Rebuilding workspace " , $this->getModuleName()) ;
        $rc = array();
        $rc[] = $this->executeAndGetReturnCode("rm -rf {$workspace_path}", true, true);
        $rc[] = $this->executeAndGetReturnCode("mkdir -p {$workspace_path}", true, true);
        $res = ($rc[0]["rc"]==0 && $rc[1]["rc"]==0) ;
        if ($res == true) {
            $logging->log("Workspace successfully rebuilt" , $this->getModuleName()) ; }
        else {
            $logging->log("Workspace failed rebuild" , $this->getModuleName()) ; }
        return $res ;
    }

    public function setPipeDir() {
        if (isset($this->params["guess"]) && $this->params["guess"]==true) {
            $this->params["pipe-dir"] = PIPEDIR ; }
        else {
            // @todo should probably ask a question here
            $this->params["pipe-dir"] = PIPEDIR ; }
    }

    private function getCurrentDirectory() {
        $workspaceDir = $this->getWorkspaceDir() ;
        $builds = scandir($workspaceDir) ;
        $buildsRay = array();
        for ($i=0; $i<count($builds); $i++) {
            if (!in_array($builds[$i], array(".", "..", "tmpfile"))){
                $buildsRay[$builds[$i]] = is_dir($workspaceDir.$builds[$i]) ; ; } }
        ksort($buildsRay) ;
        return $buildsRay ;
    }

}
