<?php

Namespace Controller ;

class UserPermission extends Base {

    public function execute($pageVars) {

        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
		return $thisModel->checkForAccess($pageVars["route"]);
        //return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

    }

}