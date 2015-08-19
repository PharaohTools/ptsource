<?php

Namespace Model;

class PipelineAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getPipelines() {
        $pipelineFactory = new Pipeline();
        $pipelineRepository = $pipelineFactory->getModel($this->params, "PipelineRepository") ;
        $pipelines = $pipelineRepository->getAllPipelines();
        $ret = $pipelines ;
        return $ret ;
    }

    public function getPipeline($line) {
        $pipelineFactory = new Pipeline();
        $pipelineCollater = $pipelineFactory->getModel($this->params, "PipelineCollater") ;
        $pipeline = $pipelineCollater->getPipeline($line);
        $ret = $pipeline ;
        return $ret ;
    }

    public function savePipeline($line) {
        $pipelineFactory = new Pipeline();
        $pipelineSaver = $pipelineFactory->getModel($this->params, "PipelineSaver") ;
        $pipeline = $pipelineSaver->getPipeline($line);
        $ret = $pipeline ;
        return $ret ;
    }

    public function getPipelineNames() {
        $pipelines = $this->getPipelines() ;
        $names = array_keys($pipelines) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

    public function getPipelineFeatures() {
        $pipeFeatureFactory = new \Model\PipeFeature();
        $pipeFeatureRepository = $pipeFeatureFactory->getModel($this->params, "PipeFeatureRepository") ;
        $names = $pipeFeatureRepository->getPipeFeatureNames();
        $pipeline = $this->getPipeline($this->params["item"]);
        $this->params["build-settings"] = $pipeline["settings"];
        $enabledFeatures = array() ;
        $i = 0;
        foreach ($pipeline["settings"] as $key => $values) {
            if (in_array($key, $names) && $values["enabled"] =="on") {
                $cname = '\Model\\'.$key ;
                $moduleFactory = new $cname();
                $modulePipeFeature = $moduleFactory->getModel($this->params, "PipeFeature");
                // @ todo maybe an interface check? is object something?
                $modulePipeFeature->setValues($values) ;
                $modulePipeFeature->setPipeline($pipeline) ;
                $collated = $modulePipeFeature->collate();
                $enabledFeatures[$i]["module"] = $key  ;
                $enabledFeatures[$i]["values"] = $values  ;
                $enabledFeatures[$i]["model"] = $collated  ; }
            $i++; }
        return $enabledFeatures ;
    }

    public function deletePipeline($name) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists(PIPEDIR.DS.$name)) {
            $logging->log("Directory exists at ".PIPEDIR.DS."{$name}. Attempting removal.", $this->getModuleName()) ;
            $rc = self::executeAndGetReturnCode('rm -rf '.PIPEDIR.DS.$name);
            return $rc ; }
        else  {
            $logging->log("No directory exists at ".PIPEDIR.DS."$name to delete", $this->getModuleName()) ;
            return true ; }
    }

    public function createPipeline($name) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists(PIPEDIR.DS.$name)) {
            $logging->log("Directory already exists at ".PIPEDIR.DS."{$name}. Exiting with failure.", $this->getModuleName()) ;
            return false ; }
        else  {
            $logging->log("Attempting to create directory ".PIPEDIR.DS."$name ", $this->getModuleName()) ;
            // @todo cross os
            $rc = self::executeAndGetReturnCode('mkdir -p '.PIPEDIR.DS.$name);
            self::executeAndGetReturnCode('mkdir -p '.PIPEDIR.DS.$name.DS.'history');
            self::executeAndGetReturnCode('mkdir -p '.PIPEDIR.DS.$name.DS.'workspace');
            self::executeAndGetReturnCode('mkdir -p '.PIPEDIR.DS.$name.DS.'stepsHistory');
            self::executeAndGetReturnCode('touch '.PIPEDIR.DS.$name.DS.'tmpfile');
            self::executeAndGetReturnCode('touch '.PIPEDIR.DS.$name.DS.'historyIndex');
            return $rc ; }
    }

}
