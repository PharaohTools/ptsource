<?php

Namespace Model;

class PluginLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getStepTypes() {
        return $this->getInstalledPlugins();
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
                "slug" => "script" ),
        );
        return $ff ;
    }

    public function executeStep($step) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $plugin = $this->getInstalledPlugins();
        $pluginFolderOnPiPe = PIPEDIR.DS.$this->params["item"].DS.'plugins'.DS; 
        if (!file_exists($pluginFolderOnPiPe))
            mkdir($pluginFolderOnPiPe, 0777);
                
        if ( in_array($step["steptype"], $plugin) ) {
            $input = $step;
            $pluginWorkDir = PIPEDIR.DS.$this->params["item"].DS.'plugins'.DS.$step["steptype"].DS;
            if (!file_exists($pluginWorkDir))
                mkdir($pluginWorkDir, 0777);
            $logging->log("Running Plugin by Data...") ;
            $pipeInstalledDir = str_replace('pipes','plugins/installed',PIPEDIR);
            $input["pluginWorkDir"] = $pluginWorkDir;
            $input["tmpfile"] = PIPEDIR.DS.$this->params["item"].DS.'tmpfile';
            if(!include_once($pipeInstalledDir.DS.$step["steptype"].DS.'Triger.php') ) {
                echo 'Plugin Removed';
                $logging->log("Plugin Removed") ;
                return false;
            }
            else {
                return true;
            }
        }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in Shell Module") ;
            return false ;
        }
    }
    
    public function getInstalledPlugins()
    {
        $detail = array();
        $plugin = scandir(str_replace('pipes','plugins/installed',PIPEDIR)) ;
        for ($i=0; $i<count($plugin); $i++) {
            if (!in_array($plugin[$i], array(".", "..", "tmpfile"))){
                $detail[] = $plugin[$i];
            } 
        }
        return $detail;
    }
}
