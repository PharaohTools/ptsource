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
        $this->fixPushPerms() ;
        return $out ;
    }

    public function fixPushPerms() {
        $repo_name = $this->findRepoName() ;
        $command  = SUDOPREFIX." chmod -R 775 /opt/ptsource/repositories/{$repo_name}/objects && ";
        $command .= SUDOPREFIX." chown -R ptsource: /opt/ptsource/repositories/{$repo_name}/objects ;";
        ob_start() ;
        $rc = $this->executeAsShell($command) ;
        $out = ob_get_clean() ;
        file_put_contents('/tmp/pharaoh.log', $rc.$out, FILE_APPEND) ;
        return $rc ;
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

        if ($this->userIsAllowed($binaryRequestUser, $repo_name)==false) {
            header('HTTP/1.1 403 Forbidden');
            return false ;  }

        if (isset($this->params['version'])) {
            if ($this->versionStringIsValid($this->params['version'])) {
                $this_version = $this->params['version'] ;
            } else {
                header('HTTP/1.1 400 Unable to handle request');
                echo "Incompatible Version String Requested" ;
                return false ;
            }
        } else {
            $this_version = '0.0.1' ;
        }

        $dir_to_write = REPODIR.DS.$this->params["item"].DS.$this_version ;
        if (!is_dir($dir_to_write)) {
            mkdir($dir_to_write, 0755, true);
        }
        $contents = file_get_contents($_FILES['file']['tmp_name']) ;

        $res = file_put_contents($dir_to_write.DS.$_FILES['file']['name'], $contents);
        if ($res !== false) {
            echo "File was uploaded successfully" ;
            return true ;
        } else {
            echo "File Upload failed" ;
            return false ;
        }

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
            //error_log("is not a write") ;
            $publicReads = $this->repoPublicAllowed("read", $repo_name) ;
//            var_dump('public reads', $publicReads) ;
            if ($publicReads == true) {
                return true ; }
            else {
                return $this->authUserToRead($binaryRequestUser, $repo_name) ; } }
        else {
            //error_log("is a write") ;
            $publicWrites = $this->repoPublicAllowed("write", $repo_name) ;
            if ($publicWrites == true) {
                //error_log("public write allowed") ;
                return true ; }
            else {
                //error_log("no public") ;
                $res = $this->authUserToWrite($binaryRequestUser, $repo_name) ;
                //error_log("auth is: {$res}") ;
                return $res ; } }
    }


    protected function repoPublicAllowed($type, $repo_name) {
        $repoFactory = new \Model\Repository() ;
        $repo = $repoFactory->getModel($this->params, "Default") ;
        $thisRepo = $repo->getRepository($repo_name) ;
//        ob_start();
//        var_dump($repo_name, $thisRepo);
//        $res = ob_get_clean();
//        error_log($res) ;
        $public_enabled = (isset($thisRepo["settings"]["PublicScope"]["enabled"]) && $thisRepo["settings"]["PublicScope"]["enabled"]=="on") ? true : false ;
        if ($public_enabled == false) { return false ; }
        if ($type == "read" || $type == "write") {
            $is_allowed = (isset($thisRepo["settings"]["PublicScope"]["public_{$type}"]) && $thisRepo["settings"]["PublicScope"]["public_{$type}"]=="on") ? true : false ;
            return $is_allowed ; }
        return false ;
    }


    protected function getBinaryRequestUser() {
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
        // @TODO There are multiple better ways to do this. Maybe a method parameter
        // var_dump($_SERVER["REQUEST_URI"]) ;
        if (isset($_SERVER["REQUEST_URI"])) {
            // Its a http request
            if ( strpos($_SERVER["REQUEST_URI"], "binary-receive-pack") !== false) {
                return true ; }
            return false ; }
        else {
            // Its an SSH request
             if (strpos($this->params["ssh_command"], 'binary-recieve-pack') === 0) {
                return true ; }
            return false ; }
    }


}