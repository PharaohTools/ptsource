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
        $ret["branches"] = $this->getAvailableBranches() ;
        $ret["identifier"] = $this->getCurrentIdentifier($ret["branches"]);
        $ret["directory"] = $this->getCurrentDirectory($ret["identifier"]);
        $ret["current_branch"] = (isset($this->params["branch"])) ? $this->params["branch"] : null;
        $ret["repository"] = $this->getRepository();
        $ret["item"] = $this->params["item"];
        $ret["wsdir"] = $this->getFileBrowserDir();
        $ret["relpath"] = $this->getRelPath();
        $ret["is_file"] = $this->isFileNotDirectory();
        if ($ret["is_file"] == true) {
            $ret["file"] = $this->loadFileContents() ;
            $ret["file_extension"] = $this->findExtension() ;
            $ret["file_mode"] = $this->findMode($ret["file_extension"]) ;
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

    private function getCurrentIdentifier($branches) {
        if (isset($this->params["identifier"])) {
            if (in_array($this->params["identifier"], $branches)) {
                $this->params["branch"] = $this->params["identifier"] ; }
            return $this->params["identifier"] ; }
        if (isset($this->params["branch"])) {
            $this->params["identifier"] = $this->params["branch"] ; }
        else if (isset($this->params["commit"])) {
            $this->params["identifier"] = $this->params["commit"] ; }
        else {
            if (in_array("master", $branches)) {
                $this->params["identifier"] = "master" ;
                $this->params["branch"] = $this->params["identifier"] ;  }
            else {
                $this->params["identifier"] = $branches[0] ;
                $this->params["branch"] = $this->params["identifier"] ;  } }
        return $this->params["identifier"] ;
    }

    private function getAvailableBranches() {
        $filebrowserDir = $this->getFileBrowserDir() ;
        $command = "cd {$filebrowserDir} && git branch" ;
        $all_branches_string = $this->executeAndLoad($command) ;
//        var_dump("<pre>", $all_branches_string, "</pre>") ;
//            die() ;
        $all_branches_string = str_replace('* ', "", $all_branches_string) ;
//        var_dump("<pre>", $all_branches_string, "</pre>") ;
        $all_branches_ray = explode("\n", $all_branches_string) ;
        return $all_branches_ray ;
    }

    private function getCurrentDirectory($identifier) {
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

    private function isFileNotDirectory($identifier=null) {
        $fileBrowserRootDir = $this->getFileBrowserDir() ;
        $filePath = $this->getRelPath() ;
        if (is_null($identifier)) { $identifier = "master" ; }
        $command = "cd {$fileBrowserRootDir} && git ls-tree -r --name-only {$identifier} . {$filePath}" ;
        $all_files = $this->executeAndLoad($command) ;
        $all_files_ray = explode("\n", $all_files) ;
        if (in_array($filePath, $all_files_ray)) { return true ;}
        return false;
    }

    private function loadFileContents($identifier=null) {
        $fileBrowserRootDir = $this->getFileBrowserDir() ;
        $filePath = $this->getRelPath() ;
        if (is_null($identifier)) { $identifier = "master" ; }
        $command = "cd {$fileBrowserRootDir} && git show {$identifier}:$filePath" ;
        $fc = $this->executeAndLoad($command) ;
        return $fc ;
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
