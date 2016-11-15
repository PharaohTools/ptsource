<?php

Namespace Model;

class AssetPublisherLinuxUnix extends Base {

    // Compatibility
    public $os = array("Linux", "Darwin") ;
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
            "publish-assets" => array("publishAssets",),
        );
        return $ff ;
    }

    public function publishAssets() {
        $r2 = $this->copyToPublicDirectory() ;
        if ($r2 == false) { return false ; }
        $r1 = $this->generatePHPToJS() ;
        if ($r1 == false) { return false ; }
        return true ;
    }

    public function generatePHPToJS() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $logging->log("Checking if NPM Exists...", $this->getModuleName()) ;
        $status = $this->executeAndGetReturnCode('npm -v', true, true);
        if ($status["rc"] != 0) {
            $logging->log("No NPM Found, will use current FileData and Bundle files...", $this->getModuleName()) ;
            return true ; }
        $npmDir = dirname(__DIR__).DS."Libraries".DS."npm".DS ;
        $logging->log("Executing NPM Build command", $this->getModuleName()) ;
        $comm = "cd {$npmDir} && npm run build" ;
        $status = $this->executeAndGetReturnCode($comm, true, true);
        if ($status["rc"] !== 0) {
            $logging->log("Executing NPM Build command failed", $this->getModuleName()) ;
            return false; }
        return true ;
    }

    public function copyToPublicDirectory() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $modDir = PFILESDIR.PHARAOH_APP.DS.PHARAOH_APP.DS."src".DS."Modules".DS ;
        $mods = scandir($modDir) ;
        $mods = array_diff($mods, array(".", "..")) ;
        $piDir = PFILESDIR.PHARAOH_APP.DS.PHARAOH_APP.DS."src".DS."Modules".DS."PostInput".DS ;
        $statuses = array();
        foreach ($mods as $mod) {
            $modPath = $modDir.$mod ;
            $logging->log("Looking for Asset directory in Module $mod", $this->getModuleName()) ;
            $modAssets = $modPath.DS."Assets" ;
            if (is_dir($modPath.DS."Assets")) {
                if ($mod == "PostInput") {
                    $logging->log("Ignoring Asset directory in Module $mod", $this->getModuleName()) ;
                    continue ; }
                else {
                    $logging->log("Found Asset directory in Module $mod", $this->getModuleName()) ;
                    $modPublicAssetDir = $piDir.'Assets'.DS.'Modules'.DS.$mod ; }
                if (!is_dir($modPublicAssetDir)) {
                    $logging->log("Creating Web Server Assets directory $modPublicAssetDir", $this->getModuleName()) ;
                    $comm = "mkdir -p $modPublicAssetDir" ;
                    $status = $this->executeAndGetReturnCode($comm);
                    if ($status !== 0) {
                        return false; } }
                $logging->log("Copying Assets to Web server readable directory", $this->getModuleName()) ;
                $comm = "cp -r $modAssets".DS."* $modPublicAssetDir" ;
                $statuses[] = $this->executeAndGetReturnCode($comm); } }
//        var_dump($statuses) ;
        if (count(array_unique($statuses)) === 1 && in_array(0, $statuses) === 'true') {
            return true ; }
        return true ;
    }

}