<?php

Namespace Model;

class ManualUploadAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $this->setRepositoryDir();
        $ret["directory"] = $this->getCurrentDirectory();
        $ret["repository"] = $this->getRepository();
        $ret["next_version"] = $this->getArtefactVersion();
        $ret["item"] = $this->params["item"];
        $ret["wsdir"] = $this->getManualUploadDir();
        return $ret ;
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        return $repository->getRepository($this->params["item"]);
    }

    public function getArtefactVersion() {

        file_put_contents('/tmp/pharaoh.log', 'afv'."\n", FILE_APPEND) ;
        file_put_contents('/tmp/pharaoh.log', json_encode($this->params['version']), FILE_APPEND) ;

        if (isset($this->params['version'])) {
            $this_version = $this->params['version'] ;
        } else {
            $all_dirs = scandir($this->params["repository_dir"].DS.$this->params["item"]) ;
            $cur_max = 0 ;
            $dir_count = 0 ;
            foreach ($all_dirs as $current_dir) {
                if (in_array($current_dir, array('.', '..'))) { continue ; }
                $full_dir = $this->params["repository_dir"].DS.$this->params["item"].DS.$current_dir ;
                if (!is_dir($full_dir)) { continue ; }
                $dir_count ++ ;
                $res = version_compare ( $cur_max , $current_dir );
                if ($res == -1) {
                    $cur_max = $current_dir ;
                } else {
                    $cur_max = $current_dir ;
                }
            }
            if ($dir_count == 0) {
                $this_version = '0.0.1' ;
            } else {
                $last_dot = strrpos($cur_max, '.') ;
                $cur_build = substr($cur_max, $last_dot+1) ;
                $new_build = $cur_build + 1;
                $cur_prefix = substr($cur_max,0, $last_dot+1) ;
                $this_version = $cur_prefix.$new_build ;
            }
        }

        file_put_contents('/tmp/pharaoh.log', 'version'."\n", FILE_APPEND) ;
        file_put_contents('/tmp/pharaoh.log', $this_version."\n", FILE_APPEND) ;

        return $this_version;
    }

    public function getManualUploadDir() {
        $this->setRepositoryDir() ;
        $version = $this->getArtefactVersion() ;
        return $this->params["repository_dir"].DS.$this->params["item"].DS.$version;
    }

    public function setRepositoryDir() {
        if (isset($this->params["guess"]) && $this->params["guess"]==true) {
            $this->params["repository_dir"] = REPODIR ; }
        else {
            // @todo should probably ask a question here
            $this->params["repository_dir"] = REPODIR ; }
    }

    private function getCurrentDirectory() {
        $documentsDir = $this->getManualUploadDir() ;
        $builds = scandir($documentsDir) ;
        $buildsRay = array();
        for ($i=0; $i<count($builds); $i++) {
            if (!in_array($builds[$i], array(".", "..", "tmpfile"))){
                $buildsRay[$builds[$i]] = is_dir($documentsDir.$builds[$i]) ; ; } }
        ksort($buildsRay) ;
        return $buildsRay ;
    }

    public function uploadFile() {
        $target_dir = $this->getManualUploadDir();
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir .DS. basename($_FILES["file"]["name"]);
        $check = (filesize($_FILES["file"]["tmp_name"]) > 0 );

        file_put_contents('/tmp/pharaoh.log', 'tf: '.$target_file."\n", FILE_APPEND) ;
        file_put_contents('/tmp/pharaoh.log', 'td: '.$target_dir."\n", FILE_APPEND) ;

        if ($check) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                chmod($target_file, 0777);
                return array("outmsg" => "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.");
            } else {
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
                return array("outmsg" => "Sorry, there was an error uploading your file.");
            }
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            return array("outmsg" => "Unable to move uploaded file.");
        }
    }

    public function deleteFile() {
        $target_dir = $this->getManualUploadDir();
        $version = $this->getArtefactVersion() ;
        if ($version == '') {
            return array(
                "outmsg" => "Blank Version is not allowed",
                "status" => "FAIL"
            );
        }
        $check = (file_exists($target_dir));
        if ($check) {
            if ($this->rrmdir($target_dir)) {
                return array(
                    "outmsg" => "The release " . $version . " has been deleted.",
                    "status" => "SUCCESS"
                ) ;
            } else {
                return array(
                    "outmsg" => "Sorry, there was an error deleting your file.",
                    "status" => "FAIL"
                ) ;
            }
        } else {
            return array(
                "outmsg" => "File does not exist, cannot delete",
                "status" => "FAIL"
            ) ;
        }
    }

    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir.DS.$object))
                        $this->rrmdir($dir.DS.$object);
                    else
                        unlink($dir.DS.$object);
                }
            }
            return rmdir($dir);
        }
        return false ;
    }

}