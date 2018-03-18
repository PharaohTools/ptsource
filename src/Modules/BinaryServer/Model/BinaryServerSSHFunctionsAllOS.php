<?php

Namespace Model;

class GitServerSSHFunctionsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("ServerSSHFunctions") ;

    public function ensureSSHServerStatus() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $this->params["app-log"] = true ;
        $this->params["php-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $mod_config = \Model\AppConfig::getAppVariable("mod_config") ;
        $is_enabled = ($mod_config["SSHServer"]['enable_ssh_server'] === 'on') ;
        if ($is_enabled === true) {
//            $app_root  = PFILESDIR.PHARAOH_APP.DS.PHARAOH_APP.DS ;
//            $bin_file = $app_root . 'src'.DS.'Modules'.DS.'GitServer'.DS.'Libraries' ;
//            $bin_file .= DS.'vendor'.DS.'fpoirotte'.DS.'pssht'.DS.'bin'.DS.'pssht' ;
//            $base_bin = basename($bin_file) ;
//            error_log($bin_file) ;
//            if (is_file($bin_file)) {
//                $logging->log("Found Server Bin file {$base_bin}", $this->getModuleName()) ;
//                $comm = "cd {$app_root} && bash -c 'php {$bin_file} >> {$app_root}ssh_log.txt 2>&1 ' & " ;
//                # bash -c 'php /opt/ptsource/ptsource/src/Modules/GitServer/Libraries/vendor/fpoirotte/psshtin/pssht > /tmp/outy 2>&1 ' &
//                $logging->log("Comm is {$comm}", $this->getModuleName()) ;
////                $status = $this->executeAndGetReturnCode($comm);
////                if ($status !== 0) {
////                    return false; }
//            }
    }
        else {
            $app_root  = PFILESDIR.PHARAOH_APP.DS.PHARAOH_APP.DS ;
//            $bin_file = $app_root . 'src'.DS.'Modules'.DS.'GitServer'.DS.'Libraries' ;
//            $bin_file .= DS.'vendor'.DS.'fpoirotte'.DS.'pssht'.DS.'bin'.DS.'pssht' ;
//            $base_bin = basename($bin_file) ;
//            error_log($bin_file) ;
//            if (is_file($bin_file)) {
//                $logging->log("Found Server Bin file {$base_bin}", $this->getModuleName()) ;
//                $comm = "cd {$app_root} && pkill pssht " ;
//                # bash -c 'php /opt/ptsource/ptsource/src/Modules/GitServer/Libraries/vendor/fpoirotte/psshtin/pssht > /tmp/outy 2>&1 ' &
//                $logging->log("Comm is {$comm}", $this->getModuleName()) ;
////                $status = $this->executeAndGetReturnCode($comm);
////                if ($status !== 0) {
////                    return false; }
////            }
        }
        $logging->log("SSH Server Status has been ensured", $this->getModuleName());
        return true ;
    }

    public function sshUserIsAllowed($gitRequestUser, $repo_name) {
//        $parsed = $this->parseSSHCommand($ssh_command) ;
        $gr_ray = array('user' => $gitRequestUser) ;
        $gsf = new \Model\BinaryServer();
        $pos = strrpos($repo_name, '/') ;
        $repo_name = substr($repo_name, $pos) ;
        $this->params['item'] = $repo_name ;
        $gs = $gsf->getModel($this->params) ;
        $res = $gs->userIsAllowed($gr_ray, $repo_name) ;
        return $res ;
    }

    protected function parseSSHCommand($ssh_command) {
        if (strpos($ssh_command, 'git-upload-pack') === 0) {
            // is a read
            $readwrite = 'read' ;
            $without_gitcomm = substr($ssh_command, 15) ;
        }
        elseif (strpos($ssh_command, 'git-recieve-pack') === 0) {
            // is a write
            $readwrite = 'write' ;
            $without_gitcomm = substr($ssh_command, 15) ;
        }
        else {
            // not an allowed command
            return false ;
        }
        $repo_path = $this->parseGitCommand($without_gitcomm) ;
        $path_sections = $this->parseRepoPath($repo_path) ;
        return $path_sections ;
    }

    protected function parseGitCommand($without_gitcomm) {
        $start = strpos($without_gitcomm, "/") ;
        $no_first = substr($without_gitcomm, $start-1) ;
        $end = strrpos($no_first, "/") ;
        $parsed = substr($no_first, 0, $end+1) ;
        return $parsed ;
    }

    protected function parseRepoPath($repo_path) {
        $sections = explode('/', $repo_path) ;
        $return_sections = array() ;
        if (in_array($sections[0], array('git', 'scm')) ) {
            $return_sections['scm_type'] = 'git' ;
        } else {
            // This is an incorrect command
            return false ;
        }
        $return_sections['repo_owner'] = $sections[1] ;
        $return_sections['repo_name'] = $sections[2] ;
        return $return_sections ;
    }

}