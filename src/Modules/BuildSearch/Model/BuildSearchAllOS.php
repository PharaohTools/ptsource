<?php

Namespace Model;

class BuildSearchAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;


    public function getSearchData() {
        $search["search_pipelines"] = $this->getSearchPipelines();
        return $search ;
    }
    // @todo need search data from datastore or PAM/LDAP
    public function getSearchPipelines() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getSeachPipelines($this->params);
        return $pipeline->getPipelines();
    }

}
