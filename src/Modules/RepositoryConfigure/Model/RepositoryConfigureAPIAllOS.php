<?php

Namespace Model;

class RepositoryConfigureAPIAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("API") ;

    public function allowedFunctions() {
        return array('create_repository') ;
    }

    public function create_repository() {
//        ob_start();
//        var_dump('Runnin repo configure API: ' , $this->params) ;
//        $out = ob_get_clean() ;
//        file_put_contents('/tmp/pharaohlog', "$out\n" . "\n\n\n", FILE_APPEND) ;
        // load repo
        $params["project-name"] = $this->params["repo_name"] ;
        $params["project-description"] = $this->params["repo_name"] ;
        $params["project-slug"] = $this->params["repo_name"] ;
        $params["item"] = $this->params["repo_name"] ;
        $params["creation"] = "yes" ;
        $rpcf = new \Model\RepositoryConfigure() ;
        $rpc = $rpcf->getModel($params) ;
//        ob_start();
//        var_dump('Midway repo configure: ' ,$rpc) ;
//        $out = ob_get_clean() ;
//        file_put_contents('/tmp/pharaohlog', "$out\n" . "\n\n\n", FILE_APPEND) ;


//        $repositoryFactory = new \Model\Repository() ;
//        $repositoryDefault = $repositoryFactory->getModel($this->params);
//        $res = $repositoryDefault->createRepository($this->params["project-slug"]) ;

        $res = $rpc->saveRepository() ;
//        ob_start();
//        var_dump('Finish repo configure: ' ,$res) ;
//        $out = ob_get_clean() ;
//        file_put_contents('/tmp/pharaohlog', "$out\n" . "\n\n\n", FILE_APPEND) ;
        return $res ;
    }

}
