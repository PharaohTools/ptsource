<?php

Namespace Controller ;

class RepositoryReleases extends Base {

    public function execute($pageVars) {
      $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
      // if we don't have an object, its an array of errors
      $this->content = $pageVars ;
      if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }

      $repoModel = $this->getModelAndCheckDependencies('Repository', $pageVars) ;
      if ($repoModel->userIsAllowedAccess() !== true) {
            $override = \Core\AutoLoader::getController("Signup")  ;
            return $override->execute() ; }

      $this->content["data"] = $thisModel->getData();
      return array ("type"=>"view", "view"=>"repositoryReleases", "pageVars"=>$this->content);
    }

}