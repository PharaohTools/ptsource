<?php

Namespace Model ;

class StepRunnerDefaultLinux extends Base {

    public $phlagrantfile;
    public $papyrus ;
    protected $stepRunnerModel ;

    public function stepRunner($hook = "") {
        $stepRunnerOuts = array() ;
        if ($hook != "") {$hook = "_$hook" ; }
        foreach ($this->phlagrantfile->config["vm"]["stepRunner$hook"] as $stepRunnerSettings) {
            $stepRunnerOuts[] = $this->doSingleStepRunner($stepRunnerSettings) ; }
        return $stepRunnerOuts ;
    }

    public function stepRunnerHook($hook, $type) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params) ;
        $logging->log("Running Step from Phlagrantfile settings if available for $hook $type") ;
        $stepRunnerOuts = $this->stepRunnerPhlagrantfile($hook, $type) ;
        $logging->log("Running Step from hook directories if available for $hook $type") ;
        $stepRunnerOuts = array_merge($stepRunnerOuts, $this->stepRunnerHookDirs($hook, $type)) ;
        return $stepRunnerOuts ;
    }

    protected function stepRunnerPhlagrantfile($hook, $type) {
        $stepRunnerOuts = array() ;
        if (isset($this->phlagrantfile->config["vm"]["stepRunner_{$hook}_{$type}"]) &&
            count($this->phlagrantfile->config["vm"]["stepRunner_{$hook}_{$type}"])>0){
            foreach ($this->phlagrantfile->config["vm"]["stepRunner_{$hook}_{$type}"] as $stepRunnerSettings) {
                $stepRunnerOuts[] = $this->doSingleStepRunner($stepRunnerSettings) ; } }
        return $stepRunnerOuts ;
    }

    protected function stepRunnerHookDirs($hook, $type) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params) ;
        $stepRunnerOuts = array() ;
        // @todo this will do for now but should be dynamic
        $stepRunners = array("PharaohTools", "Shell") ;
        foreach ($stepRunners as $stepRunner) {
            // echo "dave a2\n" ;
            // @todo this will do for now but should be dynamic
            $tools = array("cleopatra", "dapperstrano", "shell") ;
            foreach ($tools as $tool) {
                // echo "dave a3\n" ;
                $targets = array("host", "guest") ;
                foreach ($targets as $target) {
                    $dir = getcwd().DS."build".DS."config".DS."phlagrant".DS."hooks".DS."$stepRunner".DS.
                        "$tool".DS."$hook".DS."$target".DS."$type" ;
                    $hookDirectoryExists = file_exists($dir) ;
                    $hookDirectoryIsDir = is_dir($dir) ;
                    // var_dump("hde", $hookDirectoryExists, "hdd", $hookDirectoryIsDir) ;
                    // echo "dave a4 $dir\n" ;
                    if ($hookDirectoryExists) {
                        $relDir = str_replace(getcwd(), "", $dir) ;
                        $logging->log("Phlagrant hook directory $relDir found") ;
                        $hookDirFiles = scandir($dir) ;
                        // echo "dave a5 x ".implode(" ", $hookDirFiles) ;
                        foreach ($hookDirFiles as $hookDirFile) {
                            // echo "dave a6\n" ;
                            if (substr($hookDirFile, strlen($hookDirFile)-4) == ".php") {
                                $logging->log("Phlagrant hook file $dir".DS."$hookDirFile found") ;
                                $stepRunnerSettings =
                                    array(
                                        "stepRunner" => $stepRunner,
                                        "tool" => $tool,
                                        "target" => $target,
                                        "script" => "$dir".DS."$hookDirFile"
                                    );
                                $stepRunnerOuts[] = $this->doSingleStepRunner($stepRunnerSettings) ;
                                $logging->log("Executing $hookDirFile with $tool") ; } } } } } }
        return $stepRunnerOuts ;
    }


    // @todo this should support other stepRunners than pharaoh, provide some override here to allow
    // @todo chef solo, puppet agent, salt or ansible to get invoked
    protected function doSingleStepRunner($stepRunnerSettings) {
        $pharaohSpellings = array("Pharaoh", "pharaoh", "PharaohTools", "pharaohTools", "Pharaoh", "pharaoh", "PharaohTools", "pharaohTools") ;
        if (in_array($stepRunnerSettings["stepRunner"], $pharaohSpellings)) {
            $stepRunnerObjectFactory = new \Model\PharaohTools() ; }
        else if (in_array($stepRunnerSettings["stepRunner"], array("shell", "bash", "Shell", "Bash"))) {
            $stepRunnerObjectFactory = new \Model\Shell() ; }
        $stepRunnerObject = $stepRunnerObjectFactory->getModel($this->params, "StepRunner");
        $stepRunnerObject->phlagrantfile = $this->phlagrantfile;
        $stepRunnerObject->papyrus = $this->papyrus;
        return $stepRunnerObject->stepRunner($stepRunnerSettings, $this) ;
    }

}
