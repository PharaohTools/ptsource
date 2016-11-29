<?php

Namespace Controller ;

class Datastore extends Base {

    public function execute($pageVars) {
        $override = $this->getExecutorForOverride() ;
        if (!is_null($override)) { return $override->execute() ; }
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        $this->content["modulesInfo"] = $thisModel->findModuleNames($pageVars["route"]["extraParams"]);
        return array ("type"=>"view", "view"=>"index", "pageVars"=>$this->content);
    }

    protected function getExecutorForOverride() {
        $appSettings =  \Model\AppConfig::getAllAppVariables();
//        var_dump($appSettings) ;
        if ($appSettings["mod_config"]["Datastore"]["allow_override"]=="on") {
            foreach ($appSettings["mod_config"] as $module => $moduleSettings) {
                if ($moduleSettings["index_override"] == "on") {
                    return \Core\AutoLoader::getController($module) ; } } }
        return null ;

    }
}