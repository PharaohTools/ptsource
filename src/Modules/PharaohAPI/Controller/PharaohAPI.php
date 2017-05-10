<?php

Namespace Controller ;

class PharaohAPI extends Base {

     public function execute($pageVars) {

         $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
         if (is_array($thisModel)) {
             return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

         $action = $pageVars["route"]["action"];
         if ($pageVars["route"]["action"] === "call") {
             if ($thisModel->keyIsAllowedAccess() !== true) {
                 $override = $this->getIndexControllerForOverride() ;
                 return $override->execute() ; }
             $responseModel= $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars, "Response") ;
             $this->content["data"] = $responseModel->handleAPIResponse() ;
             return array ("type"=>"view", "view"=>"pharaohAPI", "pageVars" => $this->content) ; }

         if ($pageVars["route"]["action"] === "request") {
             $this->content["data"] = $thisModel->performAPIRequest() ;
             return array ("type"=>"view", "view"=>"pharaohAPI", "pageVars" => $this->content) ; }


         if ($action === 'help') {
             $helpModel = new \Model\Help();
             $this->content["helpData"] = $helpModel->getHelpData($pageVars['route']['control']);
             return array ("type"=>"view", "view"=>"help", "pageVars"=>$this->content); }

         $this->content["messages"][] = "Invalid Pharaoh API Action";
         return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

     }

    protected function getIndexControllerForOverride() {
        return \Core\AutoLoader::getController("Signup")  ;
    }


}
