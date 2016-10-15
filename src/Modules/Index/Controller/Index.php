<?php

Namespace Controller ;

class Index extends Base {

    public function execute($pageVars) {
        $override = $this->getExecutorForOverride() ;
        if (!is_null($override)) { return $override->execute() ; }
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        $this->content["modulesInfo"] = $thisModel->findModuleNames($pageVars["route"]["extraParams"]);
        $this->content["data"] = $thisModel->getData();
      return array ("type"=>"view", "view"=>"index", "pageVars"=>$this->content);
    }

    protected function getExecutorForOverride() {
        if ($this->isWebSapi() == false) { return null ; }
        $appSettings =  \Model\AppConfig::getAllAppVariables();
        if ($appSettings["mod_config"]["Index"]["allow_override"]=="on") {
            foreach ($appSettings["mod_config"] as $module => $moduleSettings) {
                if ($moduleSettings["index_override"] == "on") {
                    return \Core\AutoLoader::getController($module) ; } } }
        return null ;
    }

    private function isWebSapi() {
        if (!in_array(PHP_SAPI, array("cli")))  { return true ; }
        return false ;
    }

}