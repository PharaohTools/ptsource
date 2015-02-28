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
    	/*foreach ($this->getFormFields() as $key => $val)
			$type[] = $key;
		return $type;*/
        //return array_keys($this->getFormFields());
        return $this->getInstalledPlugins();
    }

    public function getFormFields() {
        //print_r($this->getInstalledPluginsField);
        return $this->getInstalledPluginsField() ;
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
            if(!include_once(PLUGININS.DS.$step["steptype"].DS.'Triger.php') ) {
            	echo 'Plugin Removed';
                $logging->log("Plugin Removed") ;
                return false;
            }
            else {
            	$input["tmpfile"] = PIPEDIR.DS.$this->params["item"].DS.'tmpfile';
				$input['pipeName'] = $this->params["item"];
                $input["pluginWorkDir"] = $pluginWorkDir;
				$step['steptype'] = "Publish_HTML_Reports";
				$classname = str_replace(' ', '_', $step['steptype']);
				$classname = str_replace('-', '_', $classname);
				call_user_func( $classname.'::startTriger', $input );
				return $result;
            }
        }
        else {
            $logging->log("Unrecognised Build Step Type {$step["type"]} specified in Plugin Module") ;
            return false ;
        }
    }
    
    public function getInstalledPlugins()
    {
        $detail = array();
        $plugin = scandir(PLUGININS) ;
        for ($i=0; $i<count($plugin); $i++) {
            if (!in_array($plugin[$i], array(".", ".."))){
                $detail[] = $plugin[$i];
            } 
        }
        return $detail;
    }
    
        
public function getInstalledPluginsField()
    {
    	$plugin = scandir(PLUGININS) ;
        for ($i=0; $i<count($plugin); $i++) {
            if (!in_array($plugin[$i], array(".", "..", "tmpfile"))){
                if(is_dir(PLUGININS.DS.$plugin[$i])) {
                    // @todo if this isnt definitely a build dir ignore maybe
                    //$detail['details'][$plugin[$i]] = $this->getInstalledPlugin($plugin[$i]);
                    $detail[$plugin[$i]] = $this->getInstalledPluginData($plugin[$i]); } } }
        return (isset($detail) && is_array($detail)) ? $detail : array() ;
    }
/*
    public function getInstalledPlugin($plugin) {
	$defaultsFile = PLUGININS.DS.$plugin.DS.'details' ;
        if (file_exists($defaultsFile)) {
            $defaultsFileData =  file_get_contents($defaultsFile) ;
            $defaults = json_decode($defaultsFileData, true) ; }
        return  (isset($defaults) && is_array($defaults)) ? $defaults : array() ;
    }
*/
    public function getInstalledPluginData($plugin) {
        /*$file = PIPEDIR . DS . $this->params["item"] . DS . 'pluginData';
        if ($pluginData = file_get_contents($file)) {
            $pluginData = json_decode($pluginData, true);
        }*/
        $defaultsFile = PLUGININS.DS.$plugin.DS.'data' ;
        if (file_exists($defaultsFile)) {
            $defaultsFileData =  file_get_contents($defaultsFile) ;
            $defaults = json_decode($defaultsFileData, true) ; 
        }
        //print_r($defaults);
        foreach ($defaults['buildconf'] as $key=>$val) {
            /*if (isset ($pluginData[$plugin][$val['name']]) ) {
                $value = $pluginData[$plugin][$val['name']];
                $defaults['buildconf'][$key]['value'] = $value;
            }*/
              //  $value = $pluginData[$plugin][$val['name']];
                $data[][$key] = $val;
        }
        $defaults = $defaults['buildconf'];
        return  (isset($defaults) && is_array($defaults)) ? $defaults : array() ;
    }

	
}
