<?php

Namespace Model;

class ShellLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getStepTypes() {
        return array_keys($this->getFormFields());
    }

    public function getFormFields() {
        $ff = array(
            "shelldata" => array(
                "type" => "textarea",
                "name" => "Shell Data",
                "slug" => "data" ),
            "shellscript" => array(
                "type" => "text",
                "name" => "Shell Script",
                "slug" => "script" ), );
        return $ff ;
    }

    public function executeStep($step) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if ( $step["steptype"] == "shelldata") {
            $logging->log("Running Shell from Data...", $this->getModuleName()) ;
            $env_var_string = "" ;
            if (isset($this->params["env-vars"]) && is_array($this->params["env-vars"])) {
                $logging->log("Shell Extracting Environment Variables...", $this->getModuleName()) ;
                $ext_vars = implode(", ", array_keys($this->params["env-vars"])) ;
                $count = 0 ;
                foreach ($this->params["env-vars"] as $env_var_key => $env_var_val) {
                    $env_var_string .= "$env_var_key=$env_var_val\n" ;
                    $count++ ; }
                $logging->log("Successfully Extracted {$count} Environment Variables into Shell Variables {$ext_vars}...", $this->getModuleName()) ; }
            $data = $step["data"] ;
            $data = $this->addSetter($data) ;
            $data = $env_var_string.$data ;
            $rc = $this->executeAsShell($data);
            $res = ($rc == 0) ? true : false ;
//            var_dump("rc dump in shell is: ", $rc, $res) ;
            return $res ; }
        else if ( $step["steptype"] == "shellscript") {
            $logging->log("Running Shell from Script...", $this->getModuleName()) ;
            $env_var_string = "" ;
            if (isset($this->params["env-vars"]) && is_array($this->params["env-vars"])) {
                $logging->log("Shell Extracting Environment Variables...", $this->getModuleName()) ;
                $ext_vars = implode(", ", array_keys($this->params["env-vars"])) ;
                $count = 0 ;
                foreach ($this->params["env-vars"] as $env_var_key => $env_var_val) {
                    $env_var_string .= "$env_var_key=$env_var_val\n" ;
                    $count++ ; }
                $logging->log("Successfully Extracted {$count} Environment Variables into Shell Variables {$ext_vars}...", $this->getModuleName()) ; }
            $data = $step["data"] ;
            $data = $this->addSetter($data) ;
            $data = $env_var_string.$data ;
            $rc = $this->executeAsShell("bash {$data}") ;
            $res = ($rc == 0) ? true : false ;
            return $res ; }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in Shell Module", $this->getModuleName()) ;
            return false ; }
    }

    private function addSetter($data) {
        $data = "set -e"."\n".$data ;
        return $data ;
    }

}
