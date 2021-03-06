<?php

Namespace Model;

class BinaryServerAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;
//
//    public function getEventNames() {
//        return array_keys($this->getEvents());
//    }
//
//    public function getEvents() {
//        $ff = array(
//            "afterApplicationConfigurationSave" => array(
//                "ensureSSHServerStatus",
//            ),
//        );
//        return $ff ;
//    }
//
//    public function ensureSSHServerStatus() {
//        $gsf = new \Model\BinaryServer();
//        $gs = $gsf->getModel($this->params, "ServerSSHFunctions") ;
//        return $gs->ensureSSHServerStatus() ;
//    }

    public function runBinaryHTTP() {
        $out = $this->backendData() ;
//        $this->fixPushPerms() ;
        return $out ;
    }

    protected function findRepoName(){
        $pos = strpos($this->params["item"], '/') ;
        $repo_name = $this->params["item"] ;
        if ($pos !== false) {
            $repo_name = substr($this->params["item"], 0, $pos) ; }
        return $repo_name ;
    }

    public function backendData() {

        $repo_name = $this->findRepoName();
        $binaryRequestUser = $this->getBinaryRequestUser() ;

//        var_dump($binaryRequestUser, $repo_name) ;

        if ($this->userIsAllowed($binaryRequestUser, $repo_name)==false) {
            header('HTTP/1.1 403 Forbidden');
            echo "Forbidden\n" ;
            return false ;  }

        $is_download = (is_array($_FILES) && array_key_exists('file', $_FILES)) ? false : true ;
        $files_out = var_export($_FILES, true) ;
        $reqq_out = var_export($_REQUEST, true) ;
        file_put_contents('/tmp/pharaoh.log', 'download'."\n", FILE_APPEND) ;
        file_put_contents('/tmp/pharaoh.log', $files_out."\n", FILE_APPEND) ;
        file_put_contents('/tmp/pharaoh.log', 'req out'."\n", FILE_APPEND) ;
        file_put_contents('/tmp/pharaoh.log', $reqq_out."\n", FILE_APPEND) ;

        if ($is_download) {

            $version = $this->getArtefactVersion(true) ;
            file_put_contents('/tmp/ptlog', $version) ;
            if ($this->versionStringIsValid($version)) {
                $this_version = $version ;
            } else {
                header('HTTP/1.1 400 Unable to handle request');
                echo "Incompatible Version String Requested\n" ;
                return false ;
            }

            $dir_to_read = $this->findReadWriteDirectory($this_version) ;
            $in_dir = scandir($dir_to_read);
            $this_one = null ;
            foreach ($in_dir as $one) {
                if (in_array($one, array('.', '..'))) {
                    continue ;
                } else {
                    $this_one = $one ;
                    break ;
                }
            }
            if ($this_one === null) {
                header('HTTP/1.1 404 Unable to find resource');
                echo "Unable to find Requested Resource\n" ;
                return false ;
            }

            $file_path = $dir_to_read.DS.$this_one ;
//            $mime = mime_content_type($file_path) ;
//            header("Content-Type: {$mime}");
            header("Content-Disposition: attachment; filename=\"$this_one\"");

            set_time_limit(0);
            $file = @fopen($file_path,"rb");
            while(!feof($file)) {
                print(@fread($file, 1024*8));
                ob_flush();
                flush();
            }

            return true ;

        } else {
            // is an upload

//            file_put_contents('/tmp/pharaoh.log', 'upload start'."\n", FILE_APPEND) ;
            $version = $this->getArtefactVersion() ;
//            file_put_contents('/tmp/pharaoh.log', 'version is:'.$version."\n", FILE_APPEND) ;
            if ($this->versionStringIsValid($version)) {
                $this_version = $version ;
            } else {
                header('HTTP/1.1 400 Unable to handle request');
                echo "Incompatible Version String Requested\n" ;
                return false ;
            }

            $dir_to_write = $this->findReadWriteDirectory($this_version) ;
            file_put_contents('/tmp/pharaoh.log', '$dir_to_write: '.$dir_to_write."\n", FILE_APPEND) ;

            if (!is_dir($dir_to_write)) {
                mkdir($dir_to_write, 0755, true);
//                file_put_contents('/tmp/pharaoh.log', 'mkdir worked'."\n", FILE_APPEND) ;
            }

            $res = $this->singlePostUpload($dir_to_write) ;
//            $res = $this->chunkedUpload($dir_to_write) ;
//            file_put_contents('/tmp/pharaoh.log', 'chunkedUpload / singlePostUpload res is: '.var_export($res, true)."\n", FILE_APPEND) ;
            if ($res !== false) {
                return true ;
            } else {
                return false ;
            }
        }

    }

    public function findReadWriteDirectory($this_version) {
        $repoFactory = new \Model\Repository() ;
        $repo = $repoFactory->getModel($this->params, "Default") ;
        $thisRepo = $repo->getRepository($this->params["item"]) ;
        $groups_enabled = (isset($thisRepo["settings"]["BinaryGroups"]["enabled"]) && $thisRepo["settings"]["BinaryGroups"]["enabled"]=="on") ? true : false ;
        if ($groups_enabled == 'on') {
            $requested_group = $this->params['group'] ;
            if ($thisRepo["settings"]["BinaryGroups"]["allow_all_or_specific"] == 'allow_all') {
                $dir_to_use = REPODIR.DS.$this->params["item"].DS.$this_version.DS.$requested_group ;
            } else if ($thisRepo["settings"]["BinaryGroups"]["allow_all_or_specific"] == 'specific') {
                $allowed_groups_string = $thisRepo["settings"]["BinaryGroups"]["allowed_groups"] ;
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
                    header('HTTP/1.1 400 Unable to handle request');
                    echo "Invalid Group String Requested\n" ;
                    $dir_to_use = false ;
                }
            }
        } else {
            $dir_to_use = REPODIR.DS.$this->params["item"].DS.$this_version ;
        }
        return $dir_to_use ;
    }

    public function singlePostUpload($dir_to_write) {
        $contents = file_get_contents($_FILES['file']['tmp_name']) ;
        $res = file_put_contents($dir_to_write.DS.$_FILES['file']['name'], $contents);
        if ($res !== false) {
            echo "File was uploaded successfully\n" ;
            return true ;
        } else {
            echo "File Upload failed\n" ;
            return false ;
        }
    }

    public function chunkedUpload($dir_to_write) {
        $lib_dir = dirname(__DIR__).DS.'Libraries'.DS ;
        require_once ($lib_dir.'chunked_raw.php') ;
        require_once ($lib_dir.'chunked_flow.php') ;
        require_once ($lib_dir.'chunked_native.php') ;
        echo "File was uploaded successfully" ;
        return true ;
    }

    public function getArtefactVersion($get_current_max = false) {

        if (isset($this->params['version'])) {
            $this_version = $this->params['version'] ;
        } else {
            $all_dirs = scandir(REPODIR.DS.$this->params["item"]) ;
            $cur_max = 0 ;
            $dir_count = 0 ;
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
            if ($get_current_max == true) {
                return $cur_max ;
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

        return $this_version;
    }

    protected function versionStringIsValid($version) {
        return true;
    }

    protected function getAllHeaders() {
        if (!is_array($_SERVER)) { return array(); }
        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; } }
        return $headers;
    }


    public function userIsAllowed($binaryRequestUser, $repo_name) {
        $isWriteAction = $this->isWriteAction() ;
        if ($isWriteAction == false) {
            # file_put_contents('/tmp/pharaoh.log', "uia: is not a write\n", FILE_APPEND) ;
            $publicReads = $this->repoPublicAllowed("read", $repo_name) ;
            # file_put_contents('/tmp/pharaoh.log', "uia: public reads, $publicReads\n", FILE_APPEND) ;
            if ($publicReads == true) {
                return true ; }
            else {
                return $this->authUserToRead($binaryRequestUser, $repo_name) ; } }
        else {
            # file_put_contents('/tmp/pharaoh.log', "uia: is a write\n", FILE_APPEND) ;
            $publicWrites = $this->repoPublicAllowed("write", $repo_name) ;
            if ($publicWrites == true) {
                # file_put_contents('/tmp/pharaoh.log', "uia: public write allowed\n", FILE_APPEND) ;
                return true ; }
            else {
                # file_put_contents('/tmp/pharaoh.log', "uia: no public\n", FILE_APPEND) ;
                $res = $this->authUserToWrite($binaryRequestUser, $repo_name) ;
                # file_put_contents('/tmp/pharaoh.log', "uia: auth is: ".var_export($res, true), FILE_APPEND) ;
                return $res ; } }
    }


    protected function repoPublicAllowed($type, $repo_name) {
        $repoFactory = new \Model\Repository() ;
        $repo = $repoFactory->getModel($this->params, "Default") ;
        $thisRepo = $repo->getRepository($repo_name) ;
        $public_enabled = (isset($thisRepo["settings"]["PublicScope"]["enabled"]) && $thisRepo["settings"]["PublicScope"]["enabled"]=="on") ? true : false ;
        if ($public_enabled == false) { return false ; }
        if ($type == "read" || $type == "write") {
            $is_allowed = (isset($thisRepo["settings"]["PublicScope"]["public_{$type}"]) && $thisRepo["settings"]["PublicScope"]["public_{$type}"]=="on") ? true : false ;
            return $is_allowed ; }
        return false ;
    }


    public function getBinaryRequestUser() {

        $userAccountFactory = new \Model\UserAccount();
        $userAccount = $userAccountFactory->getModel($this->params);
        $data = var_export($_SERVER, true) ;
        $data2 = var_export($this->getAllHeaders(), true) ;
        //file_put_contents('/tmp/pharaoh.log', $data, FILE_APPEND) ;
        //file_put_contents('/tmp/pharaoh.log', $data2, FILE_APPEND) ;
        if (isset($this->params['auth_user'])) {
            $res = $userAccount->checkLoginInfo($this->params['auth_user'], $this->params['auth_pw'], false) ;
            // echo(var_export($res, true).$this->params['auth_user'].$this->params['auth_pw']) ;
            if ($res['status'] === true) {
                $ret = array(
                    'user' => $this->params['auth_user']
                ) ;
                return $ret ;
            }

            $userOAuthKeyFactory = new \Model\UserOAuthKey();
            $userOAuthKey = $userOAuthKeyFactory->getModel($this->params, 'AuthenticateKey');
            $user = $userOAuthKey->authenticateOauth($this->params['auth_user'], $this->params['auth_pw']) ;
            if (is_array($user) && isset($user['user'])) {
                $ret = array(
                    'user' => $user['user']
                ) ;
                return $ret ;
            }

//            file_put_contents('/tmp/pharaoh.log', "auth oauth:\n", FILE_APPEND) ;
//            file_put_contents('/tmp/pharaoh.log', var_export($user, true), FILE_APPEND) ;

        }

        $retuser = $userAccount->getLoggedInUserData();
        if ($retuser !== false) {
            $ret = array(
                'user' => $retuser['username']
            ) ;
            return $ret ;
        }

        if (isset($_SERVER["REDIRECT_HTTP_AUTHORIZATION"])) {
            $base64 = str_replace("Basic ", "", $_SERVER["REDIRECT_HTTP_AUTHORIZATION"]) ;
            $string = base64_decode($base64) ;
            $vals = explode(":", $string) ;
            $req_user = array() ;
            $req_user["user"] = $vals[0] ;
            $req_user["pass"] = $vals[1] ;
            return $req_user ; }
        else if (isset($_SERVER["REDIRECT_REMOTE_USER"])) {
            return array("user"=> $_SERVER["REDIRECT_REMOTE_USER"]) ; }
        return array("user"=> null, "pass"=> null) ;
    }

    protected function authUserToRead($binaryRequestUser, $repo_name) {
        if ( $binaryRequestUser["user"] == "anon" ) {
            return false ; }
        $repoFactory = new \Model\Repository() ;
        $repo = $repoFactory->getModel($this->params, "Default") ;
        $thisRepo = $repo->getRepository($repo_name) ;
        $hidden = (isset($thisRepo["settings"]["HiddenScope"]["enabled"]) && $thisRepo["settings"]["HiddenScope"]["enabled"]=="on") ? true : false ;
        $hidden_from_members = (isset($thisRepo["settings"]["HiddenScope"]["hidden_from_members"]) && $thisRepo["settings"]["HiddenScope"]["hidden_from_members"]=="on") ? true : false ;

//        $uaFactory = new \Model\Signup();
//        $signup = $uaFactory->getModel($this->params) ;
//        if ($ua->userNameExist($binaryRequestUser["user"]) === false) {
//            return false ;
//        }

        $uaFactory = new \Model\UserAccount();
        $ua = $uaFactory->getModel($this->params) ;

        if ($ua->userNameExist($binaryRequestUser["user"]) === false) {

            $uoFactory = new \Model\UserOAuthKey();
            $uo = $uoFactory->getModel($this->params) ;

            $is_key = $uo->findUsernameFromKey($binaryRequestUser["user"]) ;
            if ($is_key === false) {
                return false ;
            } else {
                $binaryRequestUser["user"] = $is_key ;
            }
        }

        if ($hidden === true) {
//            var_dump('its hidden');
            // @todo here
            // if logged in user is owner
            if ($binaryRequestUser["user"] === $thisRepo["project-owner"]) {
//                var_dump('user match ting');
                return true ; }
            // if settings say hide from members return false
            if ($hidden_from_members === true) {
                return false ; }
            // if logged in user is member return true
            $pm = explode(",", $thisRepo["project-members"]) ;
            if (in_array($binaryRequestUser["user"], $pm)) {
                return true ; }
            return false ;
        } else {
            return true ;
        }


    }

    protected function authUserToWrite($binaryRequestUser, $repo_name) {
        if ( $binaryRequestUser["user"] == "anon" ) { return false ; }
        $repoFactory = new \Model\Repository() ;
        $repo = $repoFactory->getModel($this->params, "Default") ;
        $thisRepo = $repo->getRepository($repo_name) ;
        $hidden = (isset($thisRepo["settings"]["HiddenScope"]["enabled"]) &&
            $thisRepo["settings"]["HiddenScope"]["enabled"]=="on") ? true : false ;
        $hidden_from_members = (isset($thisRepo["settings"]["HiddenScope"]["hidden_from_members"]) &&
            $thisRepo["settings"]["HiddenScope"]["hidden_from_members"]=="on") ? true : false ;

        $uaFactory = new \Model\UserAccount();
        $ua = $uaFactory->getModel($this->params) ;
        if ($ua->userNameExist($binaryRequestUser["user"]) === false) {

            $uoFactory = new \Model\UserOAuthKey();
            $uo = $uoFactory->getModel($this->params) ;

            $is_key = $uo->findUsernameFromKey($binaryRequestUser["user"]) ;
            if ($is_key === false) {
                return false ;
            } else {
                $binaryRequestUser["user"] = $is_key ;
            }
        }

//        file_put_contents('/tmp/pharaoh.log', "authUserToWrite:\n", FILE_APPEND) ;
//        file_put_contents('/tmp/pharaoh.log', var_export($binaryRequestUser, true), FILE_APPEND) ;

        if ($hidden === true) {
            // @todo here
            // if logged in user is owner
            if ($binaryRequestUser["user"]==$thisRepo["project-owner"]) { return true ; }
            // if settings say hide from members return false
            if ($hidden_from_members==true) { return false ; }
            // if logged in user is member return true
            $pm = explode(",", $thisRepo["project-members"]) ;
            if (in_array($binaryRequestUser["user"], $pm)) { return true ; }
            return false ;
        } else {
            return true ; }
    }

    protected function isWriteAction() {
        $is_download = ($_FILES == array()) ? true : false ;
        return !$is_download ;
    }


}