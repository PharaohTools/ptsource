<?php

Namespace Controller;

class Signup extends Base
{

    public function execute($pageVars)
    {
        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars);
        // if we don't have an object, its an array of errors
        $this->content = $pageVars;
        if (is_array($thisModel)) {
            return $this->failDependencies($pageVars, $this->content, $thisModel); }

        // @todo This is functionality. It should be in the Model, not here
        // @todo do not Start the session here. At the very least, this should be in a wrapper
        // like $session->ensureSession();
        
        if ($pageVars["route"]["action"] == "login") {
            $this->content["data"] = $thisModel->getlogin();
        }

        if ($pageVars["route"]["action"] == "registration") {
            // todo @karthik do we need the line below
            // $this->content["data"] = "registration";
            return array("type" => "view", "view" => "signupRegistration", "pageVars" => $this->content);
        }

        if ($pageVars["route"]["action"] == "registration-submit") {
            $this->content["data"] = $thisModel->registrationSubmit();
            $this->content["route"]["extraParams"]["output-format"] = "CLI" ;
            return array("type" => "view", "view" => "signupRegistrationResult", "pageVars" => $this->content);
        }

        if ($pageVars["route"]["action"] == "login-status") {
            return $thisModel->checkLoginStatus();
        }
        if ($pageVars["route"]["action"] == "login-submit") {
            return $thisModel->checkLogin();
        }

        if ($pageVars["route"]["action"] == "logout") {
            $thisModel->allLoginInfoDestroy();
        }
		
		if ($pageVars["route"]["action"] == "verify") {
            $thisModel->mailVerification();
        }
		
        return array("type" => "view", "view" => "signupLogin", "pageVars" => $this->content);

    }
}
