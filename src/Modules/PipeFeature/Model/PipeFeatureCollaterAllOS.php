<?php

Namespace Model;

class PipeFeatureCollaterAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("PipeFeatureCollater") ;

    public function getPipeFeature($module) {
        $r = $this->collate($module);
        return $r ;
    }

    private function collate($module) {
        $collated = array() ;
        $collated["fields"] =  $this->getFormFields($module) ;
        $collated["step-types"] = $this->getStepTypes($module) ;
        $collated["settings"] = $this->getSettings($module) ;
        return $collated ;
    }

    private function getFormFields($module) {
        $stepFactoryClass = '\Model\\'.$module;
        $stepFactory = new $stepFactoryClass() ;
        $stepModel = $stepFactory->getModel($this->params);
        if (method_exists($stepModel, "getFormFields")) {
            $modFormFields = $stepModel->getFormFields() ; }
        else {
            $modFormFields = array() ; }
        return $modFormFields ;
    }

    private function getStepTypes($module) {
        $stepFactoryClass = '\Model\\'.$module;
        $stepFactory = new $stepFactoryClass() ;
        $stepModel = $stepFactory->getModel($this->params);
        if (method_exists($stepModel, "getFormFields")) {
            $modStepTypes = $stepModel->getStepTypes() ; }
        else {
            $modStepTypes = array() ; }
        return $modStepTypes ;
    }

    private function getSettings($module) {
        $stepFactoryClass = '\Model\\'.$module;
        $stepFactory = new $stepFactoryClass() ;
        $stepModel = $stepFactory->getModel($this->params);
        if (method_exists($stepModel, "getSettingFormFields")) {
            $modStepTypes = $stepModel->getSettingFormFields() ; }
        else {
            $modStepTypes = array() ; }
        return $modStepTypes ;
    }

}