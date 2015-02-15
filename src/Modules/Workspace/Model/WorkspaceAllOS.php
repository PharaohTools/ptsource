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
        $relPath = $this->params["relpath"] ;
        return $relPath ;
    }

    public function getWorkspaceDir() {
        $relPath = $this->getRelPath() ;
        return $this->params["pipe-dir"].DS.$this->params["item"].DS.'workspace'.DS.$relPath;
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