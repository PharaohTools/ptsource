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
            return $this->failDependencies($pageVars, $this->content, $thisModel);
        }

        // @todo This is functionality. It should be in the Model, not here
        // @todo do not Start the session here. At most, this should be in a wrapper like $session->ensureSession();
        session_start();

        if ($pageVars["route"]["action"] == "login") {
            $this->content["data"] = $thisModel->getlogin();
        }
        if ($pageVars["route"]["action"] == "registration") {
            $this->content["data"] = "registration";
        }

        if ($pageVars["route"]["action"] == "registration-submit") {
            return $thisModel->registrationSubmit();
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
		
        return array("type" => "view", "view" => "signup", "pageVars" => $this->content);
    }
}
