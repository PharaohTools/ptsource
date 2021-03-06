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
            $ret["stat"] = $fileBrowser->loadFileInformation() ;
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
            $ret["image_file_extension"] = $this->imageFileExtension($ret["file_extension"]) ;
            $ret["code_file_extension"] = $this->codeFileExtension() ;
            if (!is_null($ret["image_file_extension"])) {
                $ret["image_file"] = $fileBrowser->loadFileContents() ;
            } else if (!is_null($ret["code_file_extension"])) {
                $ret["code_file"] = $fileBrowser->loadFileContents() ;
            } else {
                if ($ret["stat"]['size'] < 512000) {
                    $ret["raw_file"] = $fileBrowser->loadFileContents() ;
                }
                $ret["code_file_extension"] = 'txt';
            }
            $ret["file_mode"] = $this->findMode($ret["code_file_extension"]) ;
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
            $extension = strtolower($extension) ;
        $allowed_extensions = array("php", "js", "html", 'zip', 'txt', 'log' ,'xml', 'xhtml', 'png', 'gif', 'jpg', 'jpeg') ;
        if (in_array($extension, $allowed_extensions)) {
            return $extension ;
        }
        return null ;
    }

    private function codeFileExtension($identifier=null) {
        $filePath = $this->getRelPath() ;
        $basename = strtolower(basename($filePath)) ;
//        var_dump('bname', $basename) ;
        if ($basename == 'virtufile') {
            return 'php' ;
        }
        if (substr($basename, strlen($basename)-7)=="dsl.php") {
            // @todo need a pharaoh dsl specific editor set
            $extension = pathinfo($basename, PATHINFO_EXTENSION); }
        else {
            $extension = pathinfo($basename, PATHINFO_EXTENSION); }
//            var_dump($extension) ;

        $allowed_extensions = array("php", "js", "html", 'fephp') ;
        if (in_array($extension, $allowed_extensions)) {
            $php_extensions = array('fephp') ;
            if (in_array($extension, $php_extensions)) {
                return 'php' ;
            }
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
            "virtufile" => "php",
            "fephp" => "php",
            "txt" => "text/plain",
        ) ;
        if (isset($modes[$ext])) {
            return $modes[$ext] ;
        }

        return null ;
    }

    private function imageFileExtension($ext) {
        $fexts = array (
            "png" => "image/png",
            "jpg" => "image/jpg",
            "jpeg" => "image/jpg",
            "gif" => "image/gif"
        ) ;
        if (isset($fexts[$ext])) {
            return array($ext, $fexts[$ext]) ;
        }

        return null ;
    }

}
