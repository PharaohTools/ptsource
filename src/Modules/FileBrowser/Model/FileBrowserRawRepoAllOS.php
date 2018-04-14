<?php

Namespace Model;

class FileBrowserRawRepoAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("RawRepo") ;

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

    public function getCurrentDirectory() {
        $filebrowserDir = $this->getFileBrowserDir() ;
        $relpath = $this->getRelPath() ;
        $filebrowserDir .= $relpath ;
        $scanned_files = scandir($filebrowserDir) ;
        $filesRay = array();
        foreach ($scanned_files as $scanned_file) {
            if (!in_array($scanned_file, array(".", "..", 'defaults', 'settings'))) {
                $full_path = $filebrowserDir.DS.$scanned_file ;
                $is_dir = false;
                if (is_dir($full_path)) { $is_dir = true; }
                $filesRay[$scanned_file] = $is_dir ; } }
        ksort($filesRay, SORT_NATURAL | SORT_FLAG_CASE ) ;
        $filesRay = array_reverse($filesRay) ;
//        var_dump($filesRay) ;
        return $filesRay ;
    }

    public function isFileNotDirectory($identifier=null) {
        $fileBrowserRootDir = $this->getFileBrowserDir() ;
        $filePath = $this->getRelPath() ;
        $full_path = $fileBrowserRootDir.DS.$filePath ;
        if (is_dir($full_path)) { return false ; }
        return true;
    }

    public function loadFileContents($identifier=null) {
        $fileBrowserRootDir = $this->getFileBrowserDir() ;
        $filePath = $this->getRelPath() ;
        $full_path = $fileBrowserRootDir.DS.$filePath ;
        $fc = file_get_contents($full_path) ;
        return $fc ;
    }

}
