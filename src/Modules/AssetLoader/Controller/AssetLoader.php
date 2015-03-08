<?php

Namespace Controller ;

class AssetLoader extends Base {

    public function execute($pageVars) {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        $this->content = $pageVars ;
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        if($pageVars["route"]["action"] == "show") {
            $this->content["data"] = $thisModel->getData();
            $this->content["route"]["extraParams"] = $this->forceCliParam($this->content["route"]["extraParams"]) ; }
        return array ("type"=>"view", "view"=>"assetLoader", "pageVars"=>$this->content);
    }

    private function forceCliParam($ep) {
        for ($i = 0; $i<count($ep); $i++) {
            if ($ep[$i] == '--output-format=HTML') {
                $ep[$i] = '--output-format=FILE' ; } }
        return $ep ;
    }

}