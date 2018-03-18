<?php

Namespace Controller ;

class BinaryServer extends Base {

    public function execute($pageVars) {
      $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
      // if we don't have an object, its an array of errors
      $this->content = $pageVars ;
      if (is_array($thisModel)) {
          return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
      if ($pageVars["route"]["action"] === 'serve') {
          $this->content["data"] = $thisModel->runBinaryHTTP(); }
          $this->content["route"]["extraParams"] ;
          $this->content["output-format"] = "binary" ;
      return array ("type"=>"view", "view"=>"binaryServer", "pageVars"=>$this->content);
    }

}