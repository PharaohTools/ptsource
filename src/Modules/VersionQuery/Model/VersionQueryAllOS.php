<?php

Namespace Model;

class VersionQueryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function findRepositoryVersion($current_or_next) {
        $repository = $this->getRepository() ;
        $repo_type = $repository['project-type'] ;
        $repo_version = null ;
        $is_allowed = false ;
        if ($repo_type === 'raw') {
            $binaryServerFactory = new \Model\BinaryServer();
            $binaryServer = $binaryServerFactory->getModel($this->params);
            $binaryRequestUser = $binaryServer->getBinaryRequestUser() ;
            $is_allowed = $binaryServer->userIsAllowed($binaryRequestUser, $this->params["item"]) ;
        }
        if ($is_allowed !== true) {
            $repo_version = array(
                'status' => 'Permission Denied',
                'http_status' => '403'
            ) ;
            return $repo_version ;
        }
        if ($repo_type === 'raw') {
            $repo_version = $this->getBinaryArtefactVersion($current_or_next)  ;
        }
        return $repo_version ;
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        return $repository->getRepository($this->params["item"]);
    }

    public function getAllArtefactVersions($current_or_next) {
        $repository = $this->getRepository() ;
        $groups_enabled = (isset($repository["settings"]["BinaryGroups"]["enabled"]) && $repository["settings"]["BinaryGroups"]["enabled"]=="on") ? true : false ;
        if ($groups_enabled == 'on') {
            $requested_group = $this->params['group'] ;
            $dir_to_use = $this->findDirectoryWithGroup($repository, $requested_group, $current_or_next) ;
        } else {
            $dir_to_use = $this->findDirectoryWithoutGroup($repository, $current_or_next) ;
        }
        return $dir_to_use ;
    }

    public function getBinaryArtefactVersion($current_or_next) {
        $repository = $this->getRepository() ;
        $groups_enabled = (isset($repository["settings"]["BinaryGroups"]["enabled"]) && $repository["settings"]["BinaryGroups"]["enabled"]=="on") ? true : false ;
        $dir_to_use = array() ;
        if ($groups_enabled == 'on') {
            $requested_group = isset($this->params['group']) ? $this->params['group'] : null  ;
            $allowed_groups_string = $repository["settings"]["BinaryGroups"]["allowed_groups"] ;
            $allowed_groups = explode("\r\n", $allowed_groups_string) ;
            if ($requested_group === null) {
                foreach ($allowed_groups as $allowed_group) {
                    $dir_to_use[$allowed_group] = $this->findDirectoryWithGroup($repository, $allowed_group, $current_or_next) ;
                }
            } else {
                if (in_array($requested_group, $allowed_groups)) {
                    $dir_to_use[$requested_group] = $this->findDirectoryWithGroup($repository, $requested_group, $current_or_next) ;
                } else {
                    $dir_to_use[$requested_group] = 'Group Non Existent' ;
                }
            }
        } else {
            $dir_to_use = $this->findDirectoryWithoutGroup($repository, $current_or_next) ;
        }
        return $dir_to_use ;
    }


    public function getData() {
        $repository = $this->getRepository() ;
        $groups_enabled = (isset($repository["settings"]["BinaryGroups"]["enabled"]) && $repository["settings"]["BinaryGroups"]["enabled"]=="on") ? true : false ;
        $data = array() ;
        if ($groups_enabled == 'on') {
            $allowed_groups_string = $repository["settings"]["BinaryGroups"]["allowed_groups"] ;
            $allowed_groups = explode("\r\n", $allowed_groups_string) ;
            foreach ($allowed_groups as $allowed_group) {
                $data['version'][$allowed_group]['current'] = $this->findDirectoryWithGroup($repository, $allowed_group, 'current') ;
                $data['version'][$allowed_group]['next'] = $this->findDirectoryWithGroup($repository, $allowed_group, 'next') ;
            }
        } else {
            $data['version']['groups_disabled']['current'] = $this->findDirectoryWithoutGroup($repository, 'current') ;
            $data['version']['groups_disabled']['next'] = $this->findDirectoryWithoutGroup($repository, 'next') ;
        }
        $ray = $data ;
        $ray['repository'] = $repository ;
        $ray["user"] = $this->getLoggedInUser();
        return $ray ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }

    public function findDirectoryWithoutGroup($repository, $current_or_next = 'current') {

        $cur_max = 0 ;
        $dir_count = 0 ;
        $all_dirs = scandir(REPODIR.DS.$this->params["item"]) ;

        foreach ($all_dirs as $current_dir) {
            if (in_array($current_dir, array('.', '..'))) { continue ; }
            $full_dir = REPODIR.DS.$this->params["item"].DS.$current_dir ;
            if (!is_dir($full_dir)) { continue ; }
            $dir_count ++ ;
//                file_put_contents('/tmp/pharaoh.log', "version_compare  $cur_max , $current_dir\n", FILE_APPEND) ;
            $res = version_compare ( $cur_max , $current_dir );
            if ($res == -1) {
                $cur_max = $current_dir ;
            }
        }

//            file_put_contents('/tmp/pharaoh.log', "vcompare is $res\n", FILE_APPEND) ;
        if ($dir_count == 0) {
            $this_version = '0.0.1' ;
        } else if ($current_or_next === 'current' && $dir_count !== 0) {
            $this_version = $cur_max ;
        } else if ($current_or_next === 'next' && $dir_count !== 0) {
            $last_dot = strrpos($cur_max, '.') ;
            $cur_build = substr($cur_max, $last_dot+1) ;
            $new_build = $cur_build + 1;
            $cur_prefix = substr($cur_max,0, $last_dot+1) ;
            $this_version = $cur_prefix.$new_build ;
        } else {
            return null ;
        }

        $dir_to_use = REPODIR.DS.$this->params["item"].DS.$this_version ;
        $return_values = array('version' => $this_version, 'path' => $dir_to_use) ;
        return $return_values ;
    }


    public function findDirectoryWithGroup($repository, $requested_group, $current_or_next = 'current') {

        $cur_max = 0 ;
        $dir_count = 0 ;
        $all_dirs = scandir(REPODIR.DS.$this->params["item"]) ;

        foreach ($all_dirs as $current_dir) {
            if (in_array($current_dir, array('.', '..'))) { continue ; }
            $full_dir = REPODIR.DS.$this->params["item"].DS.$current_dir.DS.$requested_group ;
            if (!is_dir($full_dir)) { continue ; }
            $dir_count ++ ;
//                file_put_contents('/tmp/pharaoh.log', "version_compare  $cur_max , $current_dir\n", FILE_APPEND) ;
            $res = version_compare ( $cur_max , $current_dir );
            if ($res == -1) {
                $cur_max = $current_dir ;
            }
        }

        if ($dir_count == 0) {
            $this_version = '0.0.1' ;
        } else if ($current_or_next === 'current' && $dir_count !== 0) {
            $this_version = $cur_max ;
        } else if ($current_or_next === 'next' && $dir_count !== 0) {
            $last_dot = strrpos($cur_max, '.') ;
            $cur_build = substr($cur_max, $last_dot+1) ;
            $new_build = $cur_build + 1;
            $cur_prefix = substr($cur_max,0, $last_dot+1) ;
            $this_version = $cur_prefix.$new_build ;
        } else {
            return null ;
        }

        if ($repository["settings"]["BinaryGroups"]["allow_all_or_specific"] == 'allow_all') {
            $dir_to_use = REPODIR.DS.$this->params["item"].DS.$this_version.DS.$requested_group ;
        } else if ($repository["settings"]["BinaryGroups"]["allow_all_or_specific"] == 'specific') {
            $allowed_groups_string = $repository["settings"]["BinaryGroups"]["allowed_groups"] ;
            $allowed_groups = explode("\r\n", $allowed_groups_string) ;
            $default_group = $allowed_groups[0] ;

            $requested_is_set = (isset($this->params['group']) && $this->params['group'] !== '') ? true : false ;
//                $is_requested = ($requested_is_set && in_array($requested_group, $allowed_groups)) ? true : false ;
            $requested_allowed = in_array($requested_group, $allowed_groups) ;
            if ($requested_is_set && !$requested_allowed) {
                header('HTTP/1.1 400 Unable to handle request');
                echo "Invalid Group String Requested\n" ;
                $dir_to_use = false ;
            } else if ($requested_is_set && $requested_allowed) {
                $dir_to_use = REPODIR.DS.$this->params["item"].DS.$this_version.DS.$requested_group ;
            } else if ($default_group  !== '') {
                $dir_to_use = REPODIR.DS.$this->params["item"].DS.$this_version.DS.$default_group ;
            } else {
                $dir_to_use = false ;
            }
        } else {
            $dir_to_use = false ;
        }

        $return_values = array('version' => $this_version, 'path' => $dir_to_use) ;
        return $return_values ;
    }

}