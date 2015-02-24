<?php

Namespace Controller ;

class Pipeline extends Base {

    public function execute($pageVars) {

        // @ todo i dont think we should be accepting any of these actions

        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        $isDefaultAction = parent::checkDefaultActions($pageVars, array(
            "install","uninstall", "x", "exec", "execute", "status", "init", "inititalize", "version", "run-at-reboots"
        ), $thisModel) ;
        if ( is_array($isDefaultAction) ) { return $isDefaultAction; }

        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        $this->content["modulesInfo"] = $thisModel->findModuleNames($pageVars["route"]["extraParams"]);
        return array ("type"=>"view", "view"=>"pipeline", "pageVars"=>$this->content);
    }

}