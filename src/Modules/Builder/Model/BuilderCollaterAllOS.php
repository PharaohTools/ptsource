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
        $stepModel = $this->getStepModel($module) ;
        $r = $this->collate($stepModel);
        return $r ;
    }

    private function getStepModel($module) {
        $stepFactoryClass = '\Model\\'.$module;
        $stepFactory = new $stepFactoryClass() ;
        $stepModel = $stepFactory->getModel($this->params);
        return $stepModel ;
    }

    private function collate($stepModel) {
        $collated = array() ;
        $collated["fields"] =  $this->getFormFields($stepModel) ;
        $collated["step-types"] = $this->getStepTypes($stepModel) ;
        $collated["settings"] = $this->getSettings($stepModel) ;
        return $collated ;
    }

    private function getFormFields($stepModel) {
        if (method_exists($stepModel, "getFormFields")) {
            $modFormFields = $stepModel->getFormFields() ; }
        else {
            $modFormFields = array() ; }
        return $modFormFields ;
    }

    private function getStepTypes($stepModel) {
        if (method_exists($stepModel, "getFormFields")) {
            $modStepTypes = $stepModel->getStepTypes() ; }
        else {
            $modStepTypes = array() ; }
        return $modStepTypes ;
    }

    private function getSettings($stepModel) {
        if (method_exists($stepModel, "getSettingFormFields")) {
            $modStepTypes = $stepModel->getSettingFormFields() ; }
        else {
            $modStepTypes = array() ; }
        return $modStepTypes ;
    }

}