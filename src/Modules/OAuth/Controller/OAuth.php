<?php

Namespace Controller;

class OAuth extends Base
{

    public function execute($pageVars)
    {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars);
        // if we don't have an object, its an array of errors
        $this->content = $pageVars;
        if (is_array($thisModel)) {
            return $this->failDependencies($pageVars, $this->content, $thisModel);
        }

        // @todo This is functionality. It should be in the Model, not here
        // @todo do not Start the session here. At most, this should be in a wrapper like $session->ensureSession();
        session_start();

       if ($pageVars["route"]["action"] == "githublogin") { 
            $this->content["data"] = $thisModel->github_login();
       }
	if ($pageVars["route"]["action"] == "googlelogin") { 
            $this->content["data"] = $thisModel->google_login();
       } 
	if ($pageVars["route"]["action"] == "fblogin") { 
            $this->content["data"] = $thisModel->fb_login();
       }
       if ($pageVars["route"]["action"] == "linkedinlogin") {
            $this->content["data"] = $thisModel->linkedin_login();
       }
	 return array("type" => "view", "view" => "index", "pageVars" => $this->content);
    }
}
