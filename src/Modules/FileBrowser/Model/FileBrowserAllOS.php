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
        $this->setRepoDir();
        $ret["repository"] = $this->getRepository();
        $fileBrowserFactory = new \Model\FileBrowser() ;
        if ($ret['repository']['project-type'] == 'raw') {
            $fileBrowser = $fileBrowserFactory->getModel($this->params, 'RawRepo');
            $ret["directory"] = $fileBrowser->getCurrentDirectory();
        } else  {
            //  ($ret['repository']['type'] == 'git')
            $fileBrowser = $fileBrowserFactory->getModel($this->params, 'GitRepo');
            $ret["branches"] = $fileBrowser->getAvailableBranches() ;
            $ret["identifier"] = $fileBrowser->getCurrentIdentifier($ret["branches"]);
            $ret["directory"] = $fileBrowser->getCurrentDirectory($ret["identifier"]);
            $ret["current_branch"] = (isset($this->params["branch"])) ? $this->params["branch"] : null;
        }
        $ret["is_file"] = $fileBrowser->isFileNotDirectory();
        $ret["item"] = $this->params["item"];
        $ret["wsdir"] = $this->getFileBrowserDir();
        $ret["relpath"] = $this->getRelPath();
        if ($ret["is_file"] == true) {
            $ret["file_extension"] = $this->findExtension() ;
            $ret["file_mode"] = $this->findMode($ret["file_extension"]) ;
            if ($ret["file_mode"] !== null) {
                $ret["file"] = $fileBrowser->loadFileContents() ;
            }
        }
        $ret["relpath"] = $this->getRelPath();
        $ret["current_user_data"] = $this->getCurrentUserData();
        return $ret ;
    }

    public function getCurrentUserData() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $user = $signup->getLoggedInUserData();
        if ($user == false) { return false ; }
        return $user ;
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
        return $this->params["repo-dir"].DS.$this->params["item"].DS;
    }

    public function setRepoDir() {
        if (isset($this->params["guess"]) && $this->params["guess"]==true) {
            $this->params["repo-dir"] = REPODIR ; }
        else {
            // @todo should probably ask a question here
            $this->params["repo-dir"] = REPODIR ; }
    }

    private function findExtension($identifier=null) {
        $filePath = $this->getRelPath() ;
        $basename = basename($filePath) ;
        if (substr($basename, strlen($basename)-7)=="dsl.php") {
            // @todo need a pharaoh dsl specific editor set
            $extension = pathinfo($basename, PATHINFO_EXTENSION); }
        else {
            $extension = pathinfo($basename, PATHINFO_EXTENSION); }
        $allowed_extensions = array("php", "js", "html") ;
        if (in_array($extension, $allowed_extensions)) {
            return $extension ;
        }
        return null ;
    }

    private function findMode($ext) {
        $modes = array (
            "js" => "javascript",
            "html" => "htmlmixed",
            "xhtml" => "htmlmixed",
            "php" => "php",
            "rb" => "ruby",
        ) ;
        if (isset($modes[$ext])) {
            return $modes[$ext] ;
        }

        return null ;
    }

}
