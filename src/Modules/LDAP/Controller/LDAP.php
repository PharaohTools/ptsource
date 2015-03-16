<?php

Namespace Controller ;

class LDAP extends Base {

    public function execute($pageVars) {

        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars);
        // if we don't have an object, its an array of errors
        $this->content = $pageVars;
        if (is_array($thisModel)) {
            return $this->failDependencies($pageVars, $this->content, $thisModel);
        }

        // @todo This is functionality. It should be in the Model, not here
        // @todo do not Start the session here. At most, this should be in a wrapper like $session->ensureSession();
       // session_start();

       if ($pageVars["route"]["action"] == "ldaplogin") { 
            $this->content["data"] = "ldaplogin";
       }
	
       if ($pageVars["route"]["action"] == "ldap-submit") {
            return $thisModel->ldapSubmit();
        }

       return array("type" => "view", "view" => "ldap", "pageVars" => $this->content);

    }

}
