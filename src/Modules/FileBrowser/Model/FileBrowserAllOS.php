<?php

Namespace Model;

class FileBrowserAllOS extends Base {

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
        $ret["repository"] = $this->getRepository();
        $ret["item"] = $this->params["item"];
        $ret["wsdir"] = $this->getFileBrowserDir();
        $ret["relpath"] = $this->getRelPath();
        return $ret ;
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        return $repository->getRepository($this->params["item"]);
    }

    public function getRelPath() {
        $relPath = isset($this->params["relpath"]) ? $this->params["relpath"] : "" ;
        return $relPath ;
    }

    public function getFileBrowserDir() {
        $relPath = $this->getRelPath() ;
        return $this->params["repo-dir"].DS.$this->params["item"].DS.'filebrowser'.DS.$relPath;
    }

    public function createFileBrowserIfNeeded() {
        $filebrowser_path = $this->getFileBrowserDir() ;
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (is_dir($filebrowser_path)) {
            $logging->log("FileBrowser directory exists... " , $this->getModuleName()) ;
            if(is_writable($filebrowser_path)) {
                $logging->log("FileBrowser is writable " , $this->getModuleName()) ;
                return true ; }
            else {
                $logging->log("FileBrowser is not writable " , $this->getModuleName()) ; } }
        else {
            $logging->log("No FileBrowser directory exists " , $this->getModuleName()) ; }
        $logging->log("Rebuilding filebrowser " , $this->getModuleName()) ;
        $rc = array();
        $rc[] = $this->executeAndGetReturnCode("rm -rf {$filebrowser_path}", true, true);
        $rc[] = $this->executeAndGetReturnCode("mkdir -p {$filebrowser_path}", true, true);
        $res = ($rc[0]["rc"]==0 && $rc[1]["rc"]==0) ;
        if ($res == true) {
            $logging->log("FileBrowser successfully rebuilt" , $this->getModuleName()) ; }
        else {
            $logging->log("FileBrowser failed rebuild" , $this->getModuleName()) ; }
        return $res ;
    }

    public function setPipeDir() {
        if (isset($this->params["guess"]) && $this->params["guess"]==true) {
            $this->params["repo-dir"] = PIPEDIR ; }
        else {
            // @todo should probably ask a question here
            $this->params["repo-dir"] = PIPEDIR ; }
    }

    private function getCurrentDirectory() {
        $filebrowserDir = $this->getFileBrowserDir() ;
        $builds = scandir($filebrowserDir) ;
        $buildsRay = array();
        for ($i=0; $i<count($builds); $i++) {
            if (!in_array($builds[$i], array(".", "..", "tmpfile"))){
                $buildsRay[$builds[$i]] = is_dir($filebrowserDir.$builds[$i]) ; ; } }
        ksort($buildsRay) ;
        return $buildsRay ;
    }

}
