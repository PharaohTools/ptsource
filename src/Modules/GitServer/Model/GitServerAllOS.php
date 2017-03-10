<?php

Namespace Model;

class GitServerAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterApplicationConfigurationSave" => array(
                "ensureSSHServerStatus",
            ),
        );
        return $ff ;
    }

    public function ensureSSHServerStatus() {
        $gsf = new \Model\GitServer();
        $gs = $gsf->getModel($this->params, "ServerSSHFunctions") ;
        return $gs->ensureSSHServerStatus() ;
    }

    public function backendData2() {
        $gsf = new \Model\GitServer();
        $gs = $gsf->getModel($this->params, "ServerFunctions") ;
        $gs->serveGit() ;
    }

    public function backendData() {

        $pos = strpos($this->params["item"], '/') ;
        $repo_name = $this->params["item"] ;
        if ($pos !== false) {
            $repo_name = substr($this->params["item"], 0, $pos) ; }

        define("DEBUG_LOG",        true);
        define("HTTP_AUTH",        false);
        define("GZIP_SUPPORT",     false);
        define("GIT_ROOT",         REPODIR.DS );
        define("GIT_HTTP_BACKEND", "/usr/lib/git-core/git-http-backend");
        define("GIT_BIN",          "/usr/bin/git");
        define("REMOTE_USER",      "smart-http");
        define("LOG_RESPONSE",     "/tmp/response.log");
        define("LOG_PROCESS",      "/tmp/process.log");
//        error_log("three" ) ;

        if(isset($_SERVER["PATH_INFO"])) {
            list($git_project_path, $path_info) = $temp = preg_split("/\//", $_SERVER["PATH_INFO"], 2, PREG_SPLIT_NO_EMPTY);
            $git_project_path = "/" . $git_project_path . "/";
            $path_info = "/" . $path_info; }
        else {
            $git_project_path = "/";
            $path_info = ""; }

        $path_info = "/".$this->params["item"] ;
        $request_headers = $this->getAllHeaders();

        $php_input = file_get_contents("php://input");

        $env = array (
            "GIT_PROJECT_ROOT"    => REPODIR ,
            "GIT_HTTP_EXPORT_ALL" => 1,
            "GIT_HTTP_MAX_REQUEST_BUFFER" => "1000M",
//            'PATH' => $_SERVER["PATH"],
//            "REMOTE_USER"         => "ptsource",
//            "REMOTE_USER"         => "smart-http",
            "REMOTE_USER"         => isset($_SERVER["REMOTE_USER"])          ? $_SERVER["REMOTE_USER"]          : "ptsource",
            "REMOTE_ADDR"         => isset($_SERVER["REMOTE_ADDR"])          ? $_SERVER["REMOTE_ADDR"]          : "",
            "REQUEST_METHOD"      => isset($_SERVER["REQUEST_METHOD"])       ? $_SERVER["REQUEST_METHOD"]       : "",
            "PATH_INFO"           => $path_info,
            "QUERY_STRING"        => isset($_SERVER["QUERY_STRING"])         ? $_SERVER["QUERY_STRING"]         : "",
            "CONTENT_TYPE"        => isset($request_headers["Accept"]) ? $request_headers["Accept"] : "",

        );
        // THIS IS IMPORTANT!! THIS IS WHAT STOPS PUSH WORKING. THE GIT CLIENT
        $env["CONTENT_TYPE"]= str_replace("result", "request",$env["CONTENT_TYPE"] );

//        $env = array_merge($_SERVER, $env) ;


        $gitRequestUser = $this->getGitRequestUser() ;

        if ($this->userIsAllowed($gitRequestUser, $repo_name)==false) {
            header('HTTP/1.1 403 Forbidden');
            return false ;  }

//        $pathStarts = array('/HEAD', '/info/', '/objects/') ;
//        $scm_synonyms = array("git", "scm") ;
//        $qs = $_SERVER["REQUEST_URI"] ;
//      THIS IS IMPORTANT! THIS STOPS PUSH FROM WORKING. IF THE QUERY STRING ENV VAR IS NOT SPECIFICALLY
//      SET TO HAVE A STRING WITH ONE PARAMETER IN THE CLIENT ASSUMES A DUMB SERVER PROTOCOL
        $qs = $_SERVER["REQUEST_URI"] ;

        $qsmpos = strpos($qs, "?") ;
        if ($qsmpos==false) {
            $service = basename($qs) ;
            $qs ="service={$service}" ; }
        else {
            if ($qsmpos !== false) {
                $qs = substr($qs, $qsmpos+1); }}

        $env["QUERY_STRING"] = $qs ;

        $env["PATH_INFO"] = $path_info ;

        if (isset($service)) {
            $path_info = str_replace($service, "", $path_info) ;
//            if (substr($path_info, 0, 1) == '/') {
//                $env["PATH_INFO"] = substr($path_info, 1, strlen($path_info)-1) ; }
        }

        $settings = array
        (
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
        );
        if(defined(DEBUG_LOG))
        {
            $settings[2] = array("file", LOG_PROCESS, "a");
        }
        $process = proc_open(GIT_HTTP_BACKEND , $settings, $pipes, REPODIR.$path_info, $env);



//        ob_start();
////        var_dump("this env", phpinfo()) ;
//        var_dump("srv:", $_SERVER, "env:", $env) ;
////        var_dump("grq:", $gitRequestUser) ;
////        var_dump("this env", $_SERVER['HTTP_AUTHORIZATION'], "user", $this->params["user"], "remote user", $_SERVER["REMOTE_USER"], "AUTH user", $_SERVER["PHP_AUTH_USER"], $_SERVER["PHP_AUTH_PW"], $_SERVER["HTTP_AUTHORIZATION"]) ;
//        $res = ob_get_clean();
//        file_put_contents('/var/log/pharaoh.log', $res, FILE_APPEND) ;

        if (is_resource($process)) {
//            error_log("php in: $php_input" ) ;
            fwrite($pipes[0], $php_input);
            fclose($pipes[0]);
            $return_output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            $return_code = proc_close($process);
//            error_log("\n\n\nNew Request" ) ;
//            error_log("rc: $return_code, stduot: $return_output" ) ;
        }
        else {
//            error_log("is r:", is_resource($process) ) ;
        }
        if(!empty($return_output))
        {
//            echo 'Pharaoh Source Git Server' ;
            list($response_headers, $response_body)
                = $response
                = preg_split("/\R\R/", $return_output, 2, PREG_SPLIT_NO_EMPTY);

            foreach(preg_split("/\R/", $response_headers) as $response_header)
            {
                error_log("RH: $response_header" ) ;
                header($response_header);
            }
            if(isset($request_headers["Accept-Encoding"]) && strpos($request_headers["Accept-Encoding"], "gzip") !== false && GZIP_SUPPORT)
            {
                error_log("using gzip" ) ;
                $gzipoutput = gzencode($response_body, 6);
                ini_set("zlib.output_compression", "Off");
                header("Content-Encoding: gzip");
                header("Content-Length: " . strlen($gzipoutput));
                echo $gzipoutput;
            }
            else
            {
                error_log("using no gzip" ) ;
                echo $response_body;
            }
        }
//        echo 'Something went wrong' ;

        if(DEBUG_LOG)
        {
//            file_put_contents(LOG_RESPONSE, "");
            $log = "";
            $log .= "\$request_headers = " . print_r($request_headers, true);
            $log .= "\$env = " . print_r($env, true);
            $log .= "\$server = " . print_r($_SERVER, true);
            $log .= "\$php_input = " . PHP_EOL . $php_input . PHP_EOL;
            //$log .= "\$return_output = " . PHP_EOL . $return_output . PHP_EOL;
            $log .= "\$response = " . print_r($response, true);
            $log .= str_repeat("-", 80) . PHP_EOL;
            $log .= PHP_EOL;
            file_put_contents(LOG_RESPONSE, $log, FILE_APPEND);
        }

    }

    protected function getAllHeaders() {
        if (!is_array($_SERVER)) { return array(); }
        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; } }
        return $headers;
    }


    public function userIsAllowed($gitRequestUser, $repo_name) {
        $isWriteAction = $this->isWriteAction() ;
        if ($isWriteAction == false) {
            //error_log("is not a write") ;
            $publicReads = $this->repoPublicAllowed("read", $repo_name) ;
//            var_dump('public reads', $publicReads) ;
            if ($publicReads == true) {
                return true ; }
            else {
                return $this->authUserToRead($gitRequestUser, $repo_name) ; } }
        else {
            //error_log("is a write") ;
            $publicWrites = $this->repoPublicAllowed("write", $repo_name) ;
            if ($publicWrites == true) {
                //error_log("public write allowed") ;
                return true ; }
            else {
                //error_log("no public") ;
                $res = $this->authUserToWrite($gitRequestUser, $repo_name) ;
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


    protected function getGitRequestUser() {
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

    protected function authUserToRead($gitRequestUser, $repo_name) {
        if ( $gitRequestUser["user"] == "anon" ) {
            return false ; }
        $repoFactory = new \Model\Repository() ;
        $repo = $repoFactory->getModel($this->params, "Default") ;
        $thisRepo = $repo->getRepository($repo_name) ;
        $hidden = (isset($thisRepo["settings"]["HiddenScope"]["enabled"]) && $thisRepo["settings"]["HiddenScope"]["enabled"]=="on") ? true : false ;
        $hidden_from_members = (isset($thisRepo["settings"]["HiddenScope"]["hidden_from_members"]) && $thisRepo["settings"]["HiddenScope"]["hidden_from_members"]=="on") ? true : false ;

//        $uaFactory = new \Model\Signup();
//        $signup = $uaFactory->getModel($this->params) ;
//        if ($ua->userNameExist($gitRequestUser["user"]) === false) {
//            return false ;
//        }

        $uaFactory = new \Model\UserAccount();
        $ua = $uaFactory->getModel($this->params) ;

        if ($ua->userNameExist($gitRequestUser["user"]) === false) {

            $uoFactory = new \Model\UserOAuthKey();
            $uo = $uoFactory->getModel($this->params) ;

            $is_key = $uo->findUsernameFromKey($gitRequestUser["user"]) ;
            if ($is_key === false) {
                return false ;
            } else {
                $gitRequestUser["user"] = $is_key ;
                return true ;
            }
        }

        if ($hidden === true) {
//            var_dump('its hidden');
            // @todo here
            // if logged in user is owner
            if ($gitRequestUser["user"] === $thisRepo["project-owner"]) {
//                var_dump('user match ting');
                return true ; }
            // if settings say hide from members return false
            if ($hidden_from_members === true) {
                return false ; }
            // if logged in user is member return true
            $pm = explode(",", $thisRepo["project-members"]) ;
            if (in_array($gitRequestUser["user"], $pm)) {
                return true ; }
            return false ;
        }

        return true ;

    }

    protected function authUserToWrite($gitRequestUser, $repo_name) {
        if ( $gitRequestUser["user"] == "anon" ) { return false ; }
        $repoFactory = new \Model\Repository() ;
        $repo = $repoFactory->getModel($this->params, "Default") ;
        $thisRepo = $repo->getRepository($repo_name) ;
        $hidden = (isset($thisRepo["settings"]["HiddenScope"]["enabled"]) && $thisRepo["settings"]["HiddenScope"]["enabled"]=="on") ? true : false ;
        $hidden_from_members = (isset($thisRepo["settings"]["HiddenScope"]["hidden_from_members"]) && $thisRepo["settings"]["HiddenScope"]["hidden_from_members"]=="on") ? true : false ;
        if ($hidden == true) {
            // @todo here
            // if logged in user is owner
            if ($gitRequestUser["user"]==$thisRepo["project-owner"]) { return true ; }
            // if settings say hide from members return false
            if ($hidden_from_members==true) { return false ; }
            // if logged in user is member return true
            $pm = explode(",", $thisRepo["project-members"]) ;
            if (in_array($gitRequestUser["user"], $pm)) { return true ; }
            return false ;
        } else {
            return true ; }
    }

    protected function isWriteAction() {
        // @TODO There are multiple better ways to do this. Maybe a method parameter
        // var_dump($_SERVER["REQUEST_URI"]) ;
        if (isset($_SERVER["REQUEST_URI"])) {
            // Its a http request
            if ( strpos($_SERVER["REQUEST_URI"], "git-receive-pack") !== false) {
                return true ; }
            return false ; }
        else {
            // Its an SSH request
             if (strpos($this->params["ssh_command"], 'git-recieve-pack') === 0) {
                return true ; }
            return false ; }
    }


}