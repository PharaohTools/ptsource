<?php

Namespace Model;

class BuilderCollaterAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("BuilderCollater") ;

    public function getBuilder($module) {
        $r = $this->collate($module);
        return $r ;
    }

    private function collate($module) {
        $collated = array() ;
        $collated["fields"] =  $this->getFormFields($module) ;
        $collated["step-types"] = $this->getStepTypes($module) ;
        // $collated = array_merge($collated, $this->getSteps()) ;
        return $collated ;
    }

    private function getFormFields($module) {
        $stepFactoryClass = '\Model\\'.$module;
        $stepFactory = new $stepFactoryClass() ;
        $stepModel = $stepFactory->getModel($this->params);
        $modFormFields = $stepModel->getFormFields() ;
        return $modFormFields ;
    }

    private function getStepTypes($module) {
        $stepFactoryClass = '\Model\\'.$module;
        $stepFactory = new $stepFactoryClass() ;
        $stepModel = $stepFactory->getModel($this->params);
        $modStepTypes = $stepModel->getStepTypes() ;
        return $modStepTypes ;
    }

}