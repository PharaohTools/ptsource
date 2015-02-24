<?php

Namespace Controller ;

class Event extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        $isDefaultAction = parent::checkDefaultActions($pageVars, array(
            "install","uninstall", "x", "exec", "execute", "status", "init", "inititalize", "version", "run-at-reboots"
        ), $thisModel) ;
        if ( is_array($isDefaultAction) ) { return $isDefaultAction; }
        $this->content["messages"][] = "Event module does not support this action";
        return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);
    }

}