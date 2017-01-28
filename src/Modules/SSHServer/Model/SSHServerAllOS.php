<?php

Namespace Model;

class SSHServerAllOS extends Base {

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
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $this->params["app-log"] = true ;
        $this->params["php-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $mod_config = \Model\AppConfig::getAppVariable("mod_config") ;
        $is_enabled = ($mod_config["SSHServer"]['enable_ssh_server'] === 'on') ;
        if ($is_enabled === true) {
            $app_root  = PFILESDIR.PHARAOH_APP.DS.PHARAOH_APP.DS ;
            $bin_file = $app_root . 'src'.DS.'Modules'.DS.'GitServer'.DS.'Libraries' ;
            $bin_file .= DS.'vendor'.DS.'fpoirotte'.DS.'pssht'.DS.'bin'.DS.'pssht' ;
            $base_bin = basename($bin_file) ;
            error_log($bin_file) ;
            if (is_file($bin_file)) {
                $logging->log("Found Server Bin file {$base_bin}", $this->getModuleName()) ;
                $comm = "cd {$app_root} && bash -c 'php {$bin_file} >> {$app_root}ssh_log.txt 2>&1 ' & " ;
                # bash -c 'php /opt/ptsource/ptsource/src/Modules/GitServer/Libraries/vendor/fpoirotte/psshtin/pssht > /tmp/outy 2>&1 ' &
                $logging->log("Comm is {$comm}", $this->getModuleName()) ;
//                $status = $this->executeAndGetReturnCode($comm);
//                if ($status !== 0) {
//                    return false; }
            } }
        else {
            $app_root  = PFILESDIR.PHARAOH_APP.DS.PHARAOH_APP.DS ;
            $bin_file = $app_root . 'src'.DS.'Modules'.DS.'GitServer'.DS.'Libraries' ;
            $bin_file .= DS.'vendor'.DS.'fpoirotte'.DS.'pssht'.DS.'bin'.DS.'pssht' ;
            $base_bin = basename($bin_file) ;
            error_log($bin_file) ;
            if (is_file($bin_file)) {
                $logging->log("Found Server Bin file {$base_bin}", $this->getModuleName()) ;
                $comm = "cd {$app_root} && pkill pssht " ;
                # bash -c 'php /opt/ptsource/ptsource/src/Modules/GitServer/Libraries/vendor/fpoirotte/psshtin/pssht > /tmp/outy 2>&1 ' &
                $logging->log("Comm is {$comm}", $this->getModuleName()) ;
//                $status = $this->executeAndGetReturnCode($comm);
//                if ($status !== 0) {
//                    return false; }
            } }
        $logging->log("SSH Server Status has been ensured", $this->getModuleName());
        return true ;
    }

}