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
        return $this->params["repo-dir"].DS.$this->params["item"].DS;
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

    public function setRepoDir() {
        if (isset($this->params["guess"]) && $this->params["guess"]==true) {
            $this->params["repo-dir"] = REPODIR ; }
        else {
            // @todo should probably ask a question here
            $this->params["repo-dir"] = REPODIR ; }
    }

    private function getCurrentDirectory() {
        $filebrowserDir = $this->getFileBrowserDir() ;
        $scanned_files = $this->gitScanDir($filebrowserDir, $identifier) ;
        $all_files = $scanned_files[0] ;
        $subdirectories = $scanned_files[1] ;
        $filesRay = array();
        for ($i=0; $i<count($all_files); $i++) {
            if (!in_array($all_files[$i], array(".", ".."))){
                $filesRay[$all_files[$i]] = in_array($all_files[$i], $subdirectories) ; } }
        $keys = array_keys($filesRay) ;
        ksort($filesRay, SORT_NATURAL | SORT_FLAG_CASE ) ;
        return $filesRay ;
    }

    private function gitScanDir($fileBrowserRootDir, $identifier=null) {

        $fileBrowserRelativePath = $this->getRelPath() ;

        $lastChar = substr($fileBrowserRelativePath, strlen($fileBrowserRelativePath)-1) ;

        if ($lastChar == DS) {
            $fileBrowserRelativePath = substr($fileBrowserRelativePath, 0, strlen($fileBrowserRelativePath)-1) ; }

        var_dump("last char", $lastChar, $fileBrowserRelativePath) ;

        if (is_null($identifier)) { $identifier = "master" ; }
        $command = "cd {$fileBrowserRootDir} && git ls-tree -t --name-only {$identifier} . {$fileBrowserRelativePath}" ;
        var_dump($command) ;
        $all_files = $this->executeAndLoad($command) ;
        $all_files_ray = explode("\n", $all_files) ;
        $new_ray=array() ;

        if ($fileBrowserRelativePath !== "") {
            var_dump("dirst davey");
            $prefix_len = strlen($fileBrowserRelativePath) ;
            for ($i=0; $i<count($all_files_ray); $i++) {
                if (substr($all_files_ray[$i], 0, $prefix_len) == $fileBrowserRelativePath) {
                    $new_ray[$i] = in_array($all_files[$i], $subdirectories) ; } } }
        else {
            var_dump("second dacey");
            for ($i=0; $i<count($all_files_ray); $i++) {
                $new_ray[$i] = in_array($all_files[$i], $subdirectories) ; } }

        $command = "cd {$fileBrowserRootDir} && git ls-tree -d -t --name-only {$identifier} . {$fileBrowserRelativePath}" ;
        $dirs = $this->executeAndLoad($command) ;
        $dirs_ray = explode("\n", $dirs) ;
        return array ($all_files_ray, $dirs_ray) ;
    }

}
