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
        $keys = array_keys($all_files) ;
        for ($i=0; $i<count($all_files); $i++) {
            if (!in_array($keys[$i], array(".", ".."))){
                $filesRay[$keys[$i]] = $all_files[$keys[$i]] ; } }
        ksort($filesRay, SORT_NATURAL | SORT_FLAG_CASE ) ;
        return $filesRay ;
    }

    private function gitScanDir($fileBrowserRootDir, $identifier=null) {

        $fileBrowserRelativePath = $this->getRelPath() ;
        $lastChar = substr($fileBrowserRelativePath, strlen($fileBrowserRelativePath)-1) ;

        if (is_null($identifier)) { $identifier = "master" ; }
        $command = "cd {$fileBrowserRootDir} && git ls-tree -t --name-only {$identifier} . {$fileBrowserRelativePath}" ;
        $all_files = $this->executeAndLoad($command) ;
        $all_files_ray = explode("\n", $all_files) ;
        $new_ray=array() ;

        $command = "cd {$fileBrowserRootDir} && git ls-tree -d -t --name-only {$identifier} . {$fileBrowserRelativePath}" ;
        $dirs = $this->executeAndLoad($command) ;
        $dirs_ray = explode("\n", $dirs) ;
//        $dirs_ray = array_unique($dirs_ray, array("")) ;

        if ($fileBrowserRelativePath !== "") {

            $prefix_len = strlen($fileBrowserRelativePath) ;

            $new_dirs_ray = array() ;
            foreach ($dirs_ray as $one_dir) {
                $cur_prefix = substr($one_dir, 0, $prefix_len) ;
                if ($one_dir !== "") {
                    if ($cur_prefix == $fileBrowserRelativePath) {
                        $cur_suffix = substr($one_dir, $prefix_len) ;
                        $new_dirs_ray[] = $cur_suffix ; } } }

            foreach ($all_files_ray as $one_file) {
                $cur_prefix = substr($one_file, 0, $prefix_len) ;
                if ($cur_prefix == $fileBrowserRelativePath && $one_file !== "") {
                    $one_file = substr($one_file, $prefix_len) ;
                    $is_dir = (in_array($one_file, $new_dirs_ray)==true) ? true : false ;
                    $new_ray[$one_file] = $is_dir ; } } }
        else {
            foreach ($all_files_ray as $one_file) {
                $is_dir = (in_array($one_file, $dirs_ray)==true) ? true : false ;
//                var_dump("<pre> second dacey", $one_file, $is_dir, "<br/> </pre>");
                if ($one_file !== "") {
                    $new_ray[$one_file] = $is_dir ; } } }
//        var_dump("<pre> nr", $new_ray, $dirs_ray, $command, "<br/> </pre>");
        return array ($new_ray, $dirs_ray) ;
    }

}
