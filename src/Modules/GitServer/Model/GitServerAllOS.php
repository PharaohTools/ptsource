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

    public function backendData2() {
        $gsf = new \Model\GitServer();
        $gs = $gsf->getModel($this->params, "ServerFunctions") ;
        $gs->serveGit() ;
    }

    public function backendData() {

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


        if(isset($_SERVER["PATH_INFO"]))
        {
            list($git_project_path, $path_info) = $temp = preg_split("/\//", $_SERVER["PATH_INFO"], 2, PREG_SPLIT_NO_EMPTY);
            $git_project_path = "/" . $git_project_path . "/";
            $path_info = "/" . $path_info;
        }
        else
        {
            $git_project_path = "/";
            $path_info = "";
        }
        $path_info = "/".$this->params["item"] ;
        $request_headers = $this->getAllHeaders();

        $php_input = file_get_contents("php://input");
        $env = array
        (
            "GIT_PROJECT_ROOT"    => REPODIR ,
            "GIT_HTTP_EXPORT_ALL" => 1,
            "GIT_HTTP_MAX_REQUEST_BUFFER" => "1000M",
//            'PATH' => $_SERVER["PATH"],
//            "REMOTE_USER"         => isset($_SERVER["REMOTE_USER"])          ? $_SERVER["REMOTE_USER"]          : REMOTE_USER,
            "REMOTE_USER"         => isset($_SERVER["REMOTE_USER"])          ? $_SERVER["REMOTE_USER"]          : "ptsource",
//            "REMOTE_ADDR"         => isset($_SERVER["REMOTE_ADDR"])          ? $_SERVER["REMOTE_ADDR"]          : "",
            "REMOTE_ADDR"         => isset($_SERVER["REMOTE_ADDR"])          ? $_SERVER["REMOTE_ADDR"]          : "",
            "REQUEST_METHOD"      => isset($_SERVER["REQUEST_METHOD"])       ? $_SERVER["REQUEST_METHOD"]       : "",
            "PATH_INFO"           => $path_info,
            "QUERY_STRING"        => isset($_SERVER["QUERY_STRING"])         ? $_SERVER["QUERY_STRING"]         : "",
            "CONTENT_TYPE"        => isset($request_headers["Content-Type"]) ? $request_headers["Content-Type"] : "",
        );
        $env = array_merge( $env, array(
//            "GIT_COMMITTER_NAME" => "Pharaoh King",
//            "GIT_COMMITTER_EMAIL" => "phpengine@pharaohtools.com",
        ) ) ;

        $pathStarts = array('/HEAD', '/info/', '/objects/') ;

        $scm_synonyms = array("git", "scm") ;
        $qs = $_SERVER["REQUEST_URI"] ;
        foreach ($scm_synonyms as $scm_synonym) {
            $remove = "/{$scm_synonym}/" ;
//            $remove = "/{$scm_synonym}/{$this->params["user"]}/{$this->params["item"]}" ;
            $qs = str_replace($remove, "", $qs) ; }



        $query_data = $_GET;
        foreach ($query_data as $key => $value) {
            if (!strncmp($key, '__', 2)) {
                unset($query_data[$key]);
            }
        }
        $query_string = http_build_query($query_data, '', '&');


        $qsmpos = strpos($qs, "?") ;
        $newqsm = $qsmpos ;
//        if ($qsmpos !== false) {
//
//            $newqsm = substr($qs, 0, $qsmpos);
//        }

        $env["QUERY_STRING"] = $qs ; //substr($qs, $qsmpos);  //;
        $env["PATH_INFO"] = $path_info ;

        $settings = array
        (
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
        );
        if(defined(DEBUG_LOG))
        {
            $settings[2] = array("file", LOG_PROCESS, "a");
        }
        $process = proc_open(GIT_HTTP_BACKEND , $settings, $pipes, null, $env);
        if(is_resource($process))
        {
//            error_log("php in: $php_input" ) ;
            fwrite($pipes[0], $php_input);
            fclose($pipes[0]);
            $return_output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            $return_code = proc_close($process);
            error_log("rc: $return_code, stduot: $return_output" ) ;

        }
        else {
            error_log("is r:", is_resource($process) ) ;
        }
        if(!empty($return_output))
        {
            list($response_headers, $response_body)
                = $response
                = preg_split("/\R\R/", $return_output, 2, PREG_SPLIT_NO_EMPTY);

            foreach(preg_split("/\R/", $response_headers) as $response_header)
            {
                header($response_header);
            }
            if(isset($request_headers["Accept-Encoding"]) && strpos($request_headers["Accept-Encoding"], "gzip") !== false && GZIP_SUPPORT)
            {
                $gzipoutput = gzencode($response_body, 6);
                ini_set("zlib.output_compression", "Off");
                header("Content-Encoding: gzip");
                header("Content-Length: " . strlen($gzipoutput));
                echo $gzipoutput;
            }
            else
            {
                echo $response_body;
            }
        }

        if(DEBUG_LOG)
        {
            file_put_contents(LOG_RESPONSE, "");
            $log = "";
            //$log .= "\$_GET = " . print_r($_GET, true);
            //$log .= "\$_POST = " . print_r($_POST, true);
            //$log .= "\$_SERVER = " . print_r($_SERVER, true);
            $log .= "\$request_headers = " . print_r($request_headers, true);
            $log .= "\$env = " . print_r($env, true);
            $log .= "\$server = " . print_r($_SERVER, true);
            $log .= "\$php_input = " . PHP_EOL . $php_input . PHP_EOL;
            //$log .= "\$return_output = " . PHP_EOL . $return_output . PHP_EOL;
            $log .= "\$response = " . print_r($response, true);
            $log .= str_repeat("-", 80) . PHP_EOL;
            $log .= PHP_EOL;
//            if(isset($_GET["service"]) && $_GET["service"] == "git-receive-pack") file_put_contents(LOG_RESPONSE, "");
            file_put_contents(LOG_RESPONSE, $log, FILE_APPEND);
//            file_put_contents(LOG_RESPONSE, "service is: ".$_GET["service"], FILE_APPEND);
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

    public function strPosX2($haystack, $needle, $number){
        if ($number == 1) {
            return strpos($haystack, $needle); }
        else if ($number > 1){
            return strpos($haystack, $needle, $this->strPosX($haystack, $needle, $number - 1) + strlen($needle)); }
        else {
            return error_log('Error: Value for parameter $number is out of range'); }
    }

    public function strPosX($haystack, $needle, $number){
        $cur_sp = 0 ;
        for ($i=1 ; $i<=$number; $i++) {
            $cur_sp = strpos($haystack, $needle, $cur_sp) ; }
        return  $cur_sp ;
    }

}